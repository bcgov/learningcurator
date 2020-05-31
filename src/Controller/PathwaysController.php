<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Pathways Controller
 *
 * @property \App\Model\Table\PathwaysTable $Pathways
 *
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // configure the login action to don't require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['index','view']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        // If the person is a curator or an admin, then return all of the pathways,
        // regardless of their statuses. Regular users should only ever see 
        // 'published' pathways.
        if($user->role_id == 2 || $user->role_id == 5) {
            $pathways = $paths->find('all')->contain(['Categories','Statuses']);
        } else {
            $pathways = $paths->find('all')->contain(['Categories','Statuses'])->where(['status_id' => 2]);
        }
        //$this->paginate($pathways);
        $this->set(compact('pathways'));
    }

    /**
     * View method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        // As we loop through the activities for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that activity. Here we get the current user id and use it to select 
        // all of the claimed activities assigned to them, and then process out 
        // just the activity IDs into a simple array. Then, in the template 
        // code, we can simply  if(in_array($rj->activity->id,$useractivitylist
        //
        // First let's check to see if this person is logged in or not.
        //
	    $user = $this->request->getAttribute('authentication')->getIdentity();
        if(!empty($user)) {
            // We need create an empty array first. If nothing gets added to
            // it, so be it
            $useractivitylist = array();
            // Get access to the apprprioate table
            $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
            // Select based on currently logged in person
            $useacts = $au->find()->where(['user_id = ' => $user->id]);
            // convert the results into a simple array so that we can
            // use in_array in the template
            $useractivities = $useacts->toList();
            // Loop through the resources and add just the ID to the 
            // array that we will pass into the template
            foreach($useractivities as $uact) {
                array_push($useractivitylist, $uact['activity_id']);
            }
        }
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Categories', 
                            'Ministries', 
                            'Competencies', 
                            'Steps', 
                            'Steps.Activities', 
                            'Steps.Activities.ActivityTypes', 
                            'Steps.Activities.Users', 
                            'Steps.Activities.Tags', 
                            'Users'],
        ]);
    //
	// we want to be able to tell if the current user is already on this
	// pathway or not, so we take the same approach as above, parsing all
	// the users into a single array so that we can perform a simple
	// in_array($thisuser,$usersonthispathway) check and show the "take
	// this Pathway" button or "you're on this Pathway" text
	//
	// Create the initially empty array that we also pass into the template
	$usersonthispathway = array();
	// Loop through the users that are on this pathway and parse just the 
	// IDs into the array that we just created
	foreach($pathway->users as $pu) {
		array_push($usersonthispathway,$pu->id);
    }

    // In order to implement the scrollspy step navigation we zip through
    // and compile a list of the steps and convert them to slugs. Now we
    // can run through the steps and link to them outside of the main 
    // loop #TODO in the template we're hacking this by having a separate
    // slugify function because we don't yet store the slug when we save
    // the step. We need to add a new entity to the steps table (also the
    // pathways table) to do this. Fairly high priority really.
    $stepsalongtheway = array();
    foreach($pathway->steps as $step) {
        array_push($stepsalongtheway,array('slug' => Text::slug(strtolower($step->name)), 
                                            'name' => $step->name, 
                                            'objective' => $step->description));
	}


    if(!empty($user)) {
		$this->set(compact('pathway', 'usersonthispathway','stepsalongtheway', 'useractivitylist'));
	} else {
		$this->set(compact('pathway', 'usersonthispathway','stepsalongtheway'));
	}

    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pathway = $this->Pathways->newEmptyEntity();
        $this->Authorization->authorize($pathway);
        if ($this->request->is('post')) {
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            if ($this->Pathways->save($pathway)) {
                //$this->Flash->success(__('The pathway has been saved.'));
                $go = '/pathways/view/' . $pathway->id;
                return $this->redirect($go);
            }
            //$this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }
        $categories = $this->Pathways->Categories->find('list', ['limit' => 200]);
        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'categories', 'ministries', 'competencies', 'steps', 'users'));
    }

    /**
     * Publish pathway method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function publish($id = null)
    {
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Competencies', 'Steps', 'Users'],
        ]);

        $this->Authorization->authorize($pathway);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->getData()['status_id'] = 2;
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            if ($this->Pathways->save($pathway)) {
                $this->Flash->success(__('The pathway has been saved.'));
                $pathback = '/pathways/view/' . $id;
                return $this->redirect($pathback);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }

    }


    /**
     * Edit method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Competencies', 'Steps', 'Users'],
        ]);

        $this->Authorization->authorize($pathway);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            if ($this->Pathways->save($pathway)) {
                $this->Flash->success(__('The pathway has been saved.'));
                $pathback = '/pathways/view/' . $id;
                return $this->redirect($pathback);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }
        $categories = $this->Pathways->Categories->find('list', ['limit' => 200]);
        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $statuses = $this->Pathways->Statuses->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'categories', 'ministries', 'statuses', 'competencies', 'steps', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pathway = $this->Pathways->get($id);
        if ($this->Pathways->delete($pathway)) {
            $this->Flash->success(__('The pathway has been deleted.'));
        } else {
            $this->Flash->error(__('The pathway could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



    /**
     * Process and return a status for this pathway for the logged in user 
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function status($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('ajax');
        // As we loop through the activities for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that activity. Here we get the current user id and use it to select 
        // all of the claimed activities assigned to them, and then process out 
        // just the activity IDs into a simple array. Then, in the template 
        // code, we can simply  if(in_array($rj->activity->id,$useractivitylist
        //
        // First let's check to see if this person is logged in or not.
        //
	    $user = $this->request->getAttribute('authentication')->getIdentity();
        if(!empty($user)) {
            // We need create an empty array first. If nothing gets added to
            // it, so be it
            $useractivitylist = array();
            // Get access to the apprprioate table
            $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
            // Select based on currently logged in person
            $useacts = $au->find()->where(['user_id = ' => $user->id]);
            // convert the results into a simple array so that we can
            // use in_array in the template
            $useractivities = $useacts->toList();
            // Loop through the resources and add just the ID to the 
            // array that we will pass into the template
            foreach($useractivities as $uact) {
                array_push($useractivitylist, $uact['activity_id']);
            }
        }

        $pathway = $this->Pathways->get($id, [
            'contain' => ['Categories', 
                            'Ministries', 
                            'Competencies', 
                            'Steps', 
                            'Steps.Activities', 
                            'Steps.Activities.ActivityTypes', 
                            'Steps.Activities.Users', 
                            'Steps.Activities.Tags', 
                            'Users'],
        ]);
        //
        // we want to be able to tell if the current user is already on this
        // pathway or not, so we take the same approach as above, parsing all
        // the users into a single array so that we can perform a simple
        // in_array($thisuser,$usersonthispathway) check and show the "take
        // this Pathway" button or "you're on this Pathway" text
        //
        // Create the initially empty array that we also pass into the template
        $usersonthispathway = array();
        // Loop through the users that are on this pathway and parse just the 
        // IDs into the array that we just created
        foreach($pathway->users as $pu) {
            array_push($usersonthispathway,$pu->id);
        }


        if (!empty($pathway->steps)) :

            $totalActivities = 0;
            $totalTime = 0;
            $claimedcount = 0;
            $readclaim = 0;
            $watchclaim = 0;
            $listenclaim = 0;
            $participateclaim = 0;
            $readtimetotal = 0;
            $watchtimetotal = 0;
            $listentimetotal = 0;
            $participatetimetotal = 0;
            
            $readcolor = '255,255,255';
            $watchcolor = '255,255,255';
            $listencolor = '255,255,255';
            $participatecolor = '255,255,255';

            $readtotal = 0;
            $watchtotal = 0;
            $listentotal = 0;
            $participatetotal = 0;
            
            foreach ($pathway->steps as $steps) :

                
                $stepTime = 0;
                $stepActivityCount = 0;
                $readtime = 0;
                $watchtime = 0;
                $listentime = 0;
                $participatetime = 0;
                
                $defunctacts = array();
                $requiredacts = array();
                $tertiaryacts = array();
                
                $readcount = 0;
                $watchcount = 0;
                $listencount = 0;
                $participatecount = 0;

                foreach ($steps->activities as $activity):
                    // If this is 'defunct' then we pull it out of the list 
                    if($activity->status_id == 3) {
                        array_push($defunctacts,$activity);
                    } else {
                        // if it's required
                        //if($activity->_joinData->required == 1) {
                            //array_push($requiredacts,$activity);
                        // Otherwise it's supplmentary
                        //} else {
                            //array_push($tertiaryacts,$activity);
                        //}
                        //
                        // we want to count each type on a per step basis
                        // as well as adding to the total
                        //
                        if($activity->activity_type->name == 'Read') {
                            $readcolor = $activity->activity_type->color;
                            $readicon = $activity->activity_type->image_path;
                            $readcount++;
                            $readtotal++;
                            if(in_array($activity->id,$useractivitylist)) {
                                $readclaim++;
                            }
                        } elseif($activity->activity_type->name == 'Watch') {
                            $watchcolor = $activity->activity_type->color;
                            $watchicon = $activity->activity_type->image_path;
                            $watchcount++;
                            $watchtotal++;
                            if(in_array($activity->id,$useractivitylist)) {
                                $watchclaim++;
                            }
                        } elseif($activity->activity_type->name == 'Listen') {
                            $listencolor = $activity->activity_type->color;
                            $listenicon = $activity->activity_type->image_path;
                            $listencount++;
                            $listentotal++;
                            if(in_array($activity->id,$useractivitylist)) {
                                $listenclaim++;
                            }
                        } elseif($activity->activity_type->name == 'Participate') {
                            $participatecolor = $activity->activity_type->color;
                            $participateicon = $activity->activity_type->image_path;
                            $participatecount++;
                            $participatetotal++;
                            if(in_array($activity->id,$useractivitylist)) {
                                $participateclaim++;
                            }
                        }
                        $totalActivities++;
                        $stepTime = $stepTime + $activity->hours;
                        $totalTime = $totalTime + $activity->hours;
                        $stepActivityCount++;
                    }
                endforeach; // activities
            endforeach; // steps

            $overallp = floor((($readclaim + $watchclaim + $listenclaim + $participateclaim) / $totalActivities) * 100);
            $readp = floor(($readcount / $stepActivityCount) * 100);
            $watchp = floor(($watchcount / $stepActivityCount) * 100);
            $listenp = floor(($listencount / $stepActivityCount) * 100);
            $pp = floor(($participatecount / $stepActivityCount) * 100);

            //$readtotal = 0;
            //$watchtotal = 0;
            //$listentotal = 0;
            //$participatetotal = 0;
            $typecounts = array('readtotal' => $readtotal, 
                                'watchtotal' => $watchtotal, 
                                'listentotal' => $listentotal, 
                                'participatetotal' => $participatetotal);

            $typecolors = array('readcolor' => $readcolor, 
                                'watchcolor' => $watchcolor, 
                                'listencolor' => $listencolor, 
                                'participatecolor' => $participatecolor);

            if(!empty($readclaim) && $readtotal > 0) {
                $readpercent = floor(($readclaim / $readtotal) * 100);
                $readpercentleft = 100 - $readpercent;
            } else {
                $readpercent = 0;
                $readpercentleft = 100;       
            }
            if(!empty($watchclaim) && $watchtotal > 0) {
                $watchpercent = floor(($watchclaim / $watchtotal) * 100);
                $watchpercentleft = 100 - $watchpercent;
            } else {
                $watchpercent = 0;
                $watchpercentleft = 100;
            }
            if(!empty($listenclaim) && $listentotal > 0) {
                $listenpercent = floor(($listenclaim / $listentotal) * 100);
                $listenpercentleft = 100 - $listenpercent;
            } else {
                $listenpercent = 0;
                $listenpercentleft = 100;
            }
            if(!empty($participateclaim) && $participatetotal > 0) {
                $participatepercent = floor(($participateclaim / $participatetotal) * 100);
                $participatepercentleft = 100 - $participatepercent;
            } else {
                $participatepercent = 0;
                $participatepercentleft = 100;
            }

            $percentages = array(
                    array($readpercent,$readpercentleft,$readcolor),
                    array($watchpercent,$watchpercentleft,$watchcolor),
                    array($listenpercent,$listenpercentleft,$listencolor),
                    array($participatepercent,$participatepercentleft,$participatecolor)
            );
            
            $status = 'Overall progress: ' . $overallp . '%';
            if($overallp == 100) {
                $status = 'Completed!';
                // #TODO check against current pathways_users status in db and 
                // write a method to update the pathways_users status if it doesn't match
            }

            $chartjs = '{"datasets": [';
            foreach($percentages as $ring) {
                $chartjs .= '{"data": [' . $ring[0] . ',' . $ring[1] . '],';
                $chartjs .= '"labels": ["all the same","not all"],';
                $chartjs .= '"backgroundColor": ["rgba(' . $ring[2] . ',1)","rgba(' . $ring[2] . ',.2)"]';
                $chartjs .= '},';
            }
            $chartjs = rtrim($chartjs, ',');
            $chartjs .= ']}';
            
            if(!empty($user)) {

                $this->set(compact(['percentages','status','chartjs','typecounts','typecolors']));
                
            } else {

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            
            }

        else:

            // There are no steps

        endif; // if steps


    } // end of method







        /**
     * View method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function path ($id = null)
    {
        $this->Authorization->skipAuthorization();
        // As we loop through the activities for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that activity. Here we get the current user id and use it to select 
        // all of the claimed activities assigned to them, and then process out 
        // just the activity IDs into a simple array. Then, in the template 
        // code, we can simply  if(in_array($rj->activity->id,$useractivitylist
        //
        // First let's check to see if this person is logged in or not.
        //
	    $user = $this->request->getAttribute('authentication')->getIdentity();
        if(!empty($user)) {
            // We need create an empty array first. If nothing gets added to
            // it, so be it
            $useractivitylist = array();
            // Get access to the apprprioate table
            $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
            // Select based on currently logged in person
            $useacts = $au->find()->where(['user_id = ' => $user->id]);
            // convert the results into a simple array so that we can
            // use in_array in the template
            $useractivities = $useacts->toList();
            // Loop through the resources and add just the ID to the 
            // array that we will pass into the template
            foreach($useractivities as $uact) {
                array_push($useractivitylist, $uact['activity_id']);
            }
        }

        $pathway = $this->Pathways->get($id, [
            'contain' => ['Categories', 
                            'Ministries', 
                            'Competencies', 
                            'Steps', 
                            'Steps.Activities', 
                            'Steps.Activities.ActivityTypes', 
                            'Steps.Activities.Users', 
                            'Steps.Activities.Tags', 
                            'Users'],
        ]);
    //
	// we want to be able to tell if the current user is already on this
	// pathway or not, so we take the same approach as above, parsing all
	// the users into a single array so that we can perform a simple
	// in_array($thisuser,$usersonthispathway) check and show the "take
	// this Pathway" button or "you're on this Pathway" text
	//
	// Create the initially empty array that we also pass into the template
	$usersonthispathway = array();
	// Loop through the users that are on this pathway and parse just the 
	// IDs into the array that we just created
	foreach($pathway->users as $pu) {
		array_push($usersonthispathway,$pu->id);
    }

    // In order to implement the scrollspy step navigation we zip through
    // and compile a list of the steps and convert them to slugs. Now we
    // can run through the steps and link to them outside of the main 
    // loop #TODO in the template we're hacking this by having a separate
    // slugify function because we don't yet store the slug when we save
    // the step. We need to add a new entity to the steps table (also the
    // pathways table) to do this. Fairly high priority really.
    $stepsalongtheway = array();
    foreach($pathway->steps as $step) {
        array_push($stepsalongtheway,array('slug' => Text::slug(strtolower($step->name)), 
                                            'name' => $step->name, 
                                            'objective' => $step->description));
	}


    if(!empty($user)) {
		$this->set(compact('pathway', 'usersonthispathway','stepsalongtheway', 'useractivitylist'));
	} else {
		$this->set(compact('pathway', 'usersonthispathway','stepsalongtheway'));
	}

    }





}

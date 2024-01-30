<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Steps Controller
 *
 * @property \App\Model\Table\StepsTable $Steps
 * @method \App\Model\Entity\Step[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StepsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setHelpers(['Tanuck/Markdown.Markdown']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $steps = $this->paginate($this->Steps);

        $this->set(compact('steps'));
    }

    /**
     * View method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($stepid = null)
    {
        $step = $this->Steps->get($stepid, ['contain' => ['Activities', 
                                                            'Activities.ActivityTypes', 
                                                            'Activities.Tags', 
                                                            'Pathways',
                                                            'Pathways.Topics',
                                                            'Pathways.Topics.Categories', 
                                                            'Pathways.Steps',
                                                            'Pathways.Users'],
        ]);
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need create an empty array first. If nothing gets added to
        // it, so be it
        $useractivitylist = array();

        // Get access to the apprprioate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');

        // Select based on currently logged in person
        // #TODO the next lines are not good. 
        // change the query to only select the ID to begin with instead
        // of selecting all and parsing it out? 
        $useacts = $au->find()->where(['user_id = ' => $user->id]);

        // convert the results into a simple array so that we can
        // use in_array in the template
        $useractivities = $useacts->all()->toList();
        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
        // we want to be able to tell if the current user is already on this
        // pathway or not so we loop through the users that are on this 
        // pathway record the ID of pathways_users entry if we find a match.
        $followid = 0;
        foreach($step->pathways[0]->users as $pu) {
            if($pu->id == $user->id) {
                $followid = $pu->_joinData->id;
            }
        }



        $steporder = [];
        $othersteps = [];
        foreach ($step->pathways as $pathways){
            foreach ($pathways->steps as $s) {
                $steporder[] = $s->_joinData->sortorder;
                array_push($othersteps,$s);
            }
        }
        // Use the tmp array to sort steps list
        array_multisort($steporder, SORT_ASC, $othersteps);
        
        $next = 0;
        $last = 0;
        $upnextid = 0;
        $upnextslug = '';
        $previousid = 0;
        $previousslug = '';
        foreach($othersteps as $ss) {
            $next = next($othersteps);
            if ($ss->id == $step->id) {
                if ($last) {
                    $previousid = $last->id;
                    $previousslug = $last->slug;
                }
                if ($next) {
                    $upnextid = $next->id;
                    $upnextslug = $next->slug;
                }
            }
            $last = $ss;
        }



        /**
         * Loop through the activities on this step and process them into
         * ordered lists for required, supplemental, and archived 
         */
        $stepTime = 0;
        $archivedacts = array();
        $requiredacts = array();
        $supplementalacts = array();
        $acts = array();

        $totalacts = count($step->activities);
        $stepclaimcount = 0;

        foreach ($step->activities as $activity) {
            $stepname = '';
            // If this is 'defunct' then we pull it out of the list 
            // and add it the defunctacts array so we can show them
            // but in a different section
            if($activity->status_id == 3) {
                array_push($archivedacts,$activity);
            } elseif($activity->status_id == 2) {
                // if it's required
                if($activity->_joinData->required == 1) {
                    array_push($requiredacts,$activity);
                // Otherwise it's teriary
                } else {
                    array_push($supplementalacts,$activity);
                }
                array_push($acts,$activity);

                if(in_array($activity->id,$useractivitylist)) {
                    $stepclaimcount++;
                }
                $reqtmp = array();
                $suptmp = array();
                // Loop through the whole list, add steporder to tmp array
                foreach($requiredacts as $line) {
                    $reqtmp[] = $line->_joinData->steporder;
                }
                foreach($supplementalacts as $line) {
                    $suptmp[] = $line->_joinData->steporder;
                }
                // Use the tmp array to sort acts list
                array_multisort($reqtmp, SORT_DESC, $requiredacts);
                array_multisort($suptmp, SORT_DESC, $supplementalacts);
                //array_multisort($tmp, SORT_DESC, $supplementalacts);
            }
        }

        $pagetitle = $step->name . ' - ' . $step->pathways[0]->name;
        
        $this->set(compact('step',
                            'pagetitle',
                            'requiredacts',
                            'supplementalacts',
                            'archivedacts',
                            'totalacts',
                            'followid',
                            'useractivitylist',
                            'othersteps',
                            'upnextslug',
                            'upnextid',
                            'previousslug',
                            'previousid'
                        )
                    );
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $step = $this->Steps->newEmptyEntity();
        if ($this->request->is('post')) {
            //echo '<pre>'; print_r($this->request->getData()); exit;
            $step = $this->Steps->patchEntity($step, $this->request->getData());
            $sluggedTitle = Text::slug($step->name);
            // trim slug to maximum length defined in schema
            $step->slug = strtolower(substr($sluggedTitle, 0, 191));
            //echo '<pre>'; print_r($step); exit;  
            if ($this->Steps->save($step)) {
                // If we're running the import process we don't want to return a redirect,
                // we want to simply return the step ID so that we can use it to add newly
                // created activities to it. 
                if(!empty($this->request->getData()['fromimport'])) {
                    
                    return $step->id;

                } else {
                    $redir = '/steps/edit/' . $step->id;
                    return $this->redirect($redir);
                }
                
            }
            $this->Flash->error(__('The step could not be saved. Please, try again.'));
        }
        $activities = $this->Steps->Activities->find('list', ['limit' => 200]);
        $pathways = $this->Steps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('step', 'activities', 'pathways'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $step = $this->Steps->get($id, [
            'contain' => ['Statuses', 'Activities', 'Activities.ActivityTypes', 'Activities.Statuses', 'Pathways', 'Pathways.Topics'],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $step = $this->Steps->patchEntity($step, $this->request->getData());
            $sluggedTitle = Text::slug($step->name);
            // trim slug to maximum length defined in schema
            $step->slug = strtolower(substr($sluggedTitle, 0, 191));
            //echo $step->slug; exit;
            
            if ($this->Steps->save($step)) {
                //print(__('The step has been saved.'));
                $pathback = '/steps/view/' . $id;
                return $this->redirect($pathback);
            }
            //print(__('The step could not be saved. Please, try again.'));
        }
        $activities = $this->Steps->Activities->find('list', ['limit' => 200]);
        
        $types = TableRegistry::getTableLocator()->get('ActivityTypes');
        $atypes = $types->find('list');

        $pathways = $this->Steps->Pathways->find('list', ['limit' => 200]);
        $statuses = $this->Steps->Statuses->find('list', ['limit' => 200]);
        $this->set(compact('step', 'activities', 'pathways', 'atypes', 'statuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $step = $this->Steps->get($id, ['contain' => ['Pathways']]);
        
        if ($this->Steps->delete($step)) {
            $redir = '/pathways/' . $step->pathways[0]->slug;
            return $this->redirect($redir);
        } else {
            echo __('The step could not be deleted. Please, try again.');
        }


    }

    /**
     * Status method for per-step progress bar.
     * Output a JSON response for a users status as it pertains to 
     * the given step ID. This is requested through AJAX on the step 
     * view and is fired when the user claims a new activity.
     * It reloads the progress bar.
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function status($id = null)
    {
        $step = $this->Steps->get($id, [
            'contain' => ['Activities'],
        ]);
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need create an empty array first. If nothing gets added to
        // it, so be it
        $useractivitylist = array();
        // Get access to the appropriate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select all activities (claims) based on currently logged in person
        $useacts = $au->find()->where(['user_id = ' => $user->id]);
        // convert the results into a simple array so that we can
        // use in_array(needle,haystack) in the template
        $useractivities = $useacts->all()->toList();
        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
		$stepTime = 0;
		$totalacts = count($step->activities);
		$stepclaimcount = 0;
        $requiredacts = 0;
		foreach ($step->activities as $activity) {
            // if it's published
			if($activity->status_id == 2) {
				// if it's required
				if($activity->_joinData->required == 1) {
                    $requiredacts++;
                    if(in_array($activity->id,$useractivitylist)) {
                        $stepclaimcount++;
                    }
				} 
			}
		} // endforeach for activities on this step 
		if($stepclaimcount > 0) {
			$steppercent = ceil(($stepclaimcount * 100) / $requiredacts);
		} else {
			$steppercent = 0;
		}
        $this->viewBuilder()->setLayout('ajax');
        $this->set(compact('totalacts','stepclaimcount','steppercent','requiredacts'));
    }


    /**
     * If the step is published, unpublish it and vice versa
     *
     * @return \Cake\Http\Response|null Redirects on successful update, renders view otherwise.
     */
    public function publishtoggle($id = null)
    {
        $step = $this->Steps->get($id);
        if($step->status_id == 2) {
            $step->status_id = 1;
        } else {
            $step->status_id = 2;
        }
        if ($this->Steps->save($step)) {
            return $this->redirect($this->referer());
        }
    }
}

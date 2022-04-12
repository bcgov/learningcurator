<?php
declare(strict_types=1);

namespace App\Controller;


Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;

/**
 * Pathways Controller
 *
 * @property \App\Model\Table\PathwaysTable $Pathways
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['search'],
        ]);
    }
    /**
     * API method outputs JSON of the index listing of newly published pathways
     *
     * @return \Cake\Http\Response|null
     */
    public function rssfeed()
    {
        $pathways = $this->Pathways->find('all');
        //$this->RequestHandler->renderAs($this, 'rss');
        $this->set(compact('pathways'));
    }
    /**
     * Show Curators their own pathways and activities
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function contributions()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $acts = TableRegistry::getTableLocator()->get('Activities');
        $activities = $acts->find('all')->contain(['ActivityTypes','Statuses','Steps','Steps.Pathways'])
                                        ->where(['Activities.createdby_id' => $user->id]);
        $pathways = $this->Pathways->find('all')->contain(['Topics','Statuses'])->where(['Pathways.createdby' => $user->id]);
        
        //$this->paginate($pathways);
        $this->set(compact('pathways','activities'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        // If the person is a curator or an admin, then return all of the pathways,
        // regardless of their statuses. Regular users should only ever see 
        // 'published' pathways.
        if($user->role == 'curator' || $user->role == 'superuser') {
            $pathways = $paths->find('all')->contain(['Topics','Topics.Categories','Statuses'])
                                            ->order(['Pathways.created' => 'desc']);
        } else {
            $pathways = $paths->find('all')
                                ->contain(['Topics','Topics.Categories','Statuses'])
                                ->where(['Pathways.featured' => 1])
                                ->where(['status_id' => 2])
                                ->order(['Pathways.created' => 'desc']);
        }
        //$this->paginate($pathways);
        $this->set(compact('pathways'));
    }
    /**
     * Search method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function search()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        // If the person is a curator or an admin, then return all of the pathways,
        // regardless of their statuses. Regular users should only ever see 
        // 'published' pathways.
        if($user->role == 'curator' || $user->role == 'superuser') {
            $pathways = $paths->find('search', ['search' => $this->request->getQuery()])
                                ->contain(['Topics','Topics.Categories','Statuses']);
        } else {
            $pathways = $paths->find('search', ['search' => $this->request->getQuery()])
                                ->contain(['Topics','Topics.Categories','Statuses','Steps'])
                                ->where(['status_id' => 2]);
        }
        $q = $this->request->getQuery('q');
        $numresults = $pathways->count();
        //$this->paginate($pathways);
        $this->set(compact('pathways','q','numresults'));
    }

    /**
     * Find method for step assignment
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function find()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $paths->find('search', ['search' => $this->request->getQuery()])
                            ->contain(['Steps']);
        $this->set(compact('pathways'));
    }


    /**
     * View method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {

        $pathway = $this->Pathways->
                            findBySlug($slug)->
                            contain([
                                'Topics',
                                'Topics.Categories', 
                                'Steps' => ['sort' => ['PathwaysSteps.sortorder' => 'desc']],
                                'Steps.Statuses', 
                                'Steps.Activities',
                                'Users'])->firstOrFail();
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need to count how many activities this person has claimed 
        // from each step (we loop through them below)
        $useractivitylist = array();
        // Get access to the appropriate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select based on currently logged in person
        $useractivities = $au->find()->where(['user_id = ' => $user->id])->toList();
        // Loop through the resources and add just the ID to the 
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
        $followid = 0;
        foreach($pathway->users as $pu) {
            // Is the current user following this pathway? If so, then 
            // we record the pathways_users ID number so we can remove
            // the association (unfollow) if the user clicks the "Unfollow"
            // button.
            if($pu->id == $user->id) {
                $followid = $pu->_joinData->id;
            }
        }
        $percentage = 0;
        $totalclaimed = 0;
        $totalacts = 0;
        $requiredacts = 0;
        $suppacts = 0;
        if (!empty($pathway->steps)):

            foreach ($pathway->steps as $steps):
                foreach ($steps->activities as $activity):
                    if($activity->status_id == 2) {
                        $totalacts++;
                        if($activity->_joinData->required == 1) {
                            $requiredacts++;
                            if(in_array($activity->id, $useractivitylist)) {
                                $totalclaimed++;
                            }
                        } else {
                            $suppacts++;
                        }
                    }
                endforeach; // activities
            endforeach; // steps
            if($totalclaimed > 0) {
                $percentage = floor(($totalclaimed / $requiredacts) * 100);
            } else {
                $percentage = 0;
            }
        endif;
        $this->set(compact('pathway', 
                            'totalacts', 
                            'requiredacts', 
                            'suppacts', 
                            'percentage', 
                            'followid'));

    }

    /**
     * Export method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function export ($slug = null)
    {
      
        $pathway = $this->Pathways->findBySlug($slug)->contain([
                            'Topics',
                            'Topics.Categories', 
                            'Ministries', 
                            'Steps' => ['sort' => ['Steps.id' => 'asc']],
                            'Steps.Statuses', 
                            'Steps.Activities', 
                            'Steps.Activities.ActivityTypes'])->firstOrFail();
        
        $this->RequestHandler->renderAs($this, 'json');
        // $this->RequestHandler->respondAs('json', [
        //     // Force download
        //     'attachment' => true,
        //     'charset' => 'UTF-8'
        // ]);
        $this->set(compact('pathway'));

    }

    /**
     * Import method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function import ($topicid = 0)
    {
        // #TODO sanitize this somehow and perhaps only accept urls from a 
        // whitelist
        $importfile = $this->request->getQuery('pathimportfile');
        $this->viewBuilder()->setLayout('ajax');
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $feed = file_get_contents($importfile);
        $path = json_decode($feed);

        $pathway = $this->Pathways->newEmptyEntity();
        
        $pathdeets = [
            'status_id' => 1,
            'topic_id' => $topicid, //33,
            'name' => $path->name,
            'description' => $path->description,
            'objective' => $path->objective,
            'slug' => $path->slug,
            'createdby' => $user->id,
            'modifiedby' => $user->id
        ];
        //echo '<pre>'; print_r($pathdeets); exit;
        
        $pathway = $this->Pathways->patchEntity($pathway, $pathdeets);
        if ($this->Pathways->save($pathway)) {
            //echo 'Pathway created.<br>';
            $pathid = $pathway->id;
            $st = TableRegistry::getTableLocator()->get('Steps');
            $act = TableRegistry::getTableLocator()->get('Activities');
            $asteptable = TableRegistry::getTableLocator()->get('ActivitiesSteps');
            foreach($path->steps as $step) {

                $newstep = $st->newEmptyEntity();
                $stepdeets = [
                    'pathways' => [['id' => $pathid]],
                    'name' => $step->name,
                    'slug' => $step->slug,
                    'description' => $step->description,
                    'createdby' => $user->id,
                    'modifiedby' => $user->id
                ];
                
                $newstep = $st->patchEntity($newstep,$stepdeets, [
                    'associated' => [
                        'Pathways'
                    ]
                ]);
                if ($st->save($newstep)) {
                    //echo '<br><br>' . $step->name . ' created <br>';

                    foreach ($step->activities as $a) {
                        
                        $linktocheck = $a->hyperlink;
                        $check = $act->find()->where(function ($exp, $query) use($linktocheck) {
                                                        return $exp->like('Activities.hyperlink', '%'.$linktocheck.'%');
                                                    })->toList();
                        if(empty($check)) {
                            
                            $newact = $act->newEmptyEntity();
                            $actdeets = [
                                'status_id' => 2,
                                'activity_types_id' => 2,
                                'hyperlink' => $a->hyperlink,
                                'name' => $a->name,
                                'slug' => $a->slug,
                                'description' => $a->description,
                                'createdby_id' => $user->id,
                                'approvedby_id' => $user->id,
                                'modifiedby_id' => $user->id
                            ];
                            
                            $newact = $act->patchEntity($newact,$actdeets);
                            if ($act->save($newact)) {
                                //echo $a->name . ' created and added to new step<br>';


                                $activitiesStep = $asteptable->newEmptyEntity();
                                $context = $a->_joinData->stepcontext ?? '';
                                $req = $a->_joinData->required ?? 0;
                                $order = $a->_joinData->steporder ?? 0;
                                $actstdeets = [
                                    'step_id' => $newstep->id,
                                    'activity_id' => $newact->id,
                                    'steporder' => $order,
                                    'stepcontext' => $context,
                                    'required' => $req
                                ];
                                $activitiesStep = $asteptable->patchEntity($activitiesStep,$actstdeets);
    
                                if (!$asteptable->save($activitiesStep)) {
                                    echo 'Cannot add to step!';
                                    echo '' . $check[0]->id;
                                    //exit;
                                }




                            } else {
                                echo 'Activity could NOT be created.';
                            }

                        } else {

                            
                            $activitiesStep = $asteptable->newEmptyEntity();
                            $context = $a->_joinData->stepcontext ?? '';
                            $req = $a->_joinData->required ?? 0;
                            $order = $a->_joinData->steporder ?? 0;
                            $actstdeets = [
                                'step_id' => $newstep->id,
                                'activity_id' => $check[0]->id,
                                'steporder' => $order,
                                'stepcontext' => $context,
                                'required' => $req
                            ];
                            $activitiesStep = $asteptable->patchEntity($activitiesStep,$actstdeets);

                            if (!$asteptable->save($activitiesStep)) {
                                echo 'Cannot add to step!';
                                echo '' . $check[0]->id;
                                //exit;
                            }
                            //echo $check[0]->id . ' exists already ... adding!<br>';

                        }

                    }



                    
                } else {
                    echo 'Step NOT created<br>';
                }

            }

            //$this->set(compact('path','pathid'));
            $redir = '/pathways/' . $path->slug;
            return $this->redirect($redir);

        } else {
            echo 'Something went wrong importing this pathway.';
            exit;
        }
        
        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        $pathway = $this->Pathways->newEmptyEntity();
        if ($this->request->is('post')) {
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            $sluggedTitle = Text::slug($pathway->name);
            // trim slug to maximum length defined in schema
            $pathway->slug = strtolower(substr($sluggedTitle, 0, 191));
            //echo '<pre>'; print_r($this->request->getData()); exit;
            if ($this->Pathways->save($pathway)) {
                //$this->Flash->success(__('The pathway has been saved.'));
                $redir = '/pathways/' . $sluggedTitle;
                return $this->redirect($redir);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }
        
        $categories = $this->Pathways->Topics->Categories->find('all', ['contain' =>['Topics'], 'limit' => 200]);
        
        $areas = [];
        foreach($categories as $c) {
            $cat = $c->name;
            foreach($c->topics as $t) {
                $top = $t->name;
                $mergedtitle = $cat . ' - ' . $top;
                $merged = ['text' => $mergedtitle, 'value' => $t->id];
                array_push($areas,$merged);
            }
        }

        //$topics = $this->Pathways->Topics->find('list', ['limit' => 200]);
        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $statuses = $this->Pathways->Statuses->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'areas', 'ministries', 'statuses', 'competencies', 'steps', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Competencies', 'Steps', 'Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            $sluggedTitle = Text::slug($pathway->name);
            // trim slug to maximum length defined in schema
            $pathway->slug = strtolower(substr($sluggedTitle, 0, 191));
            if ($this->Pathways->save($pathway)) {
                $this->Flash->success(__('The pathway has been saved.'));
                $redir = '/pathways/' . $sluggedTitle;
                return $this->redirect($redir);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }

        $topics = $this->Pathways->Topics->find('list', ['limit' => 200]);

        $categories = $this->Pathways->Topics->Categories->find('all', ['contain' =>['Topics'], 'limit' => 200]);
        
        $areas = [];
        foreach($categories as $c) {
            $cat = $c->name;
            foreach($c->topics as $t) {
                $top = $t->name;
                $mergedtitle = $cat . ' - ' . $top;
                $merged = ['text' => $mergedtitle, 'value' => $t->id];
                array_push($areas,$merged);
            }
        }
        

        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $statuses = $this->Pathways->Statuses->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'areas', 'ministries', 'statuses', 'competencies', 'steps', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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
        
        $this->viewBuilder()->setLayout('ajax');
        // As we loop through the activities for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that activity.
	    $user = $this->request->getAttribute('authentication')->getIdentity();
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
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Steps', 'Steps.Activities'],
        ]);
        if (!empty($pathway->steps)) :
            $requiredacts = 0;
            $completed = 0;
            foreach ($pathway->steps as $step) :
                foreach ($step->activities as $activity):
                    if($activity->status_id == 2) {
                        if($activity->_joinData->required == 1) {
                            $requiredacts++;
                            $actlist = array_count_values($useractivitylist); 
                            foreach($actlist as $k => $v) {
                                if($k == $activity->id) {
                                    if($v > 0) $completed++;
                                }
                            }
                        }
                    }
                endforeach; // activities
            endforeach; // steps
            $percentage = floor(($completed / $requiredacts) * 100);
            $name = $pathway->name;
            $this->set(compact(['name','requiredacts','completed','percentage']));        
        endif; // if steps


    } // end of method

}

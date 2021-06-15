<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')
                                ->contain(['Steps','Statuses'])
                                ->order(['Pathways.created' => 'desc'])
                                ->where(['Pathways.featured' => 1])
                                ->limit(10);
        $allpathways = $pathways->toList();
       
        $activities = $this->Activities
                            ->find('all')
                            ->contain(['Statuses', 
                                        'Ministries', 
                                        'ActivityTypes',
                                        'Steps.Pathways'])
                            ->where(['Activities.status_id' => 2])
                            ->order(['Activities.recommended' => 'DESC'])
                            ->limit(5);
        
		$cats = TableRegistry::getTableLocator()->get('Categories');
        $allcats = $cats->find('all')->contain(['Topics'])->order(['Categories.created' => 'desc']);
        


        $this->set(compact('activities','allpathways','allcats'));
    }

    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
     //
        // Check to see if the current user has "claimed" 
        // this activity. Here we get the current user id and use it to select 
        // all of the claimed activities assigned to them, and then process out 
        // just the activity IDs into a simple array. Then, in the template 
        // code, we if(in_array($activity->id,$useractivitylist)):
        //
        // First let's check to see if this person is logged in or not.
        //
	    $user = $this->request->getAttribute('authentication')->getIdentity();
        if(!empty($user)) {
        
            // We need create am empty array first. If nothing gets added to
            // it, so be it
            $useractivitylist = array();

            // Get access to the appropriate table
            $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
            
            // Select all activities that this user has claimed
            $useacts = $au->find()->where(['user_id = ' => $user->id]);

            // convert the results into a simple array so that we can
            // use in_array in the template
            $useractivities = $useacts->toList();

            // Loop through the resources and add just the ID to the 
            // array that we will pass into the template
            // #TODO this is probably really inefficient #refactor
            foreach($useractivities as $uact) {
                array_push($useractivitylist, $uact['activity_id']);
            }


        }
        $activity = $this->Activities->get($id, [
            'contain' => ['Statuses', 
                            'Ministries', 
                            'ActivityTypes', 
                            'Competencies', 
                            'Steps', 
                            'Steps.Pathways', 
                            'Tags',
                            'Reports'],
        ]);

        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps']);
        $allpathways = $pathways->toList();

        $this->set(compact('activity', 'useractivitylist','allpathways'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->request->getAttribute('authentication')->getIdentity();
            
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            $sluggedTitle = Text::slug($activity->name);
            // trim slug to maximum length defined in schema
            $activity->slug = strtolower(substr($sluggedTitle, 0, 191));
            $activity->createdby_id = $user->id;
            $activity->modifiedby_id = $user->id;
            $activity->approvedby_id = $user->id;

            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $statuses = $this->Activities->Statuses->find('list', ['limit' => 200]);
        $ministries = $this->Activities->Ministries->find('list', ['limit' => 200]);
        $activityTypes = $this->Activities->ActivityTypes->find('list', ['limit' => 200]);
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $competencies = $this->Activities->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Activities->Steps->find('list', ['limit' => 200]);
        $tags = $this->Activities->Tags->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'statuses', 'ministries', 'activityTypes', 'users', 'competencies', 'steps', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => ['Users', 'Competencies', 'Steps', 'Tags', 'Steps.Pathways'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            $sluggedTitle = Text::slug($activity->name);
            // trim slug to maximum length defined in schema
            $activity->slug = strtolower(substr($sluggedTitle, 0, 191));
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));
                $go = '/activities/view/' . $id;
                return $this->redirect($go);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $statuses = $this->Activities->Statuses->find('list', ['limit' => 200]);
        $ministries = $this->Activities->Ministries->find('list', ['limit' => 200]);
        $activityTypes = $this->Activities->ActivityTypes->find('list', ['limit' => 200]);
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $competencies = $this->Activities->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Activities->Steps->find('list', ['limit' => 200]);
        $tags = $this->Activities->Tags->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'statuses', 'ministries', 'activityTypes', 'users', 'competencies', 'steps', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Claim an activity
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function claim($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
  
            if ($this->Activities->save($activity)) {
                return $this->redirect($this->referer());
            }
        }

    }
    
    /**
     * Find method for activities; this is super-duper basic and search deserves better thab
     *
     * @param string|null $search search pararmeters to lookup activities.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function find()
    {

	    $search = $this->request->getQuery('q');
        $activities = $this->Activities->find()->
                                        contain('Steps.Pathways','ActivityTypes')->
                                        where(function ($exp, $query) use($search) {
            return $exp->like('name', '%'.$search.'%');
        })->order(['name' => 'ASC']);
        $activities = $this->Activities->find()->
                                            contain('Steps.Pathways','ActivityTypes')->
                                            where(function ($exp, $query) use($search) {
                                                return $exp->like('description', '%'.$search.'%');
                                            })->
                                            order(['name' => 'ASC']);
        $numresults = $activities->count();
        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps']);
        $allpathways = $pathways->toList();
        
        $this->set(compact('activities','allpathways','search', 'numresults'));
    }
    /**
     * Find method for activities; intended for use as an auto-complete
     *  search function for adding activities to steps
     *
     * @param string|null $search search pararmeters to lookup activities.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function stepfind()
    {
        $search = $this->request->getQuery('q');
        $stepid = $this->request->getQuery('step_id');
        
        $activities = $this->Activities->find()->contain('Steps.Pathways')->where(function ($exp, $query) use($search) {
            return $exp->like('name', '%'.$search.'%');
        })->order(['name' => 'ASC']);

        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps']);
        $allpathways = $pathways->toList();

        $this->set(compact('activities','allpathways','stepid'));
    }

    /**
    * Like an activity
    *
    * @return \Cake\Http\Response|null Redirects to courses index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    *
    */
    public function like ($id = null)
    {
        $activity = $this->Activities->get($id);
        $newlike = $activity->recommended;
        $newlike++;
        $this->request->getData()['recommended'] = $newlike;
        $activity->recommended = $newlike;
        if ($this->request->is(['get'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                echo 'Liked!';
                //return $this->redirect($this->referer());
            } else {
                //print(__('The activity could not be saved. Please, try again.'));
            }
        }
    }
    
}

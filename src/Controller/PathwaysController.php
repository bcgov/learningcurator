<?php
declare(strict_types=1);

namespace App\Controller;


Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

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
            $pathways = $paths->find('all')->contain(['Topics','Topics.Categories','Statuses']);
        } else {
            $pathways = $paths->find('all')
                                ->contain(['Topics','Topics.Categories','Statuses'])
                                ->where(['Pathways.featured' => 1])
                                ->where(['status_id' => 2]);
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
        // As we loop through the activities for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that activity. Here we get the current user id and use it to select 
        // all of the claimed activities assigned to them, and then process out 
        // just the activity IDs into a simple array. Then, in the template 
        // code, we can simply  if(in_array($rj->activity->id,$useractivitylist
        //
        // First let's get the user details:
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
        $pathway = $this->Pathways->findBySlug($slug)->contain([
                            'Topics',
                            'Topics.Categories', 
                            'Ministries', 
                            'Steps' => ['sort' => ['PathwaysSteps.sortorder' => 'asc']],
                            'Steps.Statuses', 
                            'Steps.Activities', 
                            'Steps.Activities.ActivityTypes', 
                            'Users'])->firstOrFail();
        //
        // we want to be able to tell if the current user is already on this
        // pathway or not, so we take the same approach as above, parsing all
        // the users into a single array so that we can perform a simple
        // in_array($thisuser,$usersonthispathway) check and show the "take
        // this Pathway" button or "you're on this Pathway" text
        //
        // Create the initially empty array that we also pass into the template
        $usersonthispathway = array();
        $followers = array();
        // Loop through the users that are on this pathway and parse just the 
        // IDs into the array that we just created
        $followid = 0;
        foreach($pathway->users as $pu) {
            // Is the current user following this pathway? If so, then 
            // we record the pathways_users ID number so we can remove
            // the association (unfollow) if the user clicks the "Unfollow"
            // button.
            if($pu->id == $user->id) {
                $followid = $pu->_joinData->id;
            }
            array_push($usersonthispathway,$pu->id);
            array_push($followers,[$pu->id,$pu->username]);
        }

        if (!empty($pathway->steps)) :
            $percentage = 0;
            $totalclaimed = 0;
            $totalacts = 0;
            $requiredacts = 0;
            $suppacts = 0;
            foreach ($pathway->steps as $steps) :
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
            $percentage = floor(($totalclaimed / $requiredacts) * 100);
        endif;
        $this->set(compact('pathway', 'totalacts', 'requiredacts', 'suppacts', 'percentage', 'followid', 'usersonthispathway', 'useractivitylist','followers'));

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
                            'Steps.Activities.ActivityTypes', 
                            'Users'])->firstOrFail();
        
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
    public function import ()
    {
        $pathway = $this->Pathways->newEmptyEntity();
        if ($this->request->is('post')) {


            
            $pathway = $this->Pathways->patchEntity($pathway, );


            $sluggedTitle = Text::slug($pathway->name);
            // trim slug to maximum length defined in schema
            $pathway->slug = strtolower(substr($sluggedTitle, 0, 191));
            if ($this->Pathways->save($pathway)) {
                $redir = '/pathways/' . $sluggedTitle;
                return $this->redirect($redir);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
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
            if ($this->Pathways->save($pathway)) {
                $this->Flash->success(__('The pathway has been saved.'));
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
            $totalclaimed = 0;
            $requiredacts = 0;
            foreach ($pathway->steps as $steps) :
                foreach ($steps->activities as $activity):
                    if($activity->status_id == 2) {
                        if($activity->_joinData->required == 1) {
                            $requiredacts++;
                            if(in_array($activity->id, $useractivitylist)) {
                                $totalclaimed++;
                            }
                        }
                    }
                endforeach; // activities
            endforeach; // steps
            $percentage = floor(($totalclaimed / $requiredacts) * 100);
            $name = $pathway->name;
            $this->set(compact(['name','requiredacts','totalclaimed','percentage']));        
        endif; // if steps


    } // end of method

}

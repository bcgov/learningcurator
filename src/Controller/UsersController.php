<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ministries', 'Roles'],
        ];
        $users = $this->paginate($this->Users);
        // This doesn't work 
        // https://discourse.cakephp.org/t/authentication-index/7506/2
        //
        $this->Authorization->authorize($users);

        $this->set(compact('users'));
    }

    /**
     * List method
     *
     * @return \Cake\Http\Response|null
     */
    public function list()
    {
        $this->Authorization->skipAuthorization();
        $users = $this->paginate($this->Users, ['order' => ['Users.id' => 'desc']]);
        //$this->Authorization->can($users);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Ministries', 
                            'Roles', 
                            'Activities', 
                            'Competencies', 
                            'Pathways',
                            'Reports' => ['sort' => ['Reports.id' => 'desc']],
                            'Reports.Activities'],
        ]);
		//$categories = $this->Categories->find('all');
        $this->Authorization->authorize($user);

        $this->set('user', $user);
    }


    /**
     * Home method to show curators their pathways
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function home()
    {
        $userinfo = $this->request->getAttribute('authentication')->getIdentity();
        $user = $this->Users->get($userinfo->id, [
            'contain' => ['Ministries', 
                            'Roles', 
                            'Activities', 
                            'Competencies', 
                            'Pathways',
                            'Reports' => ['sort' => ['Reports.id' => 'desc']],
                            'Reports.Activities'],
        ]);
		//$categories = $this->Categories->find('all');
        $this->Authorization->authorize($user);

        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps','Statuses'])->where(['Pathways.createdby' => $userinfo->id]);

        $allcats = TableRegistry::getTableLocator()->get('Categories');
        $categories = $allcats->find('all')->contain(['Topics']);

        $this->set(compact('user', 'pathways', 'categories'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        
        $this->Authorization->authorize($user);
        if ($this->request->is('post')) {

            // I don't know why the following won't work 
            // to reassign the created date :( it's in the form now
            // leaving this here as a puzzler
            //$this->request->getData()['created'] = FrozenTime::now();
            //$user->created = FrozenTime::now();
            
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                print(__('The user has been saved.'));

                return $this->redirect(['action' => 'list']);
            }
            print(__('The user could not be saved. Please, try again.'));
        }
        $ministries = $this->Users->Ministries->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $activities = $this->Users->Activities->find('list', ['limit' => 200]);
        $competencies = $this->Users->Competencies->find('list', ['limit' => 200]);
        $pathways = $this->Users->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('user', 'ministries', 'roles', 'activities', 'competencies', 'pathways'));

    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Activities', 'Competencies', 'Pathways'],
        ]);
        $this->Authorization->authorize($user);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                print(__('The user has been saved.'));

                return $this->redirect($this->referer());
            }
            print(__('The user could not be saved. Please, try again.'));
        }
        $ministries = $this->Users->Ministries->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $activities = $this->Users->Activities->find('list', ['limit' => 200]);
        $competencies = $this->Users->Competencies->find('list', ['limit' => 200]);
        $pathways = $this->Users->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('user', 'ministries', 'roles', 'activities', 'competencies', 'pathways'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            print(__('The user has been deleted.'));
        } else {
            print(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @param 
     * @return \Cake\Http\Response|null Redirects to user home page.
     * @throws 
     */
    public function login() 
    {

        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /pages/home after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'home',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            print(__('Invalid username'));
        }
    }

    /**
     * Logout method
     *
     * @param 
     * @return \Cake\Http\Response|null Redirects to login page.
     * @throws 
     */
    public function logout()
    {

        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

   /**
     * User pathways method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function pathways()
    {

	    $u = $this->request->getAttribute('authentication')->getIdentity();
        $user = $this->Users->get($u->id, [
            'contain' => ['Pathways', 
                            'Pathways.Categories', 
                            'Activities', 
                            'Activities.ActivityTypes',
                            'Competencies',
                            'Ministries'],
        ]);
        $this->Authorization->authorize($user);
		
        $cats = TableRegistry::getTableLocator()->get('Categories');
        $allcats = $cats->find('all');
		
		
        $this->set(compact('user','allcats'));
    }
  /**
     * User bookmarks method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function bookmarks()
    {

	    $u = $this->request->getAttribute('authentication')->getIdentity();
        

        $books = TableRegistry::getTableLocator()->get('ActivitiesBookmarks');
        $bookmarks = $books->find('all')
                            ->where(['user_id' => $u->id])
                            ->contain(['Activities','Activities.ActivityTypes'])
                            ->order(['ActivitiesBookmarks.created' => 'desc']);
        
        $user = $this->Users->get($u->id, [
            'contain' => ['Pathways', 
                            'Pathways.Categories', 
                            'Activities', 
                            'Activities.ActivityTypes',
                            'Competencies',
                            'Ministries'],
        ]);
        $this->Authorization->authorize($user);
        
        $this->set(compact('user','bookmarks'));
    }
  /**
     * User claimed activities method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function claimed()
    {

	    $u = $this->request->getAttribute('authentication')->getIdentity();
        $user = $this->Users->get($u->id, [
            'contain' => ['Pathways', 
                            'Pathways.Categories', 
                            'Activities' => ['sort' => ['ActivitiesUsers.started' => 'desc']], 
                            'Activities.ActivityTypes',
                            'Activities.Steps',
                            'Activities.Steps.Pathways',
                            'Competencies',
                            'Ministries'],
        ]);
        $this->Authorization->authorize($user);

				
        $this->set(compact('user'));
    }
    
    /**
     * User reported activities method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function reports()
    {

	    $u = $this->request->getAttribute('authentication')->getIdentity();
        $user = $this->Users->get($u->id, [
            'contain' => ['Pathways', 
                            'Pathways.Categories', 
                            'Activities', 
                            'Activities.ActivityTypes',
                            'Competencies',
                            'Ministries',
                            'Reports' => ['sort' => ['Reports.id' => 'desc']],
                            'Reports.Activities'],
            
        ]);
        $this->Authorization->authorize($user);

				
        $this->set(compact('user'));
    }

}

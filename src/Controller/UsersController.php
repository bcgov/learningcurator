<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
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
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Ministries', 'Roles', 'Activities', 'Competencies', 'Pathways'],
        ]);
        $this->Authorization->authorize($user);

        $this->set('user', $user);
    }


    /**
     * User auto add method
     * This is the main controller that we redirect to when we detect a user who is
     * not logged in, and doesn't already have an account.
     *
     * @return \Cake\Http\Response|null Redirects on successful add, throws error on fail
     */
    public function autoadd()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();
        $user->createdby_id = 1;
        $user->modifiedby_id = 1;
        $user->ministry_id = 1;
        $user->role_id = 1;
        $user->name = 'Martin';
        $user->idir = 'martinking';
        $user->email = 'martinking@gov.bc.ca';
        $user->password = 'martinking';
    
        $user = $this->Users->patchEntity($user, $user);
        if ($this->Users->save($user)) {
            print 'Ya good.';
            //$this->Flash->success(__('The user has been saved.'));
            //return $this->redirect(['action' => 'home']);
        }
        print 'Ya bad.';
        //$this->Flash->error(__('The user could not be saved. Please, try again.'));

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
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
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
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
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
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
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
            $this->Flash->error(__('Invalid username'));
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
     * beforeFilter method
     *
     * @param string|null \Cake\Event\EventInterface $event.
     * @return 
     * @throws 
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // configure the login action to don't require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

   /**
     * Home method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function home()
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
        $this->set('user', $user);
    }

}

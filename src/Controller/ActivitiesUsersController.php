<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;

/**
 * ActivitiesUsers Controller
 *
 * @property \App\Model\Table\ActivitiesUsersTable $ActivitiesUsers
 * @method \App\Model\Entity\ActivitiesUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesUsersController extends AppController
{
    /**
     * User claims method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function claims()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        // Select based on currently logged in person
        $published = $allpaths->find('all')
                                ->contain(['Topics','Topics.Categories'])
                                ->where(['Pathways.status_id' => 2])
                                ->where(['Pathways.featured' => 1])
                                ->order(['Pathways.created' => 'desc']);

        $activities = $this->ActivitiesUsers->find()
                                        ->contain(['Users',
                                                    'Users.Ministries',
                                                    'Activities',
                                                    'Activities.ActivityTypes',
                                                    'Activities.Steps',
                                                    'Activities.Steps.Pathways'])
                                        ->where(['user_id' => $user->id])
                                        ->order(['ActivitiesUsers.created' => 'desc']);
        $this->set(compact('activities','published'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Activities', 'Users'],
        ];
        $activitiesUsers = $this->paginate($this->ActivitiesUsers);

        $this->set(compact('activitiesUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Activities User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitiesUser = $this->ActivitiesUsers->get($id, [
            'contain' => ['Activities', 'Users'],
        ]);

        $this->set(compact('activitiesUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activitiesUser = $this->ActivitiesUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $activitiesUser = $this->ActivitiesUsers->patchEntity($activitiesUser, $this->request->getData());
            if ($this->ActivitiesUsers->save($activitiesUser)) {
                $this->Flash->success(__('The activities user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activities user could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesUsers->Activities->find('list', ['limit' => 200]);
        $users = $this->ActivitiesUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('activitiesUser', 'activities', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activities User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activitiesUser = $this->ActivitiesUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitiesUser = $this->ActivitiesUsers->patchEntity($activitiesUser, $this->request->getData());
            if ($this->ActivitiesUsers->save($activitiesUser)) {
                $this->Flash->success(__('The activities user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activities user could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesUsers->Activities->find('list', ['limit' => 200]);
        $users = $this->ActivitiesUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('activitiesUser', 'activities', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activities User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitiesUser = $this->ActivitiesUsers->get($id);
        if ($this->ActivitiesUsers->delete($activitiesUser)) {
            //echo __('The activities user has been deleted.');
            return $this->redirect($this->referer());

        } else {
            echo __('The activities user could not be deleted. Please, try again.');
        }
    }
}

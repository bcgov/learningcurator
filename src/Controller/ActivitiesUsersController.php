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
     * User completions method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function completions()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $activities = $this->ActivitiesUsers->find()
                                        ->contain(['Users',
                                                    'Users.Ministries',
                                                    'Activities',
                                                    'Activities.ActivityTypes',
                                                    'Activities.Steps',
                                                    'Activities.Steps.Pathways'])
                                        ->where(['user_id' => $user->id])
                                        ->order(['ActivitiesUsers.created' => 'desc']);
        // echo '<pre>'; print_r($activities->toList(); exit;
        // $last = '';
        // $completed = [];
        // foreach($activities as $a) {
        //     if($last == $a->activity->name) {
        //         $t = [$a->activity->name, $a->created];
        //     }
        //     $last  = $a->activity->name;
        // }
        // exit;
        $this->set(compact('activities'));

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
     * Launch an activity and mark it complete at the same time
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, prints error otherwise.
     */
    public function launch ()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $aid = $this->request->getQuery('activity_id');
        $activitiesUser = $this->ActivitiesUsers->newEmptyEntity();
        $activitiesUser->user_id = $user->id;
        $activitiesUser->activity_id = $aid;
        if ($this->ActivitiesUsers->save($activitiesUser)) {
            $act = TableRegistry::getTableLocator()->get('Activities');
            $activity = $act->get($aid);
            return $this->redirect($activity->hyperlink);
        }
        print(__('Something went wrong!'));      
    }


    /**
     * Complete an activity by adding an entry here method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function complete ()
    {
          
        if ($this->request->is('post')) {

            $activitiesUser = $this->ActivitiesUsers->newEmptyEntity();
            $user = $this->request->getAttribute('authentication')->getIdentity();
            $activitiesUser->user_id = $user->id;
            $aid = $this->request->getData()['activity_id'];
            $activitiesUser->activity_id = $aid;

            if ($this->ActivitiesUsers->save($activitiesUser)) {
                return $this->redirect($this->referer());
            }
            print(__('Something went wrong and you not completed this activity yet. Please, try again.'));
        }
        
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

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
     * Activities which the current user has launched, and the dates
     * on which they launched them
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function launches ()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $activities = $this->ActivitiesUsers->find()
                                        ->contain(['Activities','Activities.ActivityTypes'])
                                        ->where(['user_id' => $user->id])
                                       ->order(['ActivitiesUsers.id' => 'desc']);
        // This returns a list of activities, but there's one activity
        // listed for each launch, rather than one activity and then the list 
        // of launches; so, we need to make it that way since having an 
        // activity listed a bunch of times doesn't make sense. 
        // I like working with arrays ...
        $acts = $activities->all()->toList();
        // Parse out a list of just the activity IDs so that we can reduce it
        $justactids = [];
        foreach($acts as $a) {
            array_push($justactids,$a->activity->id);
        }
        $actids = array_unique($justactids);
        // OK now loop through the reduced IDs and as we go we then loop 
        // through the entire big list and parse out the info we want 
        // #TODO there's a more elegant/efficient way of doing this, to be sure
        $alllaunches = [];
        foreach($actids as $id) {
            $name = '';
            $thisone = [];
            $launches = [];
        
            foreach($acts as $aid) {
                
                if($aid->activity->id == $id) {
                    $name = $aid->activity->name;
                    $type = [
                                'name' => $aid->activity->activity_type->name,
                                'iconclass' => $aid->activity->activity_type->image_path,
                                'color' => $aid->activity->activity_type->color
                            ];
                    array_push($launches,['date' => $aid['created']]);
                }
            }
            $thisone = ['id' => $id, 'name' => $name, 'type' => $type, 'launches' => $launches];
            array_push($alllaunches, $thisone);
        }
        
        $this->set(compact('alllaunches'));

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
        $stepid = $this->request->getQuery('step_id');
        $activitiesUser = $this->ActivitiesUsers->newEmptyEntity();
        $activitiesUser->user_id = $user->id;
        $activitiesUser->activity_id = $aid;
        $activitiesUser->step_id = $stepid;
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

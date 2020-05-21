<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ActivitiesSteps Controller
 *
 * @property \App\Model\Table\ActivitiesStepsTable $ActivitiesSteps
 *
 * @method \App\Model\Entity\ActivitiesStep[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesStepsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Activities', 'Steps'],
        ];
        $activitiesSteps = $this->paginate($this->ActivitiesSteps);
        $this->Authorization->authorize($activitiesSteps);

        $this->set(compact('activitiesSteps'));
    }

    /**
     * View method
     *
     * @param string|null $id Activities Step id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitiesStep = $this->ActivitiesSteps->get($id, [
            'contain' => ['Activities', 'Steps'],
        ]);

        $this->set('activitiesStep', $activitiesStep);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activitiesStep = $this->ActivitiesSteps->newEmptyEntity();
        $this->Authorization->authorize($activitiesStep);
        $activitiesStep->step_id = $this->request->getData()['step_id'];
        $activitiesStep->activity_id = $this->request->getData()['activity_id'];
        $pathid = $this->request->getData()['pathway_id'] ?? 0;
        if ($this->request->is('post')) {
            
            if ($this->ActivitiesSteps->save($activitiesStep)) {
                
                if(!empty($pathid)) {
                    $go = '/pathways/view/' . $pathid;
                } else {
                    $go = '/steps/edit/' . $this->request->getData()['step_id'];
                }
                return $this->redirect($go);

            }
            
        }
        $activities = $this->ActivitiesSteps->Activities->find('list', ['limit' => 200]);
        $steps = $this->ActivitiesSteps->Steps->find('list', ['limit' => 200]);
        $this->set(compact('activitiesStep', 'activities', 'steps'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activities Step id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activitiesStep = $this->ActivitiesSteps->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitiesStep = $this->ActivitiesSteps->patchEntity($activitiesStep, $this->request->getData());
            if ($this->ActivitiesSteps->save($activitiesStep)) {
                $this->Flash->success(__('The activities step has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The activities step could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesSteps->Activities->find('list', ['limit' => 200]);
        $steps = $this->ActivitiesSteps->Steps->find('list', ['limit' => 200]);
        $this->set(compact('activitiesStep', 'activities', 'steps'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activities Step id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'delete']);
        $activitiesStep = $this->ActivitiesSteps->get($id);

        if ($this->ActivitiesSteps->delete($activitiesStep)) {
            echo 'Good good';
            
        }
        return $this->redirect($this->referer());
    }


    /**
     * Make an activity required on a step method, or make it not required if it already is..
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function requiredToggle($id = null)
    {
        $activitiesStep = $this->ActivitiesSteps->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitiesStep = $this->ActivitiesSteps->patchEntity($activitiesStep, $this->request->getData());
            $this->Authorization->authorize($activitiesStep);
            if ($this->ActivitiesSteps->save($activitiesStep)) {
                $this->Flash->success(__('The activities step has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The activities step could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesSteps->Activities->find('list', ['limit' => 200]);
        $steps = $this->ActivitiesSteps->Steps->find('list', ['limit' => 200]);
        $this->set(compact('activitiesStep', 'activities', 'steps'));
        
    }

    /**
     * Set the order of an activity within a step
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function sort($id = null)
    {
        //$u = $this->request->getAttribute('authentication')->getIdentity();
        //$activitiesSteps = $this->ActivitiesSteps->newEmptyEntity();
        $activitiesStep = $this->ActivitiesSteps->get($id);
        $this->Authorization->authorize($activitiesStep);
        
        $order = $this->request->getData()['sortorder'];
        
        if($this->request->getData()['direction'] == 'up') {
            $neworder = $order + 2;
        } else {
            $neworder = $order - 2;
        }
        $activitiesStep->steporder = $neworder;
        //$activitiesSteps->activity_id = $this->request->getData()['activity_id'];
        
        if ($this->request->is('post')) {
            if ($this->ActivitiesSteps->save($activitiesStep)) {
                //$this->Flash->success(__('That activity is now in a different order. Good job!'));
                return $this->redirect($this->referer());
            }
            //$this->Flash->error(__('The users action could not be saved. Please, try again.'));
        }
    }


}

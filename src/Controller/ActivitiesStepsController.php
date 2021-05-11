<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ActivitiesSteps Controller
 *
 * @property \App\Model\Table\ActivitiesStepsTable $ActivitiesSteps
 * @method \App\Model\Entity\ActivitiesStep[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesStepsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Activities', 'Steps'],
        ];
        $activitiesSteps = $this->paginate($this->ActivitiesSteps);

        $this->set(compact('activitiesSteps'));
    }

    /**
     * View method
     *
     * @param string|null $id Activities Step id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitiesStep = $this->ActivitiesSteps->get($id, [
            'contain' => ['Activities', 'Steps'],
        ]);

        $this->set(compact('activitiesStep'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activitiesStep = $this->ActivitiesSteps->newEmptyEntity();
        if ($this->request->is('post')) {
            $activitiesStep = $this->ActivitiesSteps->patchEntity($activitiesStep, $this->request->getData());
            if ($this->ActivitiesSteps->save($activitiesStep)) {
                $this->Flash->success(__('The activities step has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activities step could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesSteps->Activities->find('list', ['limit' => 200]);
        $steps = $this->ActivitiesSteps->Steps->find('list', ['limit' => 200]);
        $this->set(compact('activitiesStep', 'activities', 'steps'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activities Step id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
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

                return $this->redirect(['action' => 'index']);
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
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitiesStep = $this->ActivitiesSteps->get($id);
        if ($this->ActivitiesSteps->delete($activitiesStep)) {
            $this->Flash->success(__('The activities step has been deleted.'));
        } else {
            $this->Flash->error(__('The activities step could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
            if ($this->ActivitiesSteps->save($activitiesStep)) {
                print(__('The activities step has been saved.'));

                return $this->redirect($this->referer());
            }
            print(__('The activities step could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesSteps->Activities->find('list', ['limit' => 200]);
        $steps = $this->ActivitiesSteps->Steps->find('list', ['limit' => 200]);
        $this->set(compact('activitiesStep', 'activities', 'steps'));
        
    }
}

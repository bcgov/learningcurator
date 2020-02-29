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
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitiesStep = $this->ActivitiesSteps->get($id);
	//$activitiesSteps->activity_id = $this->request->getData()['activity_id'];
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
    public function requiredToggle()
    {
    $u = $this->request->getAttribute('authentication')->getIdentity();
    $activitiesSteps = $this->ActivitiesSteps->newEmptyEntity();
    $this->Authorization->authorize($activitiesSteps);
	if($this->request->getData()['required'] == 1) {
		$activitiesSteps->required = 1;
	} else {
		$activitiesSteps->required = 0;
	}
	$activitiesSteps->step_id = $this->request->getData()['step_id'];
	$activitiesSteps->activity_id = $this->request->getData()['activity_id'];
        if ($this->request->is('post')) {
            if ($this->ActivitiesSteps->save($activitiesSteps)) {
                $this->Flash->success(__('That activity is now required. Good job!'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The users action could not be saved. Please, try again.'));
        }
    }



}

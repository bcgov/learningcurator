<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PathwaysSteps Controller
 *
 * @property \App\Model\Table\PathwaysStepsTable $PathwaysSteps
 *
 * @method \App\Model\Entity\PathwaysStep[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysStepsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'contain' => ['Steps', 'Pathways'],
        ];
        $pathwaysSteps = $this->paginate($this->PathwaysSteps);

        $this->set(compact('pathwaysSteps'));
    }

    /**
     * View method
     *
     * @param string|null $id Pathways Step id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pathwaysStep = $this->PathwaysSteps->get($id, [
            'contain' => ['Steps', 'Pathways'],
        ]);

        $this->set('pathwaysStep', $pathwaysStep);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pathwaysStep = $this->PathwaysSteps->newEmptyEntity();
        if ($this->request->is('post')) {
            $pathwaysStep = $this->PathwaysSteps->patchEntity($pathwaysStep, $this->request->getData());
            if ($this->PathwaysSteps->save($pathwaysStep)) {
                $this->Flash->success(__('The pathways step has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pathways step could not be saved. Please, try again.'));
        }
        $steps = $this->PathwaysSteps->Steps->find('list', ['limit' => 200]);
        $pathways = $this->PathwaysSteps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('pathwaysStep', 'steps', 'pathways'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pathways Step id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pathwaysStep = $this->PathwaysSteps->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pathwaysStep = $this->PathwaysSteps->patchEntity($pathwaysStep, $this->request->getData());
            if ($this->PathwaysSteps->save($pathwaysStep)) {
                $this->Flash->success(__('The pathways step has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pathways step could not be saved. Please, try again.'));
        }
        $steps = $this->PathwaysSteps->Steps->find('list', ['limit' => 200]);
        $pathways = $this->PathwaysSteps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('pathwaysStep', 'steps', 'pathways'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathways Step id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        
        //$pathwaysStep = $this->PathwaysSteps->get($id);
        $pathid = $this->request->getData()['pathway_id'];
        $stepid = $this->request->getData()['step_id'];
        $pathwaysStep = $this->PathwaysSteps->find()->where(['pathway_id' => $pathid])->where(['step_id' => $stepid]);
        

        if ($this->PathwaysSteps->delete($pathwaysStep)) {
            $this->Flash->success(__('The pathways step has been deleted.'));
        } else {
            $this->Flash->error(__('The pathways step could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

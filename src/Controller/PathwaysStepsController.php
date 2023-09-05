<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PathwaysSteps Controller
 *
 * @property \App\Model\Table\PathwaysStepsTable $PathwaysSteps
 * @method \App\Model\Entity\PathwaysStep[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysStepsController extends AppController
{
    /**
     * Reorder steps along a pathway
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function reorder ()
    {

        $count = 0;
        foreach($this->request->getData()['steps'] as $s) {
            $order = $this->request->getData()['steporder'][$count];
            $count++;
            $pathStep = $this->PathwaysSteps->get($s);
            $new['sortorder'] = $order;
            $pathwaysStep = $this->PathwaysSteps->patchEntity($pathStep, $new);
            if (!$this->PathwaysSteps->save($pathwaysStep)) {
                echo 'Something went wrong! Sorry!';
                exit;
            }
        }
        return $this->redirect($this->referer());
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Pathways Step id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
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
        $steps = $this->PathwaysSteps->Steps->find('list', ['limit' => 200])->all();
        $pathways = $this->PathwaysSteps->Pathways->find('list', ['limit' => 200])->all();
        $this->set(compact('pathwaysStep', 'steps', 'pathways'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathways Step id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pathwaysStep = $this->PathwaysSteps->get($id);
        if ($this->PathwaysSteps->delete($pathwaysStep)) {
            $this->Flash->success(__('The pathways step has been deleted.'));
        } else {
            $this->Flash->error(__('The pathways step could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

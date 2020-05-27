<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;

/**
 * Steps Controller
 *
 * @property \App\Model\Table\StepsTable $Steps
 *
 * @method \App\Model\Entity\Step[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StepsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $steps = $this->paginate($this->Steps);

        $this->set(compact('steps'));
    }

    /**
     * View method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $step = $this->Steps->get($id, [
            'contain' => ['Activities', 'Activities.ActivityTypes', 'Activities.Tags', 'Pathways', 'Pathways.Steps'],
        ]);
        $this->Authorization->authorize($step);
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need create an empty array first. If nothing gets added to
        // it, so be it
        $useractivitylist = array();
        // Get access to the apprprioate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select based on currently logged in person
        $useacts = $au->find()->where(['user_id = ' => $user->id]);
        // convert the results into a simple array so that we can
        // use in_array in the template
        $useractivities = $useacts->toList();
        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }

        $this->set(compact('step','useractivitylist'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $step = $this->Steps->newEmptyEntity();
        $this->Authorization->authorize($step);
        if ($this->request->is('post')) {
            $step = $this->Steps->patchEntity($step, $this->request->getData());
            if ($this->Steps->save($step)) {
                //$this->Flash->success(__('The step has been saved.'));
                $go = '/steps/edit/' . $step->id;
                return $this->redirect($go);
            }
            //$this->Flash->error(__('The step could not be saved. Please, try again.'));
        }
        $activities = $this->Steps->Activities->find('list', ['limit' => 200]);
        $pathways = $this->Steps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('step', 'activities', 'pathways'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $step = $this->Steps->get($id, [
            'contain' => ['Activities', 'Pathways'],
        ]);
        
        $this->Authorization->authorize($step);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $step = $this->Steps->patchEntity($step, $this->request->getData());
            if ($this->Steps->save($step)) {
                //$this->Flash->success(__('The step has been saved.'));
                $pathback = '/pathways/view/' . $step->pathways[0]->id;
                return $this->redirect($pathback);
            }
            //$this->Flash->error(__('The step could not be saved. Please, try again.'));
        }
        $activities = $this->Steps->Activities->find('list', ['limit' => 200]);
        $pathways = $this->Steps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('step', 'activities', 'pathways'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->Authorization->authorize($step);
        $step = $this->Steps->get($id);
        if ($this->Steps->delete($step)) {
            //$this->Flash->success(__('The step has been deleted.'));
        } else {
            //$this->Flash->error(__('The step could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

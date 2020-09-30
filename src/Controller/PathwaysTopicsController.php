<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PathwaysTopics Controller
 *
 * @property \App\Model\Table\PathwaysTopicsTable $PathwaysTopics
 *
 * @method \App\Model\Entity\PathwaysTopic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysTopicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Pathways', 'Topics'],
        ];
        $pathwaysTopics = $this->paginate($this->PathwaysTopics);

        $this->set(compact('pathwaysTopics'));
    }

    /**
     * View method
     *
     * @param string|null $id Pathways Topic id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pathwaysTopic = $this->PathwaysTopics->get($id, [
            'contain' => ['Pathways', 'Topics'],
        ]);

        $this->set('pathwaysTopic', $pathwaysTopic);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pathwaysTopic = $this->PathwaysTopics->newEmptyEntity();
        if ($this->request->is('post')) {
            $pathwaysTopic = $this->PathwaysTopics->patchEntity($pathwaysTopic, $this->request->getData());
            if ($this->PathwaysTopics->save($pathwaysTopic)) {
                print(__('The pathways topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The pathways topic could not be saved. Please, try again.'));
        }
        $pathways = $this->PathwaysTopics->Pathways->find('list', ['limit' => 200]);
        $topics = $this->PathwaysTopics->Topics->find('list', ['limit' => 200]);
        $this->set(compact('pathwaysTopic', 'pathways', 'topics'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pathways Topic id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pathwaysTopic = $this->PathwaysTopics->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pathwaysTopic = $this->PathwaysTopics->patchEntity($pathwaysTopic, $this->request->getData());
            if ($this->PathwaysTopics->save($pathwaysTopic)) {
                print(__('The pathways topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The pathways topic could not be saved. Please, try again.'));
        }
        $pathways = $this->PathwaysTopics->Pathways->find('list', ['limit' => 200]);
        $topics = $this->PathwaysTopics->Topics->find('list', ['limit' => 200]);
        $this->set(compact('pathwaysTopic', 'pathways', 'topics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathways Topic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pathwaysTopic = $this->PathwaysTopics->get($id);
        if ($this->PathwaysTopics->delete($pathwaysTopic)) {
            print(__('The pathways topic has been deleted.'));
        } else {
            print(__('The pathways topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

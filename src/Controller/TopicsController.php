<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Topics Controller
 *
 * @property \App\Model\Table\TopicsTable $Topics
 *
 * @method \App\Model\Entity\Topic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopicsController extends AppController
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
            'contain' => ['Users'],
        ];
        $topics = $this->paginate($this->Topics);

        $this->set(compact('topics'));
    }

    /**
     * View method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $topic = $this->Topics->get($id, [
            'contain' => ['Users', 'Categories'],
        ]);
        $this->Authorization->authorize($topic);

        $this->set('topic', $topic);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $topic = $this->Topics->newEmptyEntity();
        $this->Authorization->authorize($topic);
        if ($this->request->is('post')) {
            $topic = $this->Topics->patchEntity($topic, $this->request->getData());
            if ($this->Topics->save($topic)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $users = $this->Topics->Users->find('list', ['limit' => 200]);
        $categories = $this->Topics->Categories->find('list', ['limit' => 200]);
        $this->set(compact('topic', 'users', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $topic = $this->Topics->get($id, [
            'contain' => ['Categories'],
        ]);
        $this->Authorization->authorize($topic);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $topic = $this->Topics->patchEntity($topic, $this->request->getData());
            if ($this->Topics->save($topic)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $users = $this->Topics->Users->find('list', ['limit' => 200]);
        $categories = $this->Topics->Categories->find('list', ['limit' => 200]);
        $this->set(compact('topic', 'users', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $topic = $this->Topics->get($id);
        $this->Authorization->authorize($topic);
        if ($this->Topics->delete($topic)) {
            $this->Flash->success(__('The topic has been deleted.'));
        } else {
            $this->Flash->error(__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

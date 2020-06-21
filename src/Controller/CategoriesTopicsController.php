<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CategoriesTopics Controller
 *
 * @property \App\Model\Table\CategoriesTopicsTable $CategoriesTopics
 *
 * @method \App\Model\Entity\CategoriesTopic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesTopicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Topics'],
        ];
        $categoriesTopics = $this->paginate($this->CategoriesTopics);

        $this->set(compact('categoriesTopics'));
    }

    /**
     * View method
     *
     * @param string|null $id Categories Topic id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoriesTopic = $this->CategoriesTopics->get($id, [
            'contain' => ['Categories', 'Topics'],
        ]);

        $this->set('categoriesTopic', $categoriesTopic);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoriesTopic = $this->CategoriesTopics->newEmptyEntity();
        if ($this->request->is('post')) {
            $categoriesTopic = $this->CategoriesTopics->patchEntity($categoriesTopic, $this->request->getData());
            if ($this->CategoriesTopics->save($categoriesTopic)) {
                $this->Flash->success(__('The categories topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categories topic could not be saved. Please, try again.'));
        }
        $categories = $this->CategoriesTopics->Categories->find('list', ['limit' => 200]);
        $topics = $this->CategoriesTopics->Topics->find('list', ['limit' => 200]);
        $this->set(compact('categoriesTopic', 'categories', 'topics'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categories Topic id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriesTopic = $this->CategoriesTopics->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriesTopic = $this->CategoriesTopics->patchEntity($categoriesTopic, $this->request->getData());
            if ($this->CategoriesTopics->save($categoriesTopic)) {
                $this->Flash->success(__('The categories topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categories topic could not be saved. Please, try again.'));
        }
        $categories = $this->CategoriesTopics->Categories->find('list', ['limit' => 200]);
        $topics = $this->CategoriesTopics->Topics->find('list', ['limit' => 200]);
        $this->set(compact('categoriesTopic', 'categories', 'topics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categories Topic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriesTopic = $this->CategoriesTopics->get($id);
        if ($this->CategoriesTopics->delete($categoriesTopic)) {
            $this->Flash->success(__('The categories topic has been deleted.'));
        } else {
            $this->Flash->error(__('The categories topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

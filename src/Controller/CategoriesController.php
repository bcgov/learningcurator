<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{

    /**
     * Home page method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function home()
    {
        $categories = $this->Categories->find()->contain(['Topics','Topics.Pathways']);
        $featuredpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $featuredpaths->find('all')
                                ->contain(['Statuses','Topics','Topics.Categories'])
                                ->order(['Pathways.created' => 'desc'])
                                ->where(['Pathways.featured' => 1])
                                ->where(['Pathways.status_id' => 2])
                                ->limit(10);
        $featuredpathways = $pathways->toList();

        $this->set(compact('categories','featuredpathways'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $categories = $this->Categories->find('all')
                                        ->contain(['Topics','Topics.Pathways'])
                                        ->where(['Categories.featured' => 1]);


        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        //$categories = $this->Categories->find('all')->where(['Categories.featured' => 1]);
        $category = $this->Categories->get($id, [
            'contain' => ['Topics','Topics.Pathways','Topics.Pathways.Statuses'],
        ]);

        $this->set(compact('category'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            $sluggedTitle = Text::slug($category->name);
            // trim slug to maximum length defined in schema
            $category->slug = strtolower(substr($sluggedTitle, 0, 191));
            if ($this->Categories->save($category)) {
                $redir = '/categories/view/' . $category->id;
                return $this->redirect($redir);
            }
            echo __('The category could not be saved. Please, try again.');
        }
        $users = $this->Categories->Users->find('list', ['limit' => 200]);
        $topics = $this->Categories->Topics->find('list', ['limit' => 200]);
        $this->set(compact('category', 'topics', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Topics'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                //$this->Flash->success(__('The category has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $topics = $this->Categories->Topics->find('list', ['limit' => 200]);
        $this->set(compact('category', 'topics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * StatsPerpath Controller
 *
 * @property \App\Model\Table\StatsPerpathTable $StatsPerpath
 * @method \App\Model\Entity\StatsPerpath[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatsPerpathController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Pathways'],
        ];
        $statsPerpath = $this->paginate($this->StatsPerpath);

        $this->set(compact('statsPerpath'));
    }

    /**
     * View method
     *
     * @param string|null $id Stats Perpath id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $statsPerpath = $this->StatsPerpath->get($id, [
            'contain' => ['Pathways'],
        ]);

        $this->set(compact('statsPerpath'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $statsPerpath = $this->StatsPerpath->newEmptyEntity();
        if ($this->request->is('post')) {
            $statsPerpath = $this->StatsPerpath->patchEntity($statsPerpath, $this->request->getData());
            if ($this->StatsPerpath->save($statsPerpath)) {
                $this->Flash->success(__('The stats perpath has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stats perpath could not be saved. Please, try again.'));
        }
        $pathways = $this->StatsPerpath->Pathways->find('list', ['limit' => 200])->all();
        $this->set(compact('statsPerpath', 'pathways'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stats Perpath id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $statsPerpath = $this->StatsPerpath->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $statsPerpath = $this->StatsPerpath->patchEntity($statsPerpath, $this->request->getData());
            if ($this->StatsPerpath->save($statsPerpath)) {
                $this->Flash->success(__('The stats perpath has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stats perpath could not be saved. Please, try again.'));
        }
        $pathways = $this->StatsPerpath->Pathways->find('list', ['limit' => 200])->all();
        $this->set(compact('statsPerpath', 'pathways'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stats Perpath id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $statsPerpath = $this->StatsPerpath->get($id);
        if ($this->StatsPerpath->delete($statsPerpath)) {
            $this->Flash->success(__('The stats perpath has been deleted.'));
        } else {
            $this->Flash->error(__('The stats perpath could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

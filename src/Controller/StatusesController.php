<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Statuses Controller
 *
 * @property \App\Model\Table\StatusesTable $Statuses
 *
 * @method \App\Model\Entity\Status[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatusesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $statuses = $this->paginate($this->Statuses);

        $this->set(compact('statuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Status id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $status = $this->Statuses->get($id, [
            'contain' => ['Activities', 'PathwaysUsers'],
        ]);

        $this->set('status', $status);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $status = $this->Statuses->newEmptyEntity();
        $this->Authorization->authorize($status);
        if ($this->request->is('post')) {
            $status = $this->Statuses->patchEntity($status, $this->request->getData());
            if ($this->Statuses->save($status)) {
                //print(__('The status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            //print(__('The status could not be saved. Please, try again.'));
        }
        $this->set(compact('status'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Status id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $status = $this->Statuses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $status = $this->Statuses->patchEntity($status, $this->request->getData());
            if ($this->Statuses->save($status)) {
                print(__('The status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The status could not be saved. Please, try again.'));
        }
        $this->set(compact('status'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Status id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Statuses->get($id);
        if ($this->Statuses->delete($status)) {
            print(__('The status has been deleted.'));
        } else {
            print(__('The status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

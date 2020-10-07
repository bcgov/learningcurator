<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 *
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{

    /**
     * List all reports method
     *
     * @return \Cake\Http\Response|null
     */
    public function listit()
    {
        
        $reports = $this->Reports->find('all')->contain(['Users','Activities']);
        //$this->Authorization->authorize($reports);
        $this->Authorization->skipAuthorization();
        $user = $this->request->getAttribute('identity');
        $this->set(compact('reports'));   

    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $report = $this->Reports->get($id, [
            'contain' => ['Activities', 'Users'],
        ]);
        $this->Authorization->authorize($report);

        $this->set('report', $report);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $report = $this->Reports->newEmptyEntity();
        $this->Authorization->authorize($report);
        if ($this->request->is('post')) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {
                print(__('The report has been saved.'));

                return $this->redirect($this->referer());
            }
            print(__('The report could not be saved. Please, try again.'));
        }
        $activities = $this->Reports->Activities->find('list', ['limit' => 200]);
        $users = $this->Reports->Users->find('list', ['limit' => 200]);
        $this->set(compact('report', 'activities', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $report = $this->Reports->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($report);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {
                print(__('The report has been saved.'));

                return $this->redirect($this->referer());
            }
            print(__('The report could not be saved. Please, try again.'));
        }
        $activities = $this->Reports->Activities->find('list', ['limit' => 200]);
        $users = $this->Reports->Users->find('list', ['limit' => 200]);
        $this->set(compact('report', 'activities', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $report = $this->Reports->get($id);
        $this->Authorization->authorize($report);
        if ($this->Reports->delete($report)) {
            print(__('The report has been deleted.'));
        } else {
            print(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}

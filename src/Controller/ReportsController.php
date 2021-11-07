<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Mailer\Mailer;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{
    /**
     * Show the user their own reports method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function reports ()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $reports = $this->Reports->find('all')
                                ->contain(['Activities','Users'])
                                ->where(['user_id' => $user->id])
                                ->order(['Reports.created' => 'desc']);


        $this->set(compact('reports'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $reports = $this->Reports->find('all')
                                ->contain(['Activities','Users'])
                                ->order(['Reports.created' => 'desc']);


        $this->set(compact('reports'));
    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $report = $this->Reports->get($id, [
            'contain' => ['Activities', 'Users'],
        ]);

        $this->set(compact('report'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $report = $this->Reports->newEmptyEntity();
        if ($this->request->is('post')) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {
                echo __('The report has been saved.');
                $mailer = new Mailer('default');
                $mailer->setFrom(['learning.curator@gov.bc.ca' => 'Learning Curator'])
                        ->setTo('allan.haggett@gov.bc.ca')
                        ->setSubject('Curator Activity Report')
                        ->deliver('Someone filed an activity report. Go check it out.');
                //return $this->redirect($this->referer());
            }
            echo __('The report could not be saved. Please, try again.');
        }


    }

    /**
     * Edit method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $report = $this->Reports->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {
                $this->Flash->success(__('The report has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The report could not be saved. Please, try again.'));
        }
        $activities = $this->Reports->Activities->find('list', ['limit' => 200]);
        $users = $this->Reports->Users->find('list', ['limit' => 200]);
        $this->set(compact('report', 'activities', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $report = $this->Reports->get($id);
        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

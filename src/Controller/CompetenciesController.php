<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Competencies Controller
 *
 * @property \App\Model\Table\CompetenciesTable $Competencies
 *
 * @method \App\Model\Entity\Competency[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompetenciesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $competencies = $this->paginate($this->Competencies);

        $this->set(compact('competencies'));
    }

    /**
     * View method
     *
     * @param string|null $id Competency id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $competency = $this->Competencies->get($id, [
            'contain' => ['Activities', 'Pathways', 'Users'],
        ]);

        $this->set('competency', $competency);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $competency = $this->Competencies->newEmptyEntity();
        if ($this->request->is('post')) {
            $competency = $this->Competencies->patchEntity($competency, $this->request->getData());
            if ($this->Competencies->save($competency)) {
                print(__('The competency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The competency could not be saved. Please, try again.'));
        }
        $activities = $this->Competencies->Activities->find('list', ['limit' => 200]);
        $pathways = $this->Competencies->Pathways->find('list', ['limit' => 200]);
        $users = $this->Competencies->Users->find('list', ['limit' => 200]);
        $this->set(compact('competency', 'activities', 'pathways', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Competency id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $competency = $this->Competencies->get($id, [
            'contain' => ['Activities', 'Pathways', 'Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $competency = $this->Competencies->patchEntity($competency, $this->request->getData());
            if ($this->Competencies->save($competency)) {
                print(__('The competency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The competency could not be saved. Please, try again.'));
        }
        $activities = $this->Competencies->Activities->find('list', ['limit' => 200]);
        $pathways = $this->Competencies->Pathways->find('list', ['limit' => 200]);
        $users = $this->Competencies->Users->find('list', ['limit' => 200]);
        $this->set(compact('competency', 'activities', 'pathways', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Competency id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $competency = $this->Competencies->get($id);
        if ($this->Competencies->delete($competency)) {
            print(__('The competency has been deleted.'));
        } else {
            print(__('The competency could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

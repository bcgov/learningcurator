<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompetenciesUsers Controller
 *
 * @property \App\Model\Table\CompetenciesUsersTable $CompetenciesUsers
 *
 * @method \App\Model\Entity\CompetenciesUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompetenciesUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Competencies', 'Users'],
        ];
        $competenciesUsers = $this->paginate($this->CompetenciesUsers);

        $this->set(compact('competenciesUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Competencies User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $competenciesUser = $this->CompetenciesUsers->get($id, [
            'contain' => ['Competencies', 'Users'],
        ]);

        $this->set('competenciesUser', $competenciesUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $competenciesUser = $this->CompetenciesUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $competenciesUser = $this->CompetenciesUsers->patchEntity($competenciesUser, $this->request->getData());
            if ($this->CompetenciesUsers->save($competenciesUser)) {
                $this->Flash->success(__('The competencies user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The competencies user could not be saved. Please, try again.'));
        }
        $competencies = $this->CompetenciesUsers->Competencies->find('list', ['limit' => 200]);
        $users = $this->CompetenciesUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('competenciesUser', 'competencies', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Competencies User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $competenciesUser = $this->CompetenciesUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $competenciesUser = $this->CompetenciesUsers->patchEntity($competenciesUser, $this->request->getData());
            if ($this->CompetenciesUsers->save($competenciesUser)) {
                $this->Flash->success(__('The competencies user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The competencies user could not be saved. Please, try again.'));
        }
        $competencies = $this->CompetenciesUsers->Competencies->find('list', ['limit' => 200]);
        $users = $this->CompetenciesUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('competenciesUser', 'competencies', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Competencies User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $competenciesUser = $this->CompetenciesUsers->get($id);
        if ($this->CompetenciesUsers->delete($competenciesUser)) {
            $this->Flash->success(__('The competencies user has been deleted.'));
        } else {
            $this->Flash->error(__('The competencies user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

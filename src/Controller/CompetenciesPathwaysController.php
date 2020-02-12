<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompetenciesPathways Controller
 *
 * @property \App\Model\Table\CompetenciesPathwaysTable $CompetenciesPathways
 *
 * @method \App\Model\Entity\CompetenciesPathway[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompetenciesPathwaysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Competencies', 'Pathways'],
        ];
        $competenciesPathways = $this->paginate($this->CompetenciesPathways);

        $this->set(compact('competenciesPathways'));
    }

    /**
     * View method
     *
     * @param string|null $id Competencies Pathway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $competenciesPathway = $this->CompetenciesPathways->get($id, [
            'contain' => ['Competencies', 'Pathways'],
        ]);

        $this->set('competenciesPathway', $competenciesPathway);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $competenciesPathway = $this->CompetenciesPathways->newEmptyEntity();
        if ($this->request->is('post')) {
            $competenciesPathway = $this->CompetenciesPathways->patchEntity($competenciesPathway, $this->request->getData());
            if ($this->CompetenciesPathways->save($competenciesPathway)) {
                $this->Flash->success(__('The competencies pathway has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The competencies pathway could not be saved. Please, try again.'));
        }
        $competencies = $this->CompetenciesPathways->Competencies->find('list', ['limit' => 200]);
        $pathways = $this->CompetenciesPathways->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('competenciesPathway', 'competencies', 'pathways'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Competencies Pathway id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $competenciesPathway = $this->CompetenciesPathways->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $competenciesPathway = $this->CompetenciesPathways->patchEntity($competenciesPathway, $this->request->getData());
            if ($this->CompetenciesPathways->save($competenciesPathway)) {
                $this->Flash->success(__('The competencies pathway has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The competencies pathway could not be saved. Please, try again.'));
        }
        $competencies = $this->CompetenciesPathways->Competencies->find('list', ['limit' => 200]);
        $pathways = $this->CompetenciesPathways->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('competenciesPathway', 'competencies', 'pathways'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Competencies Pathway id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $competenciesPathway = $this->CompetenciesPathways->get($id);
        if ($this->CompetenciesPathways->delete($competenciesPathway)) {
            $this->Flash->success(__('The competencies pathway has been deleted.'));
        } else {
            $this->Flash->error(__('The competencies pathway could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

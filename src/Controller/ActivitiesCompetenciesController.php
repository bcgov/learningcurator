<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ActivitiesCompetencies Controller
 *
 * @property \App\Model\Table\ActivitiesCompetenciesTable $ActivitiesCompetencies
 *
 * @method \App\Model\Entity\ActivitiesCompetency[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesCompetenciesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Activities', 'Competencies'],
        ];
        $activitiesCompetencies = $this->paginate($this->ActivitiesCompetencies);

        $this->set(compact('activitiesCompetencies'));
    }

    /**
     * View method
     *
     * @param string|null $id Activities Competency id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitiesCompetency = $this->ActivitiesCompetencies->get($id, [
            'contain' => ['Activities', 'Competencies'],
        ]);

        $this->set('activitiesCompetency', $activitiesCompetency);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activitiesCompetency = $this->ActivitiesCompetencies->newEmptyEntity();
        if ($this->request->is('post')) {
            $activitiesCompetency = $this->ActivitiesCompetencies->patchEntity($activitiesCompetency, $this->request->getData());
            if ($this->ActivitiesCompetencies->save($activitiesCompetency)) {
                print(__('The activities competency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The activities competency could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesCompetencies->Activities->find('list', ['limit' => 200]);
        $competencies = $this->ActivitiesCompetencies->Competencies->find('list', ['limit' => 200]);
        $this->set(compact('activitiesCompetency', 'activities', 'competencies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activities Competency id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activitiesCompetency = $this->ActivitiesCompetencies->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitiesCompetency = $this->ActivitiesCompetencies->patchEntity($activitiesCompetency, $this->request->getData());
            if ($this->ActivitiesCompetencies->save($activitiesCompetency)) {
                print(__('The activities competency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The activities competency could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesCompetencies->Activities->find('list', ['limit' => 200]);
        $competencies = $this->ActivitiesCompetencies->Competencies->find('list', ['limit' => 200]);
        $this->set(compact('activitiesCompetency', 'activities', 'competencies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activities Competency id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitiesCompetency = $this->ActivitiesCompetencies->get($id);
        if ($this->ActivitiesCompetencies->delete($activitiesCompetency)) {
            print(__('The activities competency has been deleted.'));
        } else {
            print(__('The activities competency could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

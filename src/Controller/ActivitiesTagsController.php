<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ActivitiesTags Controller
 *
 * @property \App\Model\Table\ActivitiesTagsTable $ActivitiesTags
 *
 * @method \App\Model\Entity\ActivitiesTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesTagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Activities', 'Tags'],
        ];
        $activitiesTags = $this->paginate($this->ActivitiesTags);

        $this->set(compact('activitiesTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Activities Tag id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitiesTag = $this->ActivitiesTags->get($id, [
            'contain' => ['Activities', 'Tags'],
        ]);

        $this->set('activitiesTag', $activitiesTag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activitiesTag = $this->ActivitiesTags->newEmptyEntity();
        if ($this->request->is('post')) {
            $activitiesTag = $this->ActivitiesTags->patchEntity($activitiesTag, $this->request->getData());
            if ($this->ActivitiesTags->save($activitiesTag)) {
                $this->Flash->success(__('The activities tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activities tag could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesTags->Activities->find('list', ['limit' => 200]);
        $tags = $this->ActivitiesTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('activitiesTag', 'activities', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activities Tag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activitiesTag = $this->ActivitiesTags->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitiesTag = $this->ActivitiesTags->patchEntity($activitiesTag, $this->request->getData());
            if ($this->ActivitiesTags->save($activitiesTag)) {
                $this->Flash->success(__('The activities tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activities tag could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesTags->Activities->find('list', ['limit' => 200]);
        $tags = $this->ActivitiesTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('activitiesTag', 'activities', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activities Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitiesTag = $this->ActivitiesTags->get($id);
        if ($this->ActivitiesTags->delete($activitiesTag)) {
            $this->Flash->success(__('The activities tag has been deleted.'));
        } else {
            $this->Flash->error(__('The activities tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

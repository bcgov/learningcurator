<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ActivitiesBookmarks Controller
 *
 * @property \App\Model\Table\ActivitiesBookmarksTable $ActivitiesBookmarks
 *
 * @method \App\Model\Entity\ActivitiesBookmark[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesBookmarksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'contain' => ['Activities', 'Users'],
        ];
        $activitiesBookmarks = $this->paginate($this->ActivitiesBookmarks);

        $this->set(compact('activitiesBookmarks'));
    }


    /**
     * View method
     *
     * @param string|null $id Activities Bookmark id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitiesBookmark = $this->ActivitiesBookmarks->get($id, [
            'contain' => ['Activities', 'Users'],
        ]);
        $this->Authorization->authorize($activitiesBookmark);

        $this->set('activitiesBookmark', $activitiesBookmark);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //print_r($this->request->getData()); exit;
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $activitiesBookmark = $this->ActivitiesBookmarks->newEmptyEntity();
        $activitiesBookmark->user_id = $user->id;
        $activitiesBookmark->activity_id = $this->request->getData()['activity_id'];
        $this->Authorization->authorize($activitiesBookmark);
        if ($this->request->is('post')) {
            $activitiesBookmark = $this->ActivitiesBookmarks->patchEntity($activitiesBookmark, $this->request->getData());
            if ($this->ActivitiesBookmarks->save($activitiesBookmark)) {
                //$this->Flash->success(__('The activities bookmark has been saved.'));

                return $this->redirect($this->referer());
            }
            echo __('The activities bookmark could not be saved. Please, try again.');
        }
        //$activities = $this->ActivitiesBookmarks->Activities->find('list', ['limit' => 200]);
        //$users = $this->ActivitiesBookmarks->Users->find('list', ['limit' => 200]);
        $this->set(compact('activitiesBookmark', 'activities', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activities Bookmark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activitiesBookmark = $this->ActivitiesBookmarks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitiesBookmark = $this->ActivitiesBookmarks->patchEntity($activitiesBookmark, $this->request->getData());
            if ($this->ActivitiesBookmarks->save($activitiesBookmark)) {
                $this->Flash->success(__('The activities bookmark has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activities bookmark could not be saved. Please, try again.'));
        }
        $activities = $this->ActivitiesBookmarks->Activities->find('list', ['limit' => 200]);
        $users = $this->ActivitiesBookmarks->Users->find('list', ['limit' => 200]);
        $this->set(compact('activitiesBookmark', 'activities', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activities Bookmark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitiesBookmark = $this->ActivitiesBookmarks->get($id);
        $this->Authorization->authorize($activitiesBookmark);
        if ($this->ActivitiesBookmarks->delete($activitiesBookmark)) {
            //$this->Flash->success(__('The activities bookmark has been deleted.'));
        } else {
            //$this->Flash->error(__('The activities bookmark could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;

/**
 * ActivityTypes Controller
 *
 * @property \App\Model\Table\ActivityTypesTable $ActivityTypes
 *
 * @method \App\Model\Entity\ActivityType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivityTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $activityTypes = $this->paginate($this->ActivityTypes);

        $this->set(compact('activityTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Activity Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activityType = $this->ActivityTypes->get($id, [
            'contain' => [],
        ]);
        $acts = TableRegistry::getTableLocator()->get('Activities');
        // Select based on currently logged in person
        $activities = $acts->find()->where(['activity_types_id = ' => $id]);

        $this->Authorization->authorize($activityType);

        $this->set(compact('activityType','activities'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activityType = $this->ActivityTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $activityType = $this->ActivityTypes->patchEntity($activityType, $this->request->getData());
            if ($this->ActivityTypes->save($activityType)) {
                print(__('The activity type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The activity type could not be saved. Please, try again.'));
        }
        $this->set(compact('activityType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activityType = $this->ActivityTypes->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($activityType);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activityType = $this->ActivityTypes->patchEntity($activityType, $this->request->getData());
            if ($this->ActivityTypes->save($activityType)) {
                print(__('The activity type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            print(__('The activity type could not be saved. Please, try again.'));
        }
        $this->set(compact('activityType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activityType = $this->ActivityTypes->get($id);
        if ($this->ActivityTypes->delete($activityType)) {
            print(__('The activity type has been deleted.'));
        } else {
            print(__('The activity type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

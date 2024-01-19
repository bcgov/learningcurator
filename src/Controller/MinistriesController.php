<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;

/**
 * Ministries Controller
 *
 * @property \App\Model\Table\MinistriesTable $Ministries
 * @method \App\Model\Entity\Ministry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MinistriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        $pu = TableRegistry::getTableLocator()->get('PathwaysUsers');
        $ministries = $this->Ministries->find('all')->contain(['Users']);
        $newmins = [];
        foreach($ministries as $m) {
            $usercount = 0;
            $followcount = 0;
            $launchcount = 0;
            foreach($m->users as $u) {
                // User count from ministry
                $usercount++;
                $usefollow = $pu->find()->where(['user_id = ' => $u->id])->toList();
                foreach($usefollow as $uf) {
                    $followcount++;
                }
                $useacts = $au->find()->where(['user_id = ' => $u->id])->toList();
                foreach($useacts as $uact) {
                    $launchcount++;
                }
            }
            $next = [
                        'slug' => $m->slug, 
                        'name' => $m->name, 
                        'id' => $m->id, 
                        'usercount' => $usercount, 
                        'followcount' => $followcount,
                        'launchcount' => $launchcount
                    ];
            array_push($newmins,$next);
        }
        $userorder = [];
        $orderedmins = [];
        foreach ($newmins as $min){
            $userorder[] = $min['usercount'];
            array_push($orderedmins,$min);   
        }
        // Use the tmp array to sort steps list
        array_multisort($userorder, SORT_DESC, $orderedmins);
        $this->set(compact('orderedmins'));
    }

    /**
     * View method
     *
     * @param string|null $id Ministry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ministry = $this->Ministries->get($id, [
            'contain' => ['Activities', 'Pathways', 'Users'],
        ]);

        $this->set(compact('ministry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ministry = $this->Ministries->newEmptyEntity();
        if ($this->request->is('post')) {
            $ministry = $this->Ministries->patchEntity($ministry, $this->request->getData());
            if ($this->Ministries->save($ministry)) {
                $this->Flash->success(__('The ministry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ministry could not be saved. Please, try again.'));
        }
        $this->set(compact('ministry'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ministry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ministry = $this->Ministries->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ministry = $this->Ministries->patchEntity($ministry, $this->request->getData());
            if ($this->Ministries->save($ministry)) {
                $this->Flash->success(__('The ministry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ministry could not be saved. Please, try again.'));
        }
        $this->set(compact('ministry'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ministry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ministry = $this->Ministries->get($id);
        if ($this->Ministries->delete($ministry)) {
            $this->Flash->success(__('The ministry has been deleted.'));
        } else {
            $this->Flash->error(__('The ministry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

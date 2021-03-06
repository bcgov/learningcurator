<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;

/**
 * PathwaysUsers Controller
 *
 * @property \App\Model\Table\PathwaysUsersTable $PathwaysUsers
 * @method \App\Model\Entity\PathwaysUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysUsersController extends AppController
{
    /**
     * Show which pathways User is following method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function pathways ()
    {

        // $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        // // Select based on currently logged in person
        // $published = $allpaths->find('all')
        //                         ->contain(['Topics','Topics.Categories'])
        //                         ->where(['Pathways.status_id' => 2])
        //                         ->where(['Pathways.featured' => 1])
        //                         ->order(['Pathways.created' => 'desc']);

        $user = $this->request->getAttribute('authentication')->getIdentity();
        $p = $this->PathwaysUsers->find()
                                        ->contain(['Pathways','Users','Pathways.Topics','Pathways.Topics.Categories'])
                                        ->where(['PathwaysUsers.user_id' => $user->id])
                                        ->order(['PathwaysUsers.date_start' => 'desc']);
        $pathways = $p->all();
        $this->set(compact('pathways'));
    }
    /**
     * Follow method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function follow()
    {
        if ($this->request->is('post')) {
            $pathwaysUser = $this->PathwaysUsers->newEmptyEntity();
            $user = $this->request->getAttribute('authentication')->getIdentity();
            $pathwaysUser->user_id = $user->id;
            $pid = $this->request->getData()['pathway_id'];
            $pathwaysUser->pathway_id = $pid;
            $pathwaysUser->date_start = date('Y-m-d H:i:s');

            if ($this->PathwaysUsers->save($pathwaysUser)) {
                return $this->redirect($this->referer());
            }
            print(__('Something went wrong and you are not following this pathway. Please, try again.'));
        }
        print(__('You cannot edit this directly.'));
    }
    /**
     * Complete a pathway method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function complete($id = null)
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        if ($this->request->is('post')) {
            $pathwaysUser = $this->PathwaysUsers->get($id);
            $pathwaysUser->date_complete = date('Y-m-d H:i:s');
            $pathwaysUser = $this->PathwaysUsers->patchEntity($pathwaysUser, $this->request->getData());
            if ($this->PathwaysUsers->save($pathwaysUser)) {
                return $this->redirect($this->referer());
            }
            print(__('Something went wrong.'));
        }
        print(__('You cannot edit this directly.'));
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Pathways User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pathwaysUser = $this->PathwaysUsers->get($id);
        if ($this->PathwaysUsers->delete($pathwaysUser)) {
            return $this->redirect($this->referer());
            //print(__('The pathways user has been deleted.'));
        } else {
            print(__('The pathways user could not be deleted. Please, try again.'));
        }   
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Topics Controller
 *
 * @property \App\Model\Table\TopicsTable $Topics
 * @method \App\Model\Entity\Topic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $topics = $this->Topics->find()->contain(['Users','Pathways'])->where(['featured = ' => 1]); 
        $this->set(compact('topics'));
    }

    /**
     * Management page for curators 
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function manage()
    {
        $topics = $this->Topics->find()->contain(['Users','Pathways','Pathways.Steps']); 
        $this->set(compact('topics'));
    }

    /**
     * API method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function api()
    {
        $topics = $this->Topics->find()->where(['featured = ' => 1]);
        $this->viewBuilder()->setLayout('ajax');
        // $this->response->withType('application/json')->withStringBody(json_encode($topics));
        $this->set(compact('topics'));
    }

    /**
     * View method
     *
     * @param string|null $slug Topic slug.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        
            $topic = $this->Topics->findBySlug($slug)->contain([
                                                                'Users', 
                                                                'Pathways' => ['sort' => ['Pathways.created' => 'desc']]
                                                                ]
                                                            )->firstOrFail();

        $this->set(compact('topic'));
    }
    /**
     * Stats method creating a dashboard of statistics for all pathways.
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function stats()
    {
        $spp = TableRegistry::getTableLocator()->get('StatsPerpath');

        $topics = $this->Topics->find()->contain(['Users','Pathways.Users','Pathways.Steps.Activities.Users'])->where(['featured = ' => 1]);
        $newtopics = [];
        foreach($topics as $t) {
            $newtopic = [];
            $topname = $t->name;
            $topslug = $t->slug;
            $topid = $t->id;
            $paths = [];
            $toplaunches = 0;
            $topfollows = 0;
            $topsteps = 0;
            $topacts = 0;
            foreach($t->pathways as $pathway) {
                $count = 0;
                $pathfollowcount = 0;
                $pathstepcount = 0;
                $pathactcount = 0;
                $newpathid = $pathway->id;
                $newpathname = $pathway->name;
                $newpathslug = $pathway->slug;
                foreach($pathway->users as $u) {
                    $pathfollowcount++;
                }
                foreach($pathway->steps as $s) {
                    $pathstepcount++;
                    foreach($s->activities as $a) {
                        $pathactcount++;
                        foreach($a->users as $u) {
                            // Ensure that this activity launch is from the
                            // current step or we end up counting multiples
                            // of the same launch on every step it's included
                            // on.
                            if($u->_joinData->step_id == $s->id) {
                                $count++;
                            }
                        }
                    }
                }
                $newpaths = [
                                'pathname' => $newpathname, 
                                'pathslug' => $newpathslug, 
                                'pathid' => $newpathid,
                                'launchcount' => $count,
                                'pathstepcount' => $pathstepcount,
                                'pathactcount' => $pathactcount,
                                'pathfollowcount' => $pathfollowcount
                            ];
                array_push($paths,$newpaths);
                $toplaunches = $toplaunches + $count;
                $topfollows = $topfollows + $pathfollowcount;
                $topsteps = $topsteps + $pathstepcount;
                $topacts = $topacts + $pathactcount;


                // `pathways_id` int(11) NOT NULL,
                // `steps` int(11) NOT NULL,
                // `activities` int(11) NOT NULL,
                // `follows` int(11) NOT NULL,
                // `launches` int(11) NOT NULL,
                $pathstat = $spp->newEmptyEntity();
                $pathdeets = [
                    'pathways_id' => $pathway->id,
                    'steps' => $pathstepcount,
                    'activities' => $pathactcount,
                    'follows' => $pathfollowcount,
                    'launches' => $count
                ];
                
                $pathstat = $spp->patchEntity($pathstat,$pathdeets);
                if ($spp->save($pathstat)) {
                    $saved = 1;
                }


            } // end pathways loop
            
            $newtopic = [
                            'saved' => $saved, 
                            'topicid' => $topid, 
                            'topicname' => $topname, 
                            'topicslug' => $topslug, 
                            'topiclaunches' => $toplaunches, 
                            'topicfollows' => $topfollows, 
                            'topicsteps' => $topsteps, 
                            'topicactvitities' => $topacts, 
                            'pathways' => $paths
                        ];
            array_push($newtopics,$newtopic);

        } // end topics loop
        
        $this->set(compact('newtopics'));
        
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $topic = $this->Topics->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->request->getAttribute('authentication')->getIdentity();
            $topic = $this->Topics->patchEntity($topic, $this->request->getData());
            $sluggedTitle = Text::slug($topic->name);
            // trim slug to maximum length defined in schema
            $topic->slug = strtolower(substr($sluggedTitle, 0, 191));
            $topic->user_id = $user->id;
            if ($this->Topics->save($topic)) {
                $redirect = '/topic/' . $topic->slug;
                return $this->redirect($redirect);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $users = $this->Topics->Users->find('list', ['limit' => 200]);
        $categories = $this->Topics->Categories->find('list', ['limit' => 200]);
        $this->set(compact('topic', 'users', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $topic = $this->Topics->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $topic = $this->Topics->patchEntity($topic, $this->request->getData());
            if ($this->Topics->save($topic)) {

                $redirect = '/topic/' . $topic->slug;
                return $this->redirect($redirect);
                
            }
            echo __('The topic could not be saved. Please, try again.');
        }
        $users = $this->Topics->Users->find('list', ['limit' => 200])->where(['OR' => [
                                                                                ['Users.role' => 'Manager'],
                                                                                ['Users.role' => 'superuser']
                                                                            ]
                                                                            ]);
        $cats = $this->Topics->Categories->find('all', ['limit' => 200]);
        //$categories = $cats->combine('id', 'name');
        $categories = $cats->all()->map(function ($value, $key) {
            return [
                'value' => $value->id,
                'text' => $value->name,
                'data-created' => $value->created
            ];
        });
        $this->set(compact('topic', 'users', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $topic = $this->Topics->get($id);
        if ($this->Topics->delete($topic)) {
            $this->Flash->success(__('The topic has been deleted.'));
        } else {
            $this->Flash->error(__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

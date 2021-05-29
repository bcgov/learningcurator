<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Steps Controller
 *
 * @property \App\Model\Table\StepsTable $Steps
 * @method \App\Model\Entity\Step[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StepsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $steps = $this->paginate($this->Steps);

        $this->set(compact('steps'));
    }

    /**
     * View method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($stepid = null)
    {
        $step = $this->Steps->get($stepid, ['contain' => ['Activities', 
                                                            'Activities.ActivityTypes', 
                                                            'Activities.Tags', 
                                                            'Pathways',
                                                            'Pathways.Topics',
                                                            'Pathways.Topics.Categories', 
                                                            'Pathways.Steps',
                                                            'Pathways.Users'],
        ]);
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need create an empty array first. If nothing gets added to
        // it, so be it
        $useractivitylist = array();

        // Get access to the apprprioate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');

        // Select based on currently logged in person
        $useacts = $au->find()->where(['user_id = ' => $user->id]);

        // convert the results into a simple array so that we can
        // use in_array in the template
        $useractivities = $useacts->toList();

        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }

        //
        // we want to be able to tell if the current user is already on this
        // pathway or not, so we take the same approach as above, parsing all
        // the users into a single array so that we can perform a simple
        // in_array($thisuser,$usersonthispathway) check and show the "take
        // this Pathway" button or "you're on this Pathway" text
        //
        // Create the initially empty array that we also pass into the template
        $usersonthispathway = array();
        // Loop through the users that are on this pathway and parse just the 
        // IDs into the array that we just created
        foreach($step->pathways[0]->users as $pu) {
            array_push($usersonthispathway,$pu->id);
        }

        $this->set(compact('step','useractivitylist','usersonthispathway'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $step = $this->Steps->newEmptyEntity();
        if ($this->request->is('post')) {
            $step = $this->Steps->patchEntity($step, $this->request->getData());
            if ($this->Steps->save($step)) {
                $this->Flash->success(__('The step has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The step could not be saved. Please, try again.'));
        }
        $activities = $this->Steps->Activities->find('list', ['limit' => 200]);
        $pathways = $this->Steps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('step', 'activities', 'pathways'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $step = $this->Steps->get($id, [
            'contain' => ['Activities', 'Activities.ActivityTypes', 'Activities.Statuses', 'Pathways'],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $step = $this->Steps->patchEntity($step, $this->request->getData());
            $sluggedTitle = Text::slug($step->name);
            // trim slug to maximum length defined in schema
            $step->slug = strtolower(substr($sluggedTitle, 0, 191));
            //echo $step->slug; exit;
            
            if ($this->Steps->save($step)) {
                //print(__('The step has been saved.'));
                $pathback = '/steps/view/' . $id;
                return $this->redirect($pathback);
            }
            //print(__('The step could not be saved. Please, try again.'));
        }
        $activities = $this->Steps->Activities->find('list', ['limit' => 200]);
        
        $types = TableRegistry::getTableLocator()->get('ActivityTypes');
        $atypes = $types->find('all');

        $pathways = $this->Steps->Pathways->find('list', ['limit' => 200]);
        $this->set(compact('step', 'activities', 'pathways', 'atypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Step id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $step = $this->Steps->get($id);
        if ($this->Steps->delete($step)) {
            $this->Flash->success(__('The step has been deleted.'));
        } else {
            $this->Flash->error(__('The step could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;

/**
 * Pathways Controller
 *
 * @property \App\Model\Table\PathwaysTable $Pathways
 *
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // configure the login action to don't require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['index','view']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'contain' => ['Categories', 'Ministries'],
        ];
        $pathways = $this->paginate($this->Pathways);

        $this->set(compact('pathways'));
    }

    /**
     * View method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        // As we loop through the resources for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that resource. Here we get the current user id and use it to select 
        // all of the claimed resources assigned to them, and then process out 
        // just the resource IDs into a simple array. Then, in the template 
        // code, we can simply  if(in_array($rj->resource->id,$userresourcelist
        //
        // First let's check to see if this person is logged in or not.
        //
	$user = $this->request->getAttribute('authentication')->getIdentity();
        if(!empty($user)) {
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
        }

        $pathway = $this->Pathways->get($id, [
            'contain' => ['Categories', 'Ministries', 'Competencies', 'Steps', 'Steps.Activities', 'Steps.Activities.ActivityTypes', 'Steps.Activities.Users', 'Steps.Activities.Tags', 'Users'],
        ]);
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
	foreach($pathway->users as $pu) {
		array_push($usersonthispathway,$pu->id);
	}


        if(!empty($user)) {
		$this->set(compact('pathway', 'usersonthispathway', 'useractivitylist'));
	} else {
		$this->set(compact('pathway', 'usersonthispathway'));
	}

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pathway = $this->Pathways->newEmptyEntity();
        $this->Authorization->authorize($pathway);
        if ($this->request->is('post')) {
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            if ($this->Pathways->save($pathway)) {
                $this->Flash->success(__('The pathway has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }
        $categories = $this->Pathways->Categories->find('list', ['limit' => 200]);
        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'categories', 'ministries', 'competencies', 'steps', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Competencies', 'Steps', 'Users'],
        ]);

        $this->Authorization->authorize($pathway);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            if ($this->Pathways->save($pathway)) {
                $this->Flash->success(__('The pathway has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }
        $categories = $this->Pathways->Categories->find('list', ['limit' => 200]);
        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'categories', 'ministries', 'competencies', 'steps', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pathway = $this->Pathways->get($id);
        if ($this->Pathways->delete($pathway)) {
            $this->Flash->success(__('The pathway has been deleted.'));
        } else {
            $this->Flash->error(__('The pathway could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

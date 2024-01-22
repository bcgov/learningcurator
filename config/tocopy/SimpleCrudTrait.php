<?php

declare(strict_types=1);

/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\Users\Controller\Traits;

use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;

/**
 * Covers the baked CRUD actions, note we could use Crud Plugin too
 *
 * @property \Cake\Http\ServerRequest $request
 */
trait SimpleCrudTrait
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['search'],
        ]);
    }

    /**
     * Index method acts as dashboard for curators where we list the first
     * page of users, but also list a bunch of statistics and a menu for 
     * further convenience.
     *
     * @return void
     */
    public function index()
    {
        // Pull out the user list and filter for curator, manager, supers
        // #TODO refactor to single query figure out orwhere 
        $users = $this->loadModel();
        $curators = $users->find('all')->where(['role' => 'curator'])->order(['last_name' => 'asc']);
        $managers = $users->find('all')->where(['role' => 'manager'])->order(['last_name' => 'asc']);
        $supers = $users->find('all')->where(['role' => 'superuser'])->order(['last_name' => 'asc']);

        $reports = TableRegistry::getTableLocator()->get('Reports');
        $noresponses = $reports->find('all', array('conditions' => array('Reports.response IS NULL')))
                                ->contain(['Activities', 'Users'])
                                ->order(['Reports.created' => 'desc']);

        $this->set('supers', $supers);
        $this->set('curators', $curators);
        $this->set('managers', $managers);
        $this->set('noresponses', $noresponses);
    }


    /**
     * Search method
     *
     * @return void
     */
    public function search()
    {
        $table = $this->loadModel();

        $findusers = $table->find('search', ['search' => $this->request->getQuery()])->order('last_login desc');
        $q = $this->request->getQuery('q');
        $numresults = $findusers->count();

        $tableAlias = $table->getAlias();
        //echo '<pre>'; print_r($tableAlias); exit;

        $this->set($tableAlias, $this->paginate($findusers));
        $this->set('q', $q);
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $acts = TableRegistry::getTableLocator()->get('Activities');
        $actsadded = $acts->find('all')->contain(['ActivityTypes', 'Statuses', 'Steps', 'Steps.Pathways'])
            ->where(['Activities.createdby_id' => $id]);
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        $pathsadded = $paths->find('all')->where(['Pathways.createdby' => $id]);
        $topics = TableRegistry::getTableLocator()->get('Topics');
        $topicsmanaged = $topics->find('all')->where(['Topics.user_id' => $id]);

        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, [
            'contain' => [
                'PathwaysUsers',
                'Ministries',
                'PathwaysUsers.Pathways',
                'ActivitiesUsers',
                'ActivitiesUsers.Activities',
                'ActivitiesUsers.Activities.ActivityTypes'
            ],
        ]);
        $this->set('topicsmanaged', $topicsmanaged);
        $this->set('actsadded', $actsadded);
        $this->set('pathsadded', $pathsadded);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
    }

    /**
     * API method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function api()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();

        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($user->id, [
            'contain' => [
                'PathwaysUsers',
                'PathwaysUsers.Pathways',
                'ActivitiesUsers',
                'ActivitiesUsers.Activities'
            ],
        ]);
        
        $launched = [];
        foreach ($entity->activities_users as $act) {
            array_push($launched, $act->activity_id);
        }
        $pathsfollowed = [];
        foreach ($entity->pathways_users as $path) {
            array_push($pathsfollowed, $path->pathway_id);
        }
        $this->viewBuilder()->setLayout('ajax');
        $this->set('launched', $launched);
        $this->set('followed', $pathsfollowed);
    }

    /**
     * Add method
     *
     * @return mixed Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->newEmptyEntity();
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
        if (!$this->getRequest()->is('post')) {
            return;
        }
        $entity = $table->patchEntity($entity, $this->getRequest()->getData());
        $singular = Inflector::singularize(Inflector::humanize($tableAlias));
        if ($table->save($entity)) {
            $this->Flash->success(__d('cake_d_c/users', 'The {0} has been saved', $singular));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__d('cake_d_c/users', 'The {0} could not be saved', $singular));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return mixed Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mins = TableRegistry::getTableLocator()->get('Ministries');
        $ministries = $mins->find('list');

        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, [
            'contain' => ['Ministries'],
        ]);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->set('ministries', $ministries);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
        if (!$this->getRequest()->is(['patch', 'post', 'put'])) {
            return;
        }
        $entity = $table->patchEntity($entity, $this->getRequest()->getData());
        $singular = Inflector::singularize(Inflector::humanize($tableAlias));
        if ($table->save($entity)) {
            $this->Flash->success(__d('cake_d_c/users', 'The {0} has been saved', $singular));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__d('cake_d_c/users', 'The {0} could not be saved', $singular));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, [
            'contain' => [],
        ]);
        $singular = Inflector::singularize(Inflector::humanize($tableAlias));
        if ($table->delete($entity)) {
            $this->Flash->success(__d('cake_d_c/users', 'The {0} has been deleted', $singular));
        } else {
            $this->Flash->error(__d('cake_d_c/users', 'The {0} could not be deleted', $singular));
        }

        return $this->redirect(['action' => 'index']);
    }
}

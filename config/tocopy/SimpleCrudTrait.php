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
Use Cake\ORM\TableRegistry;
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
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $table = $this->loadModel();
        $alphabetized = $table->find('all')->order(['last_name' => 'asc']);
        $tableAlias = $table->getAlias();
        $this->set($tableAlias, $this->paginate($alphabetized));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
    }

    /**
     * Search method
     *
     * @return void
     */
    public function search()
    {
        $table = $this->loadModel();

        $findusers = $table->find('search', ['search' => $this->request->getQuery()]);
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
        $actsadded = $acts->find('all')->contain(['ActivityTypes','Statuses','Steps','Steps.Pathways'])
                                        ->where(['Activities.createdby_id' => $id]);
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        $pathsadded = $paths->find('all')->where(['Pathways.createdby' => $id]);

        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, [
            'contain' => ['PathwaysUsers',
                            'PathwaysUsers.Pathways',
                            'ActivitiesUsers',
                            'ActivitiesUsers.Activities',
                            'ActivitiesUsers.Activities.ActivityTypes'],
        ]);
        $this->set('actsadded', $actsadded);
        $this->set('pathsadded', $pathsadded);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
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
        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, [
            'contain' => [],
        ]);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
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

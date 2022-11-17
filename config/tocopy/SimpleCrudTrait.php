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
        // The initial query to pull out the user list
        // $table = $this->loadModel();
        // $alphabetized = $table->find('all')->order(['last_name' => 'asc']);
        // $tableAlias = $table->getAlias();

        // Get top 5 launched activities and a count for total launches
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        $uselaunches = $au->find('all')->contain('Activities')->order(['activity_id' => 'asc']);;
        // can easily grab the total number of launches here
        $launchcount = $uselaunches->count();
        // setup a few arrays for reducing the massive query results 
        // down to the top 5
        $mostlaunched = array();
        $actnames = array();
        $links = array();
        // #TODO This probably isn't a good way of going about this
        // I'm creating two arrays here and merging them below because
        // I can't seem to make the count of all activities sort properly
        // in one go in a multidimensional array (so it includes the 
        // activity name as well as the ID--needed to make the link), 
        // so I extract a list that contains the counted and sorted IDs
        // and then use the 2nd array to extract the names. #inelegantbutworks
        foreach ($uselaunches->all()->toList() as $ul) {
            array_push($mostlaunched, $ul['activity_id']);
            array_push($actnames, ['actid' => $ul['activity_id'], 'actname' => $ul['activity']['name']]);
        }
        $most = array_count_values($mostlaunched);
        arsort($most);
        // So far we've counted and sorted the entire list, so now we 
        // just slice off the top 5. It is probably more efficient to do 
        // this earlier 
        $top5 = array_slice($most, 0, 5, true);
        foreach ($top5 as $id => $count) {
            // Needing to loop through the entire list of activity launches
            // for each of the top 5 links to extract the name is probably
            // a dumb way of doing this, but #inelegantbutworks #refactor
            foreach ($actnames as $key => $val) {
                if ($val['actid'] == $id) {
                    // #TODO shouldn't be doing formatting here but when I build an array
                    // the array_unique call below breaks and it took me so long to get to
                    // this point that I'm just rolling with it for now.
                    $link = '<a href="/activities/view/' . $id . '">' . $val['actname'] . '</a> <span class="inline-block px-2 py-1 text-sm bg-white dark:bg-black rounded-lg">' . $count . ' launches</span><br>';
                    array_push($links, $link);
                }
            }
        }
        // We have a list of the top 5, but each link it repeated for each launch
        // i.e. if it's launched 11 times, it's listed 11 times
        // let's reduce that down to one line per activity and we're done!
        $top5links = array_unique($links);


        // Pull out top 5 followed pathways as per above, with the same caveats that
        // technique here is ... likely awful
        $pu = TableRegistry::getTableLocator()->get('PathwaysUsers');
        $pathfollows = $pu->find('all')->contain('Pathways');
        $totalfollowcount = $pathfollows->count();

        // setup a few arrays for reducing the massive query results 
        // down to the top 5
        $mostfollowed = array();
        $pathnames = array();
        $plinks = array();
        // #TODO This probably isn't a good way of going about this
        // I'm creating two arrays here and merging them below because
        // I can't seem to make the count of all activities sort properly
        // in one go in a multidimensional array (so it includes the 
        // activity name as well as the ID--needed to make the link), 
        // so I extract a list that contains the counted and sorted IDs
        // and then use the 2nd array to extract the names. #inelegantbutworks
        foreach ($pathfollows->all()->toList() as $ul) {
            array_push($mostfollowed, $ul['pathway_id']);
            array_push($pathnames, ['pathid' => $ul['pathway_id'], 'pathname' => $ul['pathway']['name'], 'pathslug' => $ul['pathway']['slug']]);
        }
        $followcounts = array_count_values($mostfollowed);
        arsort($followcounts);
        // So far we've counted and sorted the entire list, so now we 
        // just slice off the top 5. It is probably more efficient to do 
        // this earlier 
        $top5f = array_slice($followcounts, 0, 5, true);
        foreach ($top5f as $id => $count) {
            // Needing to loop through the entire list of activity launches
            // for each of the top 5 links to extract the name is probably
            // a dumb way of doing this, but #inelegantbutworks #refactor
            foreach ($pathnames as $key => $val) {
                if ($val['pathid'] == $id) {
                    // #TODO shouldn't be doing formatting here but when I build an array
                    // the array_unique call below breaks and it took me so long to get to
                    // this point that I'm just rolling with it for now.
                    $plink = '<a href="/pathways/' . $val['pathslug'] . '">' . $val['pathname'] . '</a> <span class="inline-block px-2 py-1 text-sm bg-white dark:bg-black rounded-lg">' . $count . ' follows</span><br>';
                    array_push($plinks, $plink);
                }
            }
        }
        // We have a list of the top 5, but each link it repeated for each launch
        // i.e. if it's launched 11 times, it's listed 11 times
        // let's reduce that down to one line per activity and we're done!
        $top5follows = array_unique($plinks);

        $reports = TableRegistry::getTableLocator()->get('Reports');
        $noresponses = $reports->find('all', array('conditions' => array('Reports.response IS NULL')))
            ->contain(['Activities', 'Users'])
            ->order(['Reports.created' => 'desc']);

        $this->set('totalfollowcount', $totalfollowcount);
        $this->set('launchcount', $launchcount);
        $this->set('top5links', $top5links);
        $this->set('top5follows', $top5follows);
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
        $actsadded = $acts->find('all')->contain(['ActivityTypes', 'Statuses', 'Steps', 'Steps.Pathways'])
            ->where(['Activities.createdby_id' => $id]);
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        $pathsadded = $paths->find('all')->where(['Pathways.createdby' => $id]);

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
        $completed = [];
        foreach ($entity->activities_users as $act) {
            array_push($completed, $act->activity_id);
        }
        $pathspinned = [];
        foreach ($entity->pathways_users as $path) {
            array_push($pathspinned, $path->pathway_id);
        }
        $this->viewBuilder()->setLayout('ajax');
        $this->set('ActivitiesCompleted', $completed);
        $this->set('PathwaysPinned', $pathspinned);
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

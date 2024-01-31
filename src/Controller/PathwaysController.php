<?php
declare(strict_types=1);

namespace App\Controller;


Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;


/**
 * Pathways Controller
 *
 * @property \App\Model\Table\PathwaysTable $Pathways
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Search.Search', [
            'actions' => ['search'],
        ]);
        $this->viewBuilder()->setHelpers(['Tanuck/Markdown.Markdown']);
    }
    /**
     * API method outputs RSS XML of the index listing of newly published pathways
     *
     * @return \Cake\Http\Response|null
     */
    public function rssfeed()
    {
        $pathways = $this->Pathways->find('all')->where(['status_id' => 2]);
        $this->viewBuilder()->setLayout('ajax');
        $this->RequestHandler->respondAs('xml');
        $this->set(compact('pathways'));
    }
    /**
     * API method outputs JSON of the index listing of newly published pathways
     *
     * @return \Cake\Http\Response|null
     */
    public function jsonfeed()
    {
        // {
        //     "version": "https://jsonfeed.org/version/1",
        //     "title": "Learning Curator Pathways",
        //     "home_page_url": "https://learningcurator.gww.gov.bc.ca/",
        //     "feed_url": "https://learningcurator.gww.gov.bc.ca/pathways/jsonfeed",
        //     "items": [
        //     foreach($pathways as $p):
        //       {
        //         "id":"",
        //         "title":"",
        //         "summary":"",
        //         "content_text":"",
        //         "content_html":"",
        //         "_pathway_id":"",
        //         "_learning_partner":"Learning Centre",
        //         "author":"Allan Haggett",
        //         "date_published":"",
        //         "date_modified":"",
        //         "tags":"",
        //         "url":"https://learningcurator.gww.gov.bc.ca/p/"
        //       },
        //     endforeach
        //     ]
        //   }
        $pathways = $this->Pathways->find('all')->contain(['Topics'])->where(['status_id' => 2]);

        // $jsonfeed = [
        //                 'version' => 'https://jsonfeed.org/version/1',
        //                 'title' => 'Learning Curator Pathways',
        //                 'home_page_url' => 'https://learningcurator.gww.gov.bc.ca/',
        //                 'feed_url' => 'https://learningcurator.gww.gov.bc.ca/pathways/jsonfeed',
        //                 'items' => []
        //             ];
        // $pathsreduced = [];
        // foreach($pathways as $p) {
        //     // $pubdate = strval(date('r', strtotime($p->created)));
        //     // $moddate = strval(date('r', strtotime($p->modified)));
        //     $pinfo = [
        //                 'id' => $p->version, 
        //                 'title' => $p->name,
        //                 'summary' => $p->objective,
        //                 'content_text' => $p->objective,
        //                 'content_html' => $p->objective,
        //                 '_pathway_id' => $p->id,
        //                 '_learning_partner' => 'Learning Centre',
        //                 'author' => 'Allan Haggett',
        //                 'date_published' => '',
        //                 'date_modified' => '',
        //                 'tags' => '',
        //                 'url' => 'https://learningcurator.gww.gov.bc.ca/p/' . $p->id
        //             ];
        //     array_push($pathsreduced, $pinfo);

        // }
        // array_push($jsonfeed['items'],$pathsreduced);
        // //echo '<pre>';print_r($jsonfeed); exit;
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['pathways']);
        $this->set(compact('pathways'));
    }
    /**
     * 
     * Show Curators their own pathways and activities
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function contributions()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $acts = TableRegistry::getTableLocator()->get('Activities');
        $activities = $acts->find('all')->contain(['ActivityTypes','Statuses','Steps','Steps.Pathways'])
                                        ->where(['Activities.createdby_id' => $user->id]);
        $pathways = $this->Pathways->find('all')->contain(['Topics','Statuses'])->where(['Pathways.createdby' => $user->id]);
        
        //$this->paginate($pathways);
        $this->set(compact('pathways','activities'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        // If the person is a curator or an admin, then return all of the pathways,
        // regardless of their statuses. Regular users should only ever see 
        // 'published' pathways.
        if($user->role == 'curator' || $user->role == 'superuser') {
            $pathways = $paths->find('all')->contain(['Topics','Topics.Categories','Statuses'])
                                            ->order(['Pathways.created' => 'desc']);
        } else {
            $pathways = $paths->find('all')
                                ->contain(['Topics','Topics.Categories','Statuses'])
                                ->where(['status_id' => 2])
                                ->order(['Pathways.created' => 'desc']);
        }
        //$this->paginate($pathways);
        $this->set(compact('pathways'));
    }
    /**
     * Search method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function search()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        // If the person is a curator or an admin, then return all of the pathways,
        // regardless of their statuses. Regular users should only ever see 
        // 'published' pathways.
        if($user->role == 'curator' || $user->role == 'superuser') {
            $pathways = $paths->find('search', ['search' => $this->request->getQuery()])
                                ->contain(['Topics','Topics.Categories','Statuses']);
        } else {
            $pathways = $paths->find('search', ['search' => $this->request->getQuery()])
                                ->contain(['Topics','Topics.Categories','Statuses','Steps'])
                                ->where(['status_id' => 2]);
        }
        $q = $this->request->getQuery('q');
        $numresults = $pathways->count();
        //$this->paginate($pathways);
        $this->set(compact('pathways','q','numresults'));
    }

    /**
     * Find method for step assignment
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function find()
    {
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $paths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $paths->find('search', ['search' => $this->request->getQuery()])
                            ->contain(['Steps']);
        $this->set(compact('pathways'));
    }


    /**
     * View method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {

        $pathway = $this->Pathways->
                            findBySlug($slug)->
                            contain([
                                'Topics',
                                'Topics.Categories', 
                                'Steps' => ['sort' => ['PathwaysSteps.sortorder' => 'asc']],
                                'Steps.Statuses', 
                                'Steps.Activities',
                                'Users'])->firstOrFail();
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need to count how many activities this person has claimed 
        // from each step (we loop through them below)
        $useractivitylist = array();

        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select based on currently logged in person
        $useractivities = $au->find()->where(['user_id = ' => $user->id])->all()->toList();
        // Loop through the resources and add just the ID to the 
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
        $followid = 0;
        $followcount = 0;
        foreach($pathway->users as $pu) {
            $followcount++;
            // Is the current user following this pathway? If so, then 
            // we record the pathways_users ID number so we can remove
            // the association (unfollow) if the user clicks the "Unfollow"
            // button.
            if($pu->id == $user->id) {
                $followid = $pu->_joinData->id;
            }
        }
        $percentage = 0;
        $totalclaimed = 0;
        $totalacts = 0;
        $requiredacts = 0;
        $suppacts = 0;
        $curators = [];
        if (!empty($pathway->steps)):

            foreach ($pathway->steps as $steps):
                foreach ($steps->activities as $activity):
                    if($activity->status_id == 2) {

                        array_push($curators,$activity->createdby_id);

                        $totalacts++;
                        if($activity->_joinData->required == 1) {
                            $requiredacts++;
                            if(in_array($activity->id, $useractivitylist)) {
                                $totalclaimed++;
                            }
                        } else {
                            $suppacts++;
                        }
                    }
                endforeach; // activities
            endforeach; // steps
            if($totalclaimed > 0) {
                $percentage = floor(($totalclaimed / $requiredacts) * 100);
            } else {
                $percentage = 0;
            }
        endif;
        $stepcount = count($pathway->steps);


        $attribution = TableRegistry::getTableLocator()->get('Users');
        $createdby = $attribution->find()->where(['id = ' => $pathway->createdby])->all()->toList();
        if($pathway->modifiedby == $pathway->createdby) {
            $modifiedby = $attribution->find()->where(['id = ' => $pathway->modifiedby])->all()->toList();
        } else {
            $modifiedby = $createdby;
        }
        $curators = array_unique($curators);
        $contributors = [];
        foreach($curators as $c) {
            $actcurators = $attribution->find()->where(['id = ' => $c])->all()->toList();
            array_push($contributors,$actcurators);
        }
        if($pathway->published_by) {
            $publishedby = $attribution->find()->where(['id = ' => $pathway->published_by])->all()->toList();
        } else {
            $publishedby = '';
        }

        $this->set(compact('pathway', 
                            'followcount', 
                            'contributors', 
                            'createdby', 
                            'publishedby', 
                            'modifiedby', 
                            'totalacts', 
                            'stepcount', 
                            'requiredacts', 
                            'suppacts', 
                            'percentage', 
                            'followid'));

    }
    /**
     * Launch report method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function launchreport($slug = null)
    {
        $pathway = $this->Pathways->findBySlug($slug)->contain(['Steps.Activities.Users'])->firstOrFail();
        $count = 0;
        foreach($pathway->steps as $s) {
            foreach($s->activities as $a) {
                foreach($a->users as $u) {
                    if($u->_joinData->step_id == $s->id) {
                        $count++;
                    }
                }
            }
        }
        $this->viewBuilder()->setLayout('ajax');
        $this->set(compact('count'));
        
    }
    /**
     * Launch reports method returning a simple array of pathways
     * with an activity launch count.
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function launchreports()
    {

        $pathways = $this->Pathways->find('all')->contain(['Topics','Steps.Activities.Users']);
        $paths = [];
        foreach($pathways as $pathway) {
            $count = 0;
            $newpathid = $pathway->id;
            $newpathname = $pathway->name;
            foreach($pathway->steps as $p) {
                foreach($p->activities as $a) {
                    foreach($a->users as $u) {
                        $count++;
                    }
                }
            }
            $newpaths = [
                            'topicname' => $pathway->topic->name, 
                            'topicid' => $pathway->topic->id, 
                            'pathname' => $newpathname, 
                            'pathid' => $newpathid,
                            'launchcount' => $count
                        ];
            array_push($paths,$newpaths);
        }
    
        $this->viewBuilder()->setLayout('ajax');
        $this->set(compact('paths'));
        
    }
    /**
     * All-in-one pathway design method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function all($slug = null)
    {

        $pathway = $this->Pathways->
                            findBySlug($slug)->
                            contain([
                                'Topics',
                                'Topics.Categories', 
                                'Steps' => ['sort' => ['PathwaysSteps.sortorder' => 'asc']],
                                'Steps.Statuses', 
                                'Steps.Activities' => ['sort' => ['ActivitiesSteps.steporder' => 'desc']],
                                'Users'])
                            ->firstOrFail();
                            // Sigh. I can't make below work without wrecking the sort order
                            // If it's between properly sorting them and having to filter out unpublished
                            // and only getting published activities but in the wrong order ...
                            //'Steps.Activities' => function (Query $q) {
                            //    return $q->where(['Activities.status_id' => 2])->order(['ActivitiesSteps.steporder' => 'desc']);
                            //},
        
        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need to count how many activities this person has claimed 
        // from each step (we loop through them below)
        $useractivitylist = array();

        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select based on currently logged in person
        $useractivities = $au->find()->where(['user_id = ' => $user->id])->all()->toList();
        // Loop through the resources and add just the ID to the 
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
        $followid = 0;
        $followcount = 0;
        foreach($pathway->users as $pu) {
            $followcount++;
            // Is the current user following this pathway? If so, then 
            // we record the pathways_users ID number so we can remove
            // the association (unfollow) if the user clicks the "Unfollow"
            // button.
            if($pu->id == $user->id) {
                $followid = $pu->_joinData->id;
            }
        }

        $totalacts = 0;
        $requiredacts = 0;
        $suppacts = 0;
        $curators = [];
        $activityids = [];
        if (!empty($pathway->steps)):
            foreach ($pathway->steps as $steps):
                foreach ($steps->activities as $activity):
                    if($activity->status_id == 2) {
                        array_push($curators,$activity->createdby_id);
                        $totalacts++;
                        if($activity->_joinData->required == 1) {
                            array_push($activityids,$activity->id);
                            $requiredacts++;
                        } else {
                            $suppacts++;
                        }
                    }
                endforeach; // activities
            endforeach; // steps
            
        endif;
        $stepcount = count($pathway->steps);

        $attribution = TableRegistry::getTableLocator()->get('Users');
        $createdby = $attribution->find()->where(['id = ' => $pathway->createdby])->all()->toList();
        if($pathway->modifiedby == $pathway->createdby) {
            $modifiedby = $attribution->find()->where(['id = ' => $pathway->modifiedby])->all()->toList();
        } else {
            $modifiedby = $createdby;
        }
        $curators = array_unique($curators);
        $contributors = [];
        foreach($curators as $c) {
            $actcurators = $attribution->find()->where(['id = ' => $c])->all()->toList();
            array_push($contributors,$actcurators);
        }
        if($pathway->published_by) {
            $publishedby = $attribution->find()->where(['id = ' => $pathway->published_by])->all()->toList();
        } else {
            $publishedby = '';
        }

        $this->set(compact('pathway', 
                            'followcount', 
                            'contributors', 
                            'createdby', 
                            'publishedby', 
                            'modifiedby', 
                            'totalacts', 
                            'stepcount', 
                            'requiredacts', 
                            'suppacts', 
                            'followid',
                            'activityids'));

    }

    /**
     * Export method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function export ($slug = null)
    {
      
        $pathway = $this->Pathways->findBySlug($slug)->contain([
                            'Topics',
                            'Topics.Categories', 
                            'Ministries', 
                            'Steps' => ['sort' => ['Steps.id' => 'asc']],
                            'Steps.Statuses', 
                            'Steps.Activities', 
                            'Steps.Activities.ActivityTypes'])->firstOrFail();
        
        //$this->RequestHandler->renderAs($this, 'json');
        
        $p = json_encode($pathway);
        $response = $this->response;
    
        // Inject string content into response body
        $response = $response->withStringBody($p);
    
        $response = $response->withType('text/json');
        $now = date('Y-m-d-Hi');
        $filename = $pathway->topic->slug . '-' . $pathway->slug . '-' . $now . '.json';
        // Optionally force file download
        $response = $response->withDownload($filename);
    
        // Return response object to prevent controller from trying to render
        // a view.
        return $response;


    }

    /**
     * Publish method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function publish ($id = null)
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();

        // Is the person a manager or superuser? Only those roles can publish.
        if($user->role == 'superuser' || $user->role == 'manager') {
            
            
            $guid = $user->id;

            // Let's first check to see if this pathway has been published before
            // If it has been published
            //  - Stop
            // If it has NOT been published
            //  - Go through every activity and put the hyperlinks into a string
            //  - Take a hash of the links
            //  - Update version number, hash, and published_on
            $pathway = $this->Pathways->get($id, [
                'contain' => ['Topics',
                                'Topics.Categories', 
                                'Ministries', 
                                'Steps' => ['sort' => ['Steps.id' => 'asc']],
                                'Steps.Statuses', 
                                'Steps.Activities' => ['sort' => ['ActivitiesSteps.steporder' => 'desc']], 
                                'Steps.Activities.ActivityTypes'],
            ]);
            // $pathway = $this->Pathways->findBySlug($slug)->contain([
            //                     'Topics',
            //                     'Topics.Categories', 
            //                     'Ministries', 
            //                     'Steps' => ['sort' => ['Steps.id' => 'asc']],
            //                     'Steps.Statuses', 
            //                     'Steps.Activities', 
            //                     'Steps.Activities.ActivityTypes'])->firstOrFail();
            
            // Because I've not related my tables togther properly, I'm not able to 
            // pull in the curators details and can only see their user ID, but what
            // we really want is the GUID value. 
            // $pathway->createdby

            $now = date('YmdHi');
            $code = $pathway->id . '-' . $now;
            
            $savepathway = [];
            $savepathway['published_on'] = FrozenTime::now();
            $savepathway['published_by'] = $user->id;
            $savepathway['version'] = $code;

            $pathway = $this->Pathways->patchEntity($pathway, $savepathway);

            $this->Pathways->save($pathway);

            $p = json_encode($pathway);

            $filename = $code . '.json'; //-' . $pathway->slug . '.json';
            $fp = '/mnt/published/' . $filename;
            file_put_contents($fp, $p);

            // Redirect to production with the topic ID and import code 
            $p2 = $this->request->getQuery('publishto') ?? '';
            $topid = $this->request->getQuery('topicid') ?? '';
            if($p2 == 'localtest') {
                $targeturl = 'https://learningcurator.ca';
            } elseif($p2 == 'dev') {
                $targeturl = 'https://learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca';
            } else  {
                $targeturl = 'https://learningcurator.gww.gov.bc.ca';
            }
            $environment = $_SERVER['SERVER_NAME'];
            $publisher = 'dev';
            if ($environment == 'learningcurator.ca') {
                $publisher = 'localtest';
            } // we won't ever want to publish _from_ prod would we??
            $go = $targeturl . '/pathways/import/' . $topid . '?importcode=' . $code . '&publisher=' . $publisher;
            return $this->redirect($go);

            //$this->set(compact('code'));

        } else { // If they're not a manager or super
            
            echo '<p>Sorry, but you have to be a manager to publish pathways.</p>';
            
        } // end check for super or manager role
    }



    /**
     * Import method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function import ($topicid = 0)
    {
        
        // Check to see if this pathway already exists and message if it does

        $importcode = $this->request->getQuery('importcode');
        $publishercode = $this->request->getQuery('publisher');
        
        if($publishercode == 'localtest') {
            $publisherurl = 'https://learningcurator.ca';
        } elseif($publishercode == 'dev') {
            $publisherurl = 'https://learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca';
        }

        $importurl = $publisherurl . '//published/' . $importcode . '.json';

        //$this->viewBuilder()->setLayout('ajax');
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $feed = file_get_contents($importurl);
        $path = json_decode($feed);

        $pathpast = $path->file_path . '';
        $pathpast .= 'Imported pathway originally created by ' . $path->createdby . ' ';
        $pathpast .= 'on ' . $path->created . '. Last modified by ' . $path->modifiedby . ' ';
        $pathpast .= 'on ' . $path->modified;

        $version = $path->version;
        $pathslugtocheck = $path->slug;
        $namecheck = $this->Pathways->find()->where(function ($exp, $query) use($pathslugtocheck) {
                                        return $exp->like('Pathways.slug', '%'.$pathslugtocheck.'%');
                                    })->toList();
        $pathname = $path->name;
        $pathslug = $path->slug;
        if(!empty($namecheck)) {
            $pathname = $path->name . ' - ' . FrozenTime::now();
            $sluggedtitle = Text::slug($pathname);
            $pathslug = strtolower(substr($sluggedtitle, 0, 191));
        }



        $pathway = $this->Pathways->newEmptyEntity();
        
        $pathdeets = [
            'status_id' => 2,
            'topic_id' => $topicid, //33,
            'name' => $pathname,
            'file_path' => $pathpast, // we are repurposing file_path here to create a log mostly because Allan is afraid of database migrations
            'description' => $path->description,
            'objective' => $path->objective,
            'slug' => $pathslug,
            'createdby' => $path->createdby,
            'modifiedby' => $path->modifiedby,
            'published_by' => $path->published_by,
            'published_on' => $path->published_on,
            'version' => $path->version
        ];
        //echo '<pre>'; print_r($pathdeets); exit;
        
        $pathway = $this->Pathways->patchEntity($pathway, $pathdeets);
        if ($this->Pathways->save($pathway)) {
            
            $pathid = $pathway->id;
            $st = TableRegistry::getTableLocator()->get('Steps');
            $act = TableRegistry::getTableLocator()->get('Activities');
            $asteptable = TableRegistry::getTableLocator()->get('ActivitiesSteps'); 
            foreach($path->steps as $step) {

                $newstep = $st->newEmptyEntity();
                $stepdeets = [
                    'pathways' => [['id' => $pathid]],
                    'name' => $step->name,
                    'slug' => $step->slug,
                    'status_id' => 2,
                    'description' => $step->description,
                    'createdby' => $step->createdby,
                    'modifiedby' => $step->modifiedby
                ];
                
                $newstep = $st->patchEntity($newstep,$stepdeets, [
                    'associated' => [
                        'Pathways'
                    ]
                ]);
                if ($st->save($newstep)) {

                    foreach ($step->activities as $a) {
                        
                        $linktocheck = $a->hyperlink;
                        $check = $act->find()->where(function ($exp, $query) use($linktocheck) {
                                                        return $exp->like('Activities.hyperlink', '%'.$linktocheck.'%');
                                                    })->toList();
                        if(empty($check)) {
                            
                            $newact = $act->newEmptyEntity();
                            $actdeets = [
                                'status_id' => 2,
                                'activity_types_id' => $a->activity_type->id,
                                'hyperlink' => $a->hyperlink,
                                'name' => $a->name,
                                'slug' => $a->slug,
                                'description' => $a->description,
                                'createdby_id' => $a->createdby_id,
                                'approvedby_id' => $a->createdby_id,
                                'modifiedby_id' => $a->modifiedby_id
                            ];
                            
                            $newact = $act->patchEntity($newact,$actdeets);
                            if ($act->save($newact)) {
                                $activitiesStep = $asteptable->newEmptyEntity();
                                $context = $a->_joinData->stepcontext ?? '';
                                $req = $a->_joinData->required ?? 0;
                                $order = $a->_joinData->steporder ?? 0;
                                $actstdeets = [
                                    'step_id' => $newstep->id,
                                    'activity_id' => $newact->id,
                                    'steporder' => $order,
                                    'stepcontext' => $context,
                                    'required' => $req
                                ];
                                $activitiesStep = $asteptable->patchEntity($activitiesStep,$actstdeets);
    
                                if (!$asteptable->save($activitiesStep)) {
                                    echo 'Cannot add to step!' . $check[0]->id;
                                }

                            } else {
                                echo 'Activity could NOT be created.';
                            }

                        } else {

                            $activitiesStep = $asteptable->newEmptyEntity();
                            $context = $a->_joinData->stepcontext ?? '';
                            $req = $a->_joinData->required ?? 0;
                            $order = $a->_joinData->steporder ?? 0;
                            $actstdeets = [
                                'step_id' => $newstep->id,
                                'activity_id' => $check[0]->id,
                                'steporder' => $order,
                                'stepcontext' => $context,
                                'required' => $req
                            ];
                            $activitiesStep = $asteptable->patchEntity($activitiesStep,$actstdeets);

                            if (!$asteptable->save($activitiesStep)) {
                                echo 'Cannot add to step!' . $check[0]->id;
                            }

                        }

                    }

                } else {
                    echo 'Step NOT created<br>';
                }

            }

            $redir = '/p/' . $pathslug;
            return $this->redirect($redir);

        } else {
            echo 'Something went wrong importing this pathway. Please contact Allan.Haggett@gov.bc.ca for assistance.';
            exit;
        }
            
        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        $pathway = $this->Pathways->newEmptyEntity();
        if ($this->request->is('post')) {
            //echo '<pre>'; print_r($this->request->getData()); exit;
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            $sluggedTitle = Text::slug($pathway->name);
            // trim slug to maximum length defined in schema
            $pathway->slug = strtolower(substr($sluggedTitle, 0, 191));
            //echo '<pre>'; print_r($pathway); exit;
            if ($this->Pathways->save($pathway)) {
                //$this->Flash->success(__('The pathway has been saved.'));
                $redir = '/pathways/' . $sluggedTitle;
                return $this->redirect($redir);
            }
            echo 'The pathway could not be saved. Please, try again.';
        }
        
        

        $topics = $this->Pathways->Topics->find('list', ['limit' => 200])->where(['featured' => 1]);
        $ministries = $this->Pathways->Ministries->find('list', ['limit' => 200]);
        $statuses = $this->Pathways->Statuses->find('list', ['limit' => 200]);
        $competencies = $this->Pathways->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Pathways->Steps->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $this->set(compact('pathway', 'topics', 'ministries', 'statuses', 'competencies', 'steps', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Steps', 'Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //echo '<pre>'; print_r($this->request->getData()); exit;
            $pathway = $this->Pathways->patchEntity($pathway, $this->request->getData());
            $sluggedTitle = Text::slug($pathway->name);
            // trim slug to maximum length defined in schema
            $pathway->slug = strtolower(substr($sluggedTitle, 0, 191));
            if ($this->Pathways->save($pathway)) {
                //$this->Flash->success(__('The pathway has been saved.'));
                $redir = '/pathways/' . $sluggedTitle;
                return $this->redirect($redir);
            }
            $this->Flash->error(__('The pathway could not be saved. Please, try again.'));
        }

        $topics = $this->Pathways->Topics->find('list', ['limit' => 200])->where(['featured' => 1]);
        $statuses = $this->Pathways->Statuses->find('list', ['limit' => 200]);
        $users = $this->Pathways->Users->find('list', ['limit' => 200]);
        $steporder = [];
        $sortedsteps = [];
        foreach ($pathway->steps as $s) {
            $steporder[] = $s->_joinData->sortorder;
            array_push($sortedsteps,$s);
        }
        // Use the tmp array to sort steps list
        array_multisort($steporder, SORT_ASC, $sortedsteps);
        
        $this->set(compact('pathway', 'topics', 'statuses', 'users', 'sortedsteps'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null|void Redirects to index.
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
    
   /**
     * Process and return a status for this pathway for the logged in user 
     *
     * @param string|null $id Pathway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function status($id = null)
    {
        
        $this->viewBuilder()->setLayout('ajax');
        // As we loop through the activities for the steps on this pathway, we 
        // need to be able to check to see if the current user has "claimed" 
        // that activity.
	    $user = $this->request->getAttribute('authentication')->getIdentity();
        $useractivitylist = array();
        // Get access to the apprprioate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select based on currently logged in person
        $useacts = $au->find()->where(['user_id = ' => $user->id]);
        // convert the results into a simple array so that we can
        // use in_array in the template
        $useractivities = $useacts->all()->toList();
        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
        $pathway = $this->Pathways->get($id, [
            'contain' => ['Steps', 'Steps.Activities'],
        ]);
        if (!empty($pathway->steps)) :
            $requiredacts = 0;
            $completed = 0;
            foreach ($pathway->steps as $step) :
                foreach ($step->activities as $activity):
                    if($activity->status_id == 2) {
                        if($activity->_joinData->required == 1) {
                            $requiredacts++;
                            $actlist = array_count_values($useractivitylist); 
                            foreach($actlist as $k => $v) {
                                if($k == $activity->id) {
                                    if($v > 0) $completed++;
                                }
                            }
                        }
                    }
                endforeach; // activities
            endforeach; // steps
            $percentage = floor(($completed / $requiredacts) * 100);
            $name = $pathway->name;
            $this->set(compact(['name','requiredacts','completed','percentage']));        
        endif; // if steps


    } // end of method

}

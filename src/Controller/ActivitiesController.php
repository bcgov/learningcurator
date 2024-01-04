<?php
declare(strict_types=1);

namespace App\Controller;

Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesController extends AppController
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
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $activities = $this->paginate($this->Activities
                            ->find('all')
                            ->contain(['Tags',
                                        'Statuses', 
                                        'Ministries', 
                                        'ActivityTypes',
                                        'Steps.Pathways',
                                        'Steps.Pathways.Topics',
                                        'Steps.Pathways.Topics.Categories'])
                            ->where(['Activities.status_id' => 2])
                            ->order(['Activities.created' => 'DESC'])); // including 'Steps.Pathways' appears to be SUPER expensive    

        $user = $this->request->getAttribute('authentication')->getIdentity();
        // We need create an empty array first. If nothing gets added to
        // it, so be it
        $useractivitylist = array();
        // Get access to the appropriate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        // Select all activities (claims) based on currently logged in person
        $useacts = $au->find()->where(['user_id = ' => $user->id]);
        // convert the results into a simple array so that we can
        // use in_array(needle,haystack) in the template
        $useractivities = $useacts->all()->toList();
        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        foreach($useractivities as $uact) {
            array_push($useractivitylist, $uact['activity_id']);
        }
        $this->set(compact('activities','useractivitylist'));
    }


    /**
     * Flagged activities need to be manually audited
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function flagged ()
    {
        //$this->viewBuilder()->setLayout('ajax');
        $now = FrozenTime::now();
        $weeksago = $now->subDays(14);
        $auditdate = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $activities = $this->Activities->find('all')
                                        ->where(['Activities.status_id' => 2])
                                        ->where(['Activities.audited < ' => $weeksago->i18nFormat('yyyy-MM-dd HH:mm:ss')])
                                        ->where(['Activities.moderation_flag' => 1])
                                        ->limit(10);
        
        $this->set(compact('activities','auditdate'));
    }
    /**
     * Check all links in the site for 404 or redirect.
     * The idea here is that we don't want to attempt to check
     * all the links in the site at once. We're barely out the 
     * door and have almost 500 links. You can't run a script
     * that checks 500 links sequentially and synchronously,
     * as it would take 20 minutes to run.
     * Instead, this audit is designed to be run every, say, 
     * 4 hours. At the interval, we take the next 10 (currently)
     * activities whose 'audited' date is longer than 1 week ago
     * and check just those 10. As we check, we update the audited
     * date, thus removing the activity from the query the next time
     * it's run. This way, we're only checking 10 links at a time
     * and only doing that every X hours, and only checking links 
     * that haven't been checked in a week. When we find a link
     * that's not returning 200 OK, we automatically file a report
     * with the actual header response #TODO have a nice little 
     * suggestions for investigations on a case by case.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function audit ()
    {
        //$this->viewBuilder()->setLayout('ajax');
        $now = FrozenTime::now();
        $weekago = $now->subDays(7);
        // echo '<pre>'; echo $weekago->i18nFormat('yyyy-MM-dd HH:mm:ss'); exit;
        
        $activities = $this->Activities->find('all')
                                        ->where(['Activities.status_id' => 2])
                                        ->where(['Activities.audited < ' => $weekago->i18nFormat('yyyy-MM-dd HH:mm:ss')])
                                        ->where(['Activities.moderation_flag' => 0])
                                        ->limit(10)
                                        ->toList();

        $report = TableRegistry::getTableLocator()->get('Reports');
        $actcount = count($activities); 
        $count200 = 0;
        $reportcount = 0;
        $excludedcount = 0;
        // echo '<pre>'; print_r($activities); exit;
        
        foreach($activities as $a) {
    
            $url = trim($a->hyperlink);
            // First check to see if this even a valid URL to attempt to check
            if (filter_var($url, FILTER_VALIDATE_URL) !== FALSE) {

                // Now check against a exlusion list of URLs that we know are 
                // restricted from this check for one reason or another
                // e.g. manual check for intranet links that require auth
                // We're keeping this exclusion list hard-coded here in 
                // an array, but perhaps this could be sourced from somewhere
                // more updateable...
                $host = parse_url($url, PHP_URL_HOST);
                $excludedhosts = [
                    'learning.gov.bc.ca',
                    'gww.gov.bc.ca',
                    'gww.bcpublicservice.gov.bc.ca',
                    'compass.gww.gov.bc.ca',
                    'intranet.gov.bc.ca'
                ];
                
                if(in_array($host,$excludedhosts)) {

                    $act = $this->Activities->get($a->id);
                    $act->moderation_flag = 1;
                    //$act->audited = $now;
                    if ($this->Activities->save($act)) {
                        // echo 'Manual check - moderation flag set so this will not be queried again<br>';
                        $excludedcount++;
                    }
                    
                } else {
                    // It's a good URL and isn't one that we know can't be
                    // checked this way, so let's go ahead and check it
                    // $context = stream_context_create(
                    //     [
                    //         'http' => array(
                    //             'method' => 'HEAD'
                    //         )
                    //     ]
                    // );
                    $headers = @get_headers($url); // ,false, $context
                    if($headers) {
                        $code = explode(' ', $headers[0]);
                        // Anything other than 
                        // * 200 OK
                        // * 302 Moved Temporarily??
                        // gets reported
                        if ($code[1] != 200) {
                            $newreport = $report->newEmptyEntity();
                            $reportdata = [
                                'activity_id' => $a->id,
                                'user_id' => '00001FC1A510420B9A19A46D24069FFD', // always as superadmin
                                'issue' => $headers[0]
                            ];
                            $newreport = $report->patchEntity($newreport, $reportdata);
                            if ($report->save($newreport)) {
                                $reportcount++;
                                //echo $headers[0] . ' WARNING - Report Filed<br>';
                            } 
                            
                        } else {
                            $count200++;
                        }
                        // Whether it's 200 OK or not, we still log the time that we checked
                        $act = $this->Activities->get($a->id);
                        $act->audited = $now;
                        if ($this->Activities->save($act)) {
                            //echo $headers[0] . ' audited<br>';
                        }
                    } 
                }
            }
        }

        $this->set(compact('activities','actcount','excludedcount','count200','reportcount'));
    }


    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // 
        // Check to see if the current user has "claimed" 
        // this activity. Here we get the current user id and use it to select 
        // all of the claimed activities assigned to them, and then process out 
        // just the activity IDs into a simple array. Then, in the template 
        // code, we if(in_array($activity->id,$useractivitylist)):
        //
        // First let's check to see if this person is logged in or not.
        //
	    $user = $this->request->getAttribute('authentication')->getIdentity();
        
        // We need create am empty array first. If nothing gets added to
        // it, so be it
        $activitylaunches = array();

        // Get access to the appropriate table
        $au = TableRegistry::getTableLocator()->get('ActivitiesUsers');
        
        // Select all activities that this user has claimed
        $useacts = $au->find()->where(['user_id = ' => $user->id]);

        // convert the results into a simple array so that we can
        // use in_array in the template
        //$useractivities = $useacts->toList();

        // Loop through the resources and add just the ID to the 
        // array that we will pass into the template
        // #TODO this is probably really inefficient #refactor
        $claimid = 0;
        foreach($useacts as $uact) {
            // Has the current user claimed this activity? If so, then 
            // we record the activities_users ID number so we can remove
            // the association (unclaim) if the user clicks the "Unclaim"
            // button.
            if($uact->activity_id == $id) {
                $claimid = $uact->id;
                array_push($activitylaunches, [$uact['id'],$uact['created']]);
            }
        }
    
        $activity = $this->Activities->get($id, [
            'contain' => ['Statuses', 
                            'Ministries', 
                            'ActivityTypes', 
                            'Competencies', 
                            'Steps', 
                            'Steps.Pathways', 
                            'Steps.Pathways.Topics',
                            'Tags',
                            'Reports',
                            'Reports.Users'],
        ]);

        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps']);
        $allpathways = $pathways->all()->toList();

        $curatorinfo = TableRegistry::getTableLocator()->get('Users');
        $cur = $curatorinfo->find()->where(['id = ' => $activity->createdby_id]);
        $curator = $cur->all()->toList();

        $this->set(compact('activity', 'activitylaunches','allpathways','claimid','curator'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->request->getAttribute('authentication')->getIdentity();
            
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            $sluggedTitle = Text::slug($activity->name);
            // trim slug to maximum length defined in schema
            $activity->slug = strtolower(substr($sluggedTitle, 0, 191));
            $activity->createdby_id = $user->id;
            $activity->modifiedby_id = $user->id;
            $activity->approvedby_id = $user->id;

            if ($this->Activities->save($activity)) {
                //$this->Flash->success(__('The activity has been saved.'));
                $redir = '/activities/view/' . $activity->id;
                return $this->redirect($redir);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $statuses = $this->Activities->Statuses->find('list', ['limit' => 200]);
        $ministries = $this->Activities->Ministries->find('list', ['limit' => 200]);
        $activityTypes = $this->Activities->ActivityTypes->find('list', ['limit' => 200]);
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $competencies = $this->Activities->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Activities->Steps->find('list', ['limit' => 200]);
        $tags = $this->Activities->Tags->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'statuses', 'ministries', 'activityTypes', 'users', 'competencies', 'steps', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => ['Users', 'Competencies', 'Steps', 'Tags', 'Steps.Pathways'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            $sluggedTitle = Text::slug($activity->name);
            // trim slug to maximum length defined in schema
            $activity->slug = strtolower(substr($sluggedTitle, 0, 191));
            if ($this->Activities->save($activity)) {
                // $this->Flash->success(__('The activity has been saved.'));
                if($this->request->getData('redirectback') == 1) {
                    $go = $this->referer();
                } else {
                    $go = '/activities/view/' . $id;
                }
                // echo $go;
                return $this->redirect($go);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $statuses = $this->Activities->Statuses->find('list', ['limit' => 200]);
        $ministries = $this->Activities->Ministries->find('list', ['limit' => 200]);
        $activityTypes = $this->Activities->ActivityTypes->find('list', ['limit' => 200]);
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $competencies = $this->Activities->Competencies->find('list', ['limit' => 200]);
        $steps = $this->Activities->Steps->find('list', ['limit' => 200]);
        $tags = $this->Activities->Tags->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'statuses', 'ministries', 'activityTypes', 'users', 'competencies', 'steps', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    
    /**
     * The main search results for the primary search form.
     * 
     * This is #janky because of my sub-par SQL skills, I think.
     * What we actually need here is a proper search index; until we get that 
     * in place, I don't know how to construct a query that would be able to 
     * encompass what we're looking for here. We'll certainly be adding 
     * a search function along the lines of ElasticSearch, but we're holding
     * off here until an "official government solution" is put forward.
     * Until we can get a proper index in place, and because my SQL 
     * skills are in development, but not fast enough for this project,
     * we are writing below in a very naive and malperformant way, manually 
     * combining the results from multiple queries to produce acceptable
     * arrays for the template.
     * 
     * #TODO These queries attempt to restrict results to activities and 
     * pathways and steps that are published (status_id == 2), but it fails
     * when there are published steps on an unpublished pathway (still shows the path)
     * for unknown reasons. Fix this.
     *
     * @param string|null $search search pararmeters to lookup activities.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function find()
    {
        
        $search = $this->request->getQuery('search');
        
        $activities = $this->Activities->find('search', ['search' => $this->request->getQuery()])
                                        ->where(['status_id = ' => 2])
                                        ->contain(['ActivityTypes','Steps.Pathways']);
        $numacts = $activities->count();

        // We've searched for activities and that's great and all, but we also
        // want to return results for topics.
        $alltops = TableRegistry::getTableLocator()->get('Topics');
        $topics = $alltops->find('all',
                                    array('conditions' => 
                                        array('OR' => 
                                            array(
                                                'name LIKE' => '%'.$search.'%',
                                                'description LIKE' => '%'.$search.'%'
                                            )
                                        )
                                    )
                                );
        $numtops = $topics->count();

        // We don't want to show results for pathways and steps separately in the UI;
        // instead, we will merge the step results into the pathway results and
        // only show "Pathways" results in the UI, like so:
        // Personal Development
        //   - Step 3, Step 6
        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all',
                                    array('conditions' => 
                                        array('OR' => 
                                            array(
                                                'Pathways.name LIKE' => '%'.$search.'%',
                                                'Pathways.description LIKE' => '%'.$search.'%',
                                                'Pathways.objective LIKE' => '%'.$search.'%'
                                            )
                                        )
                                    )
                                )->where(['Pathways.status_id =' => 2])
                                ->contain(['Topics'])
                                ->toList();
        //echo '<pre>'; print_r($pathways); exit;
        // This is the start of the janky bits where I have to make a separate query to the 
        // steps table
        $allsteps = TableRegistry::getTableLocator()->get('Steps');
        $steps = $allsteps->find('all',
                                    array('conditions' => 
                                        array('OR' => 
                                            array(
                                                'name LIKE' => '%'.$search.'%',
                                                'description LIKE' => '%'.$search.'%'
                                            )
                                        )
                                    )
                                )
                                ->where(['Steps.status_id =' => 2])
                                ->contain(['Pathways','Pathways.Topics'])
                                ->toList();
        //echo '<pre>'; print_r($steps); exit;
        $justpathways = []; // Minimal pathways array to loop through to gather steps
        $pathwaywithsteps = []; // Main array to pass to template

        // Loop through the intial results and parse out the info need to reconstruct the links in the template
        // /category-slug/topic-slug/pathway/path-slug/s/stepid/step-slug
        foreach($pathways as $p) {
            $newp = [
                        'topic' => $p['topic']['slug'],
                        'id' => $p['id'],
                        'name' => $p['name'],
                        'slug' => $p['slug'],
                        'goal' => $p['objective']
                    ];
            array_push($justpathways,$newp);
        }
        // Now loop through the paths and on each pass, we loop through all the steps 
        // and do a quick check to see if the steps parent pathway id matches and if it
        // does then we add the step to a temp array (gets reset on each new path loop)
        // and after each path it adds the steps to the final array, creating the 
        // structure that makes it easy to loop through in the template file.
        $numpaths = 0;
        $stepnotp = []; // detect results from steps/paths that aren't in the org paths []
        foreach($justpathways as $jp) {
            $stepdeets = []; // reset step details after we've looked at the current step
            foreach($steps as $s) {
                if(!empty($s['pathways'][0])) { // Apparently there are orphaned steps that don't have a parent pathway
                    if($s['status_id'] == 2) {
                        if($jp['id'] == $s['pathways'][0]['id']) { // does current path id match steps parent path id?
                            array_push($stepdeets,[
                                                    'id' => $s['id'],
                                                    'name' => $s['name'],
                                                    'slug' => $s['slug'],
                                                    'objective' => $s['description']
                                                    ]
                                    ); // Add this steps details to temp array
                        } else {
                            array_push($stepnotp,$s);
                        }
                    }
                }
            }
            array_push($pathwaywithsteps,[$jp,$stepdeets]); // write the temp array and the current pathway details to final array
            $numpaths++;
        }

        // We still need to account for all the step results that don't have also have a pathway
        // that was found. If we just passed $pathwaywithsteps now, it would be stripping results
        // and not showing pathways that just don't have the search term in the path title/desc
        // (but do have it in the step).
        // To do this, we now loop through all the steps first and check for matching paths,
        // and if we don't find a match, then we reconstruct the pathway info from the step
        // and add it to $pathwaywithsteps.
        // Note that this does mean that these results will *always* come below the other 
        // initial pathway results unless with add a new sort into things below.
        foreach($steps as $s) {
        if($s['status_id'] == 2) {
            $stepdeets = []; // reset step details after we've looked at the current step
            // Apparently there are orphaned steps that don't have a parent pathway
            // This is a result of improper database design that allows the deletion
            // of pathways, even though there are still steps attached to it
            if(!empty($s['pathways'][0])) { 
                // For each step found we loop through all the found pathways and 
                // look for a matching ID. If we don't find a match, then we add 
                // the step with it's path 
                $matchfound = 0;
                foreach($justpathways as $jp) {
                    if($jp['id'] == $s['pathways'][0]['id']) {
                        $matchfound = 1;
                    }
                }
                if(!$matchfound) {
                    // Recreate the pathway info
                    $inpath = [
                        'topic' => $s['pathways'][0]['topic']['slug'],
                        'id' => $s['pathways'][0]['id'],
                        'name' => $s['pathways'][0]['name'],
                        'slug' => $s['pathways'][0]['slug'],
                        'goal' => $s['pathways'][0]['objective']
                    ];
                    // Create the necessary step details
                    array_push($stepdeets,[
                                            'id' => $s['id'],
                                            'name' => $s['name'],
                                            'slug' => $s['slug'],
                                            'objective' => $s['description']
                                        ]
                    );
                    // write the temp array and the current pathway details to final array
                    array_push($pathwaywithsteps,[$inpath,$stepdeets]);
                    $numpaths++;
                }
            }
        } // end status check
        }
        
        $this->set(compact('numacts',
                            'numtops',
                            'numpaths',
                            'topics', 
                            'pathwaywithsteps', 
                            'activities', 
                            'search'
                        ));
    }

    /**
     * Check for duplicate links in the system
     *
     * @param string|null $search search pararmeters to lookup activities.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function linkcheck()
    {
        $activities = $this->Activities->find('search', ['search' => $this->request->getQuery()])->firstOrFail();
        
        $this->set(compact('activities'));
    }
    /**
     * Find method for activities; intended for use as an auto-complete
     *  search function for adding activities to steps
     *
     * @param string|null $search search pararmeters to lookup activities.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function stepfind()
    {
        $search = $this->request->getQuery('q');
        $stepid = $this->request->getQuery('step_id');
        
        $activities = $this->Activities->find()->contain('Steps.Pathways')->where(function ($exp, $query) use($search) {
            return $exp->like('name', '%'.$search.'%');
        })->order(['name' => 'ASC']);

        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps']);
        $allpathways = $pathways->all()->toList();

        $this->set(compact('activities','allpathways','stepid'));
    }

    /**
    * Like an activity
    *
    * @return \Cake\Http\Response|null Redirects to courses index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    *
    */
    public function like ($id = null)
    {
        $activity = $this->Activities->get($id);
        $newlike = $activity->recommended;
        $newlike++;
        $this->request->getData()['recommended'] = $newlike;
        $activity->recommended = $newlike;
        if ($this->request->is(['get'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                //echo 'Liked!';
                return $this->redirect($this->referer());
            } else {
                //print(__('The activity could not be saved. Please, try again.'));
            }
        }
    }

    
    /**
     * Add-to-step view that looks up whether the provided link exists 
     * or doesn't 
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addtostep()
    {

        if($this->request->is('get')) {
            $user = $this->request->getAttribute('authentication')->getIdentity();            
            $linktoact = $this->request->getQuery('url') ?? '';
            // If it exists return the one we've already got.
            $activity = $this->Activities->find()->contain(['ActivityTypes','Tags','Steps.Pathways'])->where(function ($exp, $query) use($linktoact) {
                return $exp->like('hyperlink', '%'.$linktoact.'%');
            })->toList();
            $activityTypes = $this->Activities->ActivityTypes->find('list', ['limit' => 200]);
            $this->set(compact('activity','linktoact','activityTypes'));

        } 

    
    }


    /**
     * Add-to-path view that looks up whether the provided link exists 
     * or doesn't and lets the curator add it to a step within the given
     * pathway. This will attempt to supercede addtostep above as the 
     * process of having to search for a pathway is cumbersome and this
     * will allow for per-pathway bookmarklets
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addtopath()
    {

        if($this->request->is('get')) {

            $user = $this->request->getAttribute('authentication')->getIdentity();            
            
            $pathwayid = $this->request->getQuery('pathwayid') ?? 1;
            
            $linktoact = $this->request->getQuery('url') ?? '';
            
            $paths = TableRegistry::getTableLocator()->get('Pathways');
            $pathway = $paths->find()->where(['id = ' => $pathwayid])->contain(['Steps'])->toList();
            
            //print_r($pathway); exit;

            $activity = $this->Activities->find()->contain(['ActivityTypes','Tags','Steps.Pathways'])->where(function ($exp, $query) use($linktoact) {
                return $exp->like('hyperlink', '%'.$linktoact.'%');
            })->toList();

            // check to see if this activity is already on this pathway
            // because we don't allow duplicate activities on a pathway
            $dupealert = 0;
            $onsteps = [];
            if(!empty($activity[0]->steps)) {
                foreach($activity[0]->steps as $s) {
                    foreach($s['pathways'] as $p) {
                        if($pathwayid == $p['id']) {
                            $dupealert = 1;
                            // create an array of IDs so that we can exclude
                            // those steps from the UI and make it impossible
                            // to add the same activity to a step twice
                            array_push($onsteps,$s['id']);
                        } 
                    }
                }
            }

            $activityTypes = $this->Activities->ActivityTypes->find('list', ['limit' => 200]);
            $this->set(compact('pathway', 'dupealert', 'onsteps', 'activity','linktoact','activityTypes'));

        } 

    
    }


    /**
     * Add an activity directly to a step and return the necessary details to expose
     * the curator context and required flag form 
     *
     * @return \Cake\Http\Response|null Returns activity_step details on successful add.
     */
    public function addacttostep ()
    {

        if ($this->request->is('post')) {

            $linktoact = $this->request->getData()['hyperlink'];
            $activitycheck = $this->Activities->find()->contain(['ActivityTypes','Tags','Steps.Pathways'])->where(function ($exp, $query) use($linktoact) {
                return $exp->like('hyperlink', '%'.$linktoact.'%');
            })->toList();

            if(!empty($activitycheck)) {
                $message = 'Activity already exists! Please go back and add the activity via the Add Existing Activity form.';
                $this->set(compact('message'));
            } else {

                $user = $this->request->getAttribute('authentication')->getIdentity();
                    
                $activity = $this->Activities->newEmptyEntity();
                $activity = $this->Activities->patchEntity($activity, $this->request->getData());
                $activity->createdby_id = $user->id;
                $activity->modifiedby_id = $user->id;
                $activity->approvedby_id = $user->id;
                // Defaulting to publishing the activity for the user experience
                $activity->status_id = 2;
                $activity->activity_types_id = $this->request->getData()['activity_types_id'];
                $directadd = $this->request->getData()['directadd'] ?? 0;

                $sluggedTitle = Text::slug($activity->name);
                // trim slug to maximum length defined in schema
                $activity->slug = strtolower(substr($sluggedTitle, 0, 191));

                if ($this->Activities->save($activity)) {

                    $asteptable = TableRegistry::getTableLocator()->get('ActivitiesSteps');
                    $activitiesStep = $asteptable->newEmptyEntity();
                    $activitiesStep->step_id = $this->request->getData()['step_id'];
                    $activitiesStep->stepcontext = $this->request->getData()['stepcontext'] ?? '';
                    
                    $activitiesStep->required = $this->request->getData()['required'] ?? 0; // Default to not being required

                    $activitiesStep->activity_id = $activity->id;

                    if (!$asteptable->save($activitiesStep)) {
                        echo 'Cannot add to step! Contact an admin. Sorry :)';
                        echo '' . $activity->id;
                        exit;
                    }
                    if(!$directadd) {
                        $actst = array(
                            'activityid' => $activity->id,
                            'activitystepid' => $activitiesStep->id,
                            'stepid' => $this->request->getData()['step_id']
                        );
                        return $this->response->withStringBody(json_encode($actst));
                    } else {
                        return $this->redirect($this->referer());
                    }

                } else {
                    $message = 'Something went wrong saving the activity to the database. Please contact allan.haggett@gov.bc.ca';
                    $this->set(compact('message'));
                }
            }
        }
    }
    /**
     * Get activity title and description from URL so we can populate that info 
     * for curators.
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function getinfo()
    {
        $linktoact = $this->request->getQuery('url');
        $fp = file_get_contents($linktoact);
        if (!$fp) 
            return null;
        
        $doc = new \DOMDocument();
        @$doc->loadHTML($fp);
        $nodes = $doc->getElementsByTagName('title');

        $title = $nodes->item(0)->nodeValue;
        $description = '';
        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++)
        {
        $meta = $metas->item($i);
        if($meta->getAttribute('name') == 'description')
            $description = $meta->getAttribute('content');
        if($meta->getAttribute('name') == 'keywords')
            $keywords = $meta->getAttribute('content');
        if($meta->getAttribute('language') == 'language');
            $language = $meta->getAttribute('language');
        }

        $details = array('title' => $title, 'description' => $description);

        $this->set(compact('details'));
    }
    

    /**
    * Standard Activities file upload.
    * 
    * Takes a standard CSV file of activities and uploads it into the webroot/files
    * directory and redirects to activityImport
    * 
    *
    *
    * @return \Cake\Http\Response|null Redirects to activityImport for processing.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found. #TODO what does it really say?
    *
    */
    public function activityImportUpload () 
    {
        $fileobject = $this->request->getData('standardimportfile');
        $destination = '/home/allankh/learningagent/webroot/files/standard-import.csv';

        // Existing files with the same name will be replaced.
        $fileobject->moveTo($destination);
        return $this->redirect(['action' => 'activityImport']);
    }

    /**
    * Standard Activities Import process.
    * 
    * Takes a standard CSV file of activities (headers below; sample file in repo)
    * and imports them into the database.
    *
    * #TODO should this be implemented at the Model/Table layer? probs...
    *
    * 0-Pathway,1-Step,2-Activity Type,3-Name,4-Hyperlink,5-Description,6-Required,
    * 7-Competencies,8-Time,9-Tags,10-Licensing,11-ISBN,12-Curator
    *
    * ___Does NOT currently support importing pathways or steps.___ It will only 
    * import activities. Curators then still need to create pathways and steps and 
    * manually associate the activities. It's on the backlog to support this, but 
    * not for MVP
    *
    * @return \Cake\Http\Response|null Redirects to courses index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    *
    */
    public function activityImport ()
    {
        // #TODO check to see if standard-import.csv already exists,
        // make a copy of it if it does (better yet give it a unique
        // file name on upload and pass it in here)
        // #TODO Use a constant for the file path
        //
        // "Pathway","Step","2-Activity Type","Name","4-Hyperlink",
        // "Description","6-Required","Competencies","8-Time","Tags","10-Licensing","ISBN","Curator"
        //
        if (($handle = fopen("/home/allankh/learningagent/webroot/files/standard-import.csv", "r")) !== FALSE) {
            // pop the headers off so we're starting with actual data
            fgetcsv($handle);
           
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $lic = $data[10] ?? '';
                // #TODO Should we check for existing activities before proceding? 
                $activity = $this->Activities->newEmptyEntity();
                $this->Authorization->authorize($activity);
                // Get started
                $activity->name = utf8_encode($data[3]);
                $activity->description = utf8_encode($data[5]);
                // #TODO url encode this?
                $activity->hyperlink = $data[4];

                // This is for a comment on a moderation action
                // #TODO this should probably be split out into separate
                // feature that ties into user flag reports
                // (create a moderation table for each report; add a mod_comments
                //   table for discussion of the reports)
                $activity->moderator_notes = '';

                $activity->licensing = utf8_encode($lic);

                // #TODO maybe remove? automate fetch of external metadata?
                $activity->meta_description = '';

                // Default to active (1) #TODO support adding inactive? why?
                $activity->status_id = 1;

                // #TODO do a lookup here and get the proper ID based on the person's
                // name (don't require a number here)
                $activity->modifiedby_id = utf8_encode($data[12]);
                $activity->createdby_id = utf8_encode($data[12]);
                $activity->approvedby_id =  utf8_encode($data[12]);
                // #TODO change this to minutes instead of hours
                $activity->hours = 0; //utf8_encode($data[8]);
                // Is it required?
                $reqd = 0;
                if($data[6] == 'y') $reqd = 1;
                $activity->required = $reqd;

                // Competencies 
                // #TODO implement lookup and new if not exists

                // Tags
                // #TODO implement lookup and new if not exists
                // https://book.cakephp.org/4/en/tutorials-and-examples/cms/tags-and-users.html

                // 1-watch,2-read,3-listen,4-participate
                $actid = 1;
                if($data[2] == 'Watch') $actid = 1;
                if($data[2] == 'Read') $actid = 2;
                if($data[2] == 'Listen') $actid = 3;
                if($data[2] == 'Participate') $actid = 4;
                $activity->activity_types_id = $actid;
                
                if ($this->Activities->save($activity)) {
                    // do nothing, move to the next activity
                } else {
                    print_r($data);
                    echo 'Did not import ' . $data[4] . '. Something\'s wrong!<br>';
                }
            
            } // endwhile
        
            //return $this->redirect(['action' => 'index']);
        }
    }

}
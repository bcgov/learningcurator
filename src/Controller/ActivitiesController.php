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
        $useractivities = $useacts->toList();
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
        
        $activities = $this->Activities->find('all')
                                        ->where(['Activities.status_id' => 2])
                                        ->where(['Activities.audited < ' => $weeksago])
                                        ->where(['Activities.moderation_flag' => 1])
                                        ->limit(10);
        
        $this->set(compact('activities','now'));
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
        
        $activities = $this->Activities->find('all')
                                        ->where(['Activities.status_id' => 2])
                                        ->where(['Activities.audited < ' => $weekago])
                                        ->where(['Activities.moderation_flag' => 0])
                                        ->limit(10)
                                        ->toList();

        $report = TableRegistry::getTableLocator()->get('Reports');
        $actcount = count($activities); 
        $count200 = 0;
        $reportcount = 0;
        $excludedcount = 0;
        
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
                    $headers = get_headers($url);
                    // Anything other than 200 OK gets reported
                    if ($headers[0] != 'HTTP/1.1 200 OK') {
                        $newreport = $report->newEmptyEntity();
                        $reportdata = [
                            'activity_id' => $a->id,
                            'user_id' => 'fab197ca-eaa7-4418-960d-d8e8cf40231a', // always as superadmin
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
        // #TODO the below is WRONG update 
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
                            'Tags',
                            'Reports',
                            'Reports.Users'],
        ]);

        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        $pathways = $allpaths->find('all')->contain(['Steps']);
        $allpathways = $pathways->toList();

        $curatorinfo = TableRegistry::getTableLocator()->get('Users');
        $cur = $curatorinfo->find()->where(['id = ' => $activity->createdby_id]);
        $curator = $cur->toList();

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
                $this->Flash->success(__('The activity has been saved.'));
                $go = '/activities/view/' . $id;
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
     * Find method for activities; this is super-duper basic and search deserves better thab
     *
     * @param string|null $search search pararmeters to lookup activities.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function find()
    {
        $search = $this->request->getQuery('search');
        
        $activities = $this->Activities->find('search', ['search' => $this->request->getQuery()])
                                        ->contain(['ActivityTypes','Steps.Pathways']);
        $numacts = $activities->count();

        // We've searched for activities and that's great and all, but we also
        // want to return results for categories.
        $allcats = TableRegistry::getTableLocator()->get('Categories');
        $categories = $allcats->find('all',
                                    array('conditions' => 
                                    array('OR' => 
                                        array(
                                            'name LIKE' => '%'.$search.'%',
                                            'description LIKE' => '%'.$search.'%'
                                        )
                                )));
        $numcats = $categories->count();

        // We've searched for activities and categories and that's great and all, but we also
        // want to return results for pathways. 
        $allpaths = TableRegistry::getTableLocator()->get('Pathways');
        // $pathways = $allpaths->find()->where(function ($exp, $query) use($search) {
        //     return $exp->like('name', '%'.$search.'%');
        // })->order(['name' => 'ASC']);

        $pathways = $allpaths->find('all',
                                    array('conditions' => 
                                    array('OR' => 
                                        array(
                                            'name LIKE' => '%'.$search.'%',
                                            'description LIKE' => '%'.$search.'%'
                                        )
                                )));
        $numpaths = $pathways->count();

        // We've searched for activities, categories, and pathways and that's
        // great and all, but we also want to return results for steps as well. 
        $allsteps = TableRegistry::getTableLocator()->get('Steps');
        // $pathways = $allpaths->find()->where(function ($exp, $query) use($search) {
        //     return $exp->like('name', '%'.$search.'%');
        // })->order(['name' => 'ASC']);

        $steps = $allpaths->find('all',
                                    array('conditions' => 
                                    array('OR' => 
                                        array(
                                            'name LIKE' => '%'.$search.'%',
                                            'description LIKE' => '%'.$search.'%'
                                        )
                                )));
        $numsteps = $steps->count();



        $this->set(compact('categories', 
                            'pathways', 
                            'steps',
                            'activities', 
                            'search', 
                            'numcats', 
                            'numsteps', 
                            'numacts', 
                            'numpaths'));
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
        $allpathways = $pathways->toList();

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
     * Add-to-step method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addtostep()
    {

	    $user = $this->request->getAttribute('authentication')->getIdentity();
        $linktoact = $this->request->getQuery('url');
        $pathway_id = $this->request->getQuery('pathway_id');

        
        if($pathway_id) {
            
        }
        if($linktoact) {

            // If it exists return the one we've already got.
            $activity = $this->Activities->find()->contain(['ActivityTypes','Tags','Steps.Pathways'])->where(function ($exp, $query) use($linktoact) {
                return $exp->like('hyperlink', '%'.$linktoact.'%');
            })->toList();
            $this->set(compact('activity','linktoact'));

        } else {

            $activity = $this->Activities->newEmptyEntity();

            if ($this->request->is('post')) {

                //echo '<pre>'; print_r($this->request->getData()); exit;

                $activity = $this->Activities->patchEntity($activity, $this->request->getData());
                $activity->createdby_id = $user->id;
                $activity->modifiedby_id = $user->id;
                $activity->approvedby_id = $user->id;
                $activity->status_id = 2;
                $activity->activity_types_id = 1;

                $sluggedTitle = Text::slug($activity->name);
                // trim slug to maximum length defined in schema
                $activity->slug = strtolower(substr($sluggedTitle, 0, 191));

                if ($this->Activities->save($activity)) {

                    $asteptable = TableRegistry::getTableLocator()->get('ActivitiesSteps');
                    $activitiesStep = $asteptable->newEmptyEntity();
                    $activitiesStep->step_id = $this->request->getData()['step_id'];
                    $activitiesStep->activity_id = $activity->id;

                    if (!$asteptable->save($activitiesStep)) {
                        echo 'Cannot add to step! Contact an admin. Sorry :)';
                        echo '' . $activity->id;
                        exit;
                    }
                    $actstep = array(
                        'activityid' => $activity->id,
                        'activitystepid' => $activitiesStep->id,
                        'stepid' => $this->request->getData()['step_id']
                    );
                    // echo json_encode($actstep);
                    // exit;
                    $return = '/steps/edit/' . $this->request->getData()['step_id'];
                    return $this->redirect($return);
                }
    
            } // if POST method used
        } // endif does the link alreayd exist?

    
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
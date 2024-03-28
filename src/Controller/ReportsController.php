<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Mailer\Mailer;
Use Cake\ORM\TableRegistry;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{
    /**
     * Show the user their own reports method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function reports ()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity();
        $reports = $this->Reports->find('all')
                                ->contain(['Activities','Users'])
                                ->where(['user_id' => $user->id])
                                ->order(['Reports.created' => 'desc']);


        $this->set(compact('reports'));
    }
    /**
     * Index method that shows only reports that have NOT BEEN responded to
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $reports = $this->Reports->find('all', array('conditions' => array('Reports.response IS NULL')))
                                ->contain(['Activities','Users'])
                                ->order(['Reports.created' => 'desc']);

        $this->set(compact('reports'));
    }
    /**
     * Closed method that shows only reports that HAVE BEEN responded to
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function closed()
    {
        $reports = $this->Reports->find('all', array('conditions' => array('Reports.response IS NOT NULL')))
                                ->contain(['Activities','Users'])
                                ->order(['Reports.created' => 'desc']);


        $this->set(compact('reports'));
    }

    /**
     * View method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $report = $this->Reports->get($id, [
            'contain' => ['Activities', 'Users'],
        ]);

        $this->set(compact('report'));
    }

    /**
     * A user adds a new report to an activity, indicating some sort of issue
     * with the activity. When a new report is added, the user/reporter can see
     * the report on their profile, all curators can see the report in the curator dashboard,
     * and an email is sent to the owner/creator/curator
     * of the pathways to which this activity is assigned, as well as the person who
     * created/curated the activity in the first place.
     * 
     * Curators may provide a single response to reports. It is intentionally not a threaded
     * discussion. If a discussion needs to happen, it needs to happen elsewhere (e.g., Teams)
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $report = $this->Reports->newEmptyEntity();
        if ($this->request->is('post')) {
            // echo $this->request->getData()['activity_id'] . '<br><br>';
            // print_r($this->request->getData()); exit;
            // We need to look up the details of the activity that we're reporting
            // so that we can send the details to the curators involved.
            $act = TableRegistry::getTableLocator()->get('Activities');
            // OK so here is some dumb stuff. Because I cannot seem to tie together
            // createdby_id to the users table properly through the ORM, when I do
            // the pathway query, all I get is the raw ID for the user back, and 
            // not any other info such as the email address that we require here.
            // As a result, I need to loop through each of the pathways
            // and run a query to get the email address. #stupidbutworks
            // #thiswontscale
            $use = TableRegistry::getTableLocator()->get('Users');

            // Let's get the activity details, including the steps and pathways it's on
            $actid = $this->request->getData()['activity_id'];
            $actdeets = $act->find()->contain(['Steps','Steps.Pathways'])->where(['id = ' => $actid])->toList();

            // #dumbstuff setup an array of email addresses to send to
            // as we loop through the pathways on which this activity is included
            // we'll add to this and then use it to send the emails
            $curatoremails = [];
            $paths = [];
            foreach($actdeets as $a) {
                foreach($a->steps as $s) {
                    foreach($s->pathways as $path) {
                        array_push($paths,[$path->name, $path->slug]);
                        $curator = $use->find()->where(['id = ' => $path->createdby])->all()->toList();
                        array_push($curatoremails,$curator[0]['email']);
                    }
                }
            }
            // All this because I just cannot seem to grok this framework; 
            // don't blame the framework, I don't really understand 
            
            $report = $this->Reports->patchEntity($report, $this->request->getData());

            
            if ($this->Reports->save($report)) {

                // Who reported it?
                $reporterid = $this->request->getData()['user_id'];
                $reportedby = $use->find()->where(['id = ' => $reporterid])->firstOrFail();

                try {
                    // Sending an email through CHES is a two-stage process:
                    // 1. Use the CHES_CRED environment variable (which is the 
                    //     result of base64(client_id,client_secret) credentials
                    // 2. Send the email via the API using the token that we got
                    //     from the first request.
                    // Get the token:
                    $chesapicredential = env('CHES_CRED', null);
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://dev.loginproxy.gov.bc.ca/auth/realms/comsvcauth/protocol/openid-connect/token',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true ,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/x-www-form-urlencoded',
                            'Authorization: Basic ' . $chesapicredential
                        ),
                    ));
                    $tokenres = curl_exec($curl);
                    $token = json_decode($tokenres);

                    if(!empty($token->error)) {
                        echo 'Could not get access token to send email. '; 
                        echo $token->error_description;
                        exit;
                    }

                    // Now that we have a useful token, we can proceed to 
                    // compose and send the email.
                    $toemails = '';
                    foreach($curatoremails as $ce) {
                        $toemails .= $ce . ';';
                    }

                    // #TODO Set the host var based on the environment so that 
                    // this also works in dev as well as prod 
                    // (even though dev isn't open to public)
                    $host = 'https://learningcurator.gww.gov.bc.ca';
                    $subject = 'Curator Activity Report for ' . $actdeets[0]->name . '';
                    $reportedissue = addslashes($this->request->getData()['issue']);
                    $manuallink = 'https://bcgov.sharepoint.com/:f:/r/teams/00404/Shared%20Documents/Curators/Handbook%20-%20Documentation%20for%20Curators?csf=1&web=1&e=Y7b0BO';

                    // Start building the HTML message. Probably redo this with ```
                    // or put the messages into the database...
                    $message = '<div style=\"background-color: rgb(254 249 195); padding: 1em; margin-bottom: 1em;\">Please do not reply to this email.</div>';
                    $message .= '<p>Hello, Curator!</p>';
                    $message .= '<p>You are receiving this email because you are listed';
                    $message .= ' as the owner of a pathway on the ';
                    $message .= '<a href=\"'.$host.'\">Learning Curator<\/a>.</p>';
                    $message .= '<p>Learner <a href=\"' . $host . '/users/view/' . $reporterid . '\">' . $reportedby->username . '<\/a> filed a report on:</p>';
                    $message .= '<p><a style=\"font-weight: bold;\" href=\"' . $host . '/activities/view/' . $actid . '\">';
                    $message .= '' . $actdeets[0]->name . ' ';
                    $message .= '<\/a><\/p>';
                    $message .= '<p><a href=\"' . $host . '/users/view/' . $reporterid . '\">' . $reportedby->username . '<\/a> said:</p>';
                    $message .= '<blockquote style=\"background-color: #F1F1F1; padding: 2em;\">' . $reportedissue . '<\/blockquote>';
                    $message .= '<p>Direct link to activity in question:<p>';
                    $message .= '<p><a href=\"' . $actdeets[0]->hyperlink . '\">' . $actdeets[0]->hyperlink . '<\/a><\/p>';
                    $message .= '<p>This activity is on these pathways:</p>';
                    $message .= '<ul>';
                    foreach($paths as $p) {
                        $message .= '<li><a href=\"' . $host . '\/p\/' . $p[1] . '\">' . $p[0] . '<\/a><\/li>';
                    }
                    $message .= '<\/ul>';
                    $message .= '<p><a href=\"' . $manuallink . '\">Learn more about responding to reports in the Curator manual.</a></p>';
                    $message .= '<p>Curators this message has been sent to: ' . $toemails . '<\/p>';

                    // Now that the message is ready, let's send the email.
                    $opts = array(
                        CURLOPT_URL => 'https://ches-dev.api.gov.bc.ca/api/v1/email',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                            "bcc": [],
                            "bodyType": "html",
                            "body": "' . $message . '",
                            "cc": [],
                            "delayTS": 0,
                            "encoding": "utf-8",
                            "from": "Learning Curator - No Reply <noreply_curator@gov.bc.ca>",
                            "priority": "normal",
                            "subject": "' . $subject . '",
                            "to": ["allan.haggett@gov.bc.ca"],
                            "tag": "email_0b7565ca"
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $token->access_token,
                            'Cookie: 0662357d14092c112d042bc0007de896=0103b8f16bed8abcb82235ad88974279'
                        ),
                    );
                    curl_setopt_array($curl, $opts);
                    $response = curl_exec($curl);
                    curl_close($curl);
                    
                    if($this->request->getData('ajaxcall') == 1) {
                        return 'Success.';
                    } else {
                        return $this->redirect($this->referer());
                    }

                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            }

        }


    }

    /**
     * Edit method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $report = $this->Reports->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $report = $this->Reports->patchEntity($report, $this->request->getData());
            if ($this->Reports->save($report)) {
                $this->Flash->success(__('The report has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The report could not be saved. Please, try again.'));
        }
        $activities = $this->Reports->Activities->find('list', ['limit' => 200]);
        $users = $this->Reports->Users->find('list', ['limit' => 200]);
        $this->set(compact('report', 'activities', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Report id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $report = $this->Reports->get($id);
        if ($this->Reports->delete($report)) {
            $this->Flash->success(__('The report has been deleted.'));
        } else {
            $this->Flash->error(__('The report could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

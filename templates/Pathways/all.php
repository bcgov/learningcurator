<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
$environment = $_SERVER['SERVER_NAME'];

$this->assign('title', h($newsource['pathname']));

?>
<header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/1200w/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed_1200w.jpg);">
    <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Pathway</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://flic.kr/p/JULZFP" target="_blank">Paradise Meadows Boardwalk</a> by <a href="https://flic.kr/ps/3bxUBu" target="_blank">Fyre Mael on Flickr</a> (<a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">CC BY 2.0</a>)</p>
</header>
<div class="p-3 md:p-8 pt-4 w-full text-lg" id="mainContent">

    <nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <a href="/topics">All Topics</a> > 
        <a href="/topic/<?= h($newsource['topicslug']) ?>" class="hover:underline"><?= h($newsource['topicname']) ?></a> >
        <a href="/a/<?= h($newsource['pathslug']) ?>" class="hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost-2 mr-1 inline-block" viewBox="0 0 16 16">
                <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
            </svg><?= h($newsource['pathname']) ?>
        </a>
    </nav>

    <div class="p-3 mb-3 mt-8 bg-bluegreen text-white rounded-lg md:flex md:justify-start md:items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 mx-3 grow-0" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg>
        <h2 class="text-2xl flex-1">
            <?= h($newsource['pathname']) ?>
        </h2><?php if ($newsource['pathstatus'] == 1) : ?>
                <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-1 text-sm align-middle" title="Edit to set to publish">DRAFT</span>
            <?php endif ?>
        <span class="text-sm ml-3 justify-self-end flex-none"><?= $stepcount ?> steps | <?= $requiredacts ?> activities</span>
    </div>

    <div class="pl-3 md:pl-8 text-xl">

        <div class="mb-5 block">
        <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
        <?= $this->Html->link(__('Edit Pathway'), ['action' => 'edit', $newsource['pathid']], ['class' => 'float-right ml-3 px-4 py-2 text-md bg-slate-200 hover:bg-slate-200/80 focus:bg-slate-300/80 hover:no-underline rounded-lg']) ?>
        <?php endif ?>
        <p><span class="font-bold">Pathway Goal: </span><?= h($newsource['pathobjective']); ?></p></div>
        <?php if (empty($followid)) : ?>
            <div class="my-3">
                <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'follow']]) ?>
                <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $newsource['pathid']]) ?>
                <button class="py-2 px-4 bg-darkblue text-white rounded-lg hover:bg-darkblue/80">
                    Follow Pathway <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pin ml-2 inline" viewBox="0 0 16 16">
                        <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354zm1.58 1.408-.002-.001.002.001zm-.002-.001.002.001A.5.5 0 0 1 6 2v5a.5.5 0 0 1-.276.447h-.002l-.012.007-.054.03a4.922 4.922 0 0 0-.827.58c-.318.278-.585.596-.725.936h7.792c-.14-.34-.407-.658-.725-.936a4.915 4.915 0 0 0-.881-.61l-.012-.006h-.002A.5.5 0 0 1 10 7V2a.5.5 0 0 1 .295-.458 1.775 1.775 0 0 0 .351-.271c.08-.08.155-.17.214-.271H5.14c.06.1.133.191.214.271a1.78 1.78 0 0 0 .37.282z" />
                    </svg></button>
                <?= $this->Form->end(); ?>
            </div>
        <?php else : ?>
            <div class="my-3">
                <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'delete/' . $followid]]) ?>
                <button class="py-2 px-4 bg-darkblue text-white rounded-lg hover:bg-darkblue/80">
                    Un-Follow Pathway <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pin-angle inline" viewBox="0 0 16 16">
                        <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a5.927 5.927 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707-.195-.195.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a5.922 5.922 0 0 1 1.013.16l3.134-3.133a2.772 2.772 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146zm.122 2.112v-.002.002zm0-.002v.002a.5.5 0 0 1-.122.51L6.293 6.878a.5.5 0 0 1-.511.12H5.78l-.014-.004a4.507 4.507 0 0 0-.288-.076 4.922 4.922 0 0 0-.765-.116c-.422-.028-.836.008-1.175.15l5.51 5.509c.141-.34.177-.753.149-1.175a4.924 4.924 0 0 0-.192-1.054l-.004-.013v-.001a.5.5 0 0 1 .12-.512l3.536-3.535a.5.5 0 0 1 .532-.115l.096.022c.087.017.208.034.344.034.114 0 .23-.011.343-.04L9.927 2.028c-.029.113-.04.23-.04.343a1.779 1.779 0 0 0 .062.46z"/>
                    </svg>
                </button>
                <?= $this->Form->end(); ?>
            </div>
        <?php endif ?>

        <?php if(!empty($newsource['content_warning'])): ?>
        <details id="contentwarning" class="px-6 py-3 bg-yellow-200 rounded-lg hover:bg-yellow-100 open:bg-yellow-100">
            <summary class="hover:cursor-pointer">Before You Proceed</summary>
            <hr class="my-5">
            <div class="max-w-prose">
                <?= $newsource['pathwarning'] ?>
            </div>
        </details>
        <?php endif ?>



    <div class="py-3 sticky top-0 bg-white">
        <div class="flex pbarcontainer w-full bg-slate-200 rounded-lg content-center justify-start">
            <span class="hidden py-2 px-3 bg-darkblue text-white rounded-lg text-base pbar flex-none"></span>
            <span id="progressbar" 
                    class="hidden py-1 px-3 text-base pbar pro_sm flex-none bg-darkblue rounded-lg text-center text-white">
                </span>
            <span id="zero" class="py-1 px-3 text-base text-right">0 of <?= $totalacts ?></span>
        </div>
        <button id="expall" class="mt-3 px-6 py-1 bg-slate-50 text-sm hover:bg-slate-100">Expand All</button>
        <button id="collapseall" class="mt-3 px-6 py-1 bg-slate-50 text-sm hover:bg-slate-100">Collapse All</button>
    </div>









<?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
<details>
<summary>Re-order Steps</summary>
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-steps', 'action' => 'reorder']]) ?>
<?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $newsource['pathid']]) ?>
<?php $count = 0 ?>
<div id="items">
<?php foreach($newsource['steps'] as $s): ?>
<div class="flex mb-1 p-2 bg-slate-100 rounded-lg" data-id="<?= $s['stepid'] ?>">
<?php $count++ ?>
<div class="handle hover:cursor-pointer text-center" style="height: 1em; width: 2em;">
    <i class="bi bi-grip-vertical"></i>
</div>
<?= $this->Form->control('steporder[]', ['type' => 'hidden', 'class' => 'stepcount step' . $s['stepid'], 'value' => $count]) ?>
<div><?= $s['stepname'] ?></div>
<?= $this->Form->control('steps[]', ['type' => 'hidden', 'value' => $s['stepactjoinid']]) ?>
</div>
<?php endforeach ?>
</div>
<?= $this->Form->button(__('Update Step Order'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
<?= $this->Form->end() ?>
</details>
<details>
<summary>Add Step</summary>
<div class="px-4 py-3 bg-slate-50 rounded-lg">
<?= $this->Form->create(null, ['url' => [
    'controller' => 'Steps',
    'action' => 'add'
]]) ?>
<label for="name">Step Title</label>
<span class="text-slate-600 block mb-1 text-sm" id="nameHelp"><i class="bi bi-info-circle"></i> If your step has a title, include it here (or leave it as a number). </span>   
<?php echo $this->Form->input('name', ['class' => 'form-field max-w-prose mb-2', 'type' => 'text', 'aria-describedby' => 'nameHelp']);  ?>
<label for="description">Step Objective</label>
<span class="text-slate-600 block mb-1 text-sm" id="descriptionHelp"><i class="bi bi-info-circle"></i> What measurable target is the learner working towards at this step specifically? Imagine it beginning “At the completion of this step, learners will be able to…” (1&nbsp;phrase/sentence).</span>
<?php echo $this->Form->textarea('description', ['class' => 'form-field', 'aria-describedby' => 'descriptionHelp']); ?>


<?php
echo $this->Form->hidden('createdby', ['value' => $uid]);
echo $this->Form->hidden('modifiedby', ['value' => $uid]);
echo $this->Form->hidden('pathways.0.id', ['value' => $newsource['pathid']]);
?>
<?= $this->Form->button(__('Add Step'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
<?= $this->Form->end() ?>
</div>
</details>
<details>
<summary>Curator Details</summary>
    <div class="p-3 bg-slate-50 rounded-lg">
    <div class="flex mb-3">
        <div class="mr-3"><strong><?= $followcount ?></strong> follows</div>
        <div id="activitylaunches" class=""></div>
        <div id="allreports" class="pl-3">
            <a href="/stats">All Reports</a>
        </div>
    </div>
    <hr>
    <div class="mt-3">
        <?php if(!empty($createdby[0]->first_name)): ?>
        
            Created by:
            <a class="inline-block px-3 py-2 underline" href="/users/view/<?= $createdby[0]->id ?>"><?= $createdby[0]->username ?> </a>
        
        <?php if(!empty($modifiedby[0]->first_name)): ?>
        <?php if($createdby[0]->id != $modifiedby[0]->id): ?>
        
            <strong>Last modified by:</strong>
            <a class="inline-block px-3 py-2 underline" href="/users/view/<?= $modifiedby[0]->id ?>"><?= $modifiedby[0]->username ?></a>
        
        <?php endif ?>
        <?php endif ?>
        <?php else: ?>
        
            <strong>Created by:</strong>
            The user who created this pathway no longer 
            appears to be in the system.
        
        <?php endif ?>

        <?php if(!empty($newsource['pathpublishedby'])): ?>
        
            <strong>Published by:</strong>
            <a class="inline-block bg-slate-100 p-3 rounded-lg underline" href="/users/view/<?= $publishedby[0]->id ?>"><?= $publishedby[0]->username ?> </a>
        
        <?php endif ?>
        
            <?php $unrec_count = 0 ?>
            Curators:
            <?php foreach($contributors as $c): ?>
                <?php //print_r($c) ?>
                <?php if(!empty($c[0]->username)): ?>
                <a class="inline-block px-3 py-2 underline" 
                    href="/users/view/<?= $c[0]->id ?>">
                        <?= $c[0]->username ?>
                </a>
                <?php else: ?>
                <?php $unrec_count++ ?>
                <?php endif ?>
            <?php endforeach ?>
            <?php if($unrec_count > 0): ?>
                <div><?= $unrec_count ?> unrecognized contributors to this pathway.</div>
            <?php endif ?>
        
    </div>
        

        <?php if($environment != 'learningcurator.apps.silver.devops.gov.bc.ca' && $environment != 'learningcurator.gww.gov.bc.ca') : ?>
                    
        <?php if(empty($newsource['version'])): ?>



        <div class="m-3 p-3 bg-yellow-100 rounded-lg">

        <div><strong>This pathway has not be published.</strong></div>

        <?php if ($role == 'manager' || $role == 'superuser') : ?>

        <?php
        // #TODO move to controller
        $targetapi = '/topics/api';
        $targeturl = 'https://learningcurator.gww.gov.bc.ca';
        $targetname = 'Production System';
        $prodTopics = file_get_contents($targeturl.$targetapi);
        $pt = json_decode($prodTopics); 
        $matchingProdTop = [];
        if(!empty($pt->topics)) {
            foreach($pt->topics as $t) {
                if($t->slug == $newsource['topicslug']) {
                    $matchingProdTop = [$t->id,$t->name];
                } 
            }
        } else {
            echo 'Something is wrong with the target system.<br> Please contact an admin.';
        }
    
        ?>

        <?php if(empty($matchingProdTop)): ?>

            <p>There doesn't seem to be a matching topic 
                <a href="https://learningcurator.gww.gov.bc.ca/" target="_blank">in production</a>. 
                To publish, this pathway needs to be within a topic that also exists 
                <a href="https://learningcurator.gww.gov.bc.ca/" target="_blank">in production</a>.
            </p>

        <?php else: ?>
            
            <div>As a manager, you can choose to publish this pathway to production:</div>
            <div>
                <a href="/pathways/<?= h($newsource['id']); ?>/publish?topicid=<?= $matchingProdTop[0] ?>" 
                    class="py-2 inline-block px-4 bg-emerald-700 text-white rounded-lg hover:bg-darkblue/80">
                        Publish Pathway
                </a>
            </div>
            
        <?php endif; // matching topic? ?>

        <?php else: // role check ?>

            <div>Only a Topic Manager can publish pathways.</div>

        <?php endif; // role check ?>
        </div>
        <?php endif; // version exists check ?>
        <?php endif; // enviromnent check ?>


        <?php if(empty($newsource['version'])): ?>
        <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>

        <details class="mb-3">
            <summary>Bookmarklet</summary>
            <div class="p-4 bg-slate-50 rounded-lg">
                <p>A "bookmarklet" is a special kind of bookmark. Add the bookmarklet (below) to your
                    browser and make it easy to add new activities to this pathway.</p>
                <p>Once you've got the bookmarklet added to your bookmarks, adding a new activity
                    to this pathway is one click away.</p> 
                <div class="">
                    <a class="inline-block underline mb-2" 
                        rel="bookmarklet" 
                        href="javascript: (() => {const destination = 'https://learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca/activities/addtopath?pathwayid=<?= $newsource['pathid'] ?>&url=' + window.location.href;window.open(destination);})();"
                        title="Drag to bookmarks bar or right-click and add to bookmarks">
                            Add to "<?= $newsource['pathname'] ?>" Bookmarklet
                    </a>
                </div>
                
            </div>
        </details>
        
        <?php endif; // role check ?>
        
        <?php endif; // published status check ?>
        
    </div>
</details>
<?php endif; // role check ?>






        <?php if (!empty($newsource['steps'])) : ?>
            
        

        <?php $count = 0 ?>

        <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
        <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-steps', 'action' => 'reorder']]) ?>
        <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $newsource['pathid']]) ?>
        <?php endif ?>
        <div id="steplist" class="">
            <?php foreach ($newsource['steps'] as $steps) : ?>

                <?php $count++ ?>
                
                <div id="step-<?= $count ?>" 
                    data-actidlist="<?= $steps['actidlist'] ?>" 
                    data-stepid="<?= $steps['stepid'] ?>" 
                    data-required="<?= $steps['activities_required_count'] ?>"
                    class="steps mt-4 text-lg border-2 border-bluegreen group-hover:border-bluegreen/80 rounded-lg flex justify-start">

                    <h3 class="text-2xl font-semibold flex-none items-start bg-bluegreen group-hover:bg-bluegreen/80 text-white basis-1/7 p-3">
                        <?= $count ?>
                    </h3>
    
                    <div class="flex-1 basis-6/7 p-3">

                        <h4 class="text-xl font-semibold mb-2">
                            <a class="permalink" href="/a/<?= h($newsource['pathslug']) ?>#step-<?= $count ?>">
                                <?= h($steps['stepname']) ?>
                            </a>
                            <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                            <a href="/steps/edit/<?= $steps['stepid'] ?>" class="group float-right text-xs">
                                Edit
                            </a>
                            <?php endif ?>
                        </h4>
                        <div class="mb-2">
                            <div class="max-w-prose"><span class="font-bold">Objective</span>
                            <?= $steps['stepdescription'] ?>
                            </div>
                        </div>

                    <details class="activitylist py-2 px-2 md:px-4 bg-slate-100 rounded-lg">
                        <summary class="font-bold hover:cursor-pointer">
                            <span class="inline-block px-3 py-0 bg-bluegreen text-white text-sm rounded-lg">
                                <?= $steps['activities_required_count'] ?>
                            </span> Activities 
                            <!-- <span class="inline-block px-3 py-0 bg-bluegreen text-white text-sm rounded-lg">
                                <?= $steps['activities_bonus_count'] ?>
                            </span> Bonus -->
                            <span class="inline-block px-3 py-0 bg-darkblue text-white text-sm rounded-lg"><span class="stepprogress"></span></span> Launched
                        </summary>
                       

                        <?php foreach($steps['activities_required'] as $a): ?>
                        <details id="activity-<?= $a['id'] ?>" class="activity my-3 border-b-2 border-white open:bg-slate-50 rounded-lg">
                            <summary class="font-semibold fs-4 py-2 text-lg hover:cursor-pointer hover:text-blue-900 rounded-lg">
                                <!-- <span id="launched-<?= $a['id'] ?>" class="hidden launched inline-block p-0.5 px-2 bg-emerald-700 text-white text-xs text-center uppercase rounded-lg hover:no-underline hover:bg-sky-700/80"></span>  -->
                                <i id="launched-<?= $a['id'] ?>" class="launched bi bi-circle ml-2" style="color:rgb(35 64 117 / var(--tw-bg-opacity))" aria-label="Not yet launched" title="Not yet launched"></i>
                                <i class="<?= h($a['activity_type_icon']) ?> mr-1" style="color:rgb(35 64 117 / var(--tw-bg-opacity))" aria-label="<?= h($a['activity_type']) ?> activity" title="<?= h($a['activity_type']) ?> activity."></i>
                                <?= $a['name'] ?>
                            </summary>
                            <div class="p-3 ml-4 mb-2 rounded-lg max-w-prose">
                            <div class="mb-3"><?= $a['description'] ?></div>
                            <?php if (!empty($a['curator_context'])) : ?>
                            <div class="text-sm italic mt-2">Curator says:</div>
                            <blockquote class="border-l-2 p-2 m-2"><?= h($a['curator_context']) ?></blockquote>
                            <?php endif ?>
                            <div>
                                <a target="_blank" 
                                    rel="noopener" 
                                    title="Launch this activity" 
                                    data-activity="act-<?= $a['id'] ?>" 
                                    href="/activities-users/launch?activity_id=<?= $a['id'] ?>&step_id=<?= $steps['stepid'] ?>" 
                                    class="launch inline-block my-2 py-2 px-5 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-xl hover:no-underline">
                                        Launch
                                </a>
                                <a href="/activities/view/<?= $a['id'] ?>" class="inline-block ml-3 underline hover:text-blue-700">Details</a>
                            </div>
                            </div>
                        </details>
                        <?php endforeach ?>

                        <?php if(!empty($steps['activities_bonus'])): ?>
                        <div class="my-6 max-w-prose bg-slate-50 rounded-lg">
                            <h3 class="mt-4 p-2 pb-0 text-xl font-bold">
                                <?= $steps['activities_bonus_count'] ?>
                                Bonus Activities
                            </h3>
                            <div class="p-2 italic fs-6">Launching these activities does not count towards your progress.</div>
                        </div>

                        <?php foreach($steps['activities_bonus'] as $a): ?>
                            <details id="activity-<?= $a['id'] ?>" class="activity mb-3 border-b-2 border-white open:bg-slate-50 rounded-lg">
                            <summary class="font-bold fs-4 py-2 text-lg hover:cursor-pointer hover:text-blue-900 hover:bg-slate-50 rounded-lg">
                                <i id="launched-<?= $a['id'] ?>" class="launched bi bi-circle ml-2" style="color:rgb(35 64 117 / var(--tw-bg-opacity))" aria-label="Not launched" title="Not yet launched"></i>
                                <i class="<?= h($a['activity_type_icon']) ?> mr-1" style="color:rgb(35 64 117 / var(--tw-bg-opacity))" aria-label="<?= h($a['activity_type']) ?> activity" title="<?= h($a['activity_type']) ?> activity."></i>
                                <?= $a['name'] ?>
                                <span id="launched-<?= $a['id'] ?>" class="hidden launched inline-block p-0.5 px-2 bg-emerald-700 text-white text-xs text-center uppercase rounded-lg hover:no-underline hover:bg-sky-700/80"></span> 
                            </summary>
                            <div class="p-3 ml-4 rounded-lg">
                            <div class="mb-3"><?= $a['description'] ?></div>
                            <?php if (!empty($a['curator_context'])) : ?>
                            <div class="text-sm italic mt-2">Curator says:</div>
                            <blockquote class="border-l-2 p-2 m-2"><?= h($a['curator_context']) ?></blockquote>
                            <?php endif ?>
                            <div>
                                <a target="_blank" 
                                    rel="noopener" 
                                    title="Launch this activity" 
                                    data-activity="act-<?= $a['id'] ?>" 
                                    href="/activities-users/launch?activity_id=<?= $a['id'] ?>&step_id=<?= $steps['stepid'] ?>" 
                                    class="launch inline-block my-2 py-2 px-5 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-xl hover:no-underline">
                                        Launch
                                </a>
                                <a href="/activities/view/<?= $a['id'] ?>" class="inline-block ml-3 underline hover:text-blue-700">Details</a>
                            </div>
                            </div>
                        </details>
                        <?php endforeach ?>
                        <?php endif ?>
                        <?php if(!empty($steps['reflect'])): ?>
                        <div class="mb-4 mt-10 max-w-prose p-6 bg-white rounded-lg">
                            <h4 class="mb-3 text-lg font-bold">Pause and Reflect</h4>
                            <?= $steps['reflect'] ?>
                        </div>
                        <?php endif ?>
                        </div>
                        </div>
                    </details>

            <?php endforeach ?>
        </div>
    </div>
</div>


<script src="/js/sortable.min.js"></script>
<script type="module">

<?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
// ||||||||||||||||||||
// 
// Administrative functions only.
//
// * Allow curator drag-n-drop sorting of steps.
// * Update pathway launch count.
// 
// ||||||||||||||||||||
var el = document.getElementById('items');
var sortable = Sortable.create(el, {
  animation: 150,
  handle: '.handle',
  onEnd: function (/**Event*/evt) {
        resort();
	},
});
function resort () {
    let stepcount = document.getElementsByClassName('stepcount');
    let count = 1;
    Array.from(stepcount).forEach(function(element) {
        element.setAttribute('value', count);
        count++;
    });
}

getPathwayLaunchReport();
function getPathwayLaunchReport () {

    // Make the call
    let learner = fetch('/a/<?= $newsource['pathslug'] ?>/launchreport', {
            method: 'GET'
        })
        .then((res) => res.json())
        .then((json) => {
            let activitylaunches = document.getElementById('activitylaunches');
            activitylaunches.innerHTML = '<strong>' + json.count + '</strong> activity launches';
            
        })
        .catch((err) => console.error('error:', err));

}
<?php endif; // end of curator-only functions ?>

// ||||||||||||||||||||
// 
// Details/Summary niceties
//
// By default, all the activities are hidden behind a details/summary
// and subsequently the description/launch links are as well.
// This supports allowing the learner to choose to "expand all" and 
// show everything on the page all at once, or "collapse all" and 
// hide everything. 
// 
// As well, clicking on the step header will expand
// the activity list (while not expanding the activity itself),
// and update the URL with the fragment ID, so you can link people
// direcrtly to step with its activities open already.
//
// ||||||||||||||||||||

// Show everything all in once fell swoop.
let expall = document.getElementById('expall');
expall.addEventListener('click', (e) => {
    let steplist = document.getElementById('steplist');
    let deets = steplist.querySelectorAll('details');
    Array.from(deets).forEach(function(element) {
        element.setAttribute('open','open');
    });
});
// Conversley, "collapse all" hides everyting open in one fell swoop.
let collapseall = document.getElementById('collapseall');
collapseall.addEventListener('click', (e) => {
    let steplist = document.getElementById('steplist');
    let deets = steplist.querySelectorAll('details');
    Array.from(deets).forEach(function(element) {
        element.removeAttribute('open');
    });
});

// If we are linking directly to a step via a URL hash then open the 
// activities for that step automatically by adding an open attribute
// to the details/summary container.
if(window.location.hash) {
    let stepopen = window.location.hash;
    let step = stepopen.replace('#','');
    let stepacts = document.getElementById(step);
    let toopen = stepacts.getElementsByClassName('activitylist');
    toopen[0].setAttribute('open','open');
}

// When you click the permalink it will open the activities on that step 
// and update the URI with the fragment ID.
let permalinks = document.getElementsByClassName('permalink');
Array.from(permalinks).forEach(function(element) {
    element.addEventListener('click', (e) => { 
        // This is a bit fragile as it depends on the structure of the HTML
        // being in a certain order...
        let openacts = element.parentNode.nextElementSibling.nextElementSibling;
        openacts.setAttribute('open','open');
    });
});

// ||||||||||||||||||||
//
// Pathway Progress and launch indicators
// 
// ||||||||||||||||||||

// This is a list of all the required activity IDs on this pathway from every step.
let pathacts = [<?php foreach($activityids as $a) { echo $a . ','; } ?>];

// Grab the list of activities in the DOM so we can iterate over them
// assigning launched status.
let activities = document.getElementsByClassName('activity');
let steps = document.getElementsByClassName('steps');

let thispathwayid = <?= $newsource['pathid'] ?>;

// Setup the statuses on the initial page load.
getLearnerData ();

// Left to itself, the launch link on activites works just fine 
// with target=_blank set, but we want to update the UI of this 
// page while the learner visits the activity so that when they
// come back, their current state on the pathway is reflected 
// without having to refresh the page. 
let launchlinks = document.getElementsByClassName('launch');
Array.from(launchlinks).forEach(function(element) {
    element.addEventListener('click', (e) => { 
        e.preventDefault();
        // actually open the link
        let url = e.target.href;
        window.open(url);
        // Wait 3 seconds before re-loading the status so the launch
        // event gets properly registered in the background
        setTimeout(function(){
            getLearnerData();
        }, 3000);
    });
});

// The '/users/api' endpoint returns two simple arrays:
//  1. The IDs of all activities launched
//  2. The IDs of all pathways followed
// For launch statuses, the pathway has a list of all activity IDs
// that are contained on it in the 'pathacts' variable defined above
// (via PHP). We use that to compare the difference with acts launched
// to derive overall progress and individual activity status.
function getLearnerData () {

    // Make the call
    fetch('/users/api', {
            method: 'GET'
        })
        .then((res) => res.json())
        .then((json) => {
            // Pathway follow statuses.
            let followed = json['followed'];
            let pathdeets = [];
            // console.log(followed);
            followed.forEach(function(e){
                if(e[0] == thispathwayid){
                    pathdeets = e;
                }
            });
            // console.log(pathdeets[2]);
            // Activity launch statuses.
            let launched = json['launched'];
            // Update UI with launch statuses.
            updateLaunches(launched);
            // Now update overall pathway progress.
            updateProgress(launched,pathdeets);
            // Update per-step progress.
            updateStepStats(launched);
        })
        .catch((err) => console.error('error:', err));

}


// Update the progress bar UI with the info returned by getLearnerData()
function updateProgress (launched,pathdeets) {
    // pathdeets[0] pathwayid
    // pathdeets[1] date_start
    // pathdeets[2] date_end
    // pathdeets[3] pathfollowid
    // Calculate pathway progress and update the UI.
    let intersection = pathacts.filter(x => launched.includes(x));
    let progress = (intersection.length / pathacts.length) * 100;
    let togo = pathacts.length - intersection.length;
    let perc = Math.floor(progress);
    let pbar = document.getElementById('progressbar');
    let zero = document.getElementById('zero');
    // console.log(pathdeets[2]);
    // If there is no existing completion date and the new calculation
    // comes up 100 percent, we need to post to the completion endpoint
    // and update it with now()
    if(pathdeets[2]) {
        //
        // There's a completion date! 
        pbar.innerHTML = '<span class="text-xs">Pathway completed!</span>';
        zero.innerHTML = '';
        pbar.classList.remove('hidden');
        pbar.setAttribute('style','width:100%');
        //
    } else if(!pathdeets[2] && perc === 100) {
        let pathfollowid = pathdeets[3];
        //
        // completePathway(pathfollowid);
        // fetch('/users/api', {
        //         method: 'POST',
        //         body: JSON.stringify({})
        //     })
        //     .then((res) => res.json())
        //     .then((json) => {
        //
        //     })
        //     .catch((err) => console.error('error:', err));
        //
        pbar.innerHTML = '<span class="text-xs">Pathway completed!</span>';
        zero.innerHTML = '';
        pbar.classList.remove('hidden');
        pbar.setAttribute('style','width:100%');

    } else {

        pbar.setAttribute('style','width:' + perc + '%');
        if(intersection.length > 3) {
            zero.innerHTML = '';
            pbar.classList.remove('hidden');
            pbar.innerHTML = '<span class="text-xs">' + intersection.length + ' of ' + pathacts.length + '</span>';
        } else {
            if(intersection.length > 0) {
                pbar.classList.remove('hidden');
            }
            zero.innerHTML = '<span class="text-xs">' + intersection.length + ' of ' + pathacts.length + '</span>';
        }
        
    }

}

// Update the status of individual activities with the info returned 
// by getLearnerData()
function updateLaunches (launched) {
    // Grab all the activities on the page and loop through them.
    Array.from(activities).forEach(function(element) {
        // we take the id of the div which is in the format "activity-999"
        // and we need to split the "activity-" part out so that we can address
        // the numeric value only.
        let actid = element.id;
        let aid = actid.split('-');
        // Does this listed activity exist in the list of activities the 
        // learner has launched?
        if(launched.includes(parseInt(aid[1]))) {
            // Set the badge so that it says "Launched!" in the UI so that 
            // learner can easily see where they've been before.
            let badge = element.getElementsByClassName('launched');
            // I had issues with getting the element by ID for some reason
            // so we get by class and refer to the first (and expected to be
            // only) instance of it with [0].
            badge[0].classList.remove('bi-circle');
            badge[0].classList.add('bi-check-circle-fill');
            badge[0].setAttribute('title','You have launched this activity!');
            badge[0].setAttribute('aria-label','You have launched this activity!');
        }
    });
}


// Update the step-level progress bars with the info returned 
// by getLearnerData()
function updateStepStats (launched) {
    // Grab all the steps on the page and loop through them.
    Array.from(steps).forEach(function(element) {
        
        let launchcount = 0;
        let prog = element.getElementsByClassName('stepprogress');
        let reqcount = element.dataset.required;
        let actlist = element.dataset.actidlist.split(',');
        actlist.forEach(function(e) {
            if(launched.includes(parseInt(e))) {
                launchcount++;
            }
        });
        let percent = (parseInt(launchcount) / parseInt(reqcount)) * 100;
        let perc = Math.floor(percent) + '%';
        prog[0].innerHTML = launchcount;

    });
}
</script>


<?php else : ?>
    <div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>
    

<?php if(!empty($newsource['acknowledgments'])): ?>
<div class="mb-5 max-w-prose p-6 md:ml-20">
<h4 class="mb-3 text-lg font-bold">Notes of Acknowledgment</h4>
<?= $newsource['acknowledgments'] ?>
</div>
<?php endif ?>
</div>
</div>
</div>
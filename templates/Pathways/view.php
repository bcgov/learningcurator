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

$this->assign('title', h($pathway->name));

?>
<header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/1200w/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed_1200w.jpg);">
    <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Pathway</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://flic.kr/p/JULZFP" target="_blank">Paradise Meadows Boardwalk</a> by <a href="https://flic.kr/ps/3bxUBu" target="_blank">Fyre Mael on Flickr</a> (<a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">CC BY 2.0</a>)</p>
</header>
<div class="p-8 pt-4 w-full text-lg" id="mainContent">

    <nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <a href="/topics">All Topics</a> > 
        <a href="/topic/<?= h($pathway->topic->slug) ?>" class="hover:underline"><?= h($pathway->topic->name) ?></a> >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost-2 mr-1 inline-block" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg><?= h($pathway->name) ?>
    </nav>



    <div class="max-w-prose">
        <div class="p-3 mb-3 mt-8 bg-bluegreen text-white rounded-lg flex justify-start items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 mx-3 grow-0" viewBox="0 0 16 16">
                <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
            </svg>
            <h2 class="text-2xl flex-1">
                <?= h($pathway->name) ?>
            </h2><?php if ($pathway->status_id == 1) : ?>
                    <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-1 text-sm align-middle" title="Edit to set to publish">DRAFT</span>
                <?php endif ?>
            <span class="text-sm ml-3 justify-self-end flex-none"><?= $stepcount ?> steps | <?= $requiredacts ?> activities</span>
        </div>

        <div class="pl-8 text-xl">

            <div class="mb-5 block">
            <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
            <?= $this->Html->link(__('Edit Pathway'), ['action' => 'edit', $pathway->id], ['class' => 'float-right ml-3 px-4 py-2 text-md bg-slate-200 hover:bg-slate-200/80 focus:bg-slate-300/80 hover:no-underline rounded-lg']) ?>
            <?php endif ?>
            <p><span class="font-bold">Pathway Goal: </span><?= h($pathway->objective); ?></p></div>
            <?php if (empty($followid)) : ?>
                <div class="my-3">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'follow']]) ?>
                    <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $pathway->id]) ?>
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





            <h3 class="mt-4 mb-1 text-darkblue font-semibold text-lg">Pathway Activity Progress</h3>
            <div class="flex pbarcontainer mb-4 w-full bg-slate-200 rounded-lg content-center justify-start">
                <span class="hidden py-2 px-3 bg-darkblue text-white rounded-lg text-base pbar flex-none"></span>
                <span class="py-2 px-3 text-base pbar pro_sm flex-none"></span>
                <span class="py-2 px-3 text-base total flex-1 text-right"></span>
                <span class="zero hidden py-2 px-3 text-base text-right"></span>
            </div>
            <script>
                fetch('/pathways/status/<?= $pathway->id ?>', {
                    method: 'GET'
                })
                .then((res) => res.json())
                .then((json) => {

                    if (json.percentage > 0) {
                        // Phrasing
                        let launched = json.completed + ' launched';
                        let remaining = (json.requiredacts - json.completed) + ' to go';
                        document.querySelector('.zero').classList.add('hidden');
                        document.querySelector('.pbar').classList.remove('hidden');
                        document.querySelector('.pbar').style.width = json.percentage + '%';

                        if (json.percentage == 100) {
                            
                            document.querySelector('.pbar').innerHTML = 'Pathway completed!';
                            document.querySelector('.zero').innerHTML = '';
                        } else if (json.percentage < 20) {
                            
                            document.querySelector('.pbar').innerHTML = '';
                            document.querySelector('.pro_sm').innerHTML = launched;
                            document.querySelector('.total').innerHTML = remaining;
                            document.querySelector('.zero').innerHTML = '';
                        } else if (json.percentage > 90) {
                            document.querySelector('.pro_sm').innerHTML = '';
                            document.querySelector('.total').innerHTML = '';
                            document.querySelector('.pbar').innerHTML = launched + ', ' + remaining;
                            document.querySelector('.zero').innerHTML = '';
                        } else {
                            document.querySelector('.pbar').innerHTML = launched;
                            document.querySelector('.total').innerHTML = remaining;
                            document.querySelector('.pro_sm').innerHTML = '';
                            document.querySelector('.zero').innerHTML = '';
                        }

                    } else {
                        document.querySelector('.zero').classList.remove('hidden');
                        document.querySelector('.zero').innerHTML = '' + json.requiredacts + ' activities to go';
                    }
                })
                .catch((err) => console.error("error:", err));
            </script>





































<?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
<details>
    <summary>Curator Details</summary>
            <div class="p-3 text-sm">
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

                <?php if(!empty($pathway->publishedby)): ?>
                
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
            



            <?php $environment = $_SERVER['SERVER_NAME'] ?>
            <?php if($environment != 'learningcurator.apps.silver.devops.gov.bc.ca' && $environment != 'learningcurator.gww.gov.bc.ca') : ?>
            

                        
                        
            <?php if(!empty($pathway->version)): ?>
            <div class="mb-3 p-3 bg-yellow-100 rounded-lg">
          
                This pathway has been 
                <a href="https://learningcurator.gww.gov.bc.ca/topic/<?= h($pathway->topic->slug) ?>/<?= h($pathway->id) ?>/<?= h($pathway->slug) ?>" 
                    class="underline font-bold">
                        published to production
                </a>
                and should no longer be edited here.
                    
            </div>
            <?php else: ?>

            <div class="mb-3 p-3 bg-yellow-100 rounded-lg">

            <div><strong>This pathway has not be published.</strong></div>

            <?php if ($role == 'manager' || $role == 'superuser') : ?>

            <?php
            // #TODO move to controller
            $p2 = $_GET['publishto'] ?? '';
            $targetapi = '/topics/api';
            if($p2 == 'localtest') {
                $targeturl = 'https://learningcurator.ca';
                $targetname = 'Allan Local';
            } else if($p2 == 'dev') {
                $targeturl = 'https://learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca';
                $targetname = 'Dev System';
            } else if($p2 == 'prod') {
                $targeturl = 'https://learningcurator.gww.gov.bc.ca';
                $targetname = 'Production System';
            }
            $prodTopics = file_get_contents($targeturl.$targetapi);
            $pt = json_decode($prodTopics); 
            $matchingProdTop = [];
            if(!empty($pt->topics)) {
                foreach($pt->topics as $t) {
                    if($t->slug == $pathway->topic->slug) {
                        $matchingProdTop = [$t->id,$t->name];
                    } 
                }
            } else {
                echo 'Something is wrong with the target system.<br> Please contact an admin.';
            }
        

                //print_r($matchingProdTop);
            ?>
            <div>
                Publishing target: 
                <a href="<?= $targeturl ?>"><?= $targetname ?></a>
                <div>
                    <a class="inline-block px-2 mx-1 bg-slate-100" href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>?publishto=localtest">
                        Allan Local
                    </a>
                    <a class="inline-block px-2 mx-1 bg-slate-100" href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>?publishto=dev">
                        Dev
                    </a>
                    <a class="inline-block px-2 mx-1 bg-slate-100" href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>?publishto=prod">
                        Production
                    </a>
                </div>
        
            </div>

            <?php if(empty($matchingProdTop)): ?>

                <p>There doesn't seem to be a matching topic in the target 
                    environment. To publish, this pathway needs to be within 
                    a topic that also exists in the target.
                </p>

            <?php else: ?>
                
                <div>As a manager, you can choose to publish this pathway:</div>
                <div>
                    <a href="/pathways/<?= h($pathway->id); ?>/publish?topicid=<?= $matchingProdTop[0] ?>&publishto=<?= $p2 ?>" 
                        class="py-2 inline-block px-4 bg-emerald-700 text-white rounded-lg hover:bg-darkblue/80">
                            Publish Pathway
                    </a>
                </div>
                
            <?php endif; // matching topic? ?>

            <?php else: // role check ?>

                <div>Only a manager can publish pathways.</div>

            <?php endif; // role check ?>
            </div>
            <?php endif; // version exists check ?>
            <?php endif; // enviromnent check ?>






            <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
            <details class="mb-3">
                <summary>Bookmarklet</summary>
                <div class="p-4 bg-slate-50 rounded-lg">
                    <div class="">
                        <a class="inline-block underline mb-2" 
                            rel="bookmarklet" 
                            href="javascript: (() => {const destination = 'https://learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca/activities/addtopath?pathwayid=<?= $pathway->id ?>&url=' + window.location.href;window.open(destination);})();"
                            title="Drag to bookmarks bar or right-click and add to bookmarks">
                                Add to "<?= $pathway->name ?>" Bookmarklet
                        </a>
                    </div>
                    <p>A "bookmarklet" is a special kind of bookmark. Add the above bookmarklet to your
                        browser and make it easy to add new activities to this pathway.</p>
                </div>
            </details>
           

            
            
            
            <details>
            <summary>Add Step</summary>
            <div class="px-4 py-3">
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
            echo $this->Form->hidden('pathways.0.id', ['value' => $pathway->id]);
            ?>
            <?= $this->Form->button(__('Add Step'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>
            </div>
        </details>
            
        </details>
        
    <?php endif; // role check ?>
    <?php endif; // role check ?>




















            






            



            <!-- TODO Nori/Allan add code for subtitle in box -->
            <?php if (!empty($pathway->steps)) : ?>
                <?php $count = 0 ?>


                <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-steps', 'action' => 'reorder']]) ?>
                <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $pathway->id]) ?>
                <?php endif ?>

                <?php foreach ($pathway->steps as $steps) : ?>
                    <?php $requiredacts = 0; ?>
                    <?php foreach ($steps->activities as $act) : ?>
                        <?php if ($act->_joinData->required == 1) $requiredacts++; ?>
                    <?php endforeach ?>
                    <?php //echo '<pre>'; print_r($steps); continue; 
                    ?>
                    <!-- count required activities -->
                    <?php if ($steps->status->name == 'Published') : ?>
                        <?php $count++ ?>
                        
                            <div class="mt-4 text-lg border-2 border-bluegreen group-hover:border-bluegreen/80 rounded-lg flex justify-start">


                                <h3 class="text-2xl font-semibold flex-none items-start bg-bluegreen group-hover:bg-bluegreen/80 text-white basis-1/7 p-3">
                                    <?= $count ?>
                                </h3>
                                
                                
                
                                <div class="flex-1 basis-6/7 p-3">
                                    <h4 class="text-xl font-semibold mb-2">
                                        <a href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>/<?= $steps->id ?>/<?= $steps->slug ?>" class="group hover:no-underline">
                                            <?= h($steps->name) ?>
                                        </a>
                                    </h4>
                                   
                                        <p class="text-bluegreen font-semibold text-base mb-1">
                                            Step Activity Progress</p>
                                <!-- TODO step completed not showing correctly with 1 activity -->
                                    <script>
                                        fetch('/steps/status/<?= $steps->id ?>', {
                                                method: 'GET'
                                            })
                                            .then((res) => res.json())
                                            .then((json) => {
                                                if (json.steppercent > 0) {
                                                    let launched = json.stepclaimcount + ' launched';
                                                    let remaining = (json.requiredacts - json.stepclaimcount) + ' to go';

                                                    document.querySelector('.pbar_<?= h($steps->id) ?>').style.width = json.steppercent + '%';

                                                    if (json.steppercent == 100) {
                                                        document.querySelector('.pro_<?= h($steps->id) ?>').innerHTML = 'Step completed!';
                                                    } else if (json.steppercent < 20) {
                                                        document.querySelector('.pro_sm_<?= h($steps->id) ?>').innerHTML = launched;
                                                        document.querySelector('.total_<?= h($steps->id) ?>').innerHTML = remaining;
                                                    } else {
                                                        document.querySelector('.pro_<?= h($steps->id) ?>').innerHTML = launched;
                                                        document.querySelector('.total_<?= h($steps->id) ?>').innerHTML = remaining;
                                                    }

                                                } else {
                                                    document.querySelector('.pbarcontainer_<?= h($steps->id) ?>').innerHTML = '<span class="py-1 px-3 text-sm text-right flex-1">' + json.requiredacts + ' activities to go</span>';
                                                }
                                                //console.log(json);
                                            })
                                            .catch((err) => console.error("error:", err));
                                    </script>
                                    <div class="flex pbarcontainer_<?= h($steps->id) ?> mb-3 w-full bg-slate-200 rounded-lg content-center justify-start">
                                        <span class="py-1 px-3 bg-bluegreen text-white rounded-lg text-sm pbar_<?= h($steps->id) ?> pro_<?= h($steps->id) ?> flex-none"></span>
                                        <span class="py-1 px-1 text-sm pbar_<?= h($steps->id) ?> pro_sm_<?= h($steps->id) ?> flex-none"></span>
                                        <span class="py-1 px-3 text-sm total_<?= h($steps->id) ?> flex-1 text-right"></span>
                                    </div>
                                    <div class="mb-2"><p><span class="font-bold">Objective: </span><?= h($steps->description) ?></p></div>
                                    <p class="mb-2 text-sky-700 underline">
                                    <a href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>/<?= $steps->id ?>/<?= $steps->slug ?>" class="group hover:no-underline">
                                        View <strong><?= h($steps->name) ?></strong>
                                    </a>
                                    </p>


                                    <!-- <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                                    <span class="text-xs px-4 bg-slate-100/80 rounded-lg"><?= $steps->status->name ?></span>
                                <?php endif ?> -->
                                <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                                <?= $this->Form->control('steporder[]', ['class' => 'ml-2 bg-bluegreen group-hover:bg-bluegreen/80 text-white text-center rounded-lg', 'style' => 'width: 30px;', 'type' => 'text', 'value' => $count, 'label' => 'Sort order']) ?>
                                <?= $this->Form->control('steps[]', ['type' => 'hidden', 'value' => $count]) ?>
                                <?php endif ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                                
                                    <div class="mt-4 text-lg border-2 border-bluegreen group-hover:border-bluegreen/80 rounded-lg flex justify-start">

                                        <h3 class="text-2xl font-semibold flex-none items-start bg-bluegreen group-hover:bg-bluegreen/80 text-white basis-1/7 p-3">
                                            <?= $count ?>
                                        </h3>
                                        <div class="flex-1 basis-6/7 p-3">
                                            <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-1 text-sm align-middle" title="Edit to set to publish">DRAFT</span>
                                            <h4 class="text-xl font-semibold mb-2">
                                                <a href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>/<?= $steps->id ?>/<?= $steps->slug ?>" class="group hover:no-underline">
                                                    <?= h($steps->name) ?>
                                                </a>
                                            </h4>
                                            <p class="text-bluegreen font-semibold text-base mb-1">
                                            Step Activity Progress</p>
                                            <script>
                                                fetch('/steps/status/<?= $steps->id ?>', {
                                                        method: 'GET'
                                                    })
                                                    .then((res) => res.json())
                                                    .then((json) => {
                                                        if (json.steppercent > 0) {
                                                            let launched = json.stepclaimcount + ' launched';
                                                            let remaining = (json.requiredacts - json.stepclaimcount) + ' to go';

                                                            document.querySelector('.pbar_<?= h($steps->id) ?>').style.width = json.steppercent + '%';

                                                            if (json.steppercent == 100) {
                                                                document.querySelector('.pro_<?= h($steps->id) ?>').innerHTML = 'Step completed!';
                                                            }
                                                            if (json.steppercent < 20) {
                                                                document.querySelector('.pro_sm_<?= h($steps->id) ?>').innerHTML = launched;
                                                                document.querySelector('.total_<?= h($steps->id) ?>').innerHTML = remaining;
                                                            } else {
                                                                document.querySelector('.pro_<?= h($steps->id) ?>').innerHTML = launched;
                                                                document.querySelector('.total_<?= h($steps->id) ?>').innerHTML = remaining;
                                                            }

                                                        } else {
                                                            document.querySelector('.pbarcontainer_<?= h($steps->id) ?>').innerHTML = '<span class="py-1 px-3 text-sm text-right flex-1">' + json.requiredacts + ' activities to go</span>';
                                                        }
                                                        //console.log(json);
                                                    })
                                                    .catch((err) => console.error("error:", err));
                                            </script>
                                            <div class="flex pbarcontainer_<?= h($steps->id) ?> mb-3 w-full bg-slate-200 rounded-lg outline-slate-500 outline outline-1 outline-offset-2 content-center justify-start">
                                                <span class="py-1 px-3 bg-bluegreen text-white rounded-lg text-sm pbar_<?= h($steps->id) ?> pro_<?= h($steps->id) ?> flex-none"></span>
                                                <span class="py-1 px-1 text-sm pbar_<?= h($steps->id) ?> pro_sm_<?= h($steps->id) ?> flex-none"></span>
                                                <span class="py-1 px-3 text-sm total_<?= h($steps->id) ?> flex-1 text-right"></span>
                                            </div>
                                            <div class="mb-2"><?= h($steps->description) ?></div>
                                            <p class="mb-2 text-sky-700 underline">
                                            <a href="/topic/<?= $pathway->topic->slug ?>/<?= $pathway->id ?>/<?= $pathway->slug ?>/<?= $steps->id ?>/<?= $steps->slug ?>" class="group hover:no-underline">
                                                View <strong><?= h($steps->name) ?></strong>
                                            </a>
                                            </p>


                                            <!-- <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                                    <span class="text-xs px-4 bg-slate-100/80 rounded-lg"><?= $steps->status->name ?></span>
                                <?php endif ?> -->
                                <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                                <?= $this->Form->control('steporder[]', ['class' => 'ml-2 bg-bluegreen group-hover:bg-bluegreen/80 text-white text-center rounded-lg', 'style' => 'width: 30px;', 'type' => 'text', 'value' => $steps->_joinData->sortorder, 'label' => 'Sort order']) ?>
                                <?= $this->Form->control('steps[]', ['type' => 'hidden', 'value' => $steps->_joinData->id]) ?>
                                <?php endif ?>
                                        </div>

                                    </div>
                                <?php endif; // is curator 
                                ?>
                            <?php endif; // if published 
                            ?>
                        <?php endforeach ?>
                <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                <button class="mt-3 py-2 px-4 bg-bluegreen group-hover:bg-bluegreen/80 text-white rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up inline-block mr-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                </svg>Re-order Steps
                </button>
                <?= $this->Form->end(); ?>
                <?php endif ?>
        </div>


    </div>
</div>




<?php else : ?>
    <div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? 
?>

</div>
</div>
</div>
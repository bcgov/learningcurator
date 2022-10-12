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
<header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Pathways</h1>
    </div>
</header>
<div class="p-8 pt-4 w-full text-xl">

    <nav class="mb-4 text-sagedark text-sm" aria-label="breadcrumb">
        <a href="/category/<?= h($pathway->topic->categories[0]->id) ?>/<?= h($pathway->topic->categories[0]->slug) ?>" class="hover:underline"><?= h($pathway->topic->categories[0]->name) ?></a> >
        <a href="/category/<?= h($pathway->topic->categories[0]->id) ?>/<?= h($pathway->topic->categories[0]->slug) ?>/topic/<?= h($pathway->topic->id) ?>/<?= h($pathway->topic->slug) ?>" class="hover:underline"><?= h($pathway->topic->name) ?></a> >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost-2 mr-1 inline-block" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg><?= h($pathway->name) ?>
    </nav>





    <?php if ($role == 'curator' || $role == 'superuser') : ?>
        <div class="p-4 float-right">
            <?= $this->Html->link(__('Edit Pathway'), ['action' => 'edit', $pathway->id], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
        </div>

    <?php endif ?>
    <div class="max-w-prose">
    <div class="p-3 mb-3 mt-8 bg-bluegreen text-white  point-left flex justify-start items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 mx-3 grow-0" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg>
        <h2 class="text-2xl flex-1">
            <?= h($pathway->name) ?>
            <?php if ($pathway->status_id == 1) : ?>
                <span class="bg-orange-400 text-white rounded-full px-2 py-1 text-sm align-middle" title="Edit to set to publish">DRAFT</span>
            <?php endif ?>
        </h2>
        <span class="text-sm ml-3 justify-self-end flex-none">8 steps | 23 activities</span>
    </div>





    <div class="pl-10 text-lg">
        <p><span class="font-bold">Objective: </span>
        <?= $pathway->objective ?></p>
    </div>
</div>
<div class="mx-auto w-72 mt-3"><span class="pro px-3 py-1 bg-slate-50 dark:bg-slate-900/80 rounded-t-lg"></span></div>
<div class="flex pbarcontainer sticky top-0 mb-6 w-full h-8 bg-slate-50 dark:bg-black text-center rounded-lg">
    <span class="inline-block pbar pt-1 px-6 h-8 bg-sky-700 text-white rounded-lg"></span>
</div>
<script>
    fetch('/pathways/status/<?= $pathway->id ?>', {
            method: 'GET'
        })
        .then((res) => res.json())
        .then((json) => {
            if (json.percentage > 0) {
                let message = json.completed + ' of ' + json.requiredacts + ' launched';

                document.querySelector('.pbar').style.width = json.percentage + '%';

                if (json.percentage == 100) {
                    document.querySelector('.pro').innerHTML = message + ' - COMPLETED!';
                } else {
                    document.querySelector('.pro').innerHTML = message;
                    document.querySelector('.pbar').innerHTML = json.percentage + '%';
                }

            } else {
                document.querySelector('.pbarcontainer').innerHTML = ''; //'<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>';
            }
            //console.log(json);
        })
        .catch((err) => console.error("error:", err));
</script>




<?php if ($role == 'curator' || $role == 'superuser') : ?>

    <div x-data="{ open: false }">
        <button @click="open = ! open" class="float-right inline-block p-3 mb-1 ml-3 bg-slate-200 dark:bg-black dark:text-white hover:no-underline rounded-lg">
            Add a Step
        </button>
        <div xcloak x-show="open" class="p-6 my-3 rounded-lg bg-white dark:bg-slate-800 dark:text-white">

            <?= $this->Form->create(null, ['url' => [
                'controller' => 'Steps',
                'action' => 'add'
            ]]) ?>
            <?php
            echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 dark:text-white dark:bg-slate-900/80 rounded-lg']);
            echo $this->Form->control('description', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 dark:text-white dark:bg-slate-900/80 rounded-lg', 'type' => 'textarea', 'label' => 'Objective']);
            echo $this->Form->hidden('createdby', ['value' => $uid]);
            echo $this->Form->hidden('modifiedby', ['value' => $uid]);
            echo $this->Form->hidden('pathways.0.id', ['value' => $pathway->id]);
            ?>
            <?= $this->Form->button(__('Add Step'), ['class' => 'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>


<?php endif ?>


<h2 class="text-3xl p-6 my-3 rounded-lg bg-white/80 dark:bg-slate-900/80 dark:text-white">
    <span class="inline-block px-2 bg-slate-500 dark:bg-black text-white rounded-full">
        <?= $stepcount ?>
    </span>
    steps along this pathway
    <span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-sm rounded-full">
        <?= $requiredacts ?> required activities</span>
</h2>





<?php if (!empty($pathway->steps)) : ?>
    <?php foreach ($pathway->steps as $steps) : ?>
        <?php $requiredacts = 0; ?>
        <?php foreach ($steps->activities as $act) : ?>
            <?php if ($act->_joinData->required == 1) $requiredacts++; ?>
        <?php endforeach ?>

        <?php //echo '<pre>'; print_r($steps); continue; 
        ?>
        <?php if ($steps->status->name == 'Published') : ?>
            <div class="p-6 my-3 rounded-lg bg-white/80 dark:bg-slate-900/80 dark:text-white">
                <h3 class="text-2xl">
                    <a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= $pathway->topic->slug ?>/pathway/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
                        <?= h($steps->name) ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </a>
                    <?php if ($role == 'curator' || $role == 'superuser') : ?>
                        <span class="text-xs px-4 bg-slate-100/80 dark:bg-emerald-700 rounded-lg"><?= $steps->status->name ?></span>
                    <?php endif ?>
                    <span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-xs rounded-full">
                        <?= $requiredacts ?> activities
                    </span>
                </h3>


                <div class="mt-3 p-3 bg-white dark:bg-slate-800 text-xl rounded-lg">
                    <?= $steps->description ?>
                </div>


                <div class="steppbarcontainer<?= $steps->id ?> sticky top-0 my-1 w-full h-8 bg-slate-50 dark:bg-slate-900/80 rounded-lg">
                    <span class="inline-block pbar<?= $steps->id ?> pt-1 px-6 h-8 bg-sky-700 text-white rounded-lg"></span>
                </div>
                <script>
                    fetch('/steps/status/<?= $steps->id ?>', {
                            method: 'GET'
                        })
                        .then((res<?= $steps->id ?>) => res<?= $steps->id ?>.json())
                        .then((json<?= $steps->id ?>) => {
                            if (json<?= $steps->id ?>.steppercent > 0) {
                                let message = json<?= $steps->id ?>.steppercent + '% - ' + json<?= $steps->id ?>.stepclaimcount + ' of ' + json<?= $steps->id ?>.requiredacts;
                                if (json<?= $steps->id ?>.steppercent > 25) {
                                    document.querySelector('.pbar<?= $steps->id ?>').style.width = json<?= $steps->id ?>.steppercent + '%';
                                }
                                if (json<?= $steps->id ?>.steppercent == 100) {
                                    document.querySelector('.pbar<?= $steps->id ?>').innerHTML = message + ' - COMPLETED!';
                                } else {
                                    document.querySelector('.pbar<?= $steps->id ?>').innerHTML = message;
                                }
                            } else {
                                document.querySelector('.steppbarcontainer<?= $steps->id ?>').innerHTML = ''; //<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>
                            }
                            //console.log(json);
                        })
                        .catch((err) => console.error("error:", err));
                </script>


                <a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= $pathway->topic->slug ?>/pathway/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>" class="inline-block p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                    View Step
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                    </svg>
                </a>
            </div>
        <?php else : ?>
            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                <div class="p-6 my-3 rounded-lg bg-white dark:bg-slate-900/80 dark:text-white">
                    <h3 class="text-2xl">
                        <a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
                            <?= h($steps->name) ?>
                        </a>
                        <?php if ($role == 'curator' || $role == 'superuser') : ?>

                            <span class="text-xs px-4  bg-yellow-700 text-white rounded-lg"><?= $steps->status->name ?></span>

                        <?php endif ?>
                        <span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-xs rounded-full">
                            <?= $requiredacts ?> activities
                        </span>
                    </h3>


                    <div class="my-3 p-3 bg-slate-100/80 dark:bg-[#002850] text-xl rounded-lg">
                        <?= $steps->description ?>
                    </div>

                    <a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>" class="inline-block p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                        View Draft Step
                    </a>

                    <a href="/steps/publishtoggle/<?= $steps->id ?>">Publish Step</a>
                </div>
            <?php endif; // if curator or admin 
            ?>
        <?php endif; // if published 
        ?>

    <?php endforeach ?>
<?php else : ?>
    <div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? 
?>
</div>
</div>
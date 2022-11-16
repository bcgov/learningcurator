<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Your Contributions');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>


<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <!-- TODO Allan/Nori add created date? -->
    <!-- created/modified on each of the db tables -->
    <h2 class="text-2xl text-darkblue font-semibold"><?= __('My Contributions') ?></h2>
    <h3 class="mt-4 font-semibold text-xl">My Pathways</h3>
    <div class="max-w-prose">
        <?php if (!$pathways->all()->isEmpty()) : ?>
            <?php foreach ($pathways as $pathway) : ?>

                <a href="/pathways/<?= h($pathway->slug) ?>" class="hover:no-underline">

                    <div class="pl-2 pr-3 py-2 mt-3 mb-8 bg-bluegreen text-white  hover:bg-bluegreen/80  w-full rounded-l-full flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-3 flex-none" viewBox="0 0 16 16">
                            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                        </svg>
                        <h3 class="text-2xl flex-1">
                            <?= h($pathway->name) ?>
                        </h3>
                        <?php if ($pathway->status_id == 1) : ?>
                            <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-1 text-sm" title="Edit to set to publish">DRAFT</span>
                        <?php endif ?>
                        <?php if ($pathway->featured == 1) : ?>
                            <span class="bg-green-500 text-slate-900 rounded-full px-2 py-1 text-sm">Featured</span>
                        <?php endif ?>
                        <!-- <span class="text-sm justify-self-end flex-none">8 steps | 23 activities</span> -->
                    </div>
                </a>
                <div class="pl-10">
                    <div class="flex justify-end items-center text-xs text-slate-500 mt-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag inline-block mr-1" viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                        <?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id], ['class' => '']) ?>
                        <!-- TODO Nori Allan add code to link category as well as topic -->
                    </div>
                    <p class="mb-3"><?php if (!empty($pathway->description)) : ?>
                            <?= $pathway->description ?>
                        <?php else : ?>
                            <?= $pathway->objective ?>
                        <?php endif ?></p>
                    <!-- This conditional is kind of a hack and we need to make people aware that the description isn't actually optional -->
                    <p class="mb-4"> <a href="/pathways/<?= h($pathway->slug) ?>" class="text-sky-700 underline">
                            View the <strong><?= h($pathway->name) ?></strong> pathway
                        </a> </p>
                </div>

            <?php endforeach; ?>





            <!-- TODO Allan require curators to enter descriptions and have a minimum/maximum length of 130 chars/ 325 chars (2 lines prose length/5 lines prose length) -->


        <?php else : ?>
            <div class="mt-2">
                <p>No pathways contributed yet.</p>
                <a class="px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg inline-block" href="/pathways/add">Add a Pathway</a>
            </div>
        <?php endif ?>
    </div>

    <h3 class="mt-8 font-semibold text-xl">My Activities</h3>
    <?php if (!$activities->all()->isEmpty()) : ?>
        <div class="lg:columns-2 gap-4">
            <?php foreach ($activities as $a) : ?>
                <div class="w-full inline-block mb-4 p-0.5 mt-2 rounded-md bg-sagedark hover:bg-sagedark/80 ">
                    <div class="flex flex-row justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-journal-text mx-3 my-4 flex-none" viewBox="0 0 16 16">
                            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                        </svg>
                        <!-- TODO Allan Change icon for activity based on activity type -->
                        <div class="bg-white inset-1 rounded-r-sm flex-1">
                            <div class="p-3 text-lg">

                                <?php if ($a->status->name == 'Draft') : ?>
                                    <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-0.5 text-sm float-right" title="Edit to set to publish">DRAFT</span>
                                <?php endif ?>
                                <h4 class="mb-3 mt-1 text-xl font-semibold">
                                    <a href="/activities/view/<?= $a->id ?>"><?= h($a->name) ?></a>
                                </h4>
                                <!-- TODO Nori/Allan add created/modified date? -->
                                <div class="">
                                    <?php if (!empty($a->description)) : ?>
                                        <?= $a->description ?>

                                    <?php else : ?>
                                        <p><em>No description provided&hellip;</em></p>
                                    <?php endif ?>
                                </div>

                                <?php if (!empty($a->_joinData->stepcontext)) : ?>
                                    <div class="text-sm italic mt-2">
                                        Curator says:
                                        <blockquote class="border-l-2 p-2 m-2"><?= $a->_joinData->stepcontext ?></blockquote>
                                    </div><?php endif ?>

                                

                                <?php if (!empty($a->steps)) : ?> in <?php endif ?>
                                <?php foreach ($a->steps as $step) : ?>
                                    <?php if (!empty($step->pathways[0]->slug)) : ?>
                                        <a href="/pathways/<?= h($step->pathways[0]->slug) ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
                                            <?= h($step->pathways[0]->name) ?> - <?= h($step->name) ?>
                                        </a>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
                <?php else : ?>
                    <div class="mt-2">
                        <p>No activities contributed yet.</p>
                        <a class="px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg inline-block" href="/activities/add">Add an Activity</a>
                    </div>
                <?php endif ?>
                </div>


        </div>
</div>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/1200w/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed_1200w.jpg);">
    <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">My Curator</h1>
    </div>
</header>
<div class="p-8 text-lg" id="mainContent">
    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">Issues Reported</h2>

        <p class="mb-3">
            You can file reports against any activity. You might find a dead link, or encounter a licensing issue; if you do, you can click the report button and tell us what's wrong.</p>

        <?php if (!$reports->all()->isEmpty()) : ?>

            <?php foreach ($reports as $report) : ?>
                <div class="border-2 border-slate-700 mb-3 rounded-md">
                    <div class="flex justify-between gap-4 items-center bg-slate-700 text-white p-2"> <span class="ml-2 font-semibold">Issue report #<?= $report->id ?></span>
                        <span class="text-sm"><?= $this->Time->format($report->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></span>
                    </div>
                    <div class="p-3">
                        <div class="text-xl"><span class="font-semibold">Activity Reported:</span> <a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></div>
                        <div class="text-sm italic mt-2">You said:</div>
                        <blockquote class="border-l-2 p-2 m-2">
                            <?= h($report->issue) ?>
                        </blockquote>
                        <?php if (!empty($report->response)) : ?>
                            <div class="text-sm italic mt-2">Curator Response:</div>
                            <blockquote class="border-l-2 p-2 m-2"><?= h($report->response) ?></blockquote>
                        <?php else : ?>
                            <div class="italic text-slate-700 mt-2">Thank you for your report! A Curator will respond to your message soon.</div>
                        <?php endif ?>


                        <?php if ($role == 'curator' || $role == 'superuser') : ?>


                            <div x-data="{ open: false }">
                                <button @click="open = ! open" class="inline-block px-4 py-2 text-md text-white bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg my-3">
                                    Respond
                                </button>
                                <div xcloak x-show="open" class="p-3 my-3 rounded-lg bg-slate-200 font-semibold ">

                                    <?= $this->Form->create(null, ['url' => ['controller' => 'reports', 'action' => 'edit', $report->id]]) ?>
                                    <fieldset>
                                        <legend><?= __('Curator Response') ?></legend>
                                        <?php
                                        echo $this->Form->hidden('id', ['value' => $report->id]);
                                        echo $this->Form->hidden('curator_id', ['value' =>  $this->Identity->get('id')]);
                                        echo $this->Form->textarea('response', ['class' => 'block w-full px-3 py-1 my-2 rounded-lg font-light', 'placeholder' => 'Type here ...']);
                                        ?>
                                    </fieldset>
                                    <input type="submit" class="inline-block px-4 py-2 text-md text-white bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg my-3 font-normal hover:cursor-pointer" value="Submit Response">
                                    <?= $this->Form->end() ?>

                                </div>
                            </div>
                        <?php endif ?>
                        <?= $this->Form->postLink(__('Delete Issue Report'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'inline-block my-2 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base']) ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="flex justify-between gap-4 border-2 p-3 rounded-md my-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle-fill flex-none" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </svg>
                <div class="grow">
                    <h3 class="mb-3 text-xl font-semibold">No reports filed yet</h3>
                    <p class="mb-2">
                        When you report an issue with an activity, it will be listed here.
                    </p>
                </div>
            </div>

            <a href="/categories" class="inline-block p-3 mt-4 mr-4 bg-sagedark text-white text-xl hover:no-underline rounded-lg">
                Explore Categories
            </a>
            <a href="/pathways" class="inline-block p-3 mt-4 bg-darkblue text-white text-xl hover:no-underline rounded-lg">
                Explore Pathways
            </a>
        <?php endif ?>
    </div>
</div>
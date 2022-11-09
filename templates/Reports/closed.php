<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">

    <h2 class="text-2xl text-darkblue font-semibold mb-3">All Closed Reports <span class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal"> <a href="/reports">View All Open Reports</a></span></h2>
    <div class="max-w-prose">
        <?php if (!empty($reports)) : ?>
            <?php foreach ($reports as $report) : ?>
                <div class="border-2 border-slate-700 mb-3 rounded-md">
                    <div class="flex justify-between gap-4 items-center bg-slate-700 text-white p-2"> <span class="ml-2 font-semibold">Issue report #<?= $report->id ?></span>
                        <span class="text-sm"><?= $this->Time->format($report->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></span>
                    </div>
                    <div class="p-3">
                        <div class="text-xl"><span class="font-semibold">Activity Reported:</span> <a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></div>
                        <div class="text-sm italic mt-2">User said:</div>
                        <blockquote class="border-l-2 p-2 m-2">
                            <?= h($report->issue) ?>
                        </blockquote>
                        <?php if (!empty($report->response)) : ?>
                            <div class="text-sm italic mt-2">Curator Response:</div>
                            <blockquote class="border-l-2 p-2 m-2"><?= h($report->response) ?></blockquote>
                        <?php else : ?>
                            <div class="font-semibold text-slate-900 mt-2">No response yet.</div>
                        <?php endif ?>

                        <?php if ($this->Identity->get('role') == 'curator' || $this->Identity->get('role') == 'superuser') : ?>


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
        <?php endif ?>

    </div>
</div>
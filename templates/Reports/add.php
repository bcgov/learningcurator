<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report $report
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <!-- TODO delete this page eventually -->
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Issue Report
        <span class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal"><?= $this->Html->link(__('View All Open Reports'), ['action' => 'index']) ?></span>
    </h2>
    <div class="border-2 border-slate-700 mb-3 rounded-md max-w-[70ch]">
        <h3 class="flex justify-between gap-4 items-center bg-slate-700 text-white p-2"> <span class="ml-2 font-semibold">Issue report
        </h3>
        <div class="px-4 py-3">
            <?= $this->Form->create($report) ?>
            <fieldset>
                <div class="mt-2"><?php echo $this->Form->control('activity_id', ['options' => $activities, 'class' => 'form-field max-w-prose text-base']);  ?></div>
                <div class="mt-2"><?php echo $this->Form->control('user_id', ['class' => 'form-field max-w-prose text-base']);  ?></div>
                <div class="mt-2"><?php echo $this->Form->control('issue', ['class' => 'form-field max-w-prose text-base']); ?></div>
                <div class="mt-2"><?php echo $this->Form->control('curator_id', ['options' => $users, 'empty' => true, 'class' => 'form-field max-w-prose text-base']); ?></div>
                <div class="mt-2"><?php echo $this->Form->control('response', ['class' => 'form-field max-w-prose text-base']); ?></div>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'inline-block px-4 py-2 text-md text-white bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80 hover:no-underline rounded-lg my-3 font-normal hover:cursor-pointer']) ?>
            <?= $this->Form->postLink(__('Delete Issue Report'), ['action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?'), 'class' => 'block my-2 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
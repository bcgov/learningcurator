<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Activity Type: <span class="text-slate-900"><a href="/activity-types/view/<?= $activityType->id ?>">
                <?= h($activityType->name) ?></a>
        </span> <a href="/activity-types/" class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal">View all Activity Types</a></h2>
    <div class="max-w-prose">
        <div class="border border-slate-500 p-6 my-3 rounded-md block">

            <?= $this->Form->create($activityType) ?>
            <fieldset>
                <?php
                echo $this->Form->control('name', ['class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('slug', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('description', ['class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('color', ['class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('delivery_method', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('image_path', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('featured', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('createdby', ['label' => 'Created By', 'class' => 'form-field text-base mb-3']);
                echo $this->Form->control('modifiedby', ['label' => 'Modified By', 'class' => 'form-field text-base mb-3']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Save Activity Type'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>
            <?= $this->Form->postLink(
                __('Delete Activity Type'),
                ['action' => 'delete', $activityType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activityType->id), 'class' => 'block my-2 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base']
            ) ?>
        </div>
    </div>
</div>
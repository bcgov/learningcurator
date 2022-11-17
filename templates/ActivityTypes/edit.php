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
        </span></h2>
    <div class="max-w-prose">
        <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
            <div class="row">
                <aside class="column">
                    <div class="side-nav">
                        <h4 class="heading"><?= __('Actions') ?></h4>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $activityType->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?', $activityType->id), 'class' => 'side-nav-item']
                        ) ?>
                        <?= $this->Html->link(__('List Activity Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    </div>
                </aside>
                <div class="column-responsive column-80">
                    <div class="activityTypes form content">
                        <?= $this->Form->create($activityType) ?>
                        <fieldset>
                            <legend><?= __('Edit Activity Type') ?></legend>
                            <?php
                            echo $this->Form->control('name');
                            echo $this->Form->control('slug');
                            echo $this->Form->control('description');
                            echo $this->Form->control('color');
                            echo $this->Form->control('delivery_method');
                            echo $this->Form->control('image_path');
                            echo $this->Form->control('featured');
                            echo $this->Form->control('createdby');
                            echo $this->Form->control('modifiedby');
                            ?>
                        </fieldset>
                        <?= $this->Form->button(__('Submit')) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
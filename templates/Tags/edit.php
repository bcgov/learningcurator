<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Tag: <span class="text-slate-900"><?= h($tag->name) ?></span> <?= $this->Html->link(__('View All Tags'), ['action' => 'index'], ['class' => 'inline-block ml-2 text-sky-700 hover:underline text-base font-normal']) ?></h2>
    <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block max-w-prose">
        <?= $this->Form->create($tag) ?>
        <fieldset>
            <?php
            echo $this->Form->control('name', ['class' => 'form-field text-base mb-3']);
            echo $this->Form->control('slug', ['class' => 'form-field text-base mb-3']);
            echo $this->Form->control('description', ['class' => 'form-field text-base mb-3']);
           // echo $this->Form->control('createdby', ['class' => 'form-field text-base mb-3', 'label' => 'Created By']);
        //    echo $this->Form->control('modifiedby', ['class' => 'form-field text-base mb-3', 'label' => 'Modified By']);
           // echo $this->Form->control('activities._ids', ['options' => $activities, 'class' => 'form-field text-base mb-3']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
        <?= $this->Form->postLink(
            __('Delete Tag'),
            ['action' => 'delete', $tag->id],
            ['confirm' => __('Are you sure you want to delete tag #{0}?', $tag->id), 'class' => 'inline-block my-2 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base']
        ) ?>
    </div>
</div>
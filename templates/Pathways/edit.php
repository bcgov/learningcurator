<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Pathway: <span class="text-slate-900"><a href="/pathways/<?= $pathway->slug ?>">
                <?= $pathway->name ?>
            </a></span></h2>
    <div class="max-w-prose">
        <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">


            <!-- <a href="/pathways/<?= $pathway->slug ?>/export" class="float-right ml-3 p-3 bg-slate-100/80 dark:bg-black hover:no-underline rounded-lg">Export Pathway</a> -->

            <?= $this->Form->create($pathway) ?>

            <label><?php echo $this->Form->checkbox('featured'); ?> Featured?</label>

            <?php echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);

            echo $this->Form->control('status_id', ['type' => 'select', 'options' => $statuses, 'class' => 'form-field mb-3']);
            echo $this->Form->control('createdby', ['type' => 'select', 'options' => $users, 'class' => 'form-field mb-3', 'label' => 'Created By']) ?>
            <?php echo $this->Form->control('topic_id', ['type' => 'select', 'options' => $areas, 'class' => 'form-field mb-3', 'label' => 'Topic']); ?>
            <?php
            echo $this->Form->control('name', ['class' => 'form-field mb-3']);
            //echo $this->Form->control('slug', ['class' => 'form-field mb-3']);
            echo $this->Form->control('description', ['class' => 'form-field mb-3']) ?>
            <?php // echo $this->Form->control('estimated_time', ['class' => 'form-field mb-3']);
            echo $this->Form->control('objective', ['class' => 'form-field mb-3']);
            //  echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true, 'class' => 'form-field mb-3']);
            //echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true, 'class' => 'form-field mb-3']);
            //echo $this->Form->control('color');
            //echo $this->Form->control('file_path', ['class' => 'form-field mb-3','label' => 'Import history']);
            //echo $this->Form->control('image_path');
            //echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
            //echo $this->Form->control('competencies._ids', ['options' => $competencies]);
            ?>
            <?php if (!empty($pathway->file_path)) : ?>
                <div class="form-field mb-3"><?= $pathway->file_path ?></div>
            <?php endif ?>
            <?= $this->Form->button(__('Save Pathway'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>
            <?= $this->Form->postLink(__('Delete Pathway'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'inline-block mt-3 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base']) ?>
        </div>
    </div>
</div>
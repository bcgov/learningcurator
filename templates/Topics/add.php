<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Topic</h2>
    <div class="max-w-prose border border-slate-500 p-6 my-3 rounded-md block">

        <?= $this->Form->create($topic) ?>
        <fieldset>

            <label>Published? <?= $this->Form->checkbox('featured', ['class' => 'inline-block mb-5']); ?></label>
            <?php
            echo $this->Form->control('categories._ids[]', ['type' => 'hidden','value' => 1]);
            echo $this->Form->control('name', ['class' => 'form-field mb-3', 'label' => 'Topic Name']);
            //echo $this->Form->hidden('slug');?>
            <label for="description">Topic Description</label>
            <span class="text-slate-600 block mt-0 text-sm" id="descriptionHelp"><i class="bi bi-info-circle"></i> A brief description of the topic within the category (1&nbsp;to&nbsp;2&nbsp;sentences).</span>
           <?php echo $this->Form->textarea('description', ['class' => 'form-field', 'aria-describedby' => 'descriptionHelp']); ?>
          
           <?php //echo $this->Form->control('image_path');
            //echo $this->Form->control('color');

            //echo $this->Form->control('user_id', ['options' => $users]);

            ?>
        </fieldset>
        <?= $this->Form->button(__('Add Topic'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>

    </div>
</div>
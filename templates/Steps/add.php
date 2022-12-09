<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<!-- TODO delete this page eventually - added from pathway index -->
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Step <span class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal"><?= $this->Html->link(__('List Steps'), ['action' => 'index']) ?></span></h2>
    <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block max-w-[70ch]">

        <?= $this->Form->create($step) ?>
        <fieldset>


        <label for="name">Step Title</label>
            <span class="text-slate-600 block mb-1 text-sm" id="nameHelp"><i class="bi bi-info-circle"></i> If your step has a title, include it here (or leave it as a number). </span>   
        <?php echo $this->Form->input('name', ['class' => 'form-field max-w-prose', 'type' => 'text', 'aria-describedby' => 'nameHelp']);  ?>
            
            <div class="mt-2"><?php echo $this->Form->control('slug', ['class' => 'form-field  max-w-prose']); ?></div>
            <label for="description">Step Objective</label>
            <span class="text-slate-600 block mb-1 text-sm" id="descriptionHelp"><i class="bi bi-info-circle"></i> What measurable target is the learner working towards at this step specifically? Imagine it beginning “At the completion of this step, learners will be able to…” (1 phrase/sentence).</span>
           <?php echo $this->Form->textarea('description', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg', 'aria-describedby' => 'descriptionHelp']); ?>
            <div class="mt-2"><?php // echo $this->Form->control('image_path', ['class' => 'form-field max-w-prose']); 
                                ?></div>
            <div class="mt-2"><?php echo $this->Form->control('featured', ['class' => 'form-field max-w-prose']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('createdby', ['class' => 'form-field max-w-prose', 'label' => 'Created By']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('modifiedby', ['class' => 'form-field max-w-prose', 'label' => 'Modified By']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('activities._ids', ['options' => $activities, 'class' => 'form-field max-w-prose text-base']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('pathways._ids', ['options' => $pathways, 'class' => 'form-field max-w-prose text-base']); ?> </div>

        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
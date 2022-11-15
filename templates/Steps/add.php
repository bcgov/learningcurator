<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Step <span class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal"><?= $this->Html->link(__('List Steps'), ['action' => 'index']) ?></span></h2>
    <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block max-w-[70ch]">

        <?= $this->Form->create($step) ?>
        <fieldset>


            <?php echo $this->Form->control('name', ['class' => 'form-field max-w-prose']);  ?>
            <div class="mt-2"><?php echo $this->Form->control('slug', ['class' => 'form-field  max-w-prose']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('description', ['class' => 'form-field max-w-prose']); ?></div>
            <div class="mt-2"><?php // echo $this->Form->control('image_path', ['class' => 'form-field max-w-prose']); 
                                ?></div>
            <div class="mt-2"><?php echo $this->Form->control('featured', ['class' => 'form-field max-w-prose']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('createdby', ['class' => 'form-field max-w-prose', 'label' => 'Created By']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('modifiedby', ['class' => 'form-field max-w-prose', 'label' => 'Modified By']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('activities._ids', ['options' => $activities, 'class' => 'form-field max-w-prose text-base']); ?></div>
            <div class="mt-2"><?php echo $this->Form->control('pathways._ids', ['options' => $pathways, 'class' => 'form-field max-w-prose text-base']); ?> </div>

        </fieldset>
        <!-- TODO Q do curators fill in the Created/Modified fields or does that come in automatically? -->
        <?= $this->Form->button(__('Submit'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
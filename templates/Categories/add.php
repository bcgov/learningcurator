<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Category</h2>
    <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
        <?= $this->Form->create($category) ?>
        <fieldset>
            <?php
            echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
            echo $this->Form->control('description', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
            //echo $this->Form->control('image_path');
            //echo $this->Form->control('color');
            //echo $this->Form->control('featured');
            echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Add New Category'), ['class' => 'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
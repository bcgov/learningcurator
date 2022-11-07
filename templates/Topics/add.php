<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 lg:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Topic</h2>
    <div class="max-w-prose outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">

        <?= $this->Form->create($topic) ?>
        <fieldset>

            <label>Published? <?= $this->Form->checkbox('featured', ['class' => 'inline-block mb-5']); ?></label>
            <?php
            echo $this->Form->control('categories._ids[]', ['type' => 'select', 'options' => $categories, 'class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3 border text-base', 'label' => 'Category']);
            echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
            //echo $this->Form->hidden('slug');
            echo $this->Form->control('description', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg']);
            //echo $this->Form->control('image_path');
            //echo $this->Form->control('color');

            //echo $this->Form->control('user_id', ['options' => $users]);

            ?>
        </fieldset>
        <?= $this->Form->button(__('Add Topic'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>

    </div>
</div>
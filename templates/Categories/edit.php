<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Category: <span class="text-slate-900"><a href="/categories/view/<?= $category->id ?>">
                <?= h($category->name) ?>
            </a></span></h2>
    <div class="max-w-prose">
        <div class="border border-slate-500 p-6 my-3 rounded-md block">
            <?= $this->Form->create($category) ?>
            <fieldset>
                <label class="mb-3 inline-block">Published? <?= $this->Form->checkbox('featured') ?></label>
                <?php
                //echo $this->Form->control('topics._ids', ['options' => $topics]);
                echo $this->Form->control('name', ['class' => 'form-field mb-3', 'label' => 'Category Name']);
                //echo $this->Form->control('slug');
                echo $this->Form->control('description', ['class' => 'form-field mb-3', 'label' => 'Category Description']);
                //echo $this->Form->control('image_path', ['class' => 'form-field mb-3']);
                echo $this->Form->control('sortorder', ['class' => 'form-field mb-3', 'label' => 'Sort Order']);
                // echo $this->Form->control('color');
                //echo $this->Form->control('createdby');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Update Category'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
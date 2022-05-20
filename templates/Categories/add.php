<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">

    <h1 class="text-2xl">
        Add Category
    </h1>

    

<div class="mt-5 p-5 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg shadow-sm">

<?= $this->Form->create($category) ?>
<fieldset>

<?php
echo $this->Form->control('name',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('description',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('image_path');
//echo $this->Form->control('color');
//echo $this->Form->control('featured');
echo $this->Form->hidden('createdby',['value' => $this->Identity->get('id')]);
?>
</fieldset>
<?= $this->Form->button(__('Add New Category'),['class' => 'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>
</div>
</div>

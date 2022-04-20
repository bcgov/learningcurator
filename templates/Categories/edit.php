<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">

<div class="p-3 bg-slate-200 dark:bg-slate-900 rounded-lg">
<?php if($this->Identity->get('role') == 'superuser'): ?>
<div class="float-right mt-5">
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Really delete?'), 'class' => 'inline-block my-2 p-3 bg-red-600 hover:bg-red-800 rounded-lg font-semibold text-white hover:no-underline']) ?>
</div>
<?php endif ?>


<h1 class="text-3xl">
    Editing <?= h($category->name) ?>
</h1>
<a class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline" 
    href="/categories/view/<?= $category->id ?>">
        View <?= h($category->name) ?>
</a>

<?= $this->Form->create($category) ?>
<fieldset>
<label>Published?
<?= $this->Form->checkbox('featured') ?>
</label>
<?php
//echo $this->Form->control('topics._ids', ['options' => $topics]);
echo $this->Form->control('name',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('slug');
echo $this->Form->control('description',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
// echo $this->Form->control('image_path');
echo $this->Form->control('sortorder',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
// echo $this->Form->control('color');

//echo $this->Form->control('createdby');

?>
</fieldset>
<?= $this->Form->button(__('Update Category'),['class' => 'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>
</div>
</div>

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

    

<div class="mt-5 p-5 bg-white dark:bg-slate-900 rounded-lg shadow-sm">

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
<?= $this->Form->button(__('Add New Category'),['class' => 'inline-block my-2 p-3 bg-sky-600 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
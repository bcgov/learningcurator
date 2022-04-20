<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">

    <h1 class="text-3xl my-5">
        Add Topic
    </h1>

<div class="mt-5 p-5 bg-slate-100 dark:bg-slate-900 rounded-lg">

<?= $this->Form->create($topic) ?>
<fieldset>

<label>Published? <?= $this->Form->checkbox('featured'); ?></label>
<?php
echo $this->Form->control('categories._ids[]', ['type' => 'select','options' => $categories, 'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'label' => 'Category']);
echo $this->Form->control('name',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
//echo $this->Form->hidden('slug');
echo $this->Form->control('description',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('image_path');
//echo $this->Form->control('color');

//echo $this->Form->control('user_id', ['options' => $users]);

?>
</fieldset>
<?= $this->Form->button(__('Add Topic'),['class' => 'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>

</div>
</div>

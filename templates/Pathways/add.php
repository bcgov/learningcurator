<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">
<div class="mt-5 p-5 bg-white dark:bg-slate-900 rounded-lg">
<?= $this->Form->create($pathway) ?>
<fieldset>
<legend><?= __('Add Pathway') ?></legend>
<div>
<label>Topic:
<?php echo $this->Form->select(
                            'topic_id',
                            $areas,
                            ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg'],
                            );
?></label>
</div>
<?php 
echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]); 
//echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true,'class'=>'form-control']);
//echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true,'class'=>'form-control']);
echo $this->Form->control('name',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('description',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('objective',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('estimated_time', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->hidden('status_id',['value' => 1]);
//echo $this->Form->control('color');
//echo $this->Form->control('file_path');
//echo $this->Form->control('image_path');
//echo $this->Form->control('featured');
//echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
//echo $this->Form->control('competencies._ids', ['options' => $competencies]);
//echo $this->Form->control('steps._ids', ['options' => $steps]);
//echo $this->Form->control('users._ids', ['options' => $users]);
?>
</fieldset>
<?= $this->Form->button(__('Add new pathway'),['class' => 'inline-block my-2 p-3 bg-sky-600 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>
</div>
</div>

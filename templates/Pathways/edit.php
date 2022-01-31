<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>

<div class="p-6 dark:text-white">
<div class="p-6 bg-slate-200 dark:bg-slate-900 rounded-lg">

<?= $this->Form->create($pathway) ?>

<label><?php echo $this->Form->checkbox('featured'); ?> Featured?</label>

<?php echo $this->Form->hidden('modifiedby',['value' => $this->Identity->get('id')]) ?>


<?php echo $this->Form->control('status_id', ['type' => 'select', 'options' => $statuses, 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>


<?php echo $this->Form->control('createdby', ['type' => 'select', 'options' => $users, 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>


<div>
<label>Topic:
<?php echo $this->Form->select(
    'topic_id',
    $areas,
	['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg'],
);
?></label>
</div>
<?php
echo $this->Form->control('name', ['class' => 'w-full p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('slug', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('description', ['class' => 'w-full p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('estimated_time', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('objective', ['class' => 'w-full p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true, 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true, 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
//echo $this->Form->control('color');
//echo $this->Form->control('file_path');
//echo $this->Form->control('image_path');
//echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
//echo $this->Form->control('competencies._ids', ['options' => $competencies]);
?>
<?= $this->Form->button(__('Save Pathway'), ['class' => 'btn btn-block btn-success mt-3']) ?>
<?= $this->Form->end() ?>
</div>
</div>

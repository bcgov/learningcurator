<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */

$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">
<div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-lg">

<?= $this->Form->create($activity) ?>
<?php 
// echo $this->Form->control('ministry_id', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'options' => $ministries, 'empty' => true]);
// echo $this->Form->control('approvedby_id', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
//echo $this->Form->hidden('createdby_id', ['value' => $activity->createdby_id, 'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
?>

<h1 class="text-3xl">
Editing <a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
</h1>
<!-- <div class="alert alert-light"><em><?= $activity->slug ?></em></div> -->
<a href="/activities/view/<?= $activity->id ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
    View Activity
</a>

<?php echo $this->Form->control('status_id', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'options' => $statuses, 'empty' => true]); ?>
<?php echo $this->Form->control('featured', ['type' => 'checkbox', 'class' => '']); ?>

<?php echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 text-2xl rounded-lg']); ?>
<?php echo $this->Form->control('hyperlink', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
<?php echo $this->Form->control('description', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
<?php echo $this->Form->control('createdby_id', ['type' => 'select', 'options' => $users, 'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'label' => 'Curated By']) ?>

<?php echo $this->Form->control('activity_types_id', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'options' => $activityTypes]); ?>

<?php //echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
<label>Estimated Time
<select name="estimated_time" id="estimated_time_id" class="block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg">
<?php
$options = array(
'Under 5 mins',
'Under 10 mins', 
'Under 15 mins', 
'Under 20 mins',
'Under 10 mins',
'Under 30 mins',
'Under 1 hour',
'Half day or less',
'1 day',
'More than 1 day',
'Variable');
?>
<?php foreach($options as $o): ?>
<?php if($o == $activity->estimated_time): ?>
<option selected><?= $o ?></option>
<?php else: ?>
<option><?= $o ?></option>
<?php endif ?>
<?php endforeach ?>
</select>
</label>


<?php //echo $this->Form->control('moderation_flag', ['type' => 'checkbox', 'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>

<?php //echo $this->Form->control('recommended', ['type' => 'text', 'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>

<?php //echo $this->Form->control('steps._ids', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'options' => $steps]); ?>
<?php //echo $this->Form->control('licensing', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
<?php //echo $this->Form->control('moderator_notes', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
<?php echo $this->Form->control('isbn', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>


<?php echo $this->Form->control('tag_string', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'type' => 'text']); ?>
<?php //echo $this->Form->control('users._ids', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'options' => $users]); ?>
<?php //echo $this->Form->control('competencies._ids', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 'options' => $competencies]); ?>
<?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
<h2>Pathways</h2>
<?php foreach($activity->steps as $s): ?>
<div>
<a href="/pathways/<?= $s->pathways[0]['slug'] ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
<?= $s->pathways[0]['name'] ?> - <?= $s->name ?>
</a>
</div>
<?php endforeach ?>

<?= $this->Form->end() ?>

</div>
</div>
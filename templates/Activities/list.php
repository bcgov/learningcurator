<?php 
$this->layout = 'nowrap';
$this->loadHelper('Authentication.Identity');
$options = array(
	'Under 10 mins',
	'Under 30 mins',
	'Under 1 hour',
	'Half day or less',
	'1 day',
	'More than 1 day',
	'Variable');
$count = 0;
?>
<div class="container-fluid">
<div class="row">
<div class="col-6">
<?php foreach ($activities as $activity): ?>
<?php if(!in_array($activity->estimated_time,$options)): ?>
<?php $count++ ?>
<div class="row">
<div class="col-8 text-right">
	<a href="<?= $activity->hyperlink ?>" target="_blank"><?= $activity->name ?></a> - 
	<span class="badge badge-light"><?= $activity->estimated_time ?></span>
</div>
<div class="col-4">
	<div class="mb-1">
	<?= $this->Form->create($activity, ['url' => ['action' => 'edit', $activity->id], 'class' => 'form-inline']) ?>
	<?= $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id')]); ?>
	<select name="estimated_time" id="estimated_time_id" class="form-control form-control-inline">
	<?php foreach($options as $o): ?>
		<option><?= $o ?></option>
	<?php endforeach ?>
	</select>
	<?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary ml-1']) ?>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
<?php endif ?>
<?php endforeach; ?>
</div>
<div class="col-2">
<span class="badge badge-dark"><?= $count ?></span> activities left
</div>
</div>
</div>
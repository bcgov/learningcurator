<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row justify-content-md-center">
<div class="col-md-4">
<div class="card card-body">
	<?= $this->Form->create($user) ?>
	<fieldset>
		<legend><?= __('Edit User') ?></legend>
		<?php
			echo $this->Form->control('name',['class'=>'form-control']);
			echo $this->Form->control('idir',['class'=>'form-control']);
			echo $this->Form->control('ministry_id', ['options' => $ministries, 'class'=>'form-control']);
			echo $this->Form->control('role_id', ['options' => $roles, 'class'=>'form-control']);
			//echo $this->Form->control('image_path');
			echo $this->Form->control('email',['class'=>'form-control']);
			echo $this->Form->control('password',['class'=>'form-control']);
			echo $this->Form->control('activities._ids', ['options' => $activities, 'class'=>'form-control']);
			echo $this->Form->control('competencies._ids', ['options' => $competencies, 'class'=>'form-control']);
			echo $this->Form->control('pathways._ids', ['options' => $pathways, 'class'=>'form-control']);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit'),['class'=>'btn btn-success mt-3']) ?>
	<?= $this->Form->end() ?>
</div>
</div>
</div>
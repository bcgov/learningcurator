<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-8">
<h1 class="my-5"><?= __('Add a New User') ?></h1>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-4">
<div class="my-5 p-3 bg-white shadow-sm rounded-lg">
<?= $this->Form->create($user) ?>
<fieldset>
<?php
echo $this->Form->hidden('created', ['value' => date('Y-m-d H:i:s')]);
echo $this->Form->hidden('activities._ids', ['options' => $activities]);
echo $this->Form->hidden('competencies._ids', ['options' => $competencies]);
echo $this->Form->hidden('pathways._ids', ['options' => $pathways]);
echo $this->Form->hidden('ministry_id', ['value' => 1]);
echo $this->Form->hidden('image_path');
echo $this->Form->control('role_id', ['options' => $roles,'class' => 'form-control']);
echo $this->Form->control('name',['class' => 'form-control']);
echo $this->Form->control('idir',['class' => 'form-control']);
echo $this->Form->control('email',['class' => 'form-control']);
echo $this->Form->control('password',['class' => 'form-control']);
?>
</fieldset>
<?= $this->Form->button(__('Add New User'),['class' => 'btn btn-success mt-3 mb-5']) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>

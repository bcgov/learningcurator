<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */
?>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="card card-body">
<a href="/activity-types">All Activity Types</a>
<?= $this->Form->create($activityType) ?>
<fieldset>
<legend><?= __('Edit Activity Type') ?></legend>
<?php
echo $this->Form->control('name', ['class' => 'form-control']);
echo $this->Form->control('description', ['class' => 'form-control']);
echo $this->Form->control('color', ['class' => 'form-control', 'label' => 'Color (RGB value)']);
// echo $this->Form->control('delivery_method');
echo $this->Form->control('image_path', ['class' => 'form-control', 'label' => 'FontAwesome Icon']);
// echo $this->Form->control('featured');
// echo $this->Form->control('createdby');
// echo $this->Form->control('modifiedby');
?>
</fieldset>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-block btn-dark mt-3']) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>

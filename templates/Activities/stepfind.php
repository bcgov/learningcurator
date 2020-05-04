<?php
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>
<?php foreach($activities as $activity): ?>
<li class="list-group-item">
<div><?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?></div>
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?php //$this->Form->control('pathway_id',['type' => 'hidden', 'value' => '' ]) ?>
<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $stepid ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<?= $this->Form->button(__('Assign to step'),['class'=>'btn btn-sm btn-light btn-block']) ?>
<?= $this->Form->end() ?>
</li>
<?php endforeach ?>


<?php foreach($activities as $activity): ?>
<li class="list-group-item">
<div><?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?></div>
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?php //$this->Form->control('pathway_id',['type' => 'hidden', 'value' => '' ]) ?>
<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $stepid ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<?= $this->Form->control('stepcontext', ['class' => 'form-control summernote', 'label' => 'Set Context for this step']); ?>
<?= $this->Form->button(__('Assign to step'),['class'=>'btn btn-sm btn-light btn-block']) ?>
<?= $this->Form->end() ?>
</li>
<?php endforeach ?>
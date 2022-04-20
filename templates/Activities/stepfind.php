
<?php foreach($activities as $activity): ?>
<div class="mb-3 p-3 bg-white dark:bg-black rounded-lg">
<div><?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?></div>
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?php //$this->Form->control('pathway_id',['type' => 'hidden', 'value' => '' ]) ?>
<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $stepid ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<?= $this->Form->control('stepcontext', ['class' => 'w-full p-3 bg-slate-300 dark:bg-slate-900 rounded-lg', 'label' => 'Set Context for this step']); ?>
<?= $this->Form->button(__('Assign to step'),['class'=>'inline-block p-3 mt-3 bg-slate-200 dark:bg-sky-700 dark:hover:bg-sky-800 dark:text-white hover:no-underline rounded-lg']) ?>
<?= $this->Form->end() ?>
</div>
<?php endforeach ?>
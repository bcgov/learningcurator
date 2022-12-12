
<?php foreach($activities as $activity): ?>
<div class="mb-3 p-3 bg-white dark:bg-black rounded-lg">
<div class="font-semibold"><?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?></div>
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?php //$this->Form->control('pathway_id',['type' => 'hidden', 'value' => '' ]) ?>
<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $stepid ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<div class="italic text-sm"><?= $this->Form->control('stepcontext', ['class' => 'form-field', 'label' => 'Give context for including this activity in this step']); ?></div>
<?= $this->Form->button(__('Assign to step'),['class'=>'mt-3 inline-block px-3 py-1 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
<?= $this->Form->end() ?>
</div>
<hr>
<?php endforeach ?>
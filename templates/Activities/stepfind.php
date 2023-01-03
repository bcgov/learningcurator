
<?php foreach($activities as $activity): ?>
<div class="my-3">
<div class="font-semibold"><?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?></div>
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?php //$this->Form->control('pathway_id',['type' => 'hidden', 'value' => '' ]) ?>
<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $stepid ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<div class="italic text-sm"><?= $this->Form->control('stepcontext', ['class' => 'form-field', 'label' => 'Curator Context: This is where you’ll add what the learners will do, need to pay attention to, etc. Elaborate on the context—why you chose this item for this step/pathway. Example: “Just read pages 20-34 of this chapter, which sheds light on how you can adopt a servant leadership approach.”', 'rows' => '3']); ?></div>
<?= $this->Form->button(__('Assign Activity to Step'),['class'=>'mt-3 inline-block px-3 py-1 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
<?= $this->Form->end() ?>
</div>
<hr>
<?php endforeach ?>
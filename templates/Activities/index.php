<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
*/
?>
<?= $this->Html->link(__('New Activity'), ['activity' => 'add'], ['class' => 'btn btn-dark']) ?>


 <div class="alert alert-light">
	Standard Import
	<?= $this->Form->create($activities, ['activity' => 'activities/activity-import-upload', 'type' => 'file']) ?>
	<?= $this->Form->file('standardimportfile') ?>
	<input type="submit" class="btn btn-dark" value="Import">
	<?= $this->Form->end() ?>
</div> 
<h3><?= __('Activities') ?></h3>

<h4><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></h4>
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
<?php foreach ($activities as $activity): ?>
<div>
<?= $activity->activity_type->name ?> | 
<?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>

  <button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#assignment<?= $activity->id ?>" aria-expanded="false" aria-controls="assignment<?= $activity->id ?>">
    Paths
  </button>

<div class="collapse" id="assignment<?= $activity->id ?>">
<?php foreach($allpathways as $pathway): ?>
<?php $stepslist = [] ?>
<?php foreach($pathway->steps as $s): ?>
<?php $ss = array($s->id => $s->name) ?>
<?php array_push($stepslist, $ss) ?>
<?php endforeach ?>
<?php //print_r($stepslist) ?>
<?= $pathway->name ?>
<button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#steps<?= $pathway->id ?>" aria-expanded="false" aria-controls="steps<?= $pathway->id ?>">
    Steps
  </button>
<div class="collapse" id="steps<?= $pathway->id ?>">
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<?= $this->Form->control('step_id',['type' => 'radio', 'options' => $stepslist]) ?>
<?= $this->Form->button(__('Assign'),['class'=>'btn btn-sm btn-light']) ?>
<?= $this->Form->end() ?>
</div>
<?php endforeach ?>
</div>

</div>
<?php endforeach; ?>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
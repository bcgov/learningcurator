<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
*/
?>
<?= $this->Html->link(__('New Activity'), ['activity' => 'add'], ['class' => 'btn btn-dark']) ?>

 <div class="alert alert-light">
	Import from ELM
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities', 'activity' => 'elmupload'], 
					'type' => 'file']) ?>
	<?= $this->Form->file('file_path') ?>
	<input type="submit" class="btn btn-dark" value="Upload">
	<?= $this->Form->end() ?>
</div>
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

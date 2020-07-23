<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Logout'), ['action' => 'logout', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-dark btn-sm']) ?>
</div>
<h1><?= h($user->name) ?></h1>
<div class="row">
<?php if (!empty($user->pathways)) : ?>
<div class="col-md-4">
<div class="card">
<div class="card-header">
	<h2><?= __('Pathways following') ?></h2>
</div>
<ul class="list-group list-group-flush">
	<?php foreach ($user->pathways as $pathways) : ?>
	<li class="list-group-item">
	<?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?>
	</li>
	<?php endforeach; ?>
</ul>
</div>
</div>
<?php endif; ?>

<?php if(!empty($user->reports)): ?>
<div class="col-md-6">
<h2 class="mt-3"><i class="fas fa-exclamation-triangle"></i> Reports</h2>
<?php foreach($user->reports as $report): ?>
<div class="my-3 p-3 bg-white rounded-lg">
<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right btn btn-dark']) ?>
<h4><a href="/learning-curator/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></h4>
<div><?= $report->issue ?></div>
<div class="mt-2" style="font-size: 12px">Added on <?= $report->created ?></div>
<?php if(empty($report->response)): ?>
<div class="my-2 alert alert-warning">No reply yet</div>
<?php else: ?>
<div class="my-2 alert alert-success"><?= $report->response ?></div>
<?php endif ?>
</div>
<?php endforeach ?>
</div>
<?php endif ?>

<?php if (!empty($user->competencies)) : ?>
<div class="col-md-4">
<div class="card">
<div class="card-body">
	<h2><?= __('Competencies developing') ?></h2>
	<?php foreach ($user->competencies as $competencies) : ?>
	<div>
		<?= $this->Html->link($competencies->name, ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>
	</div>
	<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
</div>

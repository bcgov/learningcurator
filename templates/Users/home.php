<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Logout'), ['action' => 'logout', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?php //$this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?php //$this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-dark btn-sm']) ?>
</div>
<h1><?= h($user->name) ?></h1>
<?php if (!empty($user->pathways)) : ?>
<h2><?= __('You\'re following these pathways') ?></h2>
<div class="card-columns">
	<?php foreach ($user->pathways as $pathways) : ?>
	<div class="card p-3">
	<div><strong><?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?></strong></div>
	<div><?= h($pathways->description) ?></div>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if (!empty($user->activities)) : ?>
<h2><?= __('You\'ve claimed these activities') ?></h2>
<div class="card-columns">
	<?php foreach ($user->activities as $activity) : ?>
	<div class="card p-3">
		<?php if($activity->status_id == 2): ?>
		<span class="badge badge-warning" title="This link has been deemed to be non-functional or no longer relevant to the pathway">DEFUNCT</span>
		<div><strong><?= h($activity->name) ?></strong></div>
		<?php else: ?>
		<div><strong><?= $this->Html->link($activity->name, ['controller' => 'Actions', 'action' => 'view', $activity->id]) ?></strong></div>
		<?php endif ?>
		<div><?= h($activity->description) ?></div>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if (!empty($user->competencies)) : ?>
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
<?php endif; ?>

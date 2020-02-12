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
<?php if (!empty($user->actions)) : ?>
<div class="col-md-4">
<div class="card">
<div class="card-body">
	<h2><?= __('Actions Taken') ?></h2>
	<?php foreach ($user->actions as $actions) : ?>
	<div>
		<?= $this->Html->link($actions->name, ['controller' => 'Actions', 'action' => 'view', $actions->id]) ?>
	</div>
	<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
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

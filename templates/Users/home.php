<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Logout'), ['action' => 'logout', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
</div>
Created on: <?= h($user->created) ?>
<h1><?= h($user->name) ?> <?= h($user->id) ?></h1>
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


</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<h1><?= __('Your Curated Pathways') ?></h1>
<div class="card">

<ul class="list-group list-group-flush">
<?php foreach ($pathways as $pathway): ?>
<li class="list-group-item">
	<span class="badge badge-light"><?= $pathway->status->name ?></span>
	<h2><?= $this->Html->link($pathway->name, ['action' => 'view', $pathway->slug]) ?></h2>
	<?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id],['class' => 'badge badge-light']) ?>
</li>
<?php endforeach; ?>
</ul>
</div>
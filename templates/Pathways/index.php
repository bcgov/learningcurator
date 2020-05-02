<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<h1><?= __('All Pathways') ?></h1>
<div class="card">

<ul class="list-group list-group-flush">
<?php foreach ($pathways as $pathway): ?>
<li class="list-group-item">
	<?= $this->Html->link($pathway->category->name, ['controller' => 'categories', 'action' => 'view', $pathway->category->id]) ?> - 
	<?= $this->Html->link($pathway->name, ['action' => 'view', $pathway->id]) ?>
</li>
<?php endforeach; ?>
</ul>
</div>
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

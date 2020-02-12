<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
?>
<div class="row justify-content-md-center">
<div class="col-md-6">
<?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'btn btn-dark float-right']) ?>
<h3><?= __('Categories') ?></h3>
<ul class="list-group">
<?php foreach ($categories as $category): ?>
	<li class="list-group-item">
		<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
		<div>
		<?= $category->description ?>
		</div>
	</li>
<?php endforeach; ?>
</ul>
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
</div>
</div>

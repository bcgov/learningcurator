<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Competency $competency
*/
?>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="btn-group float-right">
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $competency->id], ['class' => 'btn btn-dark']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $competency->id], ['confirm' => __('Are you sure you want to delete # {0}?', $competency->id), 'class' => 'btn btn-dark']) ?>
<?= $this->Html->link(__('New Competency'), ['action' => 'add'], ['class' => 'btn btn-dark']) ?>
</div>
<h1><?= h($competency->name) ?></h1>
<div class="text">
<?= $this->Text->autoParagraph(h($competency->description)); ?>
</div>
<h3><?= __('Pathways') ?></h3>
<ul class="list-group">
<?php if (!empty($competency->pathways)) : ?>
<?php foreach ($competency->pathways as $pathways) : ?>
<li class="list-group-item">
<?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

</div>
</div>

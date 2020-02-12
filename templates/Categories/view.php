<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<h1><?= h($category->name) ?></h1>
<div class="text">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
<div class="row">
<div class="col-md-6">
<?php if (!empty($category->pathways)) : ?>
<?php foreach ($category->pathways as $pathways) : ?>
<div class="card mb-2">
<div class="card-body">
<h2>
<?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?>
</h2>
<div class="mb-3">
<?= h($pathways->objective) ?>
</div>
</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<!--
<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Activities</h3>
</div>
<?php if (!empty($category->activities)) : ?>
<ul class="list-group list-group-flush">
<?php foreach ($category->activities as $activities) : ?>
<li class="list-group-item">
<?= $this->Html->link($activities->name, ['controller' => 'Actions', 'action' => 'view', $activities->id]) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
</div>
-->

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<h1><?= h($category->name) ?> Pathways</h1>
<div class="text">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
<div class="row">
<div class="col-md-6">
<?php if (!empty($category->pathways)) : ?>
<?php foreach ($category->pathways as $pathways) : ?>
<?php if($pathways->status_id == 2): // is published? ?>
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
<?php endif; // is published ?>
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>

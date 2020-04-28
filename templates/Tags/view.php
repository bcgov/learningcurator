<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
<div class="col-md-6">
<div class="card">
<div class="card-body">
<div>Activities tagged with</div>
<h1><?= h($tag->name) ?></h1>
<div>
<?= $this->Text->autoParagraph(h($tag->description)); ?>
</div>

<?php if (!empty($tag->activities)) : ?>
<?php foreach ($tag->activities as $activities) : ?>

<div>
<?= $this->Html->link($activities->name, ['controller' => 'Activities', 'action' => 'view', $activities->id]) ?>
</div>

<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
</div>
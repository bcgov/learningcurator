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
</div>
<ul class="list-group list-group-flush">
<?php if (!empty($tag->activities)) : ?>
<?php foreach ($tag->activities as $activities) : ?>
    <li class="list-group-item">
		<?= $this->Html->link($activities->name, ['controller' => 'Activities', 'action' => 'view', $activities->id]) ?>
    </li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
</div>
</div>
</div>
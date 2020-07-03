<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */
?>
<div class="container">
<div class="row justify-content-md-center">
<div class="col-md-6">

<h1><?= h($activityType->name) ?></h1>

<div><?= h($activityType->color) ?></div>

<div><?= h($activityType->image_path) ?></div>

<?= $this->Text->autoParagraph(h($activityType->description)); ?>

<?php foreach($activities as $activity): ?>
    <div class="my-3"><?= $this->Html->link(h($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></div>
<?php endforeach ?>

</div>
</div>
</div>

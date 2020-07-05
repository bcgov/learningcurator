<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */
$this->layout = 'nowrap';
?>
<div class="container-fluid">
<div class="row justify-content-md-center" style="background-color: rgba(<?= h($activityType->color) ?>,1)">
<div class="col-md-8">

<h1 class="mt-3">
    <span class="fas <?= h($activityType->image_path) ?>"></span>
    <?= h($activityType->name) ?>
</h1>

<div class="my-3 p-3" style="background-color: rgba(255,255,255,.5)">

<?= h($activityType->description); ?>

</div>
</div>
</div>
<div class="container">
<div class="row justify-content-md-center">
<div class="col-md-8">
<?php foreach($activities as $activity): ?>
    <div class="my-3"><?= $this->Html->link(h($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></div>
<?php endforeach ?>

</div>
</div>
</div>

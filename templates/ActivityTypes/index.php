<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType[]|\Cake\Collection\CollectionInterface $activityTypes
 */
?>
<h1>Activity Types</h1>
<table class="table">
<?php foreach ($activityTypes as $activityType): ?>
<tr>
    <td><?= $this->Html->link(h($activityType->name), ['action' => 'view', $activityType->id]) ?></td>
    <td><?= h($activityType->color) ?></td>
    <td><?= h($activityType->image_path) ?></td>
    <td><?= $this->Html->link(__('Edit'), ['action' => 'edit', $activityType->id]) ?></td>
</tr>
<?php endforeach ?>
</table>
<!-- pagination code removed. If we have more than 20 activity types we're needing to re-write anyhow -->
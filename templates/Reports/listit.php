<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>

<h3><?= __('Reports') ?></h3>

<?php foreach ($reports as $report): ?>
<div>

<?= $report->has('activity') ? $this->Html->link($report->activity->name, ['controller' => 'Activities', 'action' => 'view', $report->activity->id]) : '' ?></div>

<div><?= $report->has('user') ? $this->Html->link($report->user->name, ['controller' => 'Users', 'action' => 'view', $report->user->id]) : '' ?></div>
<div><?= h($report->created) ?></div>
<div class="actions">
<?= $this->Html->link(__('View'), ['action' => 'view', $report->id]) ?>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $report->id]) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete # {0}?', $report->id)]) ?>
</div>
</div>
<?php endforeach; ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<h3><?= __('Reports') ?></h3>
<?php foreach ($reports as $report): ?>
<div class="mb-3 p-2 bg-light">
    <div><?= $report->issue ?></div>
    <?php $link = $report->user->name . ' ' . $report->created ?>
    <div><?= $report->has('user') ? $this->Html->link($link, ['controller' => 'Users', 'action' => 'view', $report->user->id]) : '' ?></div>
    <div><?= $report->has('activity') ? $this->Html->link($report->activity->name, ['controller' => 'Activities', 'action' => 'view', $report->activity->id]) : '' ?></div>
    <blockquote class="p-3"><?= $report->issue ?></blockquote>
    <?php if(!empty($report->response)): ?>
    Curator response:
    <blockquote class="p-3 mt-2"><?= $report->response ?></blockquote>
    <?php endif ?>
</div>
<?php endforeach; ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesStep[]|\Cake\Collection\CollectionInterface $activitiesSteps
 */
?>
<div class="activitiesSteps index content">
    <?= $this->Html->link(__('New Activities Step'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Activities Steps') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('activity_id') ?></th>
                    <th><?= $this->Paginator->sort('step_id') ?></th>
                    <th><?= $this->Paginator->sort('required') ?></th>
                    <th><?= $this->Paginator->sort('steporder') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activitiesSteps as $activitiesStep): ?>
                <tr>
                    <td><?= $activitiesStep->has('activity') ? $this->Html->link($activitiesStep->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesStep->activity->id]) : '' ?></td>
                    <td><?= $activitiesStep->has('step') ? $this->Html->link($activitiesStep->step->name, ['controller' => 'Steps', 'action' => 'view', $activitiesStep->step->id]) : '' ?></td>
                    <td><?= $this->Number->format($activitiesStep->required) ?></td>
                    <td><?= $this->Number->format($activitiesStep->steporder) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activitiesStep->activity_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activitiesStep->activity_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activitiesStep->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesStep->activity_id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

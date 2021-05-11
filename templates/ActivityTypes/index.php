<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType[]|\Cake\Collection\CollectionInterface $activityTypes
 */
?>
<div class="activityTypes index content">
    <?= $this->Html->link(__('New Activity Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Activity Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('delivery_method') ?></th>
                    <th><?= $this->Paginator->sort('image_path') ?></th>
                    <th><?= $this->Paginator->sort('featured') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('createdby') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('modifiedby') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activityTypes as $activityType): ?>
                <tr>
                    <td><?= $this->Number->format($activityType->id) ?></td>
                    <td><?= h($activityType->name) ?></td>
                    <td><?= h($activityType->slug) ?></td>
                    <td><?= h($activityType->color) ?></td>
                    <td><?= h($activityType->delivery_method) ?></td>
                    <td><?= h($activityType->image_path) ?></td>
                    <td><?= $this->Number->format($activityType->featured) ?></td>
                    <td><?= h($activityType->created) ?></td>
                    <td><?= h($activityType->createdby) ?></td>
                    <td><?= h($activityType->modified) ?></td>
                    <td><?= h($activityType->modifiedby) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activityType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activityType->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activityType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activityType->id)]) ?>
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

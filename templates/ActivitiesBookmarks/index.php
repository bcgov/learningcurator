<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesBookmark[]|\Cake\Collection\CollectionInterface $activitiesBookmarks
 */
?>
<div class="activitiesBookmarks index content">
    <?= $this->Html->link(__('New Activities Bookmark'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Activities Bookmarks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('activity_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activitiesBookmarks as $activitiesBookmark): ?>
                <tr>
                    <td><?= $activitiesBookmark->has('activity') ? $this->Html->link($activitiesBookmark->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesBookmark->activity->id]) : '' ?></td>
                    <td><?= $activitiesBookmark->has('user') ? $this->Html->link($activitiesBookmark->user->name, ['controller' => 'Users', 'action' => 'view', $activitiesBookmark->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activitiesBookmark->activity_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activitiesBookmark->activity_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activitiesBookmark->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesBookmark->activity_id)]) ?>
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

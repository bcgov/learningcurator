<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysUser[]|\Cake\Collection\CollectionInterface $pathwaysUsers
 */
?>
<div class="pathwaysUsers index content">
    <?= $this->Html->link(__('New Pathways User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pathways Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('pathway_id') ?></th>
                    <th><?= $this->Paginator->sort('status_id') ?></th>
                    <th><?= $this->Paginator->sort('date_start') ?></th>
                    <th><?= $this->Paginator->sort('date_complete') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pathwaysUsers as $pathwaysUser): ?>
                <tr>
                    <td><?= $pathwaysUser->has('user') ? $this->Html->link($pathwaysUser->user->name, ['controller' => 'Users', 'action' => 'view', $pathwaysUser->user->id]) : '' ?></td>
                    <td><?= $pathwaysUser->has('pathway') ? $this->Html->link($pathwaysUser->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathwaysUser->pathway->id]) : '' ?></td>
                    <td><?= $pathwaysUser->has('status') ? $this->Html->link($pathwaysUser->status->name, ['controller' => 'Statuses', 'action' => 'view', $pathwaysUser->status->id]) : '' ?></td>
                    <td><?= h($pathwaysUser->date_start) ?></td>
                    <td><?= h($pathwaysUser->date_complete) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pathwaysUser->user_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathwaysUser->user_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathwaysUser->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysUser->user_id)]) ?>
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

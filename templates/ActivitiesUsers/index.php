<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesUser[]|\Cake\Collection\CollectionInterface $activitiesUsers
 */
?>
<div class="activitiesUsers index content">
    <?= $this->Html->link(__('New Activities User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Activities Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('activity_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('started') ?></th>
                    <th><?= $this->Paginator->sort('finished') ?></th>
                    <th><?= $this->Paginator->sort('liked') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activitiesUsers as $activitiesUser): ?>
                <tr>
                    <td><?= $activitiesUser->has('activity') ? $this->Html->link($activitiesUser->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesUser->activity->id]) : '' ?></td>
                    <td><?= $activitiesUser->has('user') ? $this->Html->link($activitiesUser->user->name, ['controller' => 'Users', 'action' => 'view', $activitiesUser->user->id]) : '' ?></td>
                    <td><?= h($activitiesUser->started) ?></td>
                    <td><?= h($activitiesUser->finished) ?></td>
                    <td><?= $this->Number->format($activitiesUser->liked) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activitiesUser->user_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activitiesUser->user_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activitiesUser->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesUser->user_id)]) ?>
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

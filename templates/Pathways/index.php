<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<div class="pathways index content">
    <?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pathways') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('file_path') ?></th>
                    <th><?= $this->Paginator->sort('image_path') ?></th>
                    <th><?= $this->Paginator->sort('featured') ?></th>
                    <th><?= $this->Paginator->sort('topic_id') ?></th>
                    <th><?= $this->Paginator->sort('ministry_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('createdby') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('modifiedby') ?></th>
                    <th><?= $this->Paginator->sort('status_id') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('estimated_time') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pathways as $pathway): ?>
                <tr>
                    <td><?= $this->Number->format($pathway->id) ?></td>
                    <td><?= h($pathway->name) ?></td>
                    <td><?= h($pathway->color) ?></td>
                    <td><?= h($pathway->file_path) ?></td>
                    <td><?= h($pathway->image_path) ?></td>
                    <td><?= $this->Number->format($pathway->featured) ?></td>
                    <td><?= $pathway->has('topic') ? $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id]) : '' ?></td>
                    <td><?= $pathway->has('ministry') ? $this->Html->link($pathway->ministry->name, ['controller' => 'Ministries', 'action' => 'view', $pathway->ministry->id]) : '' ?></td>
                    <td><?= h($pathway->created) ?></td>
                    <td><?= h($pathway->createdby) ?></td>
                    <td><?= h($pathway->modified) ?></td>
                    <td><?= h($pathway->modifiedby) ?></td>
                    <td><?= $pathway->has('status') ? $this->Html->link($pathway->status->name, ['controller' => 'Statuses', 'action' => 'view', $pathway->status->id]) : '' ?></td>
                    <td><?= h($pathway->slug) ?></td>
                    <td><?= h($pathway->estimated_time) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pathway->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id)]) ?>
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

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry[]|\Cake\Collection\CollectionInterface $ministries
 */
?>
<div class="ministries index content">
    <?= $this->Html->link(__('New Ministry'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Ministries') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('elm_learner_group') ?></th>
                    <th><?= $this->Paginator->sort('hyperlink') ?></th>
                    <th><?= $this->Paginator->sort('image_path') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('featured') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ministries as $ministry): ?>
                <tr>
                    <td><?= $this->Number->format($ministry->id) ?></td>
                    <td><?= h($ministry->name) ?></td>
                    <td><?= h($ministry->slug) ?></td>
                    <td><?= h($ministry->elm_learner_group) ?></td>
                    <td><?= h($ministry->hyperlink) ?></td>
                    <td><?= h($ministry->image_path) ?></td>
                    <td><?= h($ministry->color) ?></td>
                    <td><?= $this->Number->format($ministry->featured) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $ministry->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ministry->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ministry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ministry->id)]) ?>
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

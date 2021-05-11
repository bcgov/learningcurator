<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step[]|\Cake\Collection\CollectionInterface $steps
 */
?>
<div class="steps index content">
    <?= $this->Html->link(__('New Step'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Steps') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
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
                <?php foreach ($steps as $step): ?>
                <tr>
                    <td><?= $this->Number->format($step->id) ?></td>
                    <td><?= h($step->name) ?></td>
                    <td><?= h($step->slug) ?></td>
                    <td><?= h($step->image_path) ?></td>
                    <td><?= $this->Number->format($step->featured) ?></td>
                    <td><?= h($step->created) ?></td>
                    <td><?= h($step->createdby) ?></td>
                    <td><?= h($step->modified) ?></td>
                    <td><?= h($step->modifiedby) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $step->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $step->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $step->id], ['confirm' => __('Are you sure you want to delete # {0}?', $step->id)]) ?>
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

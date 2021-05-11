<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Competency[]|\Cake\Collection\CollectionInterface $competencies
 */
?>
<div class="competencies index content">
    <?= $this->Html->link(__('New Competency'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Competencies') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('image_path') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('featured') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('createdby') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('modifiedby') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competencies as $competency): ?>
                <tr>
                    <td><?= $this->Number->format($competency->id) ?></td>
                    <td><?= h($competency->name) ?></td>
                    <td><?= h($competency->slug) ?></td>
                    <td><?= h($competency->image_path) ?></td>
                    <td><?= h($competency->color) ?></td>
                    <td><?= h($competency->featured) ?></td>
                    <td><?= h($competency->created) ?></td>
                    <td><?= h($competency->createdby) ?></td>
                    <td><?= h($competency->modified) ?></td>
                    <td><?= h($competency->modifiedby) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $competency->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $competency->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $competency->id], ['confirm' => __('Are you sure you want to delete # {0}?', $competency->id)]) ?>
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

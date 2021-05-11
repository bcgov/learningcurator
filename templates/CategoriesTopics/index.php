<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesTopic[]|\Cake\Collection\CollectionInterface $categoriesTopics
 */
?>
<div class="categoriesTopics index content">
    <?= $this->Html->link(__('New Categories Topic'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Categories Topics') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('topic_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriesTopics as $categoriesTopic): ?>
                <tr>
                    <td><?= $this->Number->format($categoriesTopic->id) ?></td>
                    <td><?= $categoriesTopic->has('category') ? $this->Html->link($categoriesTopic->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesTopic->category->id]) : '' ?></td>
                    <td><?= $categoriesTopic->has('topic') ? $this->Html->link($categoriesTopic->topic->name, ['controller' => 'Topics', 'action' => 'view', $categoriesTopic->topic->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $categoriesTopic->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $categoriesTopic->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $categoriesTopic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesTopic->id)]) ?>
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

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysTopic[]|\Cake\Collection\CollectionInterface $pathwaysTopics
 */
?>
<div class="pathwaysTopics index content">
    <?= $this->Html->link(__('New Pathways Topic'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pathways Topics') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('pathway_id') ?></th>
                    <th><?= $this->Paginator->sort('topic_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pathwaysTopics as $pathwaysTopic): ?>
                <tr>
                    <td><?= $pathwaysTopic->has('pathway') ? $this->Html->link($pathwaysTopic->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathwaysTopic->pathway->id]) : '' ?></td>
                    <td><?= $pathwaysTopic->has('topic') ? $this->Html->link($pathwaysTopic->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathwaysTopic->topic->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pathwaysTopic->pathway_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathwaysTopic->pathway_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathwaysTopic->pathway_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysTopic->pathway_id)]) ?>
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

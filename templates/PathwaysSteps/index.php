<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysStep[]|\Cake\Collection\CollectionInterface $pathwaysSteps
 */
?>
<div class="pathwaysSteps index content">
    <?= $this->Html->link(__('New Pathways Step'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pathways Steps') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('step_id') ?></th>
                    <th><?= $this->Paginator->sort('pathway_id') ?></th>
                    <th><?= $this->Paginator->sort('date_start') ?></th>
                    <th><?= $this->Paginator->sort('date_complete') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pathwaysSteps as $pathwaysStep): ?>
                <tr>
                    <td><?= $pathwaysStep->has('step') ? $this->Html->link($pathwaysStep->step->name, ['controller' => 'Steps', 'action' => 'view', $pathwaysStep->step->id]) : '' ?></td>
                    <td><?= $pathwaysStep->has('pathway') ? $this->Html->link($pathwaysStep->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathwaysStep->pathway->id]) : '' ?></td>
                    <td><?= h($pathwaysStep->date_start) ?></td>
                    <td><?= h($pathwaysStep->date_complete) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pathwaysStep->step_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathwaysStep->step_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathwaysStep->step_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysStep->step_id)]) ?>
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

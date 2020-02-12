<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompetenciesUser[]|\Cake\Collection\CollectionInterface $competenciesUsers
 */
?>
<div class="competenciesUsers index content">
    <?= $this->Html->link(__('New Competencies User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Competencies Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('competency_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competenciesUsers as $competenciesUser): ?>
                <tr>
                    <td><?= $competenciesUser->has('competency') ? $this->Html->link($competenciesUser->competency->name, ['controller' => 'Competencies', 'action' => 'view', $competenciesUser->competency->id]) : '' ?></td>
                    <td><?= $competenciesUser->has('user') ? $this->Html->link($competenciesUser->user->name, ['controller' => 'Users', 'action' => 'view', $competenciesUser->user->id]) : '' ?></td>
                    <td><?= h($competenciesUser->priority) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $competenciesUser->competency_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $competenciesUser->competency_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $competenciesUser->competency_id], ['confirm' => __('Are you sure you want to delete # {0}?', $competenciesUser->competency_id)]) ?>
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

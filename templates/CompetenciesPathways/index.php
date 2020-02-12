<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompetenciesPathway[]|\Cake\Collection\CollectionInterface $competenciesPathways
 */
?>
<div class="competenciesPathways index content">
    <?= $this->Html->link(__('New Competencies Pathway'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Competencies Pathways') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('competency_id') ?></th>
                    <th><?= $this->Paginator->sort('pathway_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competenciesPathways as $competenciesPathway): ?>
                <tr>
                    <td><?= $competenciesPathway->has('competency') ? $this->Html->link($competenciesPathway->competency->name, ['controller' => 'Competencies', 'action' => 'view', $competenciesPathway->competency->id]) : '' ?></td>
                    <td><?= $competenciesPathway->has('pathway') ? $this->Html->link($competenciesPathway->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $competenciesPathway->pathway->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $competenciesPathway->competency_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $competenciesPathway->competency_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $competenciesPathway->competency_id], ['confirm' => __('Are you sure you want to delete # {0}?', $competenciesPathway->competency_id)]) ?>
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

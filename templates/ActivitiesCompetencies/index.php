<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesCompetency[]|\Cake\Collection\CollectionInterface $activitiesCompetencies
 */
?>
<div class="activitiesCompetencies index content">
    <?= $this->Html->link(__('New Activities Competency'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Activities Competencies') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('activity_id') ?></th>
                    <th><?= $this->Paginator->sort('competency_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activitiesCompetencies as $activitiesCompetency): ?>
                <tr>
                    <td><?= $activitiesCompetency->has('activity') ? $this->Html->link($activitiesCompetency->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesCompetency->activity->id]) : '' ?></td>
                    <td><?= $activitiesCompetency->has('competency') ? $this->Html->link($activitiesCompetency->competency->name, ['controller' => 'Competencies', 'action' => 'view', $activitiesCompetency->competency->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activitiesCompetency->activity_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activitiesCompetency->activity_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activitiesCompetency->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesCompetency->activity_id)]) ?>
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

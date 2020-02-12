<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompetenciesUser $competenciesUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Competencies User'), ['action' => 'edit', $competenciesUser->competency_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Competencies User'), ['action' => 'delete', $competenciesUser->competency_id], ['confirm' => __('Are you sure you want to delete # {0}?', $competenciesUser->competency_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Competencies Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Competencies User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="competenciesUsers view content">
            <h3><?= h($competenciesUser->competency_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Competency') ?></th>
                    <td><?= $competenciesUser->has('competency') ? $this->Html->link($competenciesUser->competency->name, ['controller' => 'Competencies', 'action' => 'view', $competenciesUser->competency->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $competenciesUser->has('user') ? $this->Html->link($competenciesUser->user->name, ['controller' => 'Users', 'action' => 'view', $competenciesUser->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= h($competenciesUser->priority) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

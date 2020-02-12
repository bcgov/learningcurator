<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompetenciesPathway $competenciesPathway
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Competencies Pathway'), ['action' => 'edit', $competenciesPathway->competency_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Competencies Pathway'), ['action' => 'delete', $competenciesPathway->competency_id], ['confirm' => __('Are you sure you want to delete # {0}?', $competenciesPathway->competency_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Competencies Pathways'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Competencies Pathway'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="competenciesPathways view content">
            <h3><?= h($competenciesPathway->competency_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Competency') ?></th>
                    <td><?= $competenciesPathway->has('competency') ? $this->Html->link($competenciesPathway->competency->name, ['controller' => 'Competencies', 'action' => 'view', $competenciesPathway->competency->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pathway') ?></th>
                    <td><?= $competenciesPathway->has('pathway') ? $this->Html->link($competenciesPathway->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $competenciesPathway->pathway->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysStep $pathwaysStep
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pathways Step'), ['action' => 'edit', $pathwaysStep->step_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pathways Step'), ['action' => 'delete', $pathwaysStep->step_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysStep->step_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pathways Steps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pathways Step'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysSteps view content">
            <h3><?= h($pathwaysStep->step_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Step') ?></th>
                    <td><?= $pathwaysStep->has('step') ? $this->Html->link($pathwaysStep->step->name, ['controller' => 'Steps', 'action' => 'view', $pathwaysStep->step->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pathway') ?></th>
                    <td><?= $pathwaysStep->has('pathway') ? $this->Html->link($pathwaysStep->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathwaysStep->pathway->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Start') ?></th>
                    <td><?= h($pathwaysStep->date_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Complete') ?></th>
                    <td><?= h($pathwaysStep->date_complete) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

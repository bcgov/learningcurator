<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesStep $activitiesStep
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activities Step'), ['action' => 'edit', $activitiesStep->activity_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activities Step'), ['action' => 'delete', $activitiesStep->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesStep->activity_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities Steps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activities Step'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesSteps view content">
            <h3><?= h($activitiesStep->activity_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Activity') ?></th>
                    <td><?= $activitiesStep->has('activity') ? $this->Html->link($activitiesStep->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesStep->activity->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Step') ?></th>
                    <td><?= $activitiesStep->has('step') ? $this->Html->link($activitiesStep->step->name, ['controller' => 'Steps', 'action' => 'view', $activitiesStep->step->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Required') ?></th>
                    <td><?= $this->Number->format($activitiesStep->required) ?></td>
                </tr>
                <tr>
                    <th><?= __('Steporder') ?></th>
                    <td><?= $this->Number->format($activitiesStep->steporder) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

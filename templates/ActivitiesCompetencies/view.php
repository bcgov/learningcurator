<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesCompetency $activitiesCompetency
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activities Competency'), ['action' => 'edit', $activitiesCompetency->activity_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activities Competency'), ['action' => 'delete', $activitiesCompetency->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesCompetency->activity_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities Competencies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activities Competency'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesCompetencies view content">
            <h3><?= h($activitiesCompetency->activity_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Activity') ?></th>
                    <td><?= $activitiesCompetency->has('activity') ? $this->Html->link($activitiesCompetency->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesCompetency->activity->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Competency') ?></th>
                    <td><?= $activitiesCompetency->has('competency') ? $this->Html->link($activitiesCompetency->competency->name, ['controller' => 'Competencies', 'action' => 'view', $activitiesCompetency->competency->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

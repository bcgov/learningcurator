<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesTag $activitiesTag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activities Tag'), ['action' => 'edit', $activitiesTag->activity_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activities Tag'), ['action' => 'delete', $activitiesTag->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesTag->activity_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activities Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesTags view content">
            <h3><?= h($activitiesTag->activity_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Activity') ?></th>
                    <td><?= $activitiesTag->has('activity') ? $this->Html->link($activitiesTag->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesTag->activity->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= $activitiesTag->has('tag') ? $this->Html->link($activitiesTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $activitiesTag->tag->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

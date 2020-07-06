<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesBookmark $activitiesBookmark
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activities Bookmark'), ['action' => 'edit', $activitiesBookmark->activity_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activities Bookmark'), ['action' => 'delete', $activitiesBookmark->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesBookmark->activity_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities Bookmarks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activities Bookmark'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesBookmarks view content">
            <h3><?= h($activitiesBookmark->activity_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Activity') ?></th>
                    <td><?= $activitiesBookmark->has('activity') ? $this->Html->link($activitiesBookmark->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesBookmark->activity->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $activitiesBookmark->has('user') ? $this->Html->link($activitiesBookmark->user->name, ['controller' => 'Users', 'action' => 'view', $activitiesBookmark->user->id]) : '' ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activitiesBookmark->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>

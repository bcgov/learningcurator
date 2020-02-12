<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesUser $activitiesUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activities User'), ['action' => 'edit', $activitiesUser->user_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activities User'), ['action' => 'delete', $activitiesUser->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesUser->user_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activities User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesUsers view content">
            <h3><?= h($activitiesUser->user_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Activity') ?></th>
                    <td><?= $activitiesUser->has('activity') ? $this->Html->link($activitiesUser->activity->name, ['controller' => 'Activities', 'action' => 'view', $activitiesUser->activity->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $activitiesUser->has('user') ? $this->Html->link($activitiesUser->user->name, ['controller' => 'Users', 'action' => 'view', $activitiesUser->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Liked') ?></th>
                    <td><?= $this->Number->format($activitiesUser->liked) ?></td>
                </tr>
                <tr>
                    <th><?= __('Started') ?></th>
                    <td><?= h($activitiesUser->started) ?></td>
                </tr>
                <tr>
                    <th><?= __('Finished') ?></th>
                    <td><?= h($activitiesUser->finished) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activitiesUser->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>

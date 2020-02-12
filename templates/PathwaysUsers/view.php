<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysUser $pathwaysUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pathways User'), ['action' => 'edit', $pathwaysUser->user_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pathways User'), ['action' => 'delete', $pathwaysUser->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysUser->user_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pathways Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pathways User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysUsers view content">
            <h3><?= h($pathwaysUser->user_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $pathwaysUser->has('user') ? $this->Html->link($pathwaysUser->user->name, ['controller' => 'Users', 'action' => 'view', $pathwaysUser->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pathway') ?></th>
                    <td><?= $pathwaysUser->has('pathway') ? $this->Html->link($pathwaysUser->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathwaysUser->pathway->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $pathwaysUser->has('status') ? $this->Html->link($pathwaysUser->status->name, ['controller' => 'Statuses', 'action' => 'view', $pathwaysUser->status->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Start') ?></th>
                    <td><?= h($pathwaysUser->date_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Complete') ?></th>
                    <td><?= h($pathwaysUser->date_complete) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

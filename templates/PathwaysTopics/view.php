<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysTopic $pathwaysTopic
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pathways Topic'), ['action' => 'edit', $pathwaysTopic->pathway_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pathways Topic'), ['action' => 'delete', $pathwaysTopic->pathway_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysTopic->pathway_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pathways Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pathways Topic'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysTopics view content">
            <h3><?= h($pathwaysTopic->pathway_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Pathway') ?></th>
                    <td><?= $pathwaysTopic->has('pathway') ? $this->Html->link($pathwaysTopic->pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathwaysTopic->pathway->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic') ?></th>
                    <td><?= $pathwaysTopic->has('topic') ? $this->Html->link($pathwaysTopic->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathwaysTopic->topic->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

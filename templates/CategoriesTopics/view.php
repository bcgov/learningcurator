<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesTopic $categoriesTopic
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Categories Topic'), ['action' => 'edit', $categoriesTopic->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Categories Topic'), ['action' => 'delete', $categoriesTopic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesTopic->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Categories Topic'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categoriesTopics view content">
            <h3><?= h($categoriesTopic->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $categoriesTopic->has('category') ? $this->Html->link($categoriesTopic->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesTopic->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Topic') ?></th>
                    <td><?= $categoriesTopic->has('topic') ? $this->Html->link($categoriesTopic->topic->name, ['controller' => 'Topics', 'action' => 'view', $categoriesTopic->topic->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($categoriesTopic->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

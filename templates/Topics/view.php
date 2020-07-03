<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Topic'), ['action' => 'edit', $topic->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Topic'), ['action' => 'delete', $topic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $topic->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Topic'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="topics view content">
            <h3><?= h($topic->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($topic->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Path') ?></th>
                    <td><?= h($topic->image_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($topic->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Featured') ?></th>
                    <td><?= h($topic->featured) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $topic->has('user') ? $this->Html->link($topic->user->name, ['controller' => 'Users', 'action' => 'view', $topic->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($topic->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($topic->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($topic->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Categories') ?></h4>
                <?php if (!empty($topic->categories)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Image Path') ?></th>
                            <th><?= __('Color') ?></th>
                            <th><?= __('Featured') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Createdby') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($topic->categories as $categories) : ?>
                        <tr>
                            <td><?= h($categories->id) ?></td>
                            <td><?= h($categories->name) ?></td>
                            <td><?= h($categories->description) ?></td>
                            <td><?= h($categories->image_path) ?></td>
                            <td><?= h($categories->color) ?></td>
                            <td><?= h($categories->featured) ?></td>
                            <td><?= h($categories->created) ?></td>
                            <td><?= h($categories->createdby) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $categories->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $categories->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $categories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

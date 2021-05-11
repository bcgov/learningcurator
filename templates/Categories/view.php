<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categories view content">
            <h3><?= h($category->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($category->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($category->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Path') ?></th>
                    <td><?= h($category->image_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($category->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Featured') ?></th>
                    <td><?= h($category->featured) ?></td>
                </tr>
                <tr>
                    <th><?= __('Createdby') ?></th>
                    <td><?= h($category->createdby) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($category->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($category->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($category->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Topics') ?></h4>
                <?php if (!empty($category->topics)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Image Path') ?></th>
                            <th><?= __('Color') ?></th>
                            <th><?= __('Featured') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($category->topics as $topics) : ?>
                        <tr>
                            <td><?= h($topics->id) ?></td>
                            <td><?= h($topics->name) ?></td>
                            <td><?= h($topics->slug) ?></td>
                            <td><?= h($topics->description) ?></td>
                            <td><?= h($topics->image_path) ?></td>
                            <td><?= h($topics->color) ?></td>
                            <td><?= h($topics->featured) ?></td>
                            <td><?= h($topics->created) ?></td>
                            <td><?= h($topics->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Topics', 'action' => 'view', $topics->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Topics', 'action' => 'edit', $topics->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Topics', 'action' => 'delete', $topics->id], ['confirm' => __('Are you sure you want to delete # {0}?', $topics->id)]) ?>
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

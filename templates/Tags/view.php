<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tags view content">
            <h3><?= h($tag->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($tag->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tag->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Createdby') ?></th>
                    <td><?= $this->Number->format($tag->createdby) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modifiedby') ?></th>
                    <td><?= $this->Number->format($tag->modifiedby) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($tag->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($tag->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tag->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Activities') ?></h4>
                <?php if (!empty($tag->activities)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Hyperlink') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Licensing') ?></th>
                            <th><?= __('Moderator Notes') ?></th>
                            <th><?= __('Isbn') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th><?= __('Meta Title') ?></th>
                            <th><?= __('Meta Description') ?></th>
                            <th><?= __('Featured') ?></th>
                            <th><?= __('Moderation Flag') ?></th>
                            <th><?= __('File Path') ?></th>
                            <th><?= __('Image Path') ?></th>
                            <th><?= __('Hours') ?></th>
                            <th><?= __('Recommended') ?></th>
                            <th><?= __('Ministry Id') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th><?= __('Approvedby Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Createdby Id') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Modifiedby Id') ?></th>
                            <th><?= __('Activity Types Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tag->activities as $activities) : ?>
                        <tr>
                            <td><?= h($activities->id) ?></td>
                            <td><?= h($activities->name) ?></td>
                            <td><?= h($activities->hyperlink) ?></td>
                            <td><?= h($activities->description) ?></td>
                            <td><?= h($activities->licensing) ?></td>
                            <td><?= h($activities->moderator_notes) ?></td>
                            <td><?= h($activities->isbn) ?></td>
                            <td><?= h($activities->status_id) ?></td>
                            <td><?= h($activities->meta_title) ?></td>
                            <td><?= h($activities->meta_description) ?></td>
                            <td><?= h($activities->featured) ?></td>
                            <td><?= h($activities->moderation_flag) ?></td>
                            <td><?= h($activities->file_path) ?></td>
                            <td><?= h($activities->image_path) ?></td>
                            <td><?= h($activities->hours) ?></td>
                            <td><?= h($activities->recommended) ?></td>
                            <td><?= h($activities->ministry_id) ?></td>
                            <td><?= h($activities->category_id) ?></td>
                            <td><?= h($activities->approvedby_id) ?></td>
                            <td><?= h($activities->created) ?></td>
                            <td><?= h($activities->createdby_id) ?></td>
                            <td><?= h($activities->modified) ?></td>
                            <td><?= h($activities->modifiedby_id) ?></td>
                            <td><?= h($activities->activity_types_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Activities', 'action' => 'view', $activities->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activities->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Activities', 'action' => 'delete', $activities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activities->id)]) ?>
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

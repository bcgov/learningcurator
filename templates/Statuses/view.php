<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Status $status
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Status'), ['action' => 'edit', $status->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Status'), ['action' => 'delete', $status->id], ['confirm' => __('Are you sure you want to delete # {0}?', $status->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Statuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Status'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="statuses view content">
            <h3><?= h($status->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($status->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($status->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Createdby') ?></th>
                    <td><?= $this->Number->format($status->createdby) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($status->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($status->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Activities') ?></h4>
                <?php if (!empty($status->activities)) : ?>
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
                            <th><?= __('Status') ?></th>
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
                        <?php foreach ($status->activities as $activities) : ?>
                        <tr>
                            <td><?= h($activities->id) ?></td>
                            <td><?= h($activities->name) ?></td>
                            <td><?= h($activities->hyperlink) ?></td>
                            <td><?= h($activities->description) ?></td>
                            <td><?= h($activities->licensing) ?></td>
                            <td><?= h($activities->moderator_notes) ?></td>
                            <td><?= h($activities->isbn) ?></td>
                            <td><?= h($activities->status) ?></td>
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
            <div class="related">
                <h4><?= __('Related Pathways Users') ?></h4>
                <?php if (!empty($status->pathways_users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Pathway Id') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th><?= __('Date Start') ?></th>
                            <th><?= __('Date Complete') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($status->pathways_users as $pathwaysUsers) : ?>
                        <tr>
                            <td><?= h($pathwaysUsers->user_id) ?></td>
                            <td><?= h($pathwaysUsers->pathway_id) ?></td>
                            <td><?= h($pathwaysUsers->status_id) ?></td>
                            <td><?= h($pathwaysUsers->date_start) ?></td>
                            <td><?= h($pathwaysUsers->date_complete) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PathwaysUsers', 'action' => 'view', $pathwaysUsers->user_id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PathwaysUsers', 'action' => 'edit', $pathwaysUsers->user_id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PathwaysUsers', 'action' => 'delete', $pathwaysUsers->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysUsers->user_id)]) ?>
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

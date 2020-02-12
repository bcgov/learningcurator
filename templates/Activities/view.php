<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activity'), ['action' => 'edit', $activity->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activity'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activity'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activities view content">
            <h3><?= h($activity->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($activity->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hyperlink') ?></th>
                    <td><?= h($activity->hyperlink) ?></td>
                </tr>
                <tr>
                    <th><?= __('Isbn') ?></th>
                    <td><?= h($activity->isbn) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $activity->has('status') ? $this->Html->link($activity->status->name, ['controller' => 'Statuses', 'action' => 'view', $activity->status->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Meta Title') ?></th>
                    <td><?= h($activity->meta_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Path') ?></th>
                    <td><?= h($activity->file_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Path') ?></th>
                    <td><?= h($activity->image_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ministry') ?></th>
                    <td><?= $activity->has('ministry') ? $this->Html->link($activity->ministry->name, ['controller' => 'Ministries', 'action' => 'view', $activity->ministry->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $activity->has('category') ? $this->Html->link($activity->category->name, ['controller' => 'Categories', 'action' => 'view', $activity->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Activity Type') ?></th>
                    <td><?= $activity->has('activity_type') ? $this->Html->link($activity->activity_type->name, ['controller' => 'ActivityTypes', 'action' => 'view', $activity->activity_type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($activity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Featured') ?></th>
                    <td><?= $this->Number->format($activity->featured) ?></td>
                </tr>
                <tr>
                    <th><?= __('Moderation Flag') ?></th>
                    <td><?= $this->Number->format($activity->moderation_flag) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hours') ?></th>
                    <td><?= $this->Number->format($activity->hours) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recommended') ?></th>
                    <td><?= $this->Number->format($activity->recommended) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approvedby Id') ?></th>
                    <td><?= $this->Number->format($activity->approvedby_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Createdby Id') ?></th>
                    <td><?= $this->Number->format($activity->createdby_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modifiedby Id') ?></th>
                    <td><?= $this->Number->format($activity->modifiedby_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($activity->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($activity->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activity->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Licensing') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activity->licensing)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Moderator Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Meta Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activity->meta_description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($activity->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Idir') ?></th>
                            <th><?= __('Ministry Id') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Image Path') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($activity->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->name) ?></td>
                            <td><?= h($users->idir) ?></td>
                            <td><?= h($users->ministry_id) ?></td>
                            <td><?= h($users->role_id) ?></td>
                            <td><?= h($users->image_path) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Competencies') ?></h4>
                <?php if (!empty($activity->competencies)) : ?>
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
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Modifiedby') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($activity->competencies as $competencies) : ?>
                        <tr>
                            <td><?= h($competencies->id) ?></td>
                            <td><?= h($competencies->name) ?></td>
                            <td><?= h($competencies->description) ?></td>
                            <td><?= h($competencies->image_path) ?></td>
                            <td><?= h($competencies->color) ?></td>
                            <td><?= h($competencies->featured) ?></td>
                            <td><?= h($competencies->created) ?></td>
                            <td><?= h($competencies->createdby) ?></td>
                            <td><?= h($competencies->modified) ?></td>
                            <td><?= h($competencies->modifiedby) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Competencies', 'action' => 'edit', $competencies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Competencies', 'action' => 'delete', $competencies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $competencies->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Steps') ?></h4>
                <?php if (!empty($activity->steps)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Image Path') ?></th>
                            <th><?= __('Featured') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Createdby') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Modifiedby') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($activity->steps as $steps) : ?>
                        <tr>
                            <td><?= h($steps->id) ?></td>
                            <td><?= h($steps->name) ?></td>
                            <td><?= h($steps->description) ?></td>
                            <td><?= h($steps->image_path) ?></td>
                            <td><?= h($steps->featured) ?></td>
                            <td><?= h($steps->created) ?></td>
                            <td><?= h($steps->createdby) ?></td>
                            <td><?= h($steps->modified) ?></td>
                            <td><?= h($steps->modifiedby) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Steps', 'action' => 'view', $steps->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Steps', 'action' => 'edit', $steps->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Steps', 'action' => 'delete', $steps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $steps->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tags') ?></h4>
                <?php if (!empty($activity->tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Createdby') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Modifiedby') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($activity->tags as $tags) : ?>
                        <tr>
                            <td><?= h($tags->id) ?></td>
                            <td><?= h($tags->name) ?></td>
                            <td><?= h($tags->description) ?></td>
                            <td><?= h($tags->created) ?></td>
                            <td><?= h($tags->createdby) ?></td>
                            <td><?= h($tags->modified) ?></td>
                            <td><?= h($tags->modifiedby) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tags->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tags', 'action' => 'delete', $tags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->id)]) ?>
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

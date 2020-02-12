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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Activities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activities form content">
            <?= $this->Form->create($activity) ?>
            <fieldset>
                <legend><?= __('Edit Activity') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('hyperlink');
                    echo $this->Form->control('description');
                    echo $this->Form->control('licensing');
                    echo $this->Form->control('moderator_notes');
                    echo $this->Form->control('isbn');
                    echo $this->Form->control('status_id', ['options' => $statuses, 'empty' => true]);
                    echo $this->Form->control('meta_title');
                    echo $this->Form->control('meta_description');
                    echo $this->Form->control('featured');
                    echo $this->Form->control('moderation_flag');
                    echo $this->Form->control('file_path');
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('hours');
                    echo $this->Form->control('recommended');
                    echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
                    echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
                    echo $this->Form->control('approvedby_id');
                    echo $this->Form->control('createdby_id');
                    echo $this->Form->control('modifiedby_id');
                    echo $this->Form->control('activity_types_id', ['options' => $activityTypes]);
                    echo $this->Form->control('users._ids', ['options' => $users]);
                    echo $this->Form->control('competencies._ids', ['options' => $competencies]);
                    echo $this->Form->control('steps._ids', ['options' => $steps]);
                    echo $this->Form->control('tags._ids', ['options' => $tags]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesBookmark $activitiesBookmark
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activitiesBookmark->activity_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesBookmark->activity_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Activities Bookmarks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesBookmarks form content">
            <?= $this->Form->create($activitiesBookmark) ?>
            <fieldset>
                <legend><?= __('Edit Activities Bookmark') ?></legend>
                <?php
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

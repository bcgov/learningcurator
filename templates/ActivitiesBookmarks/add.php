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
            <?= $this->Html->link(__('List Activities Bookmarks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesBookmarks form content">
            <?= $this->Form->create($activitiesBookmark) ?>
            <fieldset>
                <legend><?= __('Add Activities Bookmark') ?></legend>
                <?php
                
                    echo $this->Form->text('activity_id');

                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

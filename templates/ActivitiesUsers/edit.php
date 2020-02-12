<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesUser $activitiesUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activitiesUser->user_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesUser->user_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Activities Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesUsers form content">
            <?= $this->Form->create($activitiesUser) ?>
            <fieldset>
                <legend><?= __('Edit Activities User') ?></legend>
                <?php
                    echo $this->Form->control('started', ['empty' => true]);
                    echo $this->Form->control('finished', ['empty' => true]);
                    echo $this->Form->control('liked');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysUser $pathwaysUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pathwaysUser->user_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysUser->user_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pathways Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysUsers form content">
            <?= $this->Form->create($pathwaysUser) ?>
            <fieldset>
                <legend><?= __('Edit Pathways User') ?></legend>
                <?php
                    echo $this->Form->control('status_id', ['options' => $statuses, 'empty' => true]);
                    echo $this->Form->control('date_start', ['empty' => true]);
                    echo $this->Form->control('date_complete', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesStep $activitiesStep
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activitiesStep->activity_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesStep->activity_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Activities Steps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesSteps form content">
            <?= $this->Form->create($activitiesStep) ?>
            <fieldset>
                <legend><?= __('Edit Activities Step') ?></legend>
                <?php
                    echo $this->Form->control('required');
                    echo $this->Form->control('steporder');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysStep $pathwaysStep
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pathwaysStep->step_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysStep->step_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pathways Steps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysSteps form content">
            <?= $this->Form->create($pathwaysStep) ?>
            <fieldset>
                <legend><?= __('Edit Pathways Step') ?></legend>
                <?php
                    echo $this->Form->control('date_start', ['empty' => true]);
                    echo $this->Form->control('date_complete', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

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
            <?= $this->Html->link(__('List Activities Steps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesSteps form content">
            <?= $this->Form->create($activitiesStep) ?>
            <fieldset>
                <legend><?= __('Add Activities Step') ?></legend>
                <?php
                    echo $this->Form->control('activity_id', ['options' => $activities]);
                    echo $this->Form->control('step_id', ['options' => $steps]);
                    echo $this->Form->control('required');
                    echo $this->Form->control('steporder');
                    echo $this->Form->control('stepcontext');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

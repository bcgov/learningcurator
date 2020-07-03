<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PathwaysTopic $pathwaysTopic
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Pathways Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysTopics form content">
            <?= $this->Form->create($pathwaysTopic) ?>
            <fieldset>
                <legend><?= __('Add Pathways Topic') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

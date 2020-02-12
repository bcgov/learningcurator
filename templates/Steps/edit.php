<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $step->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $step->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Steps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="steps form content">
            <?= $this->Form->create($step) ?>
            <fieldset>
                <legend><?= __('Edit Step') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('featured');
                    echo $this->Form->control('createdby');
                    echo $this->Form->control('modifiedby');
                    echo $this->Form->control('activities._ids', ['options' => $activities]);
                    echo $this->Form->control('pathways._ids', ['options' => $pathways]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activityType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activityType->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Activity Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activityTypes form content">
            <?= $this->Form->create($activityType) ?>
            <fieldset>
                <legend><?= __('Edit Activity Type') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('description');
                    echo $this->Form->control('color');
                    echo $this->Form->control('delivery_method');
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('featured');
                    echo $this->Form->control('createdby');
                    echo $this->Form->control('modifiedby');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

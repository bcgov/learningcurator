<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry $ministry
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ministry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ministry->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Ministries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="ministries form content">
            <?= $this->Form->create($ministry) ?>
            <fieldset>
                <legend><?= __('Edit Ministry') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('elm_learner_group');
                    echo $this->Form->control('description');
                    echo $this->Form->control('hyperlink');
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('color');
                    echo $this->Form->control('featured');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

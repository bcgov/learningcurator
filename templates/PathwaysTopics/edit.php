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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pathwaysTopic->pathway_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pathwaysTopic->pathway_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pathways Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathwaysTopics form content">
            <?= $this->Form->create($pathwaysTopic) ?>
            <fieldset>
                <legend><?= __('Edit Pathways Topic') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

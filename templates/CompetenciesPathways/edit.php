<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompetenciesPathway $competenciesPathway
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $competenciesPathway->competency_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $competenciesPathway->competency_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Competencies Pathways'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="competenciesPathways form content">
            <?= $this->Form->create($competenciesPathway) ?>
            <fieldset>
                <legend><?= __('Edit Competencies Pathway') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

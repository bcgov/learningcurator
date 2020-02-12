<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompetenciesUser $competenciesUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Competencies Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="competenciesUsers form content">
            <?= $this->Form->create($competenciesUser) ?>
            <fieldset>
                <legend><?= __('Add Competencies User') ?></legend>
                <?php
                    echo $this->Form->control('priority');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivitiesCompetency $activitiesCompetency
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Activities Competencies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesCompetencies form content">
            <?= $this->Form->create($activitiesCompetency) ?>
            <fieldset>
                <legend><?= __('Add Activities Competency') ?></legend>
                <?php
                    echo $this->Form->control('activity_id', ['options' => $activities]);
                    echo $this->Form->control('competency_id', ['options' => $competencies]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

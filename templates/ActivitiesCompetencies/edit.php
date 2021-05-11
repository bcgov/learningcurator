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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activitiesCompetency->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activitiesCompetency->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Activities Competencies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="activitiesCompetencies form content">
            <?= $this->Form->create($activitiesCompetency) ?>
            <fieldset>
                <legend><?= __('Edit Activities Competency') ?></legend>
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

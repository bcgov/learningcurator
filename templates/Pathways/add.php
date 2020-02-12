<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Pathways'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pathways form content">
            <?= $this->Form->create($pathway) ?>
            <fieldset>
                <legend><?= __('Add Pathway') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('color');
                    echo $this->Form->control('description');
                    echo $this->Form->control('objective');
                    echo $this->Form->control('file_path');
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('featured');
                    echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
                    echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
                    echo $this->Form->control('createdby');
                    echo $this->Form->control('modifiedby');
                    echo $this->Form->control('competencies._ids', ['options' => $competencies]);
                    echo $this->Form->control('steps._ids', ['options' => $steps]);
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

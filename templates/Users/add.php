<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->hidden('created', ['value' => date('Y-m-d H:i:s')]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('idir');
                    echo $this->Form->control('ministry_id', ['options' => $ministries]);
                    echo $this->Form->control('role_id', ['options' => $roles]);
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('activities._ids', ['options' => $activities]);
                    echo $this->Form->control('competencies._ids', ['options' => $competencies]);
                    echo $this->Form->control('pathways._ids', ['options' => $pathways]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

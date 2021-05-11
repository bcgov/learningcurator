<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesTopic $categoriesTopic
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Categories Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categoriesTopics form content">
            <?= $this->Form->create($categoriesTopic) ?>
            <fieldset>
                <legend><?= __('Add Categories Topic') ?></legend>
                <?php
                    echo $this->Form->control('category_id', ['options' => $categories]);
                    echo $this->Form->control('topic_id', ['options' => $topics]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

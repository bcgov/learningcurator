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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $categoriesTopic->category_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesTopic->category_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Categories Topics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categoriesTopics form content">
            <?= $this->Form->create($categoriesTopic) ?>
            <fieldset>
                <legend><?= __('Edit Categories Topic') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

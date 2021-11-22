<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry $ministry
 */
?>
<div class="container-fluid" id="colorful">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="m-5 p-5 bg-white rounded-lg shadow-sm">
<?= $this->Html->link(__('All Ministries'), ['action' => 'index'], ['class' => '']) ?>
    <h1>
        <?= h($ministry->name) ?> - 
        <span class="text-uppercase"><?= h($ministry->slug) ?></span>
    </h1>
    
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-5">
<div class="bg-white rounded-lg p-3 my-5">

    <?= $this->Html->link(__('Edit Ministry'), ['action' => 'edit', $ministry->id], ['class' => 'btn btn-dark']) ?>
    <?= $this->Form->postLink(__('Delete Ministry'), ['action' => 'delete', $ministry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ministry->id), 'class' => 'btn btn-warning']) ?>

    <table class="mt-3">

        <tr>
            <th><?= __('Elm Learner Group') ?></th>
            <td><?= h($ministry->elm_learner_group) ?></td>
        </tr>
        <tr>
            <th><?= __('Hyperlink') ?></th>
            <td><?= h($ministry->hyperlink) ?></td>
        </tr>
        <tr>
            <th><?= __('Image Path') ?></th>
            <td><?= h($ministry->image_path) ?></td>
        </tr>
        <tr>
            <th><?= __('Color') ?></th>
            <td><?= h($ministry->color) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ministry->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Featured') ?></th>
            <td><?= $this->Number->format($ministry->featured) ?></td>
        </tr>
    </table>
    <div class="text">
        <strong><?= __('Description') ?></strong>
        <blockquote>
            <?= $this->Text->autoParagraph(h($ministry->description)); ?>
        </blockquote>
    </div>
    <?php if(!empty($ministry->users)): ?>
    <h2>Learners in this ministry</h2>
    <?php foreach($ministry->users as $user): ?>
        <div class="px-2 py-1">
            <a href="/users/view/<?= $user->id ?>"><?= $user->username ?></a>
        </div>
    <?php endforeach ?>
    <?php endif ?>
</div>
</div>
</div>
</div>

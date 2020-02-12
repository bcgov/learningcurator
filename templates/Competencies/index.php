<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Competency[]|\Cake\Collection\CollectionInterface $competencies
 */
?>
<div class="row justify-content-md-center">
<div class="col-md-4">
<h1><?= __('Competencies') ?></h1>
<ul class="list-group">
<?php foreach ($competencies as $competency): ?>
<li class="list-group-item">
<?= $this->Html->link($competency->name, ['action' => 'view', $competency->id]) ?>
</li>
<?php endforeach; ?>
</ul>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>
</div>


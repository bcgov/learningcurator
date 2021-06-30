<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
$this->loadHelper('Authentication.Identity');
$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>

<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="py-5">
<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('New Question'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<?php endif ?>
<h1><?= __('Questions') ?></h1>
<div>Questions that we find are asked frequently.</div>
</div>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-6">
<div>
<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="bg-white rounded-lg p-3 my-3">
<h2><?= h($question->title) ?></h2>
<div><?= $question->content ?></div>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id]) ?>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="bg-white rounded-lg p-3 my-3">
    <div><span class="badge badge-warning"><?= h($question->status->name) ?></span></div>
    <h2><?= h($question->title) ?></h2>
    <div><?= $question->content ?></div>
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id]) ?>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>
</div>
</div>
</div>
</div>

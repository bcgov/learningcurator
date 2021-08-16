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
<?= $this->Html->link(__('New Question'), ['action' => 'add'], ['class' => 'btn btn-success float-right']) ?>
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
<?php if($role == 'curator' || $role == 'superuser'): ?>
    <div class="btn-group mt-3">
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id],['class'=>'btn btn-primary']) ?>
    <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'btn btn-danger']) ?>
</div>
<?php endif ?>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="bg-white rounded-lg p-3 my-3">
    <div><span class="badge badge-warning"><?= h($question->status->name) ?></span></div>
    <h2><?= h($question->title) ?></h2>
    <div><?= $question->content ?></div>
    <div class="btn-group mt-3">
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id],['class'=>'btn btn-primary']) ?>
    <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'btn btn-danger']) ?>
</div>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>
</div>
</div>
</div>
</div>

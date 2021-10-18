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
<h1 class="display-4"><?= __('Questions') ?></h1>
<div>Questions that we find are asked frequently.</div>
</div>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-3">
<div class="bg-white rounded-lg p-3 my-3">
<ul class="nav flex-column">
<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<li class="nav-item">
    <a class="nav-link" href="#<?= h($question->slug) ?>"><?= h($question->title) ?></a>
</li>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<li>
    <a href="#<?= h($question->slug) ?>"><?= h($question->title) ?></a> 
    <span class="badge badge-warning"><?= h($question->status->name) ?></span>
</li>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>
</ul>
</div>
</div>
<div class="col-md-6">

<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="bg-white rounded-lg p-3 my-3">
<h2 id="<?= h($question->slug) ?>"><?= h($question->title) ?></h2>
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
    <h2 id="<?= h($question->slug) ?>"><?= h($question->title) ?></h2>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
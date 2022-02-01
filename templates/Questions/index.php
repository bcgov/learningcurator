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

<div class="p-6 dark:text-white">
<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('New Question'), ['action' => 'add'], ['class' => 'btn btn-success float-right']) ?>
<?php endif ?>
<h1 class="text-4xl"><?= __('About') ?></h1>
<div class="mb-6">The Curator is a project from the Public Service Agency.</div>


<div class="md:flex">
<div class="basis-1/4 p-3">
<div class="md:sticky top-3 mt-3 bg-[#003366]">
<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="p-2 m-1 bg-slate-900 rounded-lg">
    <a class="" href="#<?= h($question->slug) ?>"><?= h($question->title) ?></a>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="p-2 my-1 bg-slate-900">
    <a href="#<?= h($question->slug) ?>"><?= h($question->title) ?></a> 
    <span class=""><?= h($question->status->name) ?></span>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>
</div>
</div>

<div class="basis-3/4 p-3">

<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="p-3 my-3 bg-white dark:bg-slate-900 rounded-lg">
<h2 class="text-2xl" id="<?= h($question->slug) ?>"><?= h($question->title) ?></h2>
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
<div class="p-3 my-3 bg-white dark:bg-slate-900 rounded-lg">
    <div><span class="badge badge-warning"><?= h($question->status->name) ?></span></div>
    <h2 class="text-2xl" id="<?= h($question->slug) ?>"><?= h($question->title) ?></h2>
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

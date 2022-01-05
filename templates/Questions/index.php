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

<div class="dark:text-white">
<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('New Question'), ['action' => 'add'], ['class' => 'btn btn-success float-right']) ?>
<?php endif ?>
<h1 class="text-4xl"><?= __('About') ?></h1>
<div class="mb-6">The Curator is a project from the Public Service Agency.</div>

<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="">
    <a class="" href="#<?= h($question->slug) ?>"><?= h($question->title) ?></a>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div>
    <a href="#<?= h($question->slug) ?>"><?= h($question->title) ?></a> 
    <span class=""><?= h($question->status->name) ?></span>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>


<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="p-3 my-3 bg-white dark:bg-gray-900 rounded-lg">
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
<div class="p-3 my-3 bg-white dark:bg-gray-900 rounded-lg">
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

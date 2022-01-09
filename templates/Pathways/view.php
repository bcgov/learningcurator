<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
$role = $this->Identity->get('role');
$uid = $this->Identity->get('id');
}

$this->assign('title', h($pathway->name));

?>

<div class="p-6 dark:text-white">
<?php if($pathway->status_id == 1): ?>
<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
<?php endif ?>
<nav class="bg-slate-200 dark:bg-slate-900 rounded-lg p-3" aria-label="breadcrumb">
	<a href="/categories/index">Categories</a> / 
	<?= $this->Html->link($pathway->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $pathway->topic->categories[0]->id]) ?> / 
	<?= $pathway->has('topic') ? $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id]) : '' ?> / 
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg> <?= h($pathway->name) ?>
</nav> 

<?php if(empty($followid)): ?>
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'mt-4 bg-green-300 dark:bg-green-700 rounded-lg p-3 text-center']) ?>
<?= $this->Form->end(); ?>
<?php endif ?>

<h1 class="text-4xl mt-4">
<!-- <?= h($pathway->id) ?>.  -->
<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
	<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
	<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
</svg>
<?= h($pathway->name) ?>
</h1>
<?php if($percentage > 0): ?>
<?php if($percentage < 10) {
	$percwidth = 10; 
 } else {
	 $percwidth = $percentage;
 } 
 ?>
<div class="my-3 w-full bg-slate-500 dark:bg-black rounded-lg">
<div class="mt-3 bg-green-300 dark:bg-green-700 dark:text-white text-center rounded-lg" style="width: <?= $percwidth ?>%;">
	<?= $percentage ?>% done
</div>
</div>
<?php endif ?>

<div class="text-2xl mt-3">
<?= $pathway->objective ?> 
</div>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
<?php endif ?>


<h2 class="mt-6 text-3xl dark:text-white">
	Modules
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-sm dark:bg-stone-700 rounded-full"><?= $requiredacts ?> activities</span>
</h2>
<?php if (!empty($pathway->steps)) : ?>
<?php foreach ($pathway->steps as $steps): ?>
<?php $requiredacts = 0; ?>
<?php foreach($steps->activities as $act): ?>
<?php if($act->_joinData->required == 1) $requiredacts++; ?>
<?php endforeach ?>
<div class="p-3 my-3 rounded-lg bg-slate-200 dark:bg-slate-900 dark:text-white">
<?php //echo '<pre>'; print_r($steps); continue; ?>
<?php if($steps->status->name == 'Published'): ?>
<h3 class="text-2xl">
	<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
		<?= h($steps->name) ?> 
	</a>
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-sm dark:bg-stone-700 rounded-full">
		<?= $requiredacts ?> activities
	</span>
</h3>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<!-- <div><span class=""><?= $steps->status->name ?></span></div> -->
<?php endif ?>
<div><?= $steps->description ?></div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div><span class="badge badge-warning"><?= $steps->status->name ?></span></div>
<h2>
<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
<?= h($steps->name) ?> 
</a>
</h2>
<?php endif; // if curator or admin ?>
<?php endif; // if published ?>
</div>
<?php endforeach ?>
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

</div>
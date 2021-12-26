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
$totalusers = count($usersonthispathway);
$this->assign('title', h($pathway->name));

?>

<div class="mt-4 dark:text-white">
<?php if($pathway->status_id == 1): ?>
<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
<?php endif ?>
<nav class="bg-slate-200 dark:bg-gray-600 rounded-lg p-3" aria-label="breadcrumb">
<a href="/categories/index">Categories</a> / 
<?= $this->Html->link($pathway->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $pathway->topic->categories[0]->id]) ?> / 
<?= $pathway->has('topic') ? $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id]) : '' ?> / 
<?= h($pathway->name) ?>
</nav> 
<h1 class="text-4xl mt-4">
<!-- <?= h($pathway->id) ?>.  -->
<?= h($pathway->name) ?>
</h1>
<div class="text-xl mt-4">
<?= $pathway->objective ?> 
</div>
<div class="mt-6">
<span class="inline-block px-2 bg-black text-white dark:bg-white dark:text-black rounded-full"><?= $requiredacts ?></span> required activities,
<span class="inline-block px-2 bg-black text-white dark:bg-white dark:text-black rounded-full"><?= $suppacts ?></span> supplemental
</div>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModal">
<?= $totalusers ?>  following
</button>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
<?php endif ?>
<?php if(in_array($uid,$usersonthispathway)): ?>
<div class="mt-5 bg-green-300 dark:bg-green-700 dark:text-white text-center rounded-lg" style="width: <?= $percentage ?>%;">
	<?= $percentage ?>% done
</div>
<?php else: ?>
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'btn btn-block btn-primary mb-0']) ?>
<?= $this->Form->end() ?>
<div class="py-3">
	Following a pathway allows you to track your progress and 
	pin the pathway to <a href="/">your profile</a>.
</div>
<?php endif ?>
</div>
<h2 class="mt-4 text-3xl dark:text-white">Modules</h2>
<?php if (!empty($pathway->steps)) : ?>
<?php foreach ($pathway->steps as $steps) : ?>
<div class="p-3 my-3 rounded-lg bg-white dark:bg-gray-900 dark:text-white">
<?php //echo '<pre>'; print_r($steps); continue; ?>
<?php if($steps->status->name == 'Published'): ?>
<h3 class="text-2xl">
	<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
		<?= h($steps->name) ?> 
	</a>
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


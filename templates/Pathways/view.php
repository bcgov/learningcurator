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

<nav class="mb-3 bg-slate-200 dark:bg-slate-900 rounded-lg p-3" aria-label="breadcrumb">
	<a href="/categories/index">Categories</a> / 
	<?= $this->Html->link($pathway->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $pathway->topic->categories[0]->id]) ?> / 
	<?= $pathway->has('topic') ? $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id]) : '' ?> / 
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg> <?= h($pathway->name) ?>
</nav> 


<h1 class="text-4xl">
<!-- <?= h($pathway->id) ?>.  -->
<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
	<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
	<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
</svg>
<?= h($pathway->name) ?>
</h1>


<div class="mt-3 py-4 px-10">

<div class="mb-6 text-2xl">
<?= $pathway->objective ?> 
</div>


<div
    x-cloak
    x-data="{status: [], 'isLoading': true}"
    x-init="fetch('/pathways/status/<?= $pathway->id ?>')
            .then(response => response.json())
            .then(response => { 
                    status = response; 
                    isLoading = false; 
                    //console.log(response); 
                })"
>
<div class="" x-show="isLoading">Loading&hellip;</div>
<div x-show="!isLoading">
	<div class="mb-6 w-full bg-slate-500 dark:bg-black rounded-lg">
		<span :style="'width:' + status.percentage + '%;'" class="progressbar h-6 inline-block bg-green-300 dark:bg-green-700 dark:text-white text-center rounded-lg">&nbsp;</span>
		<span x-text="status.percentage + '%'" class="beginning inline-block"></span>
	</div>
</div>
</div>

<?php if(empty($followid)): ?>
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]) ?>
<?= $this->Form->button(__('Pin to Profile'),['class' => 'mb-4 bg-green-300 dark:bg-green-700 rounded-lg p-3 text-center']) ?>
<?= $this->Form->end(); ?>
<?php endif ?>

</div> <!-- / objective contain -->

<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
<?php endif ?>


<h2 class="text-3xl dark:text-white">
	Modules
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-sm rounded-full"><?= $requiredacts ?> activities</span>
</h2>
<?php if (!empty($pathway->steps)) : ?>
<?php foreach ($pathway->steps as $steps): ?>
<?php $requiredacts = 0; ?>
<?php foreach($steps->activities as $act): ?>
<?php if($act->_joinData->required == 1) $requiredacts++; ?>
<?php endforeach ?>
<div class="p-6 my-3 rounded-lg bg-white dark:bg-slate-900 dark:text-white">
<?php //echo '<pre>'; print_r($steps); continue; ?>
<?php if($steps->status->name == 'Published'): ?>
<h3 class="text-2xl">
	<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
		<?= h($steps->name) ?> 
	</a>
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-sm rounded-full">
		<?= $requiredacts ?> activities
	</span>
</h3>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<div><?= $steps->status->name ?></span></div>
<?php endif ?>


<div class="mt-3 p-3 bg-slate-200 dark:bg-[#002850] text-xl rounded-lg">
	<?= $steps->description ?>
</div>


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
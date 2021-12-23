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

<nav aria-label="breadcrumb">
<?= $this->Html->link($pathway->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $pathway->topic->categories[0]->id]) ?> / 
<?= $pathway->has('topic') ? $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id]) : '' ?> / 
<?= h($pathway->name) ?>
</nav> 
<h1 class="text-4xl mt-4">
<?= h($pathway->name) ?>
</h1>
<div class="text-xl mb-4">
<?= $pathway->objective ?> 
</div>


<?php if($role == 'curator' || $role == 'superuser'): ?>
<button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModal">
<?= $totalusers ?>  following
</button>
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
<?php endif ?>
<?php if(in_array($uid,$usersonthispathway)): ?>


<div>Overall Progress: <span class="mb-3 following"></span>%</div>


<?php else: ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'btn btn-block btn-primary mb-0']) ?>

<?= $this->Form->end() ?>

<div class="py-3">
Following a pathway allows you to track your progress and pin the pathway to <a href="/profile/pathways">your profile</a>.
</div>

<?php endif ?>


</div>
<h2 class="mt-4 text-3xl dark:text-white">Modules</h2>
<?php if (!empty($pathway->steps)) : ?>

<?php foreach ($pathway->steps as $steps) : ?>

<?php 


$defunctacts = array();
$requiredacts = array();
$supplementalacts = array();
$acts = array();

$totalacts = count($steps->activities);
$stepclaimcount = 0;

foreach ($steps->activities as $activity) {
	//print_r($activity);
	// If this is 'defunct' then we pull it out of the list 
	if($activity->status_id == 3) {
		array_push($defunctacts,$activity);
	} elseif($activity->status_id == 2) {
		// if it's required
		if($activity->_joinData->required == 1) {
			array_push($requiredacts,$activity);
		// Otherwise it's supplemental
		} else {
			array_push($supplementalacts,$activity);
		}
		array_push($acts,$activity);
		if(in_array($activity->id,$useractivitylist)) {
			$stepclaimcount++;
		}
	}
}

$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);
$completeclass = 'notcompleted'; 
if($stepclaimcount == $totalacts) {
	$completeclass = 'completed';
}

if($stepclaimcount > 0) {
	$steppercent = ceil(($stepclaimcount * 100) / $stepacts);
} else {
	$steppercent = 0;
}
?>

<div class="p-3 my-3 rounded-lg bg-white dark:bg-gray-900 dark:text-white">
<?php if($steps->status->name == 'Published'): ?>

<h3 class="text-2xl">
<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
<?= h($steps->name) ?> 
<i class="bi bi-arrow-right-circle-fill"></i>
</a>
</h3>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div><span class=""><?= $steps->status->name ?></span></div>
<?php endif ?>
<div><?= $steps->description ?></div>

<div class="my-3">
<span class=""><?= $totalacts ?> total activities</span> 
<span class=""><?= $stepacts ?> required</span>
<span class=""><?= $supplmentalcount ?> supplemental</span>
</div>

<div class="progress progress-bar-striped mb-3" style="height: 26px;">
<div class="progress-bar" role="progressbar" style="background-color: #000 color: #FFF; width: <?= $steppercent ?>%" aria-valuenow="<?= $steppercent ?>" aria-valuemin="0" aria-valuemax="100">
<?= $steppercent ?>% done
</div>
</div>

<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>

<div><span class="badge badge-warning"><?= $steps->status->name ?></span></div>
<h2>
<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
<?= h($steps->name) ?> 
<i class="fas fa-arrow-circle-right"></i>
</a>
</h2>
<div style="font-size; 130%"><?= $steps->description ?></div>
<div class="my-3">
<span class=""><?= $totalacts ?> total activities</span> 
<span class=""><?= $stepacts ?> required</span>
<span class=""><?= $supplmentalcount ?> supplemental</span>
</div>

<?php endif; // if curator or admin ?>
<?php endif; // if published ?>
</div>
<?php endforeach ?>
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>


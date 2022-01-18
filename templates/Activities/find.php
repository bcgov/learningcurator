<?php

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}

?>

<div class="p-6 dark:text-white">
<h1 class="text-3xl">Searching for &quot;<?= $search ?>&quot;</h1>

<div class="flex flex-row">

<?php if($numcats > 0): ?>
<div class="basis-1/3 p-3">
<h2 class="text-2xl">Found <span class="badge badge-dark"><?= $numcats ?></span> categories</h2>
<?php foreach($categories as $c): ?>
<div class="p-3 my-3 rounded-lg bg-slate-200 dark:bg-slate-900">
	<h3 class="text-xl">
		<a href="/categories/view/<?= $c->id ?>">
			<?= $c->name ?>
		</a>
	</h3>
	<div>
		<?= $c->description ?>
	</div>
</div>
<?php endforeach ?>
</div>
<?php endif ?>




<?php if($numpaths > 0): ?>
<div class="basis-1/3 p-3">
<h2 class="text-2xl">Found <span class="badge badge-dark"><?= $numpaths ?></span> pathways</h2>
<?php foreach($pathways as $p): ?>
<div class="p-3 my-3 rounded-lg bg-slate-200 dark:bg-slate-900">
	<h3 class="text-xl">
		<a href="/pathways/<?= $p->slug ?>">
			<?= $p->name ?>
		</a>
	</h3>
	<div>
		<?= $p->description ?>
	</div>
</div>
<?php endforeach ?>
</div>
<?php endif ?>




<?php if($numacts > 0): ?>
<div class="basis-1/3 p-3">
	<h2 class="text-2xl">Found <span class="badge badge-dark"><?= $numacts ?></span> activities</h2>
	<?php 
	//echo '<pre>';
	foreach($activities as $activity): 
		//print_r($activity); continue;
	?>
	<div class="p-3 my-3 rounded-lg bg-slate-200 dark:bg-slate-900">

	<h3 class="text-xl">
		<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>
	</h3>
	<!-- <div class="py-3 ">
		<?= $activity->description ?>
	</div> -->
	<?php if(!empty($activity->steps)): ?>
	<div class="p-3 mb-3 bg-white dark:bg-slate-800 rounded-lg">This activity is on the following pathways:
	<?php foreach($activity->steps as $step): ?>
	<?php foreach($step->pathways as $path): ?>
	<span class="badge badge-light"><a href="/steps/view/<?= $step->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
	<?php endforeach ?>
	<?php endforeach ?>
	</div>
	<?php endif ?>
	</div>
	<?php endforeach; ?>
</div>
<?php endif ?>


</div> <!-- /.row -->
</div> <!-- /.container -->
<?php

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}

?>

<div class="p-6">
<h1 class="text-3xl">Searching for &quot;<?= $search ?>&quot;</h1>
<?php if(!$numcats && !$numpaths && !$numacts): ?>
	<div class="py-3">

		<div class="mb-3 bg-gray-100 p-3 border-2 rounded-lg">No results found.</div>
		
		<form method="get" action="/find" class="w-fit flex" role="search">
			<label for="search" class="sr-only">Search</label>
			<input x-ref="input" 
					placeholder="Search again"
					required 
					class="w-40 bg-white text-sm text-slate-700 rounded-l-md ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-700" 
					type="search" 
					aria-label="Search" 
					name="search" 
					id="search">
			<button title="Click here or press Enter to search" 
					class="bg-white text-sm leading-6 text-slate-700 ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-700 rounded-r-lg" 
					type="submit">
				<svg width="24" height="24" fill="none" aria-hidden="true" class="flex-none">
					<path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
					<circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
				</svg>
			</button>
		</form>
	
	</div>
<?php endif ?>
<div class="flex flex-col">

<?php if($numcats > 0): ?>
<div class="p-3">
<h2 class="text-2xl">Found <span class="badge badge-dark"><?= $numcats ?></span> categories</h2>
<?php foreach($categories as $c): ?>
<div class="p-3 my-3 rounded-lg bg-slate-200">
	<h3 class="text-xl">
		<a href="/categories/view/<?= $c->id ?>">
			<?= $c->name ?>
		</a>
	</h3>
</div>
<?php endforeach ?>
</div>
<?php endif ?>




<?php if($numpaths > 0): ?>
<div class="p-3">
<h2 class="text-2xl">Found <span class="badge badge-dark"><?= $numpaths ?></span> pathways</h2>
<?php foreach($pathwaywithsteps as $p): ?>
<div class="p-3 my-3 rounded-lg bg-slate-200">
	<h3 class="text-xl">
		<a href="/pathways/<?= $p[0][2] ?>">
			<?= $p[0][1] ?>
		</a>
	</h3>
	<div><?= $p[0][3] ?></div>
	<?php foreach($p[1] as $step): ?>
		<?= $step[1] ?> - <?= $step[3] ?><br>
	<?php endforeach ?>
</div>
<?php endforeach ?>
</div>
<?php endif ?>


<?php if($numacts > 0): ?>
<div class="p-3">
	<h2 class="text-2xl">Found <span class="badge badge-dark"><?= $numacts ?></span> activities</h2>
	<?php 
	//echo '<pre>';
	foreach($activities as $activity): 
		//print_r($activity); continue;
	?>
	<div class="p-3 my-3 rounded-lg bg-slate-200">

	<h3 class="text-xl">
		<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>
	</h3>
	<!-- <div class="py-3 ">
		<?= $activity->description ?>
	</div> -->

	</div>
	<?php endforeach; ?>
</div>
<?php endif ?>


</div> <!-- /.row -->
</div> <!-- /.container -->
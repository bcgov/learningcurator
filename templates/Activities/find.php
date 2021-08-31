<?php

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-12">
<div class="py-5">
<h1>Searching for &quot;<?= $search ?>&quot;</h1>
<div>Found <span class="badge badge-dark"><?= $numresults ?></span> activities</div>
<div class="py-3">
	<form method="get" action="/activities/find" class="form-inline">
		<input class="form-control mr-sm-2" type="search" placeholder="Search again" aria-label="Search" name="search">
		<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	</form>
</div>
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-7">
<?php 
//echo '<pre>';
foreach($activities as $activity): 
	//print_r($activity); continue;
?>

<div class="rounded-lg bg-white">
<div class="p-3 my-3 rounded-lg" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2)">
<div class="activity-icon activity-icon-lg" style="background-color: rgba(<?= $activity->activity_type->color ?>,1)">
			<i class="activity-icon activity-icon-lg <?= $activity->activity_type->image_path ?>"></i>
	</div>
<h3>
	<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
	<?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>
</h3>
<div class="py-3 ">
	<?= $activity->description ?>
</div>
<?php if(!empty($activity->steps)): ?>
<div class="p-3 mb-3 bg-white rounded-lg">This activity is on the following pathways:
<?php foreach($activity->steps as $step): ?>
<?php foreach($step->pathways as $path): ?>
<span class="badge badge-light"><a href="/steps/view/<?= $step->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
<?php endforeach ?>
<?php endforeach ?>
</div>
<?php endif ?>

</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
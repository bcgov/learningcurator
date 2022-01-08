<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
*/

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<style>

.pagination {
	background-color; rgba(255,255,255,.5);
}
.page-item.active .page-link {
	background-color: #000;
	color; #FFF;
}
</style>
<div class="dark:text-white">
<h1>Activities</h1>
<p>The 30 most recently added activities.</p>
<form method="get" action="/activities/find" class="form-inline my-2 my-lg-0 mr-3" role="search">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="search">
		<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	</form>
</div>

<?php foreach ($activities as $activity) : ?>
	
	<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">

	<h3 class="my-3 text-3xl">
		<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
	</h3>



		<?= $activity->description ?>

		<?php if(!empty($activity->_joinData->stepcontext)): ?>
		<div class="">
				Curator says:<br>
				<?= $activity->_joinData->stepcontext ?>
			</div>
			<?php endif ?>

		<a target="_blank" 
			rel="noopener" 
			data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
			href="<?= $activity->hyperlink ?>" 
			class="">
				Launch
		</a>
		

	<?php if(!empty($activity->steps)): ?>
	<div class="mt-2">

		<?php foreach($activity->steps as $step): ?>
			<?php if(!empty($step->pathways[0]->slug)): ?>
			Pathways in: 
			<a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
				<i class="bi bi-pin-map-fill"></i>
				<?= $step->pathways[0]->name ?> - 
				<?= $step->name ?>
			</a>
			<?php endif ?>
		<?php endforeach ?>

	</div>
	<?php endif ?>


	</div>


	<?php endforeach; // end of activities loop for this step ?>


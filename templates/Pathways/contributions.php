<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
$this->assign('title', 'Pathways you follow');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">

<div class="py-5">
	
	<div class="systemrole">
	<?php if($role == 'curator'): ?>
		 <span class="badge badge-success">Curator</span>
	<?php elseif($role == 'superuser'): ?>
		<span class="badge badge-success">Super User</span>
	<?php endif ?>
	</div>
	<h1 class="display-4">
		Welcome <?= $this->Identity->get('first_name') ?>
	</h1>

</div>
<div class="nav nav-pills justify-content-center">
    <a class="nav-link" href="/profile/pathways">Pathways</a> 
    <a class="nav-link" href="/profile/claims">Claims</a> 
    <a class="nav-link" href="/profile/reports">Reports</a> 
    <a class="nav-link active" href="/profile/contributions">Contributions</a> 
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-12 col-lg-12 col-xl-8">
<h2><?= __('Your Contributions') ?></h2>
</div>
<div class="w-100"></div>
<div class="col-md-6 col-lg-6 col-xl-4">
<h3>Pathways</h3>
<?php if(!$pathways->isEmpty()): ?>

<?php foreach ($pathways as $pathway): ?>
<div class="p-3 mb-2 bg-white rounded-lg">
	
	<div>
		<a href="/pathways/<?= h($pathway->slug) ?>" class="font-weight-bold">
			<i class="bi bi-pin-map-fill"></i>
			<?= h($pathway->name) ?>
		</a>
</div>
<div>
	<span class=""><?= $pathway->status->name ?></span> in 
	<?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id],['class' => '']) ?>
</div>
</div>
<?php endforeach ?>
<?php else: ?>
	<div class="p-3 mb-2 bg-white rounded-lg">
	<p><strong>You have yet to contribute any pathways.</strong></p>
	<p>If you want to work with us, we're always looking for help!</p>
	</p>
	</div>
<?php endif ?>

</div>
<div class="col-md-6 col-lg-6 col-xl-4">
<h3>Activities</h3>
<?php if(!$activities->isEmpty()): ?>
<div class="">
<?php foreach ($activities as $a): ?>
<div class="p-3 mb-2 bg-white rounded-lg">
	<div>
		<i class="bi <?= $a->activity_type->image_path ?>"></i>
		<a href="/activities/view/<?= $a->id ?>" class="font-weight-bold"><?= h($a->name) ?></a>
	</div>
	<?= $a->status->name ?>
	<?php if(!empty($a->steps)): ?> in <?php endif ?>
	<?php foreach($a->steps as $step): ?>
	<?php if(!empty($step->pathways[0]->slug)): ?>
	<a href="/pathways/<?= h($step->pathways[0]->slug) ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
		<?= h($step->pathways[0]->name) ?> - <?= h($step->name) ?>
	</a>
	<?php endif ?>
	<?php endforeach ?>
</div>
<?php endforeach ?>
</div>
<?php else: ?>
	<div class="p-3 mb-2 bg-white rounded-lg">
	<p><strong>You have yet to contribute any activities.</strong></p>
	<p>If you want to work with us, we're always looking for help!</p>
	</p>
	</div>
<?php endif ?>
</div>
</div>
</div>



</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

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


<div class="p-6">
	
<div class="p-3 mb-2 bg-slate-200 dark:bg-slate-900/80 rounded-lg">

<h2><?= __('Your Contributions') ?></h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<?php if(!$pathways->all()->isEmpty()): ?>


<div>
<h3>Pathways</h3>
<?php foreach ($pathways as $pathway): ?>
<div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
	
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
</div>
<?php else: ?>
<div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
	<p><strong>You have yet to contribute any pathways.</strong></p>
	<p>If you want to work with us, we're always looking for help!</p>
</div>
<?php endif ?>

<?php if(!$activities->all()->isEmpty()): ?>
<div>
<h3>Activities</h3>
<div class="overflow-auto h-96">
<?php foreach ($activities as $a): ?>
<div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
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
	<div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
	<p><strong>You have yet to contribute any activities.</strong></p>
	<p>If you want to work with us, we're always looking for help!</p>
	</p>
	</div>
<?php endif ?>
</div>
</div>


</div>
</div>


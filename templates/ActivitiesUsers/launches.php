<?php  
$this->assign('title', 'Activities you\'ve claimed');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
$role = $this->Identity->get('role');
$uid = $this->Identity->get('id');
}
?>

<div class="p-6 dark:text-white">

<div class="p-3 mb-2 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">
<?php if(!empty($alllaunches)): ?>
<?php foreach($alllaunches as $a): ?>

<div class="p-3 mb-3 bg-white dark:bg-slate-800 rounded-lg">
<h2 class="text-2xl">
	<a href="/activities/view/<?= $a['id'] ?>" class="font-weight-bold">
		<?= $a['name'] ?>
	</a>
</h2>
<div class="mt-3">
	<div class="inline-block w-24 bg-slate-900 text-white text-sm text-center uppercase rounded-lg">
		Launched
	</div>
	<?php foreach($a['launches'] as $ls): ?>
	<span class="inline-block px-3 py-0 mb-2 tex-lg bg-slate-200 dark:bg-slate-700 text-sm rounded-lg">
		<?= $this->Time->format($ls['date'],\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
	</span>
	<?php endforeach ?>

</div>

</div>
<?php endforeach ?>
<?php else: ?>
	<div class="p-3 mb-2 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">

		<h2 class="mb-3 text-3xl">You've not yet launched any activities</h2>
		<div class="p-4 bg-white dark:bg-slate-800 rounded-lg">
		<p>As you launch activities on a pathway, they will be recorded here 
			along with the date and time that you clicked the launch button.</p>
		<p>Pathway modules have one or more required activities. When you launch
			a required activity, that action counts towards your pathway progress,
			indicated by the progress bar.</p> 
		</div>
		
		<a href="/categories" class="inline-block p-3 mt-4 bg-sky-700 dark:bg-sky-700 text-white text-2xl hover:no-underline rounded-lg">
			Explore Categories
		</a>

	</div>




<?php endif ?>
</div>
</div>
</div>
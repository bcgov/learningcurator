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
<a target="_blank" 
	rel="noopener" 
	data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
	href="/activities-users/launch?activity_id=<?= $a['id'] ?>" 
	class="inline-block my-2 p-3 bg-sky-700 rounded-lg text-white text-xl hover:no-underline">
		Launch Activity 
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
			<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
		</svg>
</a>

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
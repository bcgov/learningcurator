<?php  
$this->assign('title', 'Activities you\'ve claimed');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
$role = $this->Identity->get('role');
$uid = $this->Identity->get('id');
}
?>

<div class="p-6 dark:text-white">
<div @click.away="open = false" class="relative ml-8" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-sm font-semibold text-right bg-slate-200 rounded-t-lg dark:bg-slate-900 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-900 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		<span>Profile Menu</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full origin-top-right shadow-lg">
	<div class="-ml-8 p-6 bg-white rounded-md shadow dark:bg-slate-900">
		<a href="/profile" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-slate-900 dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Pinned Pathways
		</a> 
		<a href="/profile/completions" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-[#003366] dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Completed Activities
		</a> 
		<a href="/profile/reports" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Issues Reported
		</a> 
		    
    	<a href="/logout" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Logout
		</a>
    
	</div>
	</div>
</div>
<div class="p-6 rounded-lg activity bg-slate-200 dark:bg-slate-900 dark:text-white">
<h1 class="mb-3 text-lg">Completed Activities</h1>
<?php if(!$activities->isEmpty()): ?>
<?php foreach($activities as $a): ?>

<div class="p-3 mb-3 bg-white dark:bg-slate-800 rounded-lg">
<?= $this->Form->postLink(__('Un-complete'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $a['id']], ['class' => 'float-right p-3 ml-3 bg-slate-300 no-underline rounded-lg', 'confirm' => __('Unclaim?')]) ?>
<h2 class="text-2xl">
<a href="/activities/view/<?= $a['activity']['id'] ?>" class="font-weight-bold">
	<?= $a['activity']['name'] ?>
</a>
</h2>
<div class="">
<div>Claimed on: <?= $this->Time->format($a['created'],\IntlDateFormatter::MEDIUM,null,'GMT-8') ?></div>

<?php foreach($a['activity']['steps'] as $s): ?>
<?php if(!empty($s->pathways[0]->slug)): ?>
<?php if($s->pathways[0]->status_id == 2): ?>
<div class="my-1">Included in 
<a href="/pathways/<?= $s->pathways[0]->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>" class="font-weight-bold">
<i class="bi bi-pin-map-fill"></i>
<?= $s->pathways[0]->name ?> - <?= $s->name ?>
</a>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach ?>
</div>

</div>
<?php endforeach ?>
<?php else: ?>

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">
<p><strong>You've not yet claimed any activities.</strong></p>
<p>You can claim activities along a pathway. Doing so allows you to see how much of the path you have completed.</p>
</div>
<?php endif ?>
</div>
</div>
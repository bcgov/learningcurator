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
		<a href="/profile" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-slate-900 dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline hover:no-underline">
			Followed Pathways
		</a> 
		<a href="/profile/launches" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-[#003366] dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline hover:no-underline">
			Launched Activities
		</a> 
		<a href="/profile/reports" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline hover:no-underline">
			Issues Reported
		</a> 
		    
    	<a href="/logout" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline hover:no-underline">
			Logout
		</a>
    
	</div>
	</div>
</div>
<div class="p-6 rounded-lg activity bg-slate-200 dark:bg-slate-900 dark:text-white">

<h1 class="mb-3 text-lg">Launched Activities</h1>


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

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">
<p><strong>You've not yet lanuched any activities.</strong></p>
<p>As you launch activities on a pathway, they will be recorded here 
	along with the date and time that you clicked the launch button.</p>
<p>Pathway modules have one or more required activities. When you launch
	a required activity, that action counts towards your pathway progress,
	indicated by the progress bar.</p> 
</div>
<?php endif ?>
</div>
</div>
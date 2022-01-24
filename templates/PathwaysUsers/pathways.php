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

<div class="px-6 dark:text-white">


<div @click.away="open = false" class="relative ml-4 mt-4" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-sm font-semibold text-right bg-gray-600 text-white rounded-t-lg dark:bg-slate-900 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		<span>Profile Menu</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" 
			x-transition:enter="transition ease-out duration-100" 
			x-transition:enter-start="transform opacity-0 scale-95" 
			x-transition:enter-end="transform opacity-100 scale-100" 
			x-transition:leave="transition ease-in duration-75" 
			x-transition:leave-start="transform opacity-100 scale-100" 
			x-transition:leave-end="transform opacity-0 scale-95" 
			class="absolute right-0 w-full origin-top-right p-4 bg-slate-800 shadow-lg">

		<a href="/profile" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-slate-900 dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Pinned Pathways
		</a> 
		<a href="/profile/claims" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Completed Activities
		</a> 
		<a href="/profile/reports" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Issues Reported
		</a> 
	</div>
</div>









<div class="p-3 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">
<?php if (!$pathways->isEmpty()) : ?>
	
	<?php foreach ($pathways as $path) : ?>
        
	<div class="p-3 mb-3 bg-slate-200 dark:bg-slate-800 rounded-lg">

		<div>
			<?= $path->pathway->has('category') ? $this->Html->link($path->pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $path->pathway->category->id]) : '' ?>
		</div>
		
    	<h2 class="text-2xl mb-3">
			<a href="/pathways/<?= $path->pathway->slug ?>" class="font-weight-bold">
				<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
					<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
					<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
				</svg>
				<?= $path->pathway->name ?>
			</a>
		</h2>

		<!-- <div class="bg-light "><?= h($path->pathway->objective) ?></div> -->
		<div>Followed on:
		<?= $this->Time->format($path->date_start,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		</div>
		<?php if(!empty($path->date_complete)): ?>
		<div>
			Completed:
			<?= $this->Time->format($path->date_complete,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		</div>
		<?php endif ?>


		<div x-cloak
			x-data="{status<?= $path->pathway->id ?>: [], 'isLoading': true}"
			x-init="fetch('/pathways/status/<?= $path->pathway->id ?>')
					.then(response<?= $path->pathway->id ?> => response<?= $path->pathway->id ?>.json())
					.then(response<?= $path->pathway->id ?> => { 
							status<?= $path->pathway->id ?> = response<?= $path->pathway->id ?>; 
							isLoading = false; 
							//console.log(response); 
						})"
		>
		<div class="" x-show="isLoading">Loading your progress on this pathway&hellip;</div>
		<div x-show="!isLoading">
			<div class="my-4 h-6 w-full bg-slate-500 dark:bg-black rounded-lg">
				<span :style="'width:' + status<?= $path->pathway->id ?>.percentage + '%;'" class="progressbar h-6 inline-block bg-green-300 dark:bg-green-700 dark:text-white text-center rounded-lg">&nbsp;</span>
				<span x-text="status<?= $path->pathway->id ?>.percentage + '%'" class="beginning inline-block"></span>
			</div>
		</div>
		</div>


<?php 
echo $this->Form->postLink(__('Un-Pin'), 
								['controller' => 'PathwaysUsers', 'action' => 'delete/'. $path->id], 
								['class' => 'inline-block p-3 bg-[#003366] rounded-lg', 'title' => 'Stop seeing your progress on this pathway', 'confirm' => __('Really un-pin?')]); 
?>

	</div>
	<?php endforeach; ?>
	
<?php else: ?>


	<div class="p-3 mb-2 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">

		<h2 class="mb-3 text-3xl">Get Started</h2>
		<div class="p-4 bg-[#003366]/50 rounded-lg">
			<p>Curator pathways are organized into topics and 
			topics are categorized. You can see all the pathways we have to offer, but you can also 
			pin a pathway to your profile to access it quickly.</p>
			<p>As you complete activities contained in a pathway you'll be able to see your progress here too.</p>
		</div>
		
		<a href="/categories" class="inline-block p-3 my-6 bg-slate-300 dark:bg-green-700 text-lg rounded-lg">
			View Categories
		</a>

	</div>


<?php endif ?>

</div>
</div>
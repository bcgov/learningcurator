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

<div class="p-6 dark:text-white">



<div class="p-6 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">

<?php if (!$pathways->isEmpty()) : ?>
	<h1 class="mb-3 text-lg sr-only">Followed Pathways</h1>	
	<?php foreach ($pathways as $path) : ?>
        
	<div class="p-3 mb-3 bg-white dark:bg-slate-800 rounded-lg">
	<?php 
	echo $this->Form->postLink(__('Un-Follow'), 
									['controller' => 'PathwaysUsers', 'action' => 'delete/'. $path->id], 
									['class' => 'float-right inline-block p-3 bg-sky-700 hover:bg-sky-800 text-white hover:no-underline rounded-lg', 'title' => 'Stop seeing your progress on this pathway', 'confirm' => __('Really un-pin?')]); 
	?>
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

		<div class="bg-light "><?= h($path->pathway->objective) ?></div>
		<!-- <div>Followed on:
		<?= $this->Time->format($path->date_start,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		</div> -->
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
			<div class="my-4 h-6 w-full bg-slate-300 dark:bg-black rounded-lg ">
				<span :style="'width:' + status<?= $path->pathway->id ?>.percentage + '%;'" class="progressbar h-6 inline-block bg-sky-700 dark:bg-sky-700 dark:text-white text-center rounded-lg">&nbsp;</span>
				<span x-text="status<?= $path->pathway->id ?>.percentage + '%'" class="beginning inline-block"></span>
			</div>
		</div>
		</div>


	</div>
	<?php endforeach; ?>
	
<?php else: ?>


	<div class="p-3 mb-2 bg-slate-100 rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">

		<h2 class="mb-3 text-3xl">Get Started</h2>
		<div class="p-4 bg-white dark:bg-slate-800 rounded-lg">
			<p class="mb-3 text-xl">
				Curator pathways are organized into 
				<a href="/categories" class="underline">categories</a> and then topics.
				You can explore 
				<a href="/pathways" class="underline">all the pathways</a>
				we have to offer and when you see one you like, you can 
				follow it. When you follow a pathway, it will be listed 
				here, so the next time you login, you can jump right to it.
			</p>
			<p class="text-lg">As you launch activities contained in a pathway you'll be able to see your progress here too.</p>
		</div>
		
		<a href="/categories" class="inline-block p-3 mt-4 bg-sky-700 dark:bg-sky-700 text-white text-2xl hover:no-underline rounded-lg">
			Explore Categories
		</a>

	</div>


<?php endif ?>

</div>
</div>
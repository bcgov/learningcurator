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


<?php if (!$pathways->isEmpty()) : ?>
	<div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-lg">
	<h1 class="mb-3 text-lg sr-only">Followed Pathways</h1>	
	<?php foreach ($pathways as $path) : ?>
        
	<div class="p-3 mb-3 bg-white dark:bg-slate-800 rounded-lg">
	<?php 
	echo $this->Form->postLink(__('Un-Follow'), 
									['controller' => 'PathwaysUsers', 'action' => 'delete/'. $path->id], 
									['class' => 'float-right inline-block p-3 bg-sky-700 hover:bg-sky-800 text-white hover:no-underline rounded-lg', 'title' => 'Stop seeing your progress on this pathway', 'confirm' => __('Really un-pin?')]); 
	?>

		<a href="/category/<?= $path->pathway->topic->categories[0]->id ?>/<?= $path->pathway->topic->categories[0]->slug ?>"><?= $path->pathway->topic->categories[0]->name ?></a> 
		<a href="/category/<?= $path->pathway->topic->categories[0]->id ?>/<?= $path->pathway->topic->categories[0]->slug ?>/topic/<?= $path->pathway->topic->id ?>/<?= $path->pathway->topic->slug ?>"><?= $path->pathway->topic->name ?>
    	<h2 class="text-2xl mb-3">
			<a href="/<?= $path->pathway->topic->categories[0]->slug ?>/<?= $path->pathway->topic->slug ?>/pathway/<?= $path->pathway->slug ?>" class="font-weight-bold">
				<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
					<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
					<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
				</svg>
				<?= $path->pathway->name ?>
			</a>
		</h2>

		<div class="p-4 text-xl bg-slate-100 dark:bg-slate-900 rounded-lg">
			<div class="text-xs">Objective</div>
			<?= h($path->pathway->objective) ?>
		</div>
		<!-- <div>Followed on:
		<?= $this->Time->format($path->date_start,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		</div> -->
		<?php if(!empty($path->date_complete)): ?>
		<div>
			Completed:	
			<?= $this->Time->format($path->date_complete,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		</div>
		<?php endif ?>


		<div class="pbarcontainer<?= $path->pathway->id ?> sticky top-0 my-1 w-full h-8 bg-slate-50 dark:bg-slate-900 rounded-lg">
			<span class="inline-block pbar<?= $path->pathway->id ?> pt-1 px-6 h-8 bg-sky-700 text-white rounded-lg"></span>
		</div>
		<script>

		fetch('/pathways/status/<?= $path->pathway->id ?>', { method: 'GET' })
			.then((res<?= $path->pathway->id ?>) => res<?= $path->pathway->id ?>.json())
			.then((json<?= $path->pathway->id ?>) => {
				if(json<?= $path->pathway->id ?>.percentage > 0) {
					let message = json<?= $path->pathway->id ?>.percentage + '% - ' + json<?= $path->pathway->id ?>.completed + ' of ' + json<?= $path->pathway->id ?>.requiredacts;
					if(json<?= $path->pathway->id ?>.percentage > 25) {
						document.querySelector('.pbar<?= $path->pathway->id ?>').style.width = json<?= $path->pathway->id ?>.percentage + '%';
					} 
					if(json<?= $path->pathway->id ?>.percentage == 100) {
						document.querySelector('.pbar<?= $path->pathway->id ?>').innerHTML = message + ' - COMPLETED!';
					} else {
						document.querySelector('.pbar<?= $path->pathway->id ?>').innerHTML = message;
					}
				} else {
					document.querySelector('.pbarcontainer<?= $path->pathway->id ?>').innerHTML = ''; //'<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>';
				}
				//console.log(json);
			})
			.catch((err) => console.error("error:", err));

		</script>

        <a href="/pathways/<?= h($path->pathway->slug) ?>" 
            class="inline-block p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                View Pathway
        </a>


	</div>
	<?php endforeach; ?>
	</div>
<?php else: ?>


	<div class="p-3 mb-2 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">

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
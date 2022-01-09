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

<div class="px-6">

<h1 class="mt-6 text-2xl dark:text-white">
	Welcome <?= $this->Identity->get('first_name') ?>
</h1>

<div class="systemrole">
<?php if($role == 'curator'): ?>
<span class="dark:text-white">Curator</span>
<?php elseif($role == 'superuser'): ?>
<span class="dark:text-white">Super User</span>
<?php endif ?>
</div>

<div class="mt-3 ml-6">
    <a href="/profile" class="inline-block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-t-lg dark:bg-slate-900 dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		My Pathways
	</a> 
    <a href="/profile/claims" class="inline-block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">My Activities</a> 
    <a href="/profile/reports" class="inline-block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-[#003366] dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">My Issues</a> 
</div>
<div class="p-3 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">
<?php if (!$pathways->isEmpty()) : ?>
	
	<?php foreach ($pathways as $path) : ?>
        
	<div class="p-3 mb-3 bg-slate-200 dark:bg-slate-800 rounded-lg">

		<?php //$this->Form->postLink(__('Unfollow'), ['controller' => 'PathwaysUsers','action' => 'delete/'. $path->pathway->_joinData->id], ['class' => 'btn btn-primary float-right', 'confirm' => __('Really unfollow?')]) ?>
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

		<div class="my-3 w-full bg-slate-500 dark:bg-black rounded-lg">
			<span class="progressbar<?= $path->pathway->id ?> inline-block bg-green-300 dark:bg-green-800 dark:text-white text-center rounded-lg"></span>
			<span class="beginning<?= $path->pathway->id ?> inline-block"></span>
		</div>
		<script>
		var request<?= $path->pathway->id ?> = new XMLHttpRequest();
		request<?= $path->pathway->id ?>.open('GET', '/pathways/status/<?= $path->pathway->id ?>', true);
		request<?= $path->pathway->id ?>.onload = function() {
			if (this.status >= 200 && this.status < 400) {
				var data<?= $path->pathway->id ?> = JSON.parse(this.response);
				if(data<?= $path->pathway->id ?>.percentage > 0) {
					let percwid = data<?= $path->pathway->id ?>.percentage;
					if(percwid < 10) {
						document.querySelector('.beginning<?= $path->pathway->id ?>').innerHTML = data<?= $path->pathway->id ?>.percentage + '% complete';
						document.querySelector('.progressbar<?= $path->pathway->id ?>').innerHTML = '&nbsp;';
					} else {
						document.querySelector('.progressbar<?= $path->pathway->id ?>').innerHTML = data<?= $path->pathway->id ?>.percentage + '% complete';
					}
					document.querySelector('.progressbar<?= $path->pathway->id ?>').style.width = percwid + '%';
					
				} else {
					document.querySelector('.beginning<?= $path->pathway->id ?>').innerHTML = 'You\'ve not completed any activities yet. Complete an activity to see your progress bar.';
				}
			}
		};
		request<?= $path->pathway->id ?>.onerror = function() {
			// There was a connection error of some sort
			document.querySelector('.beginning<?= $path->pathway->id ?>').innerHTML = 'Could not get status :(';
		};
		request<?= $path->pathway->id ?>.send();
		</script>

		<?php 
		echo $this->Form->postLink(__('Un-Follow'), 
										['controller' => 'PathwaysUsers', 'action' => 'delete/'. $path->id], 
										['class' => 'btn btn-light my-2', 'title' => 'Stop seeing your progress on this pathway', 'confirm' => __('Really unfollow?')]); 
		?>

	</div>
	<?php endforeach; ?>
	
<?php else: ?>
	<div class="p-3 mb-2 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
	<p><strong>You're not yet following any pathways.</strong></p>
	<p>Following means that you can see your progress through the pathway as you claim activities.</p>
	<a href="/categories" class="inline-block p-3 my-6 bg-slate-300 dark:bg-[#003366] text-lg rounded-lg">
		View Categories
	</a>
	</div>
<?php endif ?>

</div>
</div>
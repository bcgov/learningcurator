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

<div class="p-3 my-5 dark:text-white dark:bg-gray-600">
    <a class=" active" href="/profile">My Pathways</a> 
    <a class="" href="/profile/claims">My Activities</a> 
    <a class="" href="/profile/reports">My Issues</a> 
</div>

<?php if (!$pathways->isEmpty()) : ?>
	
	<?php foreach ($pathways as $path) : ?>
        
	<div class="p-3 my-3 bg-slate-100 dark:bg-gray-900 dark:text-white">

		<?php //$this->Form->postLink(__('Unfollow'), ['controller' => 'PathwaysUsers','action' => 'delete/'. $path->pathway->_joinData->id], ['class' => 'btn btn-primary float-right', 'confirm' => __('Really unfollow?')]) ?>
		<div>
			<?= $path->pathway->has('category') ? $this->Html->link($path->pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $path->pathway->category->id]) : '' ?>
		</div>
		
    	<h2 class="text-2xl">
			<a href="/pathways/<?= $path->pathway->slug ?>" class="font-weight-bold">
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

		<div>
		<span class="progressbar<?= $path->pathway->id ?> inline-block my-3 bg-green-300 dark:bg-green-700 dark:text-white text-center rounded-lg"></span>
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
	<div class="p-3 mb-2 bg-white rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
	<p><strong>You're not yet following any pathways.</strong></p>
	<p>Following means that you can see your progress through the pathway as you claim activities.
		Check out the featured pathways below!
	</p>
	</div>
<?php endif ?>


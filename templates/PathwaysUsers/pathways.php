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
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<div class="py-5">
	
	<div class="systemrole">
	<?php if($role == 'curator'): ?>
		 <span class="badge badge-success">Curator</span>
	<?php elseif($role == 'superuser'): ?>
		<span class="badge badge-success">Super User</span>
	<?php endif ?>
	</div>
	<h1 class="display-4">
		Welcome <?= $this->Identity->get('first_name') ?>
	</h1>

</div>
<div class="nav nav-pills justify-content-center">
    <a class="nav-link active" href="/profile/pathways">Pathways</a> 
    <a class="nav-link" href="/profile/claims">Claims</a> 
    <a class="nav-link" href="/profile/reports">Reports</a> 
    <a class="nav-link" href="/profile/contributions">Contributions</a> 
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-8 col-lg-6">
<h2><?= __('Your Pathways') ?></h2>
<?php if (!$pathways->isEmpty()) : ?>
	
	<?php foreach ($pathways as $path) : ?>
        
	<div class="p-3 mb-2 bg-white rounded-lg">
	<div class="row">
	<div class="col-3 ">
		<canvas class="bg-white rounded-lg" id="chart<?= $path->pathway->id ?>" width="400" height="400"></canvas>
		<script>
			var request<?= $path->pathway->id ?> = new XMLHttpRequest();

			request<?= $path->pathway->id ?>.open('GET', '/pathways/status/<?= $path->pathway->id ?>', true);

			request<?= $path->pathway->id ?>.onload = function() {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var data<?= $path->pathway->id ?> = JSON.parse(this.response);
				document.querySelector('.status<?= $path->pathway->id ?>').innerHTML = data<?= $path->pathway->id ?>.status;
				var ctx<?= $path->pathway->id ?> = document.getElementById('chart<?= $path->pathway->id ?>').getContext('2d');
				var myDoughnutChart = new Chart(ctx<?= $path->pathway->id ?>, {
					type: 'doughnut',
					data: JSON.parse(data<?= $path->pathway->id ?>.chartjs),
					options: { 
						legend: { 
							display: false 
						},
					}
				});
			} else {
				// We reached our target server, but it returned an error

			}
			};

			request<?= $path->pathway->id ?>.onerror = function() {
				// There was a connection error of some sort
				document.querySelector('.status<?= $path->pathway->id ?>').innerHTML = 'Could not get status';
			};
			request<?= $path->pathway->id ?>.send();
		</script>
	</div>
	<div class="col">
	
		<?php //$this->Form->postLink(__('Unfollow'), ['controller' => 'PathwaysUsers','action' => 'delete/'. $path->pathway->_joinData->id], ['class' => 'btn btn-primary float-right', 'confirm' => __('Really unfollow?')]) ?>
		<div>
			<?= $path->pathway->has('category') ? $this->Html->link($path->pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $path->pathway->category->id]) : '' ?>
		</div>
		
    	<div>
			<i class="bi bi-pin-map-fill"></i>
			<a href="/pathways/<?= $path->pathway->slug ?>" class="font-weight-bold">
				<?= $path->pathway->name ?>
			</a>
		</div>

		<div><?= h($path->pathway->objective) ?></div>
		<div>Followed on:
		<?= $this->Time->format($path->date_start,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?><br>
		Completed:
		<?= $this->Time->format($path->date_complete,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		</div>

		<div class="p-3 mt-3 bg-light">Overall Progress: <span class="status<?= $path->pathway->id ?>"></span>%</div>
		
		<?php 
		echo $this->Form->postLink(__('Un-Follow'), 
										['controller' => 'PathwaysUsers', 'action' => 'delete/'. $path->id], 
										['class' => 'btn btn-light', 'title' => 'Stop seeing your progress on this pathway', 'confirm' => __('Really unfollow?')]); 
		?>
		<?php 
		//echo $this->Form->postLink(__('Complete'), 
		//								['controller' => 'PathwaysUsers', 'action' => 'complete/'. $path->id], 
		//								['class' => 'btn btn-light', 'title' => 'Complete this pathway', 'confirm' => __('Really complete?')]); 
		?>
	
	
	</div>
	</div>
	</div>
	<?php endforeach; ?>
	
<?php else: ?>
	<div class="p-3 mb-2 bg-white rounded-lg shadow-lg">
	<p><strong>You're not yet following any pathways.</strong></p>
	<p>Following means that you can see your progress through the pathway as you claim activities.
		Check out the topics below to see all the pathways!
	</p>
	</div>
<?php endif ?>

<h3 class="mt-5">Recent Pathways</h3>

<?php foreach($published as $p): ?>
	<!-- <pre><?php print_r($p) ?></pre> -->
	<div class="p-3 mb-2 bg-white">
		<a href="/pathways/<?= $p->slug ?>">
			<i class="bi bi-pin-map-fill"></i> 
			<?= h($p->name) ?>
		</a> 
		<a href="/topics/view/<?= $p->topic->id ?>" class="badge badge-light">
		<?= h($p->topic->categories[0]->name) ?> <?= h($p->topic->name) ?>
		</a>
	</div>
<?php endforeach ?>


</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
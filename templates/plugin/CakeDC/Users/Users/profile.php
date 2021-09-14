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
<div class="col-md-6">

<div class="py-5">
	<?php echo $this->User->logout('Logout',['class'=>'btn btn-warning float-right']) ?>
	<div class="systemrole">
	<?php if($user->role == 'curator'): ?>
		 <span class="badge badge-success">Curator</span>
	<?php elseif($user->role == 'superuser'): ?>
		<span class="badge badge-success">Super User</span>
	<?php endif ?>
	</div>
	<h1 class="display-4">
		Welcome <?= h($user->first_name) ?>
	</h1>

    
	<?php if (!empty($user->ministry)) : ?>
	<!--<div>
	<?= $user->ministry->name ?>
	</div> -->
	<?php endif ?>
	

</div>
<div class="nav nav-pills justify-content-center">
    <a class="nav-link active" href="/profile">Pathways</a> 
    <a class="nav-link" href="/profile/claims">Claims</a> 
    <a class="nav-link" href="/profile/reports">Reports</a> 
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-8 col-lg-6">

<?php if (!empty($user->pathways_users)) : ?>
	
	<h2><?= __('Your Pathways') ?></h2>
	<?php foreach ($user->pathways_users as $path) : ?>
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
		
    	<h3>
			<i class="bi bi-pin-map-fill"></i>
			<a href="/pathways/<?= $path->pathway->slug ?>"><?= $path->pathway->name ?></a>
		</h3>

		<div><?= h($path->pathway->objective) ?></div>

		<div class="p-3 mt-3 bg-light">Overall Progress: <span class="status<?= $path->pathway->id ?>"></span>%</div>

		<?php //echo $this->Form->postLink(__('Unfollow'), ['controller' => 'App\PathwaysUsers','action' => 'delete/'. $path->_joinData->id], ['class' => 'btn btn-primary float-right', 'confirm' => __('Really unfollow?')]) ?>
	
	
	</div>
	</div>
	</div>
	<?php endforeach; ?>
	
<?php else: ?>
	<h2 class="mb-3"><?= _('You\'re not following any pathways yet.') ?></h2>
	<div class="p-3 mb-2 bg-white rounded-lg">
	<p class="mb-3">Check out the following topics for pathways aligned with your goals:</p>
	<?php foreach($categories as $cat): ?>
		
		<?php foreach($cat->topics as $t): ?>
			<h4><a href="/topics/view/<?= $t->id ?>"><?= $cat->name ?> - <?= $t->name ?></a></h4>
		<?php endforeach ?>
	<?php endforeach ?>

</div>
<?php endif ?>


</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
var options = {
    valueNames: [ 'name' ]
};

var hackerList = new List('activitylist', options);
</script>
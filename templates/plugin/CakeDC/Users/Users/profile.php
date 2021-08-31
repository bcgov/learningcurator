<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
$this->assign('title', 'Your Profile');
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
	<h1>
		Welcome <?= h($user->first_name) ?>
	</h1>

    <div>
	<?php if (!empty($user->ministry)) : ?>
	<?= $user->ministry->name ?>
	<?php endif ?>
	</div>

</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-4 col-lg-4">

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
		
    	<h3><a href="/pathways/<?= $path->pathway->slug ?>"><?= $path->pathway->name ?></a></h3>

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
	<p class="mb-3">Check out the following topic areas for pathways aligned with your goals:</p>
	<?php foreach($categories as $cat): ?>
		<h3 class="mt-3"><a href="/categories/view/<?= $cat->id ?>"><?= $cat->name ?></a></h3>
		<div class="p-3 mb-3 bg-light rounded-3 shadow-sm"><?= $cat->description ?></div>
	<?php endforeach ?>

</div>
<?php endif ?>

</div>



<?php if (!empty($user->activities_users)) : ?>
	<div class="col-md-4 col-lg-4">
	<h2><?= __('Your Claims') ?></h2>
	<div id="activitylist">
	<input type="text" name="activityfilter" id="activityfilter" placeholder="Filter" class="search form-control mb-3">
	<div class="list"> 
	<?php foreach($user->activities_users as $act): ?>
		<div class="p-3 mb-2 bg-white rounded-lg">
		<span class="name">
			<a href="/activities/view/<?= $act->activity->id ?>"><?= $act->activity->name ?></a>
		</span>
		</div>
<?php endforeach ?>
</div>
</div>
</div>
<?php endif ?>




	


<?php if (!empty($user->reports)) : ?>
	<div class="col-md-4 col-lg-4">
	<h2><i class="fas fa-sitemap"></i> <?= __('Your Reports') ?></h2>
	<?php foreach ($user->reports as $report) : ?>
	<div class="p-3 mb-2 bg-white rounded-lg">
		
		<?= h($report->created) ?><br>
		<a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a><br>
		<?= h($report->issue) ?><br>
		<?php if(!empty($report->response)): ?>
			<div class="alert alert-success"><?= h($report->response) ?></div>
		<?php else: ?>
			<div class="alert alert-primary">No response yet.</div>
		<?php endif ?>
		

	</div>
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
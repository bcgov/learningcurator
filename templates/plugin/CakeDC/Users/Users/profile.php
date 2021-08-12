<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/

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
		Welcome <?= h($user->first_name) ?> <?= h($user->last_name) ?> 	
	</h1>

    

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
	
		<?php //$this->Form->postLink(__('Unfollow'), ['controller' => 'PathwaysUsers','action' => 'delete/'. $path->pathway->_joinData->id], ['class' => 'btn btn-dark float-right', 'confirm' => __('Really unfollow?')]) ?>
		<div>
			<?= $path->pathway->has('category') ? $this->Html->link($path->pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $path->pathway->category->id]) : '' ?>
		</div>
		
    	<h3><a href="/pathways/<?= $path->pathway->slug ?>"><?= $path->pathway->name ?></a></h3>

		<div><?= h($path->pathway->objective) ?></div>

		<div class="p-3 mt-3 bg-light">Overall Progress: <span class="status<?= $path->pathway->id ?>"></span>%</div>

		<?php //echo $this->Form->postLink(__('Unfollow'), ['controller' => 'App\PathwaysUsers','action' => 'delete/'. $path->_joinData->id], ['class' => 'btn btn-dark float-right', 'confirm' => __('Really unfollow?')]) ?>
	
	
	</div>
	</div>
	</div>
	<?php endforeach; ?>
<?php else: ?>
<h2><?= _('You\'re not following any pathways yet.') ?></h2>
<?php endif ?>
<p><?php //_('Pathways are organized into topics. Here some topics for you to explore:') ?></p>

</div>

<div class="col-md-4 col-lg-4">
<h2><?= __('Your Claims') ?></h2>
<?php if (!empty($user->activities_users)) : ?>
<?php foreach($user->activities_users as $act): ?>
    <div class="p-3 mb-2 bg-white rounded-lg">
    <a href="/activities/view/<?= $act->activity->id ?>"><?= $act->activity->name ?></a>
</div>
<?php endforeach ?>
<?php endif ?>
</div>


<div class="col-md-4 col-lg-4">
<?php if (!empty($user->reports)) : ?>
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
<?php endif ?>
</div>


</div>
</div>
</div>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
	
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
var options = {
    valueNames: [ 'name' ]
};

var hackerList = new List('activitylist', options);
</script>
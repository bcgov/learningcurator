<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
?>

<div class="btn-group float-right">
<?= $this->Html->link(__('Logout'), ['action' => 'logout', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?php //$this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?php //$this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-dark btn-sm']) ?>
</div>
<h1><?= h($user->name) ?></h1>

<div class="row">
<div class="col-md-6">
<?php if (!empty($user->pathways)) : ?>
<h2><?= __('You\'re following these pathways') ?></h2>
<div class="row">
	<?php foreach ($user->pathways as $pathways) : ?>
	<div class="col-md-6 mb-3">
	<div class="card">
	<div class="card-body">
		<div><?= $pathways->has('category') ? $this->Html->link($pathways->category->name, ['controller' => 'Categories', 'action' => 'view', $pathways->category->id]) : '' ?></div>
		<h2><?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?></h2>
		<!--<div><?= h($pathways->description) ?></div>-->
		<div class="status<?= $pathways->id ?>"></div>
		<canvas id="chart<?= $pathways->id ?>" width="400" height="400"></canvas>
		<script>
			var request<?= $pathways->id ?> = new XMLHttpRequest();

			request<?= $pathways->id ?>.open('GET', '/pathways/status/<?= $pathways->id ?>', true);

			request<?= $pathways->id ?>.onload = function() {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var data<?= $pathways->id ?> = JSON.parse(this.response);
				document.querySelector('.status<?= $pathways->id ?>').innerHTML = data<?= $pathways->id ?>.status;
				var ctx<?= $pathways->id ?> = document.getElementById('chart<?= $pathways->id ?>').getContext('2d');
				var myDoughnutChart = new Chart(ctx<?= $pathways->id ?>, {
					type: 'doughnut',
					data: JSON.parse(data<?= $pathways->id ?>.chartjs),
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

			request<?= $pathways->id ?>.onerror = function() {
				// There was a connection error of some sort
				document.querySelector('.status<?= $pathways->id ?>').innerHTML = 'Could not get status';
			};
			request<?= $pathways->id ?>.send();
		</script>
	</div>
	</div>
	</div>
	<?php endforeach; ?>

<?php endif; ?>

</div></div>
<div class="col-md-6">

<?php if (!empty($user->activities)) : ?>
<h2><?= __('You\'ve claimed these activities') ?></h2>
<div class="card">
<div class="card-body">
<div id="activitylist">
<input type="text" name="activityfilter" id="activityfilter" placeholder="Filter" class="search form-control mb-3">

<?php 
// #TODO push this code into the controller
$ts = [];
foreach ($user->activities as $activity) {
	$a = $activity->activity_type->name . '|' . $activity->activity_type->color;
	array_push($ts,$a);
}
$unique = array_keys(array_flip($ts)); 
?>
<!--
<div class="mb-1">
Sort: 
<?php foreach($unique as $type): ?>
<?php $t = explode('|',$type) ?>
	<a class="sort badge badge-dark" data-sort="name" style="background-color: rgba(<?= $t[1] ?>,1)"><?= $t[0] ?></a>
<?php endforeach ?>
</div>
-->
<div class="list"> 
	<?php foreach ($user->activities as $activity) : ?>
	<div class="my-3 p-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border: 0">
		<?php if($activity->status_id == 2): ?>
		<span class="badge badge-warning" title="This link has been deemed to be non-functional or no longer relevant to the pathway">DEFUNCT</span>
		<div><strong><?= h($activity->name) ?></strong></div>
		<?php else: ?>
		<h3 class="name"><?= h($activity->name) ?></h3>
		<?php endif ?>
		<div><?= h($activity->description) ?></div>
	<a target="_blank" 
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
		class="btn btn-block my-2 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>
			
			<?= $activity->activity_type->name ?>
	</a>

	</div>
	<?php endforeach; ?>
</div> <!-- /.list -->
</div> <!-- /#activitylist -->
</div> <!-- /.card-body -->
</div> <!-- /.card -->

</div>
</div>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
var options = {
    valueNames: [ 'name' ]
};

var hackerList = new List('activitylist', options);
</script>
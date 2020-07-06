<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
$this->layout = 'nowrap';
?>
<style>
.badge {
	border-radius: 50%;
	color:#FFF; 
	display: inline-block;
	font-size: 24px;
	height: 50px;
	padding-top: 12px;
	width: 60px;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="pad-sm">
	<h1>
		Welcome <?= h($user->name) ?> 	
		<a class="" data-toggle="collapse" href="#editname" role="button" aria-expanded="false" aria-controls="editname">
			<i class="fas fa-edit"></i>
		</a>
	</h1>

	<div class="collapse" id="editname">
	<div class="row">
	<div class="col-sm-12 col-md-7 col-lg-5">
	<div class="p-3" style="background-color: rgba(255,255,255,.5)">	
		<p>Update your display name here. This is the name that will be used on 
		any completion certificates that you might earn.</p>
		<?= $this->Form->create(null, ['url' => [
			'controller' => 'Users',
			'action' => 'edit/' . $user->id
		]]) ?>
		<?= $this->Form->control('name',['class'=>'form-control','value' => $user->name, 'label' => false]) ?>
		<?= $this->Form->hidden('id', ['value' => $user->id]) ?>
		<?= $this->Form->button(__('Update name'), ['class'=>'btn btn-light']) ?>
		<?= $this->Form->end() ?>
	</div>
	</div>
	</div>
	</div>

</div>
</div>
</div>
</div>
<div class="container mt-3">
<div class="row">
<div class="col-md-6 mb-3">

<?php if (!empty($user->pathways)) : ?>
	<h2><?= __('Your Pathways') ?></h2>
	<?php foreach ($user->pathways as $pathways) : ?>
	<div class="card card-body mb-2">
	<div class="row">
	<div class="col-3">
	
		<canvas id="chart<?= $pathways->id ?>" width="400" height="400"></canvas>
		<script>
			var request<?= $pathways->id ?> = new XMLHttpRequest();

			request<?= $pathways->id ?>.open('GET', '/learning-curator/pathways/status/<?= $pathways->id ?>', true);

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
	<div class="col">
		<div>
			<?= $pathways->has('category') ? $this->Html->link($pathways->category->name, ['controller' => 'Categories', 'action' => 'view', $pathways->category->id]) : '' ?>
		</div>
		<h3><?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?></h3>
		<!--<div><?= h($pathways->description) ?></div>-->
		<div>Overall Progress: %<span class="status<?= $pathways->id ?>"></span></div>
		
	</div>
	</div>
	</div>
	<?php endforeach; ?>
<?php else: ?>
<h2><?= _('You\'re not following any pathways yet.') ?></h2>
<p><?= _('Pathways are organized into topics. Here some topics for you to explore:') ?></p>
<?php foreach ($allcats as $cat) : ?>
<div class="card card-body mb-2">
<h3>
	<?= $this->Html->link($cat->name, ['controller' => 'Categories', 'action' => 'view', $cat->id]) ?>
</h3>
<div><?= h($cat->description) ?></div>
</div>
<?php endforeach; ?>

<?php endif; ?>

</div>

<div class="col-md-6">
<h2><?= __('Bookmarked Activities') ?></h2>
<?php foreach($bookmarks as $bookmark): ?>
<div class="p-3 bg-white mb-2"><?= $this->Html->link(h($bookmark->activity->name), ['controller' => 'Activities','action' => 'view', $bookmark->activity->id]) ?></div>
<?php endforeach ?>
<?php if (!empty($user->activities)) : ?>
<h2><?= __('Claimed Activities') ?></h2>

<div id="activitylist">
<input type="text" name="activityfilter" id="activityfilter" placeholder="Filter" class="search form-control mb-3">


<div class="list"> 
	<?php foreach ($user->activities as $activity) : ?>
	<div class="card card-body mb-2">
		<?php if($activity->status_id == 3): ?>
		<span class="badge badge-warning" title="This link has been deemed to be non-functional or no longer relevant to the pathway">DEFUNCT</span>
		<?php endif ?>
		<div class="row">

		<div class="col-4 text-right">
			<a target="_blank" 
				href="<?= $activity->hyperlink ?>"  
				style="background-color: rgba(<?= $activity->activity_type->color ?>,1);"
				class="btn btn-sm" 
				title="<?= $activity->activity_type->name ?> <?= h($activity->name) ?>">

					<i class="fas <?= $activity->activity_type->image_path ?>"></i>
					<?= $activity->activity_type->name ?>
					
			</a>
		</div>
		<div class="col">
		<span class="name"><?= $this->Html->link(h($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></span>
	
		</div>
		</div>
	</div>
	<?php endforeach; ?>
</div> <!-- /.list -->
</div> <!-- /#activitylist -->



<?php else: ?>
<h2><?= _('You\'ve not claimed any activities yet.') ?></h2>
<p>As you claim activities, they will appear here, along with any pathways you might be following.</p>
<div class="card card-body mt-3">
	<p>If you're looking for something specific, try searching for it!</p>
	<form method="get" action="/learning-curator/activities/find" class="form-inline my-2 my-lg-0">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
		<button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
	</form>
</div>
<?php endif; ?>


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
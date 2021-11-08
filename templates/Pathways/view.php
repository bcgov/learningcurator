<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
$totalusers = count($usersonthispathway);
$this->assign('title', h($pathway->name));

?>
<style>
/* Start desktop-specific code for this page.
Arbitrarily set to 45em based on sample code from ...somewhere. 
This seems to work out, but #TODO investigate optimizing this
*/
@media (min-width: 45em) {

	.stickyrings {

		position: -webkit-sticky;
		position: sticky;
		top: 86px;
		z-index: 1000;
	}
} /* end desktop-specific code */

</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-12 col-lg-8 col-xl-6">
<div class="p-3">

	<?php if($pathway->status_id == 1): ?>
	<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
	<?php endif ?>

	<nav aria-label="breadcrumb">
	<ol class="breadcrumb mt-3">
	
	<li class="breadcrumb-item"><?= $this->Html->link($pathway->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $pathway->topic->categories[0]->id]) ?></li>
		<li class="breadcrumb-item"><?= $pathway->has('topic') ? $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id]) : '' ?></li>
		<!-- <li class="breadcrumb-item" aria-current="page"><?= h($pathway->name) ?> </li> -->
	</ol>
	</nav> 

	<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="btn-group float-right">
	<button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModal">
	<?= $totalusers ?>  following
	</button>
	<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
	<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
	</div>
	<?php endif ?>
	<h1>
		<i class="bi bi-pin-map-fill"></i>
		<?= h($pathway->name) ?>
	</h1>

	<!-- totals below updated via JS -->

	<div class="py-3" style="background-color: rgba(255,255,255,.5)">
	<?= $pathway->objective ?> 
	
	<div class="my-2"><em>Estimated time for this pathway: <?= h($pathway->estimated_time) ?></em></div>

	<div class="mb-2">
	<span class="badge badge-light totaltotal"></span>  
	<span class="badge badge-light readtotal"></span>  
	<span class="badge badge-light watchtotal"></span>  
	<span class="badge badge-light listentotal"></span>  
	<span class="badge badge-light participatetotal"></span>  
	</div>
	<div class="text-muted p-2 mt-2" style="background-color: rgba(255,255,255,.2)">
		Added on 
		<?= $this->Time->format($pathway->created,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
		<?php if($role == 'curator' || $role == 'superuser'): ?>
		by <a href="/users/view/<?= $pathway->createdby ?>">curator</a>
		<?php endif ?>
	</div>
			
	<?php if($role == 'curator' || $role == 'superuser'): ?>

	<a class="" 
		data-toggle="collapse" 
		href="#addstepform" 
		role="button" 
		aria-expanded="false" 
		aria-controls="addstepform">
			<span>+</span> Add a step
	</a>
	<div class="collapse" id="addstepform">
	<div class="card my-3">
	<div class="card-body">
	<?= $this->Form->create(null, ['url' => [
			'controller' => 'Steps',
			'action' => 'add'
	]]) ?>
	<fieldset>
	<legend class=""><?= __('Add Step') ?></legend>
	<?php
	echo $this->Form->control('name',['class'=>'form-control']);
	echo $this->Form->control('description',['class' => 'form-control', 'type' => 'textarea']);
	echo $this->Form->hidden('createdby', ['value' => $uid]);
	echo $this->Form->hidden('modifiedby', ['value' => $uid]);
	echo $this->Form->hidden('pathways.1.id', ['value' => $pathway->id]);
	?>
	</fieldset>
	<?= $this->Form->button(__('Add Step'), ['class'=>'btn btn-block btn-primary']) ?>
	<?= $this->Form->end() ?>
	</div>
	</div>
	</div>

	<?php endif ?>
</div>
</div>
</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center">

<div class="col-md-3 col-lg-2 order-last">

<?php if(in_array($uid,$usersonthispathway)): ?>

	
	<div class="bg-white p-3 mt-3 text-center stickyrings">
	<div>Overall Progress: <span class="mb-3 following"></span>%</div>
	<canvas id="myChart" width="250" height="250"></canvas>
	</div>
	
<?php else: ?>
<div class="bg-white rounded-lg p-3 my-3 stickyrings">

<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'btn btn-block btn-primary mb-0']) ?>

<?= $this->Form->end() ?>

<div class="py-3">
	Following a pathway allows you to track your progress and pin the pathway to <a href="/profile/pathways">your profile</a>.
</div>


</div>

<?php endif ?>

<!--<div class="" style="font-size: 12px">Published <?= h(date('D M jS \'y',strtotime($pathway->created))) ?></div>-->


</div>
<?php if (!empty($pathway->steps)) : ?>

<div class="col-md-8 col-lg-6 col-xl-4">

<?php foreach ($pathway->steps as $steps) : ?>

<?php 

$stepTime = 0;
$defunctacts = array();
$requiredacts = array();
$supplementalacts = array();
$acts = array();

$readstepcount = 0;
$watchstepcount = 0;
$listenstepcount = 0;
$participatestepcount = 0;
$readcolor = '';
$watchcolor = '';
$listencolor = '';
$participatecolor = '';

$totalacts = count($steps->activities);
$stepclaimcount = 0;

foreach ($steps->activities as $activity) {
	//print_r($activity);
	// If this is 'defunct' then we pull it out of the list 
	if($activity->status_id == 3) {
		array_push($defunctacts,$activity);
	} elseif($activity->status_id == 2) {
		// if it's required
		if($activity->_joinData->required == 1) {
			array_push($requiredacts,$activity);

		// Otherwise it's supplemental
		} else {
			array_push($supplementalacts,$activity);
		}
		array_push($acts,$activity);
		if($activity->activity_types_id == 1) {
			$watchstepcount++;
			$watchcolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 2) {
			$readstepcount++;
			$readcolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 3) {
			$listenstepcount++;
			$listencolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 4) {
			$participatestepcount++;
			$participatecolor = $activity->activity_type->color;
		}
		if(in_array($activity->id,$useractivitylist)) {
			$stepclaimcount++;
		}

	}
}

?>

<?php
$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);
$completeclass = 'notcompleted'; 
if($stepclaimcount == $totalacts) {
	$completeclass = 'completed';
}

if($stepclaimcount > 0) {
	$steppercent = ceil(($stepclaimcount * 100) / $stepacts);
} else {
	$steppercent = 0;
}
?>


<?php if($steps->status->name == 'Published'): ?>

<div class="p-3 my-3 bg-white rounded-lg">
	<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div><span class="badge badge-light"><?= $steps->status->name ?></span></div>
	<?php endif ?>
	<h2>

		<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
			<?= h($steps->name) ?> 
			<i class="bi bi-arrow-right-circle-fill"></i>
		</a>
	</h2>
	
	<div style="font-size; 130%"><?= $steps->description ?></div>
	
	<div class="my-3">
			<span class="badge badge-pill badge-light"><?= $totalacts ?> total activities</span> 
			<span class="badge badge-pill badge-light"><?= $stepacts ?> required</span>
			<span class="badge badge-pill badge-light"><?= $supplmentalcount ?> supplemental</span>
			<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $readcolor ?>,1)">
				<?= $readstepcount ?> to read
			</span>  
			<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $watchcolor ?>,1)">
				<?= $watchstepcount ?> to watch
			</span>  
			<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $listencolor ?>,1)">
				<?= $listenstepcount ?> to listen to
			</span>  
			<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $participatecolor ?>,1)">
				<?= $participatestepcount ?> to participate in
			</span>  
		</div>
		
	<div class="progress progress-bar-striped mb-3" style="background-color: #F1F1F1; height: 26px;">
	  <div class="progress-bar" role="progressbar" style="background-color: rgba(88,174,36,.8); color: #FFF; width: <?= $steppercent ?>%" aria-valuenow="<?= $steppercent ?>" aria-valuemin="0" aria-valuemax="100">
		<?= $steppercent ?>% done
	  </div>
	</div>
	
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="p-3 my-3 bg-white rounded-lg">
<div><span class="badge badge-warning"><?= $steps->status->name ?></span></div>
<h2>
	<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
		<?= h($steps->name) ?> 
		<i class="fas fa-arrow-circle-right"></i>
	</a>
</h2>
<div style="font-size; 130%"><?= $steps->description ?></div>
<div class="my-3">
	<span class="badge badge-pill badge-light"><?= $totalacts ?> total activities</span> 
	<span class="badge badge-pill badge-light"><?= $stepacts ?> required</span>
	<span class="badge badge-pill badge-light"><?= $supplmentalcount ?> supplemental</span>
	<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $readcolor ?>,1)">
		<?= $readstepcount ?> to read
	</span>  
	<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $watchcolor ?>,1)">
		<?= $watchstepcount ?> to watch
	</span>  
	<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $listencolor ?>,1)">
		<?= $listenstepcount ?> to listen to
	</span>  
	<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $participatecolor ?>,1)">
		<?= $participatestepcount ?> to participate in
	</span>  
</div>
</div>
<?php endif; // if curator or admin ?>
<?php endif; // if published ?>
<?php endforeach ?>


</div> <!-- /.col-md -->
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

</div>

</div>








<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel"><span class="badge badge-pill badge-dark"><?= $totalusers ?></span> 
		people following</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<ul class="list-group list-group-flush">
<?php foreach($followers as $follower): ?>
<li class="list-group-item">
	<a href="/users/view/<?= $follower[0] ?>"><?= $follower[1] ?></a>
</li>
<?php endforeach ?>
</ul>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<?php endif ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


<script type="text/javascript" src="/js/jquery.scrollTo.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script>

$(document).ready(function(){

	// load up the activity rings
	loadStatus();


	$('#stepnav .nav-link').on('click', function(event) {
		event.preventDefault();
		$(this).tooltip('hide');
        $.scrollTo(event.target.hash, 250, {offset:-105,});
	});


	$('[data-toggle="tooltip"]').tooltip();

	$('.likingit').on('click',function(e){
		var url = $(this).attr('href');
		$(this).children('.lcount').html('Liked!');
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: url,
			data: '',
			success: function(data)
			{
			},
			statusCode: 
			{
				403: function() {
					let alert = 'You must be logged in.</div>';
					console.log(alert);
				}
			}
		});
	});

});

//
// Get the summary for this pathway independently of the page load
//
function loadStatus() {

	var form = $(this);
	$.ajax({
		type: "GET",
		url: '/pathways/status/<?= $pathway->id ?>',
		data: '',
		success: function(data)
		{
			form.find('btn').val('Claimed!');
			var pathstatus = JSON.parse(data);

			$('.following').html(pathstatus.status);

			console.log(pathstatus.status);
			$('.totaltotal').html(pathstatus.typecounts.totaltotal + ' total activities');
			$('.readtotal').html(pathstatus.typecounts.readtotal + ' to read')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.readcolor + ',1)');
			$('.watchtotal').html(pathstatus.typecounts.watchtotal + ' to watch')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.watchcolor + ',1)');
			$('.listentotal').html(pathstatus.typecounts.listentotal + ' to listen to')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.listencolor + ',1)');
			$('.participatetotal').html(pathstatus.typecounts.participatetotal + ' to participate in')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.participatecolor + ',1)');

			var ctx = document.getElementById('myChart').getContext('2d');
			var myDoughnutChart = new Chart(ctx, {
				type: 'doughnut',
				data: JSON.parse(pathstatus.chartjs),
				options: { 
					legend: { 
						display: false 
					},
				}
			});
		},
		statusCode: 
		{
			403: function() {
				form.after('<div class="alert alert-warning">You must be logged in.</div>');
			}
		}
	});

}

</script>
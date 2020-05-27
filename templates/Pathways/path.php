<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->layout = 'nowrap';
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}

?>
<style>
/* Start desktop-specific code for this page.
Arbitrarily set to 45em based on sample code from ...somewhere. 
This seems to work out, but #TODO investigate optimizing this
*/
@media (min-width: 45em) {
	/* probably can be removed as probably not using columns any more */
    .card-columns {
        -webkit-column-count:2;
        -moz-column-count:2;
        column-count:2;
    }
	
	.stickyrings {
		align-self: flex-start; 
		position: -webkit-sticky;
		position: sticky;
		text-transform: uppercase;
		top: 86px;
		z-index: 1000;
	}
} /* end desktop-specific code */

.following {
	font-size: 20px;
	font-weight: 200;
	text-align: center;
}
.stickynav {
	align-self: flex-start; 
	position: -webkit-sticky;
	position: sticky;
	top: 0;
	text-transform: uppercase;
	z-index: 1000;
}
#stepnav {
	box-shadow: 0 0 20px rgba(0,0,0,.05);
}
.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
	background-color: #F1F1F1;
	color: #333;
}
</style>


<style>
/* the follow is only here to potentially support the 
confetti celebration upon path completion which may or
may not be actually inplemented. #TODO remove this if 
not used */
#emitter {
  visibility: hidden;
  background-color: #222;
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  top: 40%;
  left: 0%;
}
.dot-container {
  position:absolute;
  left:0;
  top:0;
  overflow:visible;
  z-index:5000;
  pointer-events:none;
}
.dot {
  position: absolute;
  pointer-events: none; /*performance optimization*/
}
/* end of confetti celebration CSS */
</style>


<div class="row justify-content-md-center">
<div class="col-md-4">
	<?php if($pathway->status_id == 1): ?>
	<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
	<?php endif ?>

	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
	<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
	</div>
	<?php endif ?>
	<div><?= $pathway->has('category') ? $this->Html->link($pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $pathway->category->id]) : '' ?> pathway</div>
	<h1><?= h($pathway->name) ?></h1>
	<!-- totals below updated via JS -->
<div class="mb-2">
	<span class="badge badge-light readtotal"></span>  
	<span class="badge badge-light watchtotal"></span>  
	<span class="badge badge-light listentotal"></span>  
	<span class="badge badge-light participatetotal"></span>  
</div>
	<div><em>Description</em></div>
	<?= $this->Text->autoParagraph(h($pathway->description)); ?>

	<div><em>Objective</em></div>
	<div class="moretoshow" id="objectives">
	<?= $this->Text->autoParagraph(h($pathway->objective)); ?>
	</div> <!-- /.objective -->

<?php if(in_array($uid,$usersonthispathway)): ?>

	<div class="mb-3 following"></div>
	<canvas id="myChart" width="250" height="250"></canvas>

<?php else: ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'add']]) ?>
<?php
    echo $this->Form->control('user_id',['type' => 'hidden', 'value' => $uid]);
    echo $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]);
    echo $this->Form->control('status_id',['type' => 'hidden', 'value' => 1]);
?>
<?= $this->Form->button(__('Follow this pathway'),['class' => 'btn btn-lg btn-dark mb-0']) ?>
<br><small><a href="#">What does this mean?</a></small>
<?= $this->Form->end() ?>

<?php endif ?>

<div class="" style="font-size: 12px">Published <?= h(date('D M jS \'y',strtotime($pathway->created))) ?></div>


<?php if($role == 2 || $role == 5): ?>
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
<?php if (!empty($pathway->steps)) : ?>

<div class="col-lg-4 col-md-4">

<?php foreach ($pathway->steps as $step) : ?>
<div class="card card-body mb-3">
<h2><a href="/steps/view/<?= $step->id ?>"><?= $step->name ?></a></h2>
<div><?= $step->description ?></div>
</div>
<?php endforeach ?>


</div> <!-- /.col-md -->
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

</div>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>


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

	$('.claim').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').html('CLAIMED! <span class="fas fa-check-circle"></span>').tooltip('dispose').attr('title','Good job!');
		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/activities-users/claim',
			data: form.serialize(),
			success: function(data)
			{
				
				loadStatus();
			},
			statusCode: 
			{
				403: function() {
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
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

			//console.log(pathstatus.typecolors);
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

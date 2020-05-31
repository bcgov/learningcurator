<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
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
.active {
    background-color: #FFF;
}
.dot {
	color: #000;
}
.dotactive {
	color: #FFF;
	font-size: 140%;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<?php if (!empty($step->pathways)) : ?>

<?php foreach ($step->pathways as $pathways) : ?>
<?php $totalsteps = count($pathways->steps) ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb mt-3">
  	<li class="breadcrumb-item"><?= $pathways->has('category') ? $this->Html->link($pathways->category->name, ['controller' => 'Categories', 'action' => 'view', $pathways->category->id]) : '' ?> pathway</li>
    <li class="breadcrumb-item" aria-current="page"><?= h($pathways->name) ?> </li>
	<li class="breadcrumb-item"><a href="/pathways/view/<?= $pathways->id ?>">All Steps</a></li>
  </ol>
</nav> 


<h1>
	<?= h($pathways->name) ?>
	<?php //$this->Html->link(h($pathways->name), ['controller' => 'Pathways', 'action' => 'path', $pathways->id]) ?>
</h1>
<?= $this->Text->autoParagraph(h($pathways->objective)); ?>
<div>
<?php foreach($pathways->steps as $s): ?>
<?php $c = ''; ?>
<?php $n = next($pathways->steps) ?>
<?php if($s->id == $step->id): ?>
<div class="row <?= $c ?>">
	<div class="col">
		<?php if(!empty($laststep)): ?>
		<a href="/steps/view/<?= $laststep ?>" style="color: #000; font-size: 250%;"><i class="fas fa-arrow-circle-left"></i></a>
		<?php endif ?>
	</div>
	<div class="col-md-9" style="background-color: rgba(255,255,255,.5)">
		<h2 class="mt-2"><?= $s->name ?> <small>of <?= $totalsteps ?></small></h2>	
		<?= $this->Text->autoParagraph(h($s->description)); ?>
	</div>
	<div class="col text-right">
		<?php if(!empty($n->id)): ?>
		<a href="/steps/view/<?= $n->id ?>" style="color: #000; font-size: 250%;"><i class="fas fa-arrow-circle-right"></i></a>
		<?php endif ?>
	</div>
</div>
<?php endif ?>
<?php 
$laststep = $s->id;
$lastname = $s->name;
$lastobj = $s->description;
?>
<?php endforeach ?>
<div class="text-center my-3">
<?php foreach($pathways->steps as $s): ?>
	<?php $c = 'dot' ?>
	<?php if($s->id == $step->id) $c = 'dotactive' ?>
	<a href="/steps/view/<?= $s->id ?>"><i class="far fa-dot-circle <?= $c ?>" title="<?= $s->name ?>"></i></a>
<?php endforeach ?>
</div>
</div>
</div>
<?php endforeach; ?>

<?php endif; ?>


</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-6 col-md-3 col-lg-2">



<?php if(in_array($uid,$usersonthispathway)): ?>

	
<div class="w-100 mt-3 text-center">
<div class="mb-3 following"></div>
<canvas id="myChart" width="250" height="250"></canvas>
</div>

<?php else: ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'add']]) ?>
<?php
echo $this->Form->control('user_id',['type' => 'hidden', 'value' => $uid]);
echo $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]);
echo $this->Form->control('status_id',['type' => 'hidden', 'value' => 1]);
?>
<?= $this->Form->button(__('Follow this pathway'),['class' => 'btn btn-lg btn-light mb-0']) ?>

<?= $this->Form->end() ?>

<?php endif ?>


</div>
<div class="col-md-9">
<?php if (!empty($step->activities)) : ?>
<div class="card-columns">
<?php foreach ($step->activities as $activity) : ?>
	<div class="card my-3">
<div class="p-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="">

	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	</div>
	<?php endif; // role check ?>

	<?php foreach($activity->tags as $tag): ?>
	<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
	<?php endforeach ?>

	<h2 class="my-3">
		<?= $activity->name ?>
		<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>
	</h2>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<?= $activity->description ?>
	</div>
	<div class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
		<i class="fas fa-clock"></i>
		<?= $activity->estimated_time ?>
	</div> 
	<?php if(!empty($activity->tags)): ?>
	<?php foreach($activity->tags as $tag): ?>

	<?php if($tag->name == 'Learning System Course'): ?>

	<a target="_blank" 
		data-toggle="tooltip" data-placement="bottom" title="Enrol in this course in the Learning System"
		href="https://learning.gov.bc.ca/psc/CHIPSPLM_6/EMPLOYEE/ELM/c/LM_OD_EMPLOYEE_FL.LM_FND_LRN_FL.GBL?Page=LM_FND_LRN_RSLT_FL&Action=U&KWRD=<?php echo urlencode($activity->name) ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>

	<?php elseif($tag->name == 'YouTube'): ?>
	
	<div class="my-3 p-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); border-radius: 3px;">
		<iframe width="100%" 
			height="315" 
			src="https://www.youtube.com/embed/<?= h($activity->hyperlink) ?>/" 
			frameborder="0" 
			allow="" 
			allowfullscreen>
		</iframe>
	</div>

	<?php endif; // logic check for formatting differently based on tag ?>	

	<?php endforeach; // tags loop ?>

	<?php else: // if there aren't any tags at all, default ?>


	<a target="_blank" 
		data-toggle="tooltip" data-placement="bottom" title="<?= $activity->activity_type->name ?> this activity"
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>

	<?php endif; // are there tags? ?>	

	<?php if(!empty($activity->_joinData->required)): ?>

	<div class="required float-right" data-toggle="tooltip" data-placement="bottom" title="This activity is required to complete the step">
		<i class="fas fa-check-double"></i> Required
	</div>
	<?php else: ?>
	<div class="required float-right" data-toggle="tooltip" data-placement="bottom" title="This activity is supplemtary to completing this step">
		<i class="fas fa-check"></i> Supplementary
	</div>
	
	<?php endif ?>


	<!-- Hiding this until we can get a proper reporting system in place.
	<a href="#" style="color:#333;" class="btn btn-light float-right" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
		<i class="fas fa-exclamation-triangle"></i>
	</a>	-->

	<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
	</a>
	
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'claim']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'You\'ve completed it, now claim it so it shows up on your profile', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: // they have claimed it, so show that ?>

	<div class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div>

	<?php endif; // claimed or not ?>
	<?php endif; // logged in ?>

	</div>
	</div>
	</div>
	<?php endforeach; // end of activities loop for this step ?>
</div> <!-- /.card-coumns -->

	




<?php endif; ?>

</div>
</div>

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


<script type="text/javascript" src="/js/jquery.scrollTo.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script>

$(document).ready(function(){

	// load up the activity rings
	loadStatus();

	$('.steplink').each(function(e){
		let actualstep = $(this).attr('href');
		if($(actualstep).hasClass('completed')) {
			let checkmark = '<i class="fas fa-check-square" style="color: rgba(88,174,36,1);"></i>';
			$(this).prepend(checkmark);
		}
	});

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
		url: '/pathways/status/<?= $step->pathways[0]->id ?>',
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
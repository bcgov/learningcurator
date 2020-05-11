<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
// #TODO remove this hack and do this properly where we're 
// adding a new slug entity to the steps table so that 
// we don't have to process the title strings at all.
function slugify($string) {
	$slug = \Transliterator::createFromRules(
		':: Any-Latin;'
		. ':: NFD;'
		. ':: [:Nonspacing Mark:] Remove;'
		. ':: NFC;'
		. ':: [:Punctuation:] Remove;'
		. ':: Lower();'
		. '[:Separator:] > \'-\''
	)->transliterate( $string );
	return $slug;
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
<div id="emitter"></div> <!-- confetti placeholder -->

<div class="row">
<div class="col-md-12">
<?php if($pathway->status_id == 1): ?>
<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
<?php endif ?>
<div class="card mb-3">
<div class="card-body">

<?php if($role == 2 || $role == 5): ?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Edit'), ['action' => 'edit', $pathway->id], ['class' => 'btn btn-light']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'btn btn-light']) ?>
</div>
<?php endif ?>
<div><?= $pathway->has('category') ? $this->Html->link($pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $pathway->category->id]) : '' ?> pathway</div>
<h1><?= h($pathway->name) ?></h1>
<div class="row">
<div class="col-md-6">
	<div><em>Description</em></div>
	<?= $this->Text->autoParagraph(h($pathway->description)); ?>
</div>
<div class="col-md-6">
	<div><em>Objectives</em></div>
	<div class="moretoshow" id="objectives">
	<?= $this->Text->autoParagraph(h($pathway->objective)); ?>
	</div> <!-- /.objectives -->
</div>
</div>
<div class="float-right" style="font-size: 12px">Published <?= h(date('D M jS \'y',strtotime($pathway->created))) ?></div>
<!-- totals below updated via JS -->
<div class="mb-2">
	<span class="badge badge-dark readtotal"></span>  
	<span class="badge badge-dark watchtotal"></span>  
	<span class="badge badge-dark listentotal"></span>  
	<span class="badge badge-dark participatetotal"></span>  
</div>

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
</div> <!-- /.card -->
</div> <!-- /.col-12 -->
</div> <!-- /.row -->


<?php if(count($stepsalongtheway) > 1): ?>
<nav id="stepnav" class="stickynav nav nav-pills mb-3 p-3" style="background: #FFF">
<?php foreach($stepsalongtheway as $steplink): ?>
	<a class="nav-link " 
		href="#pathway-<?= $steplink['slug'] ?>"
		title="<?= $steplink['objective'] ?>"
		data-toggle="tooltip" data-placement="bottom">
			<?= $steplink['name'] ?>
	</a> 
<?php endforeach ?>
</nav> <!-- /nav -->
<?php endif ?>

<?php if (!empty($pathway->steps)) : ?>

<div class="row">
<div class="col-lg-4 col-md-3 col-6 order-md-last stickyrings">
<?php if(!empty($uid)): ?>
<?php if(in_array($uid,$usersonthispathway)): ?>
<div class="card">
<div class="card-body">
	<div class="mb-3 following"></div>
	<canvas id="myChart" width="250" height="250"></canvas>
</div>
</div>
<?php else: ?>
<div class="card">
<div class="card-body">
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'add']]) ?>
<?php
    echo $this->Form->control('user_id',['type' => 'hidden', 'value' => $uid]);
    echo $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]);
    echo $this->Form->control('status_id',['type' => 'hidden', 'value' => 1]);
?>
<?= $this->Form->button(__('Follow this pathway'),['class' => 'btn btn-lg btn-dark mb-0']) ?>
<br><small><a href="#">What does this mean?</a></small>
<?= $this->Form->end() ?>
</div>
</div>
<?php endif ?>
<?php else: ?>

<!-- not logged in -->

<?php endif ?>

</div>
<div class="col-lg-8 col-md-9">

<?php foreach ($pathway->steps as $steps) : ?>

<div id="pathway-<?php echo slugify($steps->name) ?>" class="card ">
<div class="card-body">

<?php if($role == 2 || $role == 5): ?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Edit Step'), ['controller' => 'Steps', 'action' => 'edit', $steps->id], ['class' => 'btn btn-light btn-sm']) ?>
<?php //$this->Form->postLink(__('Delete Step'), ['controller' => 'Steps', 'action' => 'delete', $steps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $steps->id), 'class' => 'btn btn-light btn-sm']) ?>
</div> <!-- /.btn-group -->
<?php endif ?>


<?php 

$stepTime = 0;
$defunctacts = array();
$requiredacts = array();
$tertiaryacts = array();
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
	if($activity->status_id == 2) {
		array_push($defunctacts,$activity);
	} else {
		// if it's required
		//if($activity->_joinData->required == 1) {
		//	array_push($requiredacts,$activity);
		// Otherwise it's teriary
		//} else {
		//	array_push($tertiaryacts,$activity);
		//}
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
		$tmp = array();
		// Loop through the whole list, add steporder to tmp array
		foreach($acts as $line) {
			$tmp[] = $line->_joinData->steporder;
		}
		// Use the tmp array to sort acts list
		array_multisort($tmp, SORT_DESC, $acts);
	}
}

?>
<?php if($stepclaimcount == $totalacts): ?>
<div class="stepcompleted" id="step<?= $steps->id ?>complete"><span class="badge badge-dark">STEP COMPLETED</span>
<?php endif ?>

<h1 class="text-uppercase">
	<!--<?= h($steps->id) ?>.--> <?= h($steps->name) ?>
</h1>
<div class="mb-2">
	<span class="badge badge-dark" style="background-color: rgba(<?= $readcolor ?>,1)"><?= $readstepcount ?> to read</span>  
	<span class="badge badge-dark" style="background-color: rgba(<?= $watchcolor ?>,1)"><?= $watchstepcount ?> to watch</span>  
	<span class="badge badge-dark" style="background-color: rgba(<?= $listencolor ?>,1)"><?= $listenstepcount ?> to listen to</span>  
	<span class="badge badge-dark" style="background-color: rgba(<?= $participatecolor ?>,1)"><?= $participatestepcount ?> to participate in</span>  
</div>
<div class="my-3 py-3"><?= h($steps->description) ?></div>

<?php foreach($acts as $activity): ?>

<div class="card mb-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">

	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle/' . $activity->_joinData->id, 'class' => '']]) ?>
	<?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $activity->_joinData->id]) ?>
	<?php if($activity->_joinData->required == 0): ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
	<?php else: ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
	<?php endif ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Required'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>

	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $activity->_joinData->id, 'class' => '']]) ?>
	<?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $activity->_joinData->steporder]) ?>
	<?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
	<?= $this->Form->control('id',['type' => 'hidden', 'value' => $activity->_joinData->id]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Up'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>

	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $activity->_joinData->id, 'class' => '']]) ?>
	<?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $activity->_joinData->steporder]) ?>
	<?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
	<?= $this->Form->control('id',['type' => 'hidden', 'value' => $activity->_joinData->id]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Down'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php endif; // role check ?>

	<?php foreach($activity->tags as $tag): ?>
	<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
	<?php endforeach ?>

	<h1 class="my-3">
		<?= $activity->name ?>
		<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>
	</h1>
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
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
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
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
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

	<?php endforeach; // end of activities loop for this step ?>


	<?php if(!empty($defunctacts)): // show any defunct activities behind a button ?>
	<div>
		<a class="btn btn-light" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
			Defunct activities
		</a>
	</div>
	<div class="collapse" id="collapseExample">
		<ul class="list-group">
		<?php foreach($defunctacts as $activity): ?>
			<li class="list-group-item"><a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a></li>
		<?php endforeach ?>
		</ul>
	</div>
	<?php endif ?>




	</div> <!-- /.card-body -->
	</div> <!-- /.card -->

	<div class="text-center">
	<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
		<style>
			.line-arrow-down1{
				animation: line-arrow-down1-fly 3s infinite ease-in-out;
			}
			@keyframes line-arrow-down1-fly{
				0% { transform: translate3d(0, -200px, 0);}
				30% {transform: translate3d(0, 0, 0);}
				40% {transform: translate3d(0, -4px, 0);}
				50% {transform: translate3d(0, 0, 0);}
				70% {transform: translate3d(0, -4px, 0);}
				100% {transform: translate3d(0, 240px, 0);}
			}
		</style>
		<path class="line-arrow-down1" 
				d="M48.9919 5L48.9919 95M48.9919 95L85 59.1525M48.9919 95L13.75 59.1525" 
				stroke="#000" 
				stroke-width="2px" 
				stroke-linecap="round" 
				style="animation-duration: 3s;"></path>
	</svg>
	</div>
	<?php endforeach; // end of step loop ?>

	<div class="card mb-3">
	<div class="card-body">
		<h1>The End</h1>
		<?= $this->Text->autoParagraph(h($pathway->objective)); ?>
	</div>
	</div>

</div> <!-- /.col-md -->
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

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

	$('#stepnav .nav-link').on('click', function(event) {
		event.preventDefault();
		$(this).tooltip('hide');
        $.scrollTo(event.target.hash, 250, {offset:-60,});
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
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
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

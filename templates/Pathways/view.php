<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
//if ($this->Identity->isLoggedIn()) {
//	$name = $this->Identity->get('role_id');
//}
$uid = 0;
$role = 0;
if(!empty($active)) {
	$role = $active->role_id;
	$uid = $active->id;
}




?>



<style>
@media (min-width: 34em) {
    .card-columns {
        -webkit-column-count:2;
        -moz-column-count:2;
        column-count:2;
    }
}
.hours {
	background: rgba(255,255,255,1);
	color: #222;
}
.required {
	background: rgba(0,0,0,1);
	color: #FFF;
	float: right;
}
.required,
.hours {
	border-radius: 5px;
	text-align: center;
	text-transform: uppercase;
	width: 130px;
}
.activity-badge {
	border-radius: 50%;
	float: left;
	font-size: 18px;
	height: 140px;
	line-height: 1;
	margin: 5px;
	padding-top: 30px;
	text-align: centre;
	width: 140px;
}

</style>
<div class="row">
<div class="col-md-8">
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
</div>

</div>
</div>
<?php if (!empty($pathway->steps)) : ?>
<div class="row">
<div class="col-md-8">
<?php 
$totalActivities = 0;
$totalTime = 0;
$claimedcount = 0;
$readclaim = 0;
$watchclaim = 0;
$listenclaim = 0;
$participateclaim = 0;
$readtimetotal = 0;
$watchtimetotal = 0;
$listentimetotal = 0;
$participatetimetotal = 0;


$readtotal = array();
$watchtotal = array();
$listentotal = array();
$participatetotal = array();
?>
<?php foreach ($pathway->steps as $steps) : ?>
<?php


?>

<div class="card ">
<div class="card-body">

<?php if($role == 2 || $role == 5): ?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Edit Step'), ['controller' => 'Steps', 'action' => 'edit', $steps->id], ['class' => 'btn btn-light btn-sm']) ?>
<?= $this->Form->postLink(__('Delete Step'), ['controller' => 'Steps', 'action' => 'delete', $steps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $steps->id), 'class' => 'btn btn-light btn-sm']) ?>
</div> <!-- /.btn-group -->
<?php endif ?>





<?php 

$stepTime = 0;
$stepActivityCount = 0;
$readtime = 0;
$watchtime = 0;
$listentime = 0;
$participatetime = 0;

$defunctacts = array();
$requiredacts = array();
$tertiaryacts = array();

$readcount = array();
$watchcount = array();
$listencount = array();
$participatecount = array();

$readcolor = '255,255,255';
$watchcolor = '255,255,255';
$listencolor = '255,255,255';
$participatecolor = '255,255,255';

$act = array();
foreach ($steps->activities as $activity) {
	// If this is 'defunct' then we pull it out of the list 
	if($activity->status_id == 2) {
		array_push($defunctacts,$activity);
	} else {
		// if it's required
		if($activity->_joinData->required == 1) {
			array_push($requiredacts,$activity);
		// Otherwise it's teriary
		} else {
			array_push($tertiaryacts,$activity);
		}
		// we want to count each type on a per step basis
		// as well as adding to the total
		if($activity->activity_type->name == 'Read') {
			$readcolor = $activity->activity_type->color;
			$readicon = $activity->activity_type->image_path;
			// #TODO probably shouldn't push the whole object onto
			// the array when a simple +1 would do, but ...
			array_push($readcount,$activity);
			array_push($readtotal,$activity);
		} elseif($activity->activity_type->name == 'Watch') {
			$watchcolor = $activity->activity_type->color;
			$watchicon = $activity->activity_type->image_path;
			array_push($watchcount,$activity);
			array_push($watchtotal,$activity);
		} elseif($activity->activity_type->name == 'Listen') {
			$listencolor = $activity->activity_type->color;
			$listenicon = $activity->activity_type->image_path;
			array_push($listencount,$activity);
			array_push($listentotal,$activity);
		} elseif($activity->activity_type->name == 'Participate') {
			$participatecolor = $activity->activity_type->color;
			$participateicon = $activity->activity_type->image_path;
			array_push($participatecount,$activity);
			array_push($participatetotal,$activity);
		}
		$totalActivities++;
		$stepTime = $stepTime + $activity->hours;
		$totalTime = $totalTime + $activity->hours;
		$stepActivityCount++;
	}
}
$readp = ceil((count($readcount) / $stepActivityCount) * 100);
$watchp = ceil((count($watchcount) / $stepActivityCount) * 100);
$listenp = ceil((count($listencount) / $stepActivityCount) * 100);
$pp = ceil((count($participatecount) / $stepActivityCount) * 100);
?>

<h1 class="text-uppercase">
	<div class="float-right">
	<span class="badge badge-light">
	<i class="fas fa-clock"></i>
	<?= $stepTime ?> hours</span></div>
	<!--<?= h($steps->id) ?>.--> <?= h($steps->name) ?>
</h1>
<div class="alert alert-light"><?= h($steps->description) ?></div>

<!--
<div class="progress mb-3" style="font-size: 130%; height: 40px">
<div role="progressbar" class="progress-bar" style="width: <?= $readp ?>%; background-color: rgba(<?= $readcolor ?>,1)" aria-valuenow="<?= $readp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $readicon ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo count($readcount) ?> things to read"></span>
</div>
<div role="progressbar" class="progress-bar" style="width: <?= $watchp ?>%; background-color: rgba(<?= $watchcolor ?>,1)" aria-valuenow="<?= $watchp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $watchicon ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo count($watchcount) ?> things to watch"></span>
</div>
<div role="progressbar" class="progress-bar" style="width: <?= $listenp ?>%; background-color: rgba(<?= $listencolor ?>,1)" aria-valuenow="<?= $listenp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $listenicon ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo count($listencount) ?> things to listen to"></span>
</div>
<div role="progressbar" class="progress-bar" style="width: <?= $pp ?>%; background-color: rgba(<?= $participatecolor ?>,1)" aria-valuenow="<?= $pp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $participateicon ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo count($participatecount) ?> things to participate in"></span>
</div>
</div>
-->






<?php foreach($requiredacts as $activity): ?>

<div class="card mb-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">
	<div class="required" data-toggle="tooltip" data-placement="bottom" title="This activity is required to complete the step">
		<i class="fas fa-check-double"></i>
		Required
	</div>	
	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activitys-steps','action' => 'removeactivity', 'class' => '']]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->button(__('Remove'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle', 'class' => '']]) ?>
	<?php if($activity->_joinData->required == 0): ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
	<?php else: ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
	<?php endif ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Required'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php if($activity->status_id == 2): ?>
	<span class="badge badge-danger">DEFUNCT</span>
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	<span class="badge badge-warning">INVESTIGATE</span>
	<?php endif ?>


	<?php endif; // role check ?>

	<div class="hours" data-toggle="tooltip" data-placement="bottom" title="This activity should take approximately <?= $activity->hours ?> hours to complete">
		<i class="fas fa-clock"></i>
		<?= $activity->hours ?> hours
	</div>

	<?php foreach($activity->tags as $tag): ?>
	<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a>
	<?php endforeach ?>


	<h1 class="my-3">
		<?= $activity->name ?>
		<?php if($role == 2 || $role == 5): ?>
		<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>
		<?php endif ?>
	</h1>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<?= $activity->description ?>
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
	
	<div class="mb-3 p-3 bg-white">
		<iframe width="100%" 
			height="315" 
			src="https://www.youtube.com/embed/<?= h($activity->hyperlink) ?>/" 
			frameborder="0" 
			allow="" 
			allowfullscreen>
		</iframe>
	</div>



	<?php endif ?>	

	<?php endforeach ?>





	<?php else: ?>


<a target="_blank" 
	data-toggle="tooltip" data-placement="bottom" title="<?= $activity->activity_type->name ?> this activity"
	href="<?= $activity->hyperlink ?>" 
	style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
	class="btn btn-block my-3 text-uppercase btn-lg">

		<i class="fas <?= $activity->activity_type->image_path ?>"></i>

		<?= $activity->activity_type->name ?>

</a>


<?php endif ?>	












		<a href="#" style="color:#333;" class="btn btn-light float-right" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
			<i class="fas fa-exclamation-triangle"></i>
		</a>	
		<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
		</a>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => '']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'You\'ve completed it, now claim it so it shows up on your profile', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<?php
	if($activity->activity_type->name == 'Read') {
		$readclaim++;
	} elseif($activity->activity_type->name == 'Watch') {
		$watchclaim++;
	} elseif($activity->activity_type->name == 'Listen') {
		$listenclaim++;
	} elseif($activity->activity_type->name == 'Participate') {
		$participateclaim++;
	}
	?>
	<div class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div>

	<?php endif ?>
	<?php endif ?>




</div>
</div>

<?php endforeach ?>










<p>The following activities are supplemental and not required to complete this pathway.</p>


<div class="card-columns">
<?php foreach($tertiaryacts as $activity): ?>
	
<div class="card" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">
	
	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activitys-steps','action' => 'removeactivity', 'class' => '']]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->button(__('Remove'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle', 'class' => '']]) ?>
	<?php if($activity->_joinData->required == 0): ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
	<?php else: ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
	<?php endif ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Required'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php if($activity->status_id == 2): ?>
	<span class="badge badge-danger">DEFUNCT</span>
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	<span class="badge badge-warning">INVESTIGATE</span>
	<?php endif ?>


	<?php endif ?>
	<div class="hours" data-toggle="tooltip" data-placement="bottom" title="This activity should take approximately <?= $activity->hours ?> hours to complete">
		<i class="fas fa-clock"></i>
		<?= $activity->hours ?> hours
	</div>

	<?php foreach($activity->tags as $tag): ?>
	<a href="#" class="badge badge-light"><?= $tag->name ?></a>
	<?php endforeach ?>


	<h2 class="my-3">
		<?= $activity->name ?>
		<?php if($role == 2 || $role == 5): ?>
		<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>
		<?php endif ?>
	</h2>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<?= $activity->description ?>
	</div>











	<a target="_blank" 
		data-toggle="tooltip" data-placement="bottom" title="<?= $activity->activity_type->name ?> this activity"
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>
	</a>















	<a href="#" style="color:#333;" class="btn btn-light float-right" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
		<i class="fas fa-exclamation-triangle"></i>
	</a>	
		<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
		</a>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => '']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'You\'ve completed it, now claim it so it shows up on your profile', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<?php
	if($activity->activity_type->name == 'Read') {
		$readclaim++;
	} elseif($activity->activity_type->name == 'Watch') {
		$watchclaim++;
	} elseif($activity->activity_type->name == 'Listen') {
		$listenclaim++;
	} elseif($activity->activity_type->name == 'Participate') {
		$participateclaim++;
	}
	?>
	<div class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div>
	<?php endif ?>
	<?php endif ?>


</div>
</div>

<?php endforeach ?>
</div>


<?php if(!empty($defunctacts)): ?>
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

<?php endforeach; ?>
<div class="card mb-3">
<div class="card-body">
<h1>The End</h1>

	<?= $this->Text->autoParagraph(h($pathway->objective)); ?>
</div>
</div>
</div> <!-- /.col-md-8 -->
<?php endif; ?>
<div class="col-md-4">

<div class="card mb-3">
<div class="card-body">


<?php if(!empty($uid)): ?>
<?php if(in_array($uid,$usersonthispathway)): ?>

<h1 class="mb-3 following">You're following this pathway!</h1>















<canvas id="myChart" width="400" height="400"></canvas>


<div style="border-radius: 3px;">
<div class="stats my-3 text-center" style="border-radius: 3px; color: #FFF; ">
<div class="activity-badge" style="background-color: rgba(<?= $readcolor ?>, 1)">
	<span class="fas <?= $readicon ?>" style="font-size:230%;"></span><br>
	Read <br><?= $readclaim ?> of <?php echo count($readtotal) ?>
</div>
<div class="activity-badge" style="background-color: rgba(<?= $watchcolor ?>, 1)">
	<span class="fas <?= $watchicon ?>" style="font-size:230%;"></span><br>
	Watched <br><?= $watchclaim ?> of <?php echo count($watchtotal) ?>
</div>
<div class="activity-badge" style="background-color: rgba(<?= $listencolor ?>, 1)">
	<span class="fas <?= $listenicon ?>" style="font-size:230%;"></span><br>
	Listened <br><?= $listenclaim ?> of <?php echo count($listentotal) ?>
</div>
<div class="activity-badge" style="background-color: rgba(<?= $participatecolor ?>, 1)">
	<span class="fas <?= $participateicon ?>" style="font-size:230%;"></span><br>
	Participated <br><?= $participateclaim ?> of <?php echo count($participatetotal) ?> 
</div>
</div>
</div>

<div>
<span class="badge badge-dark"><?= $totalActivities ?></span> Total activities<br>
<span class="badge badge-dark"><?= $totalTime ?></span> hours of time<br>
</div>






<div class="my-3"><em>You started following this pathway on January 17th 2020.</em></div>


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
<?php else: ?>


<h1>Follow this pathway?</h1>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create(null, ['url' => ['controller' => 'users', 'action' => 'login']]) ?>
        <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
        <?= $this->Form->control('password', ['required' => true, 'class' => 'form-control']) ?>
    <?= $this->Form->submit(__('IDIR Login'), ['class' => 'btn btn-success btn-block mt-3']); ?>
    <?= $this->Form->end() ?>

<?php endif ?>


</div>
</div>
<!--<div class="card">
<div class="card-body">
<h2><?= __('Competencies') ?></h2>
<?php if (!empty($pathway->competencies)) : ?>
<?php foreach ($pathway->competencies as $competencies) : ?>
<?= $this->Html->link($competencies->name, ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>, 
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>-->
</div>
</div>
</div>
<?php

if(!empty($readclaim) && count($readtotal) > 0) {
	$readpercent = floor($readclaim / count($readtotal) * 100);
	$readpercentleft = 100 - $readpercent;
} else {
	$readpercent = 0;
	$readpercentleft = 100;       
}
if(!empty($watchclaim) && count($watchtotal) > 0) {
	$watchpercent = floor($watchclaim / count($watchtotal) * 100);
	$watchpercentleft = 100 - $watchpercent;
} else {
	$watchpercent = 0;
	$watchpercentleft = 100;
}
if(!empty($listenclaim) && count($listentotal) > 0) {
	$listenpercent = floor($listenclaim / count($listentotal) * 100);
	$listenpercentleft = 100 - $listenpercent;
} else {
	$listenpercent = 0;
	$listenpercentleft = 100;
}
if(!empty($participateclaim) && count($participatetotal) > 0) {
	$participatepercent = floor($participateclaim / count($participatetotal) * 100);
	$participatepercentleft = 100 - $participatepercent;
} else {
	$participatepercent = 0;
	$participatepercentleft = 100;
}
$percentages = array(
        array($readpercent,$readpercentleft,$readcolor),
        array($watchpercent,$watchpercentleft,$watchcolor),
        array($listenpercent,$listenpercentleft,$listencolor),
        array($participatepercent,$participatepercentleft,$participatecolor),
);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<script>
//
// Get the summary for this pathway independently of the page load
//
var request = new XMLHttpRequest();
request.open('GET', '/pathways/status/<?= $pathway->id ?>', true);

request.onload = function() {
  if (this.status >= 200 && this.status < 400) {
    // Success!
    var chartdata = JSON.parse(this.response);
	document.querySelector('.following').innerHTML = chartdata.status;
	var ctx = document.getElementById('myChart').getContext('2d');
	var myDoughnutChart = new Chart(ctx, {
		type: 'doughnut',
		data: JSON.parse(chartdata.chartjs),
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
request.onerror = function() {
  // There was a connection error of some sort
};
request.send();




	
</script>



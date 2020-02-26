<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
	$name = $this->Identity->get('role_id');
}
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

<h1>
	<div class="float-right"><span class="badge badge-light"><?= $stepTime ?> hours</span></div>
	<!--<?= h($steps->id) ?>.--> <?= h($steps->name) ?>
</h1>
<div class="alert alert-light"><?= h($steps->description) ?></div>
<div class="progress mb-3" style="font-size: 130%; height: 40px">
<div role="progressbar" class="progress-bar" style="width: <?= $readp ?>%; background-color: rgba(<?= $readcolor ?>,1)" aria-valuenow="<?= $readp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $readicon ?>" title="<?php echo count($readcount) ?> things to read"></span>
	<?php //echo count($readcount) ?> 
</div>
<div role="progressbar" class="progress-bar" style="width: <?= $watchp ?>%; background-color: rgba(<?= $watchcolor ?>,1)" aria-valuenow="<?= $watchp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $watchicon ?>" title="<?php echo count($watchcount) ?> things to watch"></span>
	<?php //echo count($watchcount) ?>
</div>
<div role="progressbar" class="progress-bar" style="width: <?= $listenp ?>%; background-color: rgba(<?= $listencolor ?>,1)" aria-valuenow="<?= $listenp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $listenicon ?>" title="<?php echo count($listencount) ?> things to listen to"></span>
	<?php //echo count($listencount) ?>
</div>
<div role="progressbar" class="progress-bar" style="width: <?= $pp ?>%; background-color: rgba(<?= $participatecolor ?>,1)" aria-valuenow="<?= $pp ?>" aria-valuemin="0" aria-valuemax="100">
	<span class="fas <?= $participateicon ?>" title="<?php echo count($participatecount) ?> things to participate in"></span>
	<?php //echo count($participatecount) ?> 
</div>
</div>







<?php foreach($requiredacts as $activity): ?>

<div class="card mb-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border: 0;">
<div class="card-body">
	
	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit Activity'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activitys-steps','action' => 'removeactivity', 'class' => '']]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->button(__('Remove from step'),['class'=>'btn btn-sm btn-light']) ?>
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
	DEFUNCT
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	INVESTIGATE
	<?php endif ?>


	<?php endif ?>

	<span class="badge badge-light"><?= $activity->hours ?> hours</span>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'float-right']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<?php
	if($activity->activity_type->name == 'Read') {
		$readtime = $readtime + $activity->hours;
		$readtimetotal = $readtime + $activity->hours;
		$readclaim++;
	} elseif($activity->activity_type->name == 'Watch') {
		$watchtime = $watchtime + $activity->hours;
		$watchtimetotal = $watchtime + $activity->hours;
		$watchclaim++;
	} elseif($activity->activity_type->name == 'Listen') {
		$listentime = $listentime + $activity->hours;
		$listentimetotal = $listentime + $activity->hours;
		$listenclaim++;
	} elseif($activity->activity_type->name == 'Participate') {
		$participatetime = $participatetime + $activity->hours;
		$participatetimetotal = $participatetime + $activity->hours;
		$participateclaim++;
	}
	?>
	<span class="badge badge-dark">Claimed</span>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>

	<span class="badge">REQUIRED</span><br>
	<?php foreach($activity->tags as $tag): ?>
	<span class="badge badge-light"><?= $tag->name ?></span>
	<?php endforeach ?>


	<h1 class=""><?= $activity->name ?></h1>
	<div class=""><?= $activity->description ?></div>


	<a target="_blank" 
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); border: 4px solid #FFF; color: #FFF; font-weight: bold;" 
		class="btn btn-block my-2 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>
			
			<?= $activity->activity_type->name ?>
	</a>
	<a href="#" class="btn btn-link btn-sm" title="Report this activity for some reason">Report</a>	
</div>
</div>

<?php endforeach ?>













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

	<span class="badge badge-light"><?= $activity->hours ?> hours</span>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'float-right mt-3']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light']) ?>
	<?= $this->Form->end() ?><br>
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
	<span class="badge badge-dark">Claimed</span><br>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>
	<?php foreach($activity->tags as $tag): ?>
	<span class="badge badge-light"><?= $tag->name ?></span>
	<?php endforeach ?>


	<h2 class=""><?= $activity->name ?></h2>
	<div class=""><?= $activity->description ?></div>
	<a target="_blank" 
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); border: 4px solid #FFF; color: #FFF; font-weight: bold;" 
		class="btn btn-block my-2 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>
			<?= $activity->activity_type->name ?>
	</a>
	<div class="btn-group float-right mb-3">
		<a href="#" style="color:#333;" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
			<i class="fas fa-exclamation-triangle"></i>
		</a>	
		<a href="#" style="color:#333;" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
			<i class="fas fa-thumbs-up"></i>
		</a>
	</div>

</div>
</div>

<?php endforeach ?>
</div>


<?php if(!empty($defunctacts)): ?>
<h3>Defunct</h3>
<?php foreach($defunctacts as $activity): ?>
<?= $activity->name ?><br>
<?php endforeach ?>
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

<h1 class="mb-3">You're following this pathway!</h1>




<div class="stats my-3">

<span class="badge badge-dark" style="background-color: rgba(<?= $readcolor ?>, 1)">
	<span class="fas <?= $readicon ?>"></span>
	Read <?= $readclaim ?> of <?php echo count($readtotal) ?>
</span>
<span class="badge badge-dark" style="background-color: rgba(<?= $watchcolor ?>, 1)">
	<span class="fas <?= $watchicon ?>"></span>
	Watched <?= $watchclaim ?> of <?php echo count($watchtotal) ?>
</span>
<span class="badge badge-dark" style="background-color: rgba(<?= $listencolor ?>, 1)">
	<span class="fas <?= $listenicon ?>"></span>
	Listened <?= $listenclaim ?> of <?php echo count($listentotal) ?>
</span>
<span class="badge badge-dark" style="background-color: rgba(<?= $participatecolor ?>, 1)">
	<span class="fas <?= $participateicon ?>"></span>
	Participated <?= $participateclaim ?> of <?php echo count($participatetotal) ?> 
</span>
</div>










<canvas id="myChart" width="400" height="400"></canvas>





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
$readpercent = floor($readclaim / count($readtotal) * 100);
$readpercentleft = 100 - $readpercent;
$watchpercent = floor($watchclaim / count($watchtotal) * 100);
$watchpercentleft = 100 - $watchpercent;
$listenpercent = floor($listenclaim / count($listentotal) * 100);
$listenpercentleft = 100 - $listenpercent;
$participatepercent = floor($participateclaim / count($participatetotal) * 100);
$participatepercentleft = 100 - $participatepercent;
$percentages = array(
        array($readpercent,$readpercentleft,$readcolor),
        array($watchpercent,$watchpercentleft,$watchcolor),
        array($listenpercent,$listenpercentleft,$listencolor),
        array($participatepercent,$participatepercentleft,$participatecolor),
);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var data = {
    datasets: [
<?php foreach($percentages as $ring): ?>
{
	data: [<?= $ring[0] ?>,<?= $ring[1] ?>],
	labels: ['all the same','not all'],
	'backgroundColor': ['rgba(<?= $ring[2] ?>,1)','rgba(<?= $ring[2] ?>,.2)']
},
<?php endforeach ?>
],

	labels: ['Percent done','Percent left']
};

var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: { 
        legend: { 
            display: false 
        },
    }
});



</script>



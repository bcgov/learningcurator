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
<div><?= $pathway->has('category') ? $this->Html->link($pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $pathway->category->id]) : '' ?></div>
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

<h1><!--<?= h($steps->id) ?>.--> <?= h($steps->name) ?></h1>
<div class="mb-3"><?= h($steps->description) ?></div>




<?php 
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
			array_push($readcount,$activity);
			array_push($readtotal,$activity);
		} elseif($activity->activity_type->name == 'Watch') {
			array_push($watchcount,$activity);
			array_push($watchtotal,$activity);
		} elseif($activity->activity_type->name == 'Listen') {
			array_push($listencount,$activity);
			array_push($listentotal,$activity);
		} elseif($activity->activity_type->name == 'Participate') {
			array_push($participatecount,$activity);
			array_push($partcipatetotal,$activity);
		}
		$totalActivities++;
		$totalTime = $totalTime + $activity->hours;
	}
}
?>
<div class="mb-1">
<span class="badge badge-light"><?php echo count($readcount) ?> to read</span>
<span class="badge badge-light"><?php echo count($watchcount) ?> to watch</span>
<span class="badge badge-light"><?php echo count($listencount) ?> to listen</span>
<span class="badge badge-light"><?php echo count($participatecount) ?> to participate</span>
</div>
<?php foreach($requiredacts as $activity): ?>
<div class="alert" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2)">
	
	<img width="150" src="<?= $activity->activity_type->image_path ?>" alt="Activity type glyph">
	
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

	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'float-right']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<span class="badge badge-dark">Claimed</span>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>

	<span class="badge badge-danger">Required</span>
	<span class="badge badge-light"><?= $activity->hours ?> hours</span><br>
	<?php foreach($activity->tags as $tag): ?>
	<span class="badge badge-light"><?= $tag->name ?></span>
	<?php endforeach ?>


	<h1 class=""><?= $activity->name ?></h1>
	<div class=""><?= $activity->description ?></div>
	<a target="_blank" href="<?= $activity->hyperlink ?>" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF;" class="btn btn-block btn-outline-light my-2 text-uppercase btn-lg"><?= $activity->activity_type->name ?></a>

	
</div>
<?php endforeach ?>




<div class="row">
<?php foreach($tertiaryacts as $activity): ?>
<div class="col-md-6">
<div class="alert" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2)">
	<img width="75" src="<?= $activity->activity_type->image_path ?>" alt="Activity type glyph">
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

	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'float-right mt-3']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<span class="badge badge-dark">Claimed</span>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>
	<span class="badge badge-light"><?= $activity->hours ?> hours</span><br>
	<?php foreach($activity->tags as $tag): ?>
	<span class="badge badge-light"><?= $tag->name ?></span>
	<?php endforeach ?>


	<h2 class=""><?= $activity->name ?></h2>
	<div class=""><?= $activity->description ?></div>
	<a target="_blank" href="<?= $activity->hyperlink ?>" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF;" class="btn btn-block my-2 text-uppercase btn-lg"><?= $activity->activity_type->name ?></a>


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
<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><style>
     
         .line-arrow-down1{animation: line-arrow-down1-fly 3s infinite ease-in-out;}
         @keyframes line-arrow-down1-fly{
             0% { transform: translate3d(0, -200px, 0);}
             30% {transform: translate3d(0, 0, 0);}
             40% {transform: translate3d(0, -4px, 0);}
             50% {transform: translate3d(0, 0, 0);}
             70% {transform: translate3d(0, -4px, 0);}
             100% {transform: translate3d(0, 240px, 0);}
         }
     
    </style><path class="line-arrow-down1" d="M48.9919 5L48.9919 95M48.9919 95L85 59.1525M48.9919 95L13.75 59.1525" stroke="#000" stroke-width="2px" stroke-linecap="round" style="animation-duration: 3s;"></path></svg>
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
Read: <?php echo count($readtotal) ?>
Watch: <?php echo count($watchtotal) ?>
Listen: <?php echo count($listentotal) ?>
Participate: <?php echo count($participatetotal) ?>
<?php 
$pathwayPercent = 66;
$count = 12;
$pathcount = 4;
?>
<canvas id="myChart" width="400" height="400"></canvas>
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

<div class="stats my-3">
<span class="badge badge-light"><?= $totalActivities ?></span> Total activities<br>
<span class="badge badge-light"><?= $totalTime ?></span> hours of time<br>
<!--<span class="badge badge-light">4</span> acitivies to read<br>
<span class="badge badge-light">3</span> acitivies to watch<br>
<span class="badge badge-light">2</span> acitivies to listen to<br>
<span class="badge badge-light">2</span> acitivies to participate in-->
</div>
</div>
</div>
<div class="card">
<div class="card-body">
<h2><?= __('Competencies') ?></h2>
<?php if (!empty($pathway->competencies)) : ?>
<?php foreach ($pathway->competencies as $competencies) : ?>
<?= $this->Html->link($competencies->name, ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>, 
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var data = {
    datasets: [{
        data: [50, 50],
        'backgroundColor':['rgba(71,189,182,1)','rgba(71,189,182,.2)'],
    },
    {
        data: [25, 75],
        'backgroundColor':['rgba(240,203,86,1)','rgba(240,203,86,.2)'],
    },
    {
        data: [60, 40],
        'backgroundColor':['rgba(229,76,59,1)','rgba(229,76,59,.2)'],
    },
    {
        data: [80, 20],
        'backgroundColor':['rgba(134, 33, 206,1)','rgba(134, 33, 206,.2)'],
    }
]
};

var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: []
});



</script>



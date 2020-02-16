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
<!--<div><?= $pathway->has('category') ? $this->Html->link($pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $pathway->category->id]) : '' ?></div>-->
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
$readCount = 0;
$watchCount = 0;
$participateCount = 0;
$listenCount = 0;
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
	if($activity->status == 2) {
		array_push($defunctacts,$activity);
	} else {
		if($activity->_joinData->required == 1) {
			array_push($requiredacts,$activity);
		} else {
			array_push($tertiaryacts,$activity);
		}
		if($activity->activity_type->name == 'Read') {
			array_push($readcount,$activity);
		} elseif($activity->activity_type->name == 'Watch') {
			array_push($watchcount,$activity);
		} elseif($activity->activity_type->name == 'Listen') {
			array_push($listencount,$activity);
		} elseif($activity->activity_type->name == 'Participate') {
			array_push($participatecount,$activity);
		}
		$totalActivities++;
		$totalTime = $totalTime + $activity->hours;
	}
}
print 'Reading: ' . count($readcount) . ' ';
print 'Watching: ' . count($watchcount) . ' ';
print 'Listening: ' . count($listencount) . ' ';
print 'Participating: ' . count($participatecount) . ' ';
?>

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
	<div>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim']]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-dark']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php else: ?>
	<span class="badge badge-dark">Claimed</span>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>

	<span class="badge badge-danger">Required</span>
	<span class="badge badge-dark"><?= $activity->hours ?> hours</span><br>
	<h1 class=""><?= $activity->name ?></h1>
	<div class=""><?= $activity->description ?></div>
	<a target="_blank" href="<?= $activity->hyperlink ?>" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF;" class="btn btn-block btn-outline-light my-2 text-uppercase btn-lg"><?= $activity->activity_type->name ?></a>

	
	<?php foreach($activity->tags as $tag): ?>
	<?= $tag->name ?>
	<?php endforeach ?>

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
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'float-right']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<span class="badge badge-dark">Claimed</span>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>
	<span class="badge badge-dark"><?= $activity->hours ?> hours</span><br>
	<h2 class=""><?= $activity->name ?></h2>
	<div class=""><?= $activity->description ?></div>
	<a target="_blank" href="<?= $activity->hyperlink ?>" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF;" class="btn btn-block my-2 text-uppercase btn-lg"><?= $activity->activity_type->name ?></a>


</div>
</div>
<?php endforeach ?>
</div>









</div> <!-- /.card-body -->
</div> <!-- /.card -->
<div class="text-center mb-3" style="font-size: 60px; line-height: 60px;">&#8595;</div>
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
<div class="radial"></div>
<div>
<?php 
$pathwayPercent = 66;
$count = 12;
$pathcount = 4;
?>
<div class="progress" style="height: 30px">
<div class="progress-bar" role="progressbar" style="width: <?= $pathwayPercent ?>%;" aria-valuenow="<?= $pathwayPercent ?>" aria-valuemin="0" aria-valuemax="100"><?= $pathwayPercent ?>%</div>
</div>
of the way through.</div>
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


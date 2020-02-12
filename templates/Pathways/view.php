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
<div class="card card-primary mb-3">
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

<div class="card card-primary">
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
$requiredacts = array();
$tertiaryacts = array();
$act = array();
foreach ($steps->activities as $activity) {
	// if it's required
	if($activity->_joinData->required == 1) {
		array_push($requiredacts,$activity);
	} else {
		array_push($tertiaryacts,$activity);
	}
	$totalActivities++;
	$totalTime = $totalTime + $activity->hours;

}
?>







<?php foreach ($steps->activities as $activity) : ?>
 
<?php if($activity->status_id == 1): ?>
ACTIVE
<?php elseif($activity->status_id == 2): ?>
DEFUNCT
<?php endif ?>
<?php if($activity->moderation_flag == 1): ?>
INVESTIGATE
<?php endif ?>
<?php if($activity->_joinData->required == 1): ?>
<div class="alert alert-primary">
<?php else: ?>
<div class="alert alert-light">
<?php endif ?>
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
	<?php endif ?>

	<?php if($activity->_joinData->required == 1): ?>
	<span class="badge badge-danger">Required</span>
	<?php endif ?>
	<!--<span class="badge badge-light"><?= $activity->activity_type->name ?> </span>-->
	<span class="badge badge-primary"><?= $activity->hours ?> hours</span><br>
	<?php if($activity->_joinData->required == 1): ?>
	<h1><!--<?= $activity->id ?>.--> <?= $activity->name ?></h1>
	<?php else: ?>
	<h3><a href="<?= $activity->hyperlink ?>"><?= $activity->name ?></a></h3>
	<?php endif ?>
	<?= $activity->description ?>
	<a target="_blank" href="<?= $activity->hyperlink ?>" class="btn btn-block btn-light my-2 text-uppercase btn-lg"><?= $activity->activity_type->name ?></a>
	<?php if($activity->activity_type->name == 'Watch'): ?> 
	<div><img src="/img/watch-mockup.png" alt="Mocked up video thumbnail" width="320"></div>
	<?php endif ?>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<div>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim']]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php else: ?>
	<span class="badge badge-success">Claimed</span>
	<?php endif ?>
	<?php else: ?>
	<?php endif ?>
</div>
<?php endforeach; ?>










</div> <!-- /.card-body -->
</div> <!-- /.card -->
<div class="text-center mb-3" style="font-size: 60px; line-height: 60px;">&#8595;</div>
<?php endforeach; ?>

</div> <!-- /.col-md-8 -->
<?php endif; ?>
<div class="col-md-4">

<div class="card mb-3">
<div class="card-body">
<?php if(!empty($uid)): ?>
<?php if(in_array($uid,$usersonthispathway)): ?>
<h1 class="mb-3">You're following this pathway!</h1>
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
<?php endif ?>

<div class="stats my-3">
<span class="badge badge-light"><?= $totalActivities ?></span> Total activities<br>
<span class="badge badge-light"><?= $totalTime ?></span> hours of time<br>
<!--<span class="badge badge-light">4</span> acitivies to read<br>
<span class="badge badge-light">3</span> acitivies to watch<br>
<span class="badge badge-light">2</span> acitivies to listen to<br>
<span class="badge badge-light">2</span> acitivies to participate in-->
</div>
<div class="progress" style="height: 60px">
  <div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Read (3)</div>
  <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Watch (3)</div>
<!--  <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Listen</div>-->
  <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Participate (3)</div>
</div>
</div>
</div>
<div class="card card-primary">
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


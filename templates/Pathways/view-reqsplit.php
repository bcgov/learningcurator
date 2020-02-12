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
	<div><em>Objective</em></div>
	<?= $this->Text->autoParagraph(h($pathway->objective)); ?>
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


<?php foreach ($requiredacts as $ra) : ?>
<div class="alert alert-primary">
	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit Activity'), ['controller' => 'Activities', 'action' => 'edit', $ra['id']], ['class' => 'btn btn-light btn-sm']) ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activitys-steps','action' => 'removeactivity', 'class' => '']]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $ra['id']]) ?>
	<?= $this->Form->button(__('Remove from step'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle', 'class' => '']]) ?>
	<?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $ra['id']]) ?>
	<?= $this->Form->button(__('Required'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php endif ?>


	<span class="badge badge-danger">Required</span>
	<span class="badge badge-primary"><?= $ra['hours'] ?> hours</span><br>
	<h2><?= $ra['name'] ?></h2>
	<?= $ra['description'] ?>
	<a target="_blank" href="<?= $ra['hyperlink'] ?>" class="btn btn-block btn-light my-2 text-uppercase btn-lg"><?= $ra['activity_type']['name'] ?></a>
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
<?php endforeach ?>

<?php foreach ($tertiaryacts as $ta) : ?>
	<h4>
		<span class="badge badge-primary"><?= $ta['hours'] ?> hours</span>
		<a href="<?= $ta['name'] ?>"><?= $ta['name'] ?></a>
	</h4>
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
<?php endforeach ?>


<?php foreach ($steps->activities as $activity) : ?>
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
	<h2><!--<?= $activity->id ?>.--> <?= $activity->name ?></h2>
	<?= $activity->description ?>
	<a target="_blank" href="<?= $activity->hyperlink ?>" class="btn btn-block btn-light my-2 text-uppercase btn-lg"><?= $activity->activity_type->name ?></a>
	<?php else: ?>
	<div><a href="<?= $activity->hyperlink ?>"><?= $activity->name ?></a></div>
	<?php endif ?>
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
<?= $this->Form->button(__('Follow this pathway'),['class' => 'btn btn-lg btn-dark mb-3']) ?>
<?= $this->Form->end() ?>
<?php endif ?>
<?php endif ?>

<div class="stats my-3">
<span class="badge badge-light"><?= $totalActivities ?></span> Total activities<br>
<span class="badge badge-light"><?= $totalTime ?></span> hours of time<br>
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

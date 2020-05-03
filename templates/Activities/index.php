<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
*/
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>

<style>
.activity-icon {
	border-radius: 50%;
	color: #FFF;
	display: inline-block;
	height: 50px;
	padding-top: 12px;
	text-align: center;
	width: 50px;
}
</style>
<div class="row justify-content-md-center">
<div class="col-md-9">
<div class="card mb-3">
<div class="card-body">

<?= $this->Html->link(__('New Activity'), ['activity' => 'add'], ['class' => 'btn btn-dark float-right']) ?>

<h1><?= __('Latest Activities') ?></h1>

<h4><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></h4>
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
<?php foreach ($activities as $activity): ?>

<div class="p-3 mb-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2)">

<h3>
	<div class="activity-icon" style="background-color: rgba(<?= $activity->activity_type->color ?>,1)">
		<i class="fas <?= $activity->activity_type->image_path ?>"></i>
	</div>
	<?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>
</h3>
<div class="alert alert-light">
	<?= $activity->description ?>
	<div class="mt-2"><span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i></div>
	<div class="mt-2" style="font-size: 12px">Added on <?= $activity->created ?></div>

</div>


<?php if($role == 2 || $role == 5): ?>
<button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#assignment<?= $activity->id ?>" aria-expanded="false" aria-controls="assignment<?= $activity->id ?>">
    Path Assigment
  </button>
<?php endif ?>
<?php foreach($activity->steps as $step): ?>
<?php foreach($step->pathways as $path): ?>
<span class="badge badge-light"><a href="/pathways/view/<?= $path->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
<?php endforeach ?>
<?php endforeach ?>


<?php if($role == 2 || $role == 5): ?>
<div class="collapse" id="assignment<?= $activity->id ?>">
<?php foreach($allpathways as $pathway): ?>
<div class="my-1 p-3" style="background-color: rgba(255,255,255,.3)">
<button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#steps<?= $pathway->id ?>" aria-expanded="false" aria-controls="steps<?= $pathway->id ?>">
    Steps
  </button>
<?= $pathway->name ?>

<div class="collapse p-3" id="steps<?= $pathway->id ?>">
<?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'add', 'class' => '']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id ]) ?>
<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
<?php foreach($pathway->steps as $step): ?>
<label style="display: inline-block; margin: 0 10px 0 5px;">
<input id="step_id_<?= $step->id ?>" type="radio" name="step_id" value="<?= $step->id ?>">
<?= $step->name ?>
</label>
<?php endforeach ?>
<?= $this->Form->button(__('Assign'),['class'=>'btn btn-sm btn-light']) ?>
<?= $this->Form->end() ?>
</div>
</div>
<?php endforeach ?>
</div>
<?php endif ?>

</div>
<?php endforeach; ?>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
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
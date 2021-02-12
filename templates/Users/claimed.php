<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
$this->layout = 'nowrap';
?>
<style>
.badge {
	border-radius: 50%;
	color:#FFF; 
	display: inline-block;
	font-size: 24px;
	height: 50px;
	padding-top: 12px;
	width: 60px;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="pad-sm">
	<h1>
		Welcome <?= h($user->name) ?> 	
		<a class="" data-toggle="collapse" href="#editname" role="button" aria-expanded="false" aria-controls="editname">
			<i class="fas fa-edit"></i>
		</a>
	</h1>

	<div class="collapse" id="editname">
	<div class="row">
	<div class="col-sm-12 col-md-7 col-lg-5">
	<div class="p-3" style="background-color: rgba(255,255,255,.5)">	
		<p>Update your display name here. This is the name that will be used on 
		any completion certificates that you might earn.</p>
		<?= $this->Form->create(null, ['url' => [
			'controller' => 'Users',
			'action' => 'edit/' . $user->id
		]]) ?>
		<?= $this->Form->control('name',['class'=>'form-control','value' => $user->name, 'label' => false]) ?>
		<?= $this->Form->hidden('id', ['value' => $user->id]) ?>
		<?= $this->Form->button(__('Update name'), ['class'=>'btn btn-light']) ?>
		<?= $this->Form->end() ?>
	</div>
	</div>
	</div>
	</div>

</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-8 col-lg-6">
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link" href="/users/pathways">Pathways</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="/users/claimed">Claimed</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/users/reports">Reports</a>
  </li>
</ul>
</div>
<div class="w-100"></div>
<div class="col-md-8 col-lg-6">
<?php if (!empty($user->activities)) : ?>
<h2><i class="fas fa-check"></i> <?= __('Claimed Activities') ?></h2>
<p>As you claim activities, they will appear here.</p>
<div id="activitylist">
<input type="text" name="activityfilter" id="activityfilter" placeholder="Filter" class="search form-control mb-3">


<div class="list"> 
	<?php foreach ($user->activities as $activity) : ?>
	
	<div class="p-3 mb-2 bg-white rounded-lg">
	<?= $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $activity->_joinData->id], ['class' => 'btn btn-sm btn-dark float-right', 'confirm' => __('Really delete?')]) ?>
		<?php if($activity->status_id == 3): ?>
		<span class="badge badge-warning" title="This link has been deemed to be non-functional or no longer relevant to the pathway">DEFUNCT</span>
		<?php endif ?>

		<a href="/activity-types/view/<?= $activity->activity_type->id ?>" 
			class="activity-icon activity-icon-md" 
			style="background-color: rgba(<?= $activity->activity_type->color ?>,1)">
				<i class="activity-icon activity-icon-md fas <?= $activity->activity_type->image_path ?>"></i>
			
		</a>
		<h4>
		<span class="name"><?= $this->Html->link(h($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></span>
		</h4>

		<div class="p-3 bg-light rounded-lg">
		From: 
		<?php foreach ($activity->steps as $step) : ?>
		<?php foreach ($step->pathways as $path) : ?>
		<a href="/pathways/view/<?= $path->id ?>"><?= $path->name ?></a>
		<?php endforeach; ?>
		 - <a href="/steps/view/<?= $step->id ?>"><?= $step->name ?></a>
		<?php endforeach; ?>
		</div>
		
	</div>
	<?php endforeach; ?>
</div> <!-- /.list -->
</div> <!-- /#activitylist -->



<?php else: ?>
<h2><?= _('You\'ve not claimed any activities yet.') ?></h2>
<p>As you claim activities, they will appear here, along with any pathways you might be following.</p>

<?php endif; ?>

<div class="card card-body my-3">
	<p>If you're looking for something specific, try searching for it!</p>
	<form method="get" action="/activities/find" class="form-inline my-2 my-lg-0">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
		<button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
	</form>
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
	
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
var options = {
    valueNames: [ 'name' ]
};

var hackerList = new List('activitylist', options);
</script>
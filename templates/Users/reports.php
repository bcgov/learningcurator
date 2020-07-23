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
    <a class="nav-link" href="/learning-curator/users/pathways">Pathways</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/learning-curator/users/bookmarks">Bookmarks</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/learning-curator/users/claimed">Claimed</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="/learning-curator/users/reports">Reports</a>
  </li>
</ul>
</div>
<div class="w-100"></div>
<div class="col-md-8 col-lg-6">



<?php if(!empty($user->reports)): ?>
<h2 class="mt-3"><i class="fas fa-exclamation-triangle"></i> Reports</h2>
<?php foreach($user->reports as $report): ?>
<div class="my-3 p-3 bg-white rounded-lg">
<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right btn btn-dark']) ?>
<div class="mt-2">On <?= $report->created ?> you reported:</div>
<h4><a href="/learning-curator/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></h4>
<div class="p-3 bg-light"><?= $report->issue ?></div>
<?php if(empty($report->response)): ?>
<div class="my-2 alert alert-warning">No reply yet</div>
<?php else: ?>
<div class="mt-3">
Curator repsonse:
<div class="my-2 alert alert-success"><?= $report->response ?></div>
</div>
<?php endif ?>
</div>
<?php endforeach ?>
<?php endif ?>




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
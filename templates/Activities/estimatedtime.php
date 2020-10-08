<?php
$this->layout = 'nowrap';
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>

<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-7">
<?php foreach($activities as $activity): ?>
<?php
// I _cannot_ make my query contain the activity_types
// so I'm creating this manual mapping for the time 
// being #TODO 
//1 -Watch	193,129,183	fa-video	Edit
//2 - Read	249,145,80	fa-book-reader	Edit
//3 - Listen	244,105,115	fa-headphones	Edit
//4 - Participate	255,218,96	fa-users
$bgcolor = '';
$acticon = '';
if($activity->activity_types_id == 1) {
	$bgcolor = '193,129,183';
	$acticon = 'fa-video';
} elseif($activity->activity_types_id == 2) {
	$bgcolor = '249,145,80';
	$acticon = 'fa-book-reader';
} elseif($activity->activity_types_id == 3) {
	$bgcolor = '244,105,115';
	$acticon = 'fa-headphones';
} elseif($activity->activity_types_id == 4) {
	$bgcolor = '255,218,96';
	$acticon = 'fa-users';
}
?>
<div class="rounded-lg bg-white">
<div class="p-3 my-3 rounded-lg" style="background-color: rgba(<?= $bgcolor ?>,.2)">
<div class="activity-icon activity-icon-lg" style="background-color: rgba(<?= $bgcolor ?>,1)">
			<i class="activity-icon activity-icon-lg fas <?= $acticon ?>"></i>
	</div>
<h3>
	<a href="/learning-curator/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
	<?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>
</h3>
<?php echo $this->Html->link($activity->estimated_time, ['action' => 'estimatedtime', $activity->estimated_time]) ?>
<div class="py-3 ">
	<?= $activity->description ?>
</div>
<?php if(!empty($activity->steps)): ?>
<div class="p-3 mb-3 bg-white rounded-lg">This activity is on the following pathways:
<?php foreach($activity->steps as $step): ?>
<?php foreach($step->pathways as $path): ?>
<span class="badge badge-light"><a href="/learning-curator/steps/view/<?= $step->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
<?php endforeach ?>
<?php endforeach ?>
</div>
<?php endif ?>

</div>
</div>
<?php endforeach; ?>
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
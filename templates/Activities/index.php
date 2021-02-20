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

.pagination {
	background-color; rgba(255,255,255,.5);
}
.page-item.active .page-link {
	background-color: #000;
	color; #FFF;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">

<h1 class="display-4 mt-5">Access learning resources on demand</h1>
<h2 class="font-weight-light">Sourced by BC Public Service curators</h2>
<div class="p-3 rounded-lg mb-5 bg-white shadow-sm">
<p style="font-size: 1.5rem">BC Public Service curators are trusted guides designing pathways of knowledge and 
skill development. Learning Curator pathways may stand alone or they may supplement 
your corporate training offered through the Learning Centre.</p>
<p style="font-size: 1.3rem">A <a href="#">best practice in learning for organizations</a>, curation helps us develop 
ourselves as part of a trusted, talented, and modern public service.</p>

<a class="btn btn-lg btn-success my-3" href="/pages/faq">Learn More</a>


</div>

</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center">





<div class="col-md-3">
<h2 class="mt-3">Latest Topics</h2>
<?php foreach ($allcats as $cat) : ?>
<div class="p-3 mb-3 bg-white rounded-lg">
<h3>
	<?= $this->Html->link($cat->name, ['controller' => 'Categories', 'action' => 'view', $cat->id]) ?>
</h3>
<div><?= h($cat->description) ?></div>

<?php foreach($cat->topics as $topic): ?>
<div class="bg-light p-3 my-3">
	<div class="font-weight-bold"><?= $this->Html->link($topic->name, ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></div>
	<div><?= h($topic->description) ?></div>
</div>
<?php endforeach ?>

<!-- <div><span class="badge badge-light">Added: <?= h($cat->created) ?></span></div> -->
</div>
<?php endforeach; ?>
</div>



<div class="col-md-4">

<h2 class="mt-3">Latest Pathways</h2>
<div>
<?php foreach($allpathways as $path): ?>
<?php if($path->status_id != 2): ?>
<?php if($role == 2 || $role == 5): ?>
	<div class="p-3 mb-3 bg-white rounded-lg">
		<span class="badge badge-warning"><?= $path->status->name ?></span>
		<h3><a href="/pathways/<?= $path->slug ?>"><?= $path->name ?></a></h3>
		<?= $path->objective ?>
		<div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div>
	</div>
<?php endif ?>
<?php else: ?>
	<div class="p-3 mb-3 bg-white rounded-lg">
		
		<h3><a href="/pathways/<?= $path->slug ?>"><?= $path->name ?></a></h3>
		<?= $path->objective ?>
		<div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div>
	</div>
<?php endif ?>

<?php endforeach ?>
</div>
</div>


<div class="col-md-5">

<h2 class="mt-3">Latest Activities</h2>

<div class="">
<?php foreach ($activities as $activity): ?>

<div class="p-3 rounded-lg mb-3 bg-white"> <!-- style="background-color: rgba(<?= $activity->activity_type->color ?>,.2)" -->
<div class="activity-icon activity-icon-md" style="background-color: rgba(<?= $activity->activity_type->color ?>,1)">
		<i class="activity-icon activity-icon-md fas <?= $activity->activity_type->image_path ?>"></i>
	</div>
<h3>

	<?= $this->Html->link($activity->name, ['action' => 'view', $activity->id]) ?>
</h3>
<div class="">
<span class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
			<i class="fas fa-clock"></i>
			<?php echo $this->Html->link($activity->estimated_time, ['controller' => 'Activities', 'action' => 'estimatedtime', $activity->estimated_time]) ?>
		</span> 

	<div class="pb-3">
	<?php foreach($activity->steps as $step): ?>
	<?php foreach($step->pathways as $path): ?>
	<?php if($path->status_id == 2): ?>
	<span class="badge badge-light"><a href="/steps/view/<?= $step->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
	<?php endif ?>
	<?php endforeach ?>
	<?php endforeach ?>
	</div>
	
	<div class="mt-3"><span class="badge badge-light">Added: <?= h($activity->created) ?></span></div>

</div>



</div>
<?php endforeach; ?>
</div> <!-- /. -->



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

	<script>

$(document).ready(function(){


	$('.claim').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').removeClass('btn-light').addClass('btn-dark').html('CLAIMED! <span class="fas fa-check-circle"></span>').tooltip('dispose').attr('title','Good job!');
		
		$(this).parent('.activity').css('box-shadow','0 0 10px rgba(0,0,0,.4)'); // css('border','2px solid #000')

		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/activities-users/claim',
			data: form.serialize(),
			success: function(data)
			{
				loadStatus();
			},
			statusCode: 
			{
				403: function() {
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
	});

	$('[data-toggle="tooltip"]').tooltip();

	$('.likingit').on('click',function(e){
		var url = $(this).attr('href');
		$(this).children('.lcount').html('Liked!');
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: url,
			data: '',
			success: function(data)
			{
			},
			statusCode: 
			{
				403: function() {
					let alert = 'You must be logged in.</div>';
					console.log(alert);
				}
			}
		});
	});

});

</script>
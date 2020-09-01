<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
*/
$this->layout = 'nowrap';
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
<div class="col-md-8">
<div class="pad-sm">
<h1><?= __('The Latest') ?></h1>
<p><?= __('The most recently published topics, pathways, and activities.') ?></p>
</div>
</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center">
<div class="col-md-5">
<h2 class="mt-3"><i class="fas fa-check"></i> Latest Activities</h2>

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
	<div class="py-3">
	<?= $activity->description ?>
	</div>
	<div class="pb-3">
	<?php foreach($activity->steps as $step): ?>
	<?php foreach($step->pathways as $path): ?>
	<?php if($path->status_id == 2): ?>
	<span class="badge badge-light"><a href="/learning-curator/steps/view/<?= $step->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
	<?php endif ?>
	<?php endforeach ?>
	<?php endforeach ?>
	</div>
	<?php if(!in_array($activity->id,$userbooklist)): // if the user hasn't bookmarked this, then show them claim form ?>
	<?= $this->Form->create(null,['url' => ['controller' => 'activities-bookmarks', 'action' => 'add'], 'class' => 'bookmark form-inline']) ?>
		<?= $this->Form->hidden('activity_id',['value' => $activity->id]) ?>
		<button class="btn btn-dark"><i class="fas fa-bookmark"></i> Bookmark</button>
		<?php //$this->Form->button(__('Bookmark'),['class' => 'btn btn-light']) ?>
		<?= $this->Form->end() ?>
	<?php else: ?>
		<span class="btn btn-dark"><i class="fas fa-bookmark"></i> Bookmarked</span>
	<?php endif ?>
	<div class="mt-3"><span class="badge badge-light">Added: <?= h($activity->created) ?></span></div>

</div>



</div>
<?php endforeach; ?>
</div> <!-- /. -->



</div>


<div class="col-md-4">

<h2 class="mt-3"><i class="fas fa-sitemap"></i> Latest Pathways</h2>
<div>
<?php foreach($allpathways as $path): ?>
<?php if($path->status_id != 2): ?>
<?php if($role == 2 || $role == 5): ?>
	<div class="p-3 mb-3 bg-white rounded-lg">
		<span class="badge badge-warning"><?= $path->status->name ?></span>
		<h3><a href="/learning-curator/pathways/view/<?= $path->id ?>"><?= $path->name ?></a></h3>
		<?= $path->objective ?>
		<div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div>
	</div>
<?php endif ?>
<?php else: ?>
	<div class="p-3 mb-3 bg-white rounded-lg">
		
		<h3><a href="/learning-curator/pathways/view/<?= $path->id ?>"><?= $path->name ?></a></h3>
		<?= $path->objective ?>
		<div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div>
	</div>
<?php endif ?>

<?php endforeach ?>
</div>
</div>

<div class="col-md-3">
<h2 class="mt-3">Latest Categories</h2>
<?php foreach ($allcats as $cat) : ?>
<div class="p-3 mb-3 bg-white rounded-lg">
<h3>
	<?= $this->Html->link($cat->name, ['controller' => 'Categories', 'action' => 'view', $cat->id]) ?>
</h3>
<div><?= h($cat->description) ?></div>
<div class="bg-light p-3 my-3">
<div class="mb-3"><strong>View pathways on the following topics:</strong></div>
<?php foreach($cat->topics as $topic): ?>
<span class=""><?= $topic->name ?></span>
<?php endforeach ?>
</div>
<div><span class="badge badge-light">Added: <?= h($cat->created) ?></span></div>
</div>
<?php endforeach; ?>
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


	$('.bookmark').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').removeClass('btn-light').addClass('btn-dark').html('<span class="fas fa-bookmark"></span> Bookmarked!').tooltip('dispose').attr('title','Good job!');
		
		//$(this).parent('.activity').css('box-shadow','0 0 10px rgba(0,0,0,.4)'); // css('border','2px solid #000')

		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/learning-curator/activities-bookmarks/add',
			data: form.serialize(),
			success: function(data)
			{
				//loadStatus();
			},
			statusCode: 
			{
				403: function() {
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
	});
	$('.claim').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').removeClass('btn-light').addClass('btn-dark').html('CLAIMED! <span class="fas fa-check-circle"></span>').tooltip('dispose').attr('title','Good job!');
		
		$(this).parent('.activity').css('box-shadow','0 0 10px rgba(0,0,0,.4)'); // css('border','2px solid #000')

		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/learning-curator/activities-users/claim',
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
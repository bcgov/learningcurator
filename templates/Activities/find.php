<?php foreach($activities as $activity): ?>


    <div class="card my-3">
<div class="card-body">



	<h1 class="my-1">
		<?= $activity->name ?>
		
		<a class="badge badge-light" href="/activities/view/<?= $activity->id ?>">#</a>
		
	</h1>
	<div class=""><?= $activity->description ?></div>


</div>
</div>
<?php endforeach ?>

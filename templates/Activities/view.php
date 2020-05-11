<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
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
.bigicon {
    border-radius: 50%;
    color: #FFF;
    float: right;
    font-size: 36px;
    height: 100px;
    padding: 20px 0 0 5px;
    text-align: center;
    width: 100px;
}
@media (min-width: 34em) {
    .card-columns {
        -webkit-column-count:2;
        -moz-column-count:2;
        column-count:2;
    }
}
.hours {
	background: rgba(255,255,255,1);
	color: #222;
}
.required {
	background: rgba(0,0,0,1);
	color: #FFF;
	float: right;
}
.required,
.hours {
	border-radius: 5px;
	display: inline-block;
	padding: 0 10px;
	text-align: center;
	text-transform: uppercase;
}

</style>

</style>
<div class="row justify-content-md-center">
<div class="col-md-9">
<div class="card" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">






	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>

	</div>
	<?php if($activity->status_id == 2): ?>
	<span class="badge badge-danger">DEFUNCT</span>
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	<span class="badge badge-warning">INVESTIGATE</span>
	<?php endif ?>


	<?php endif; // role check ?>


	<?php foreach($activity->tags as $tag): ?>
	<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a>
	<?php endforeach ?>


	<h1 class="my-1">
		<?= $activity->name ?>
		<?php if($role == 2 || $role == 5): ?>
		<a class="badge badge-light" href="/activities/view/<?= $activity->id ?>">#</a>
		<?php endif ?>
	</h1>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<?= $activity->description ?>
	</div>
	<div class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
		<i class="fas fa-clock"></i>
		<?= $activity->estimated_time ?>
	</div> 

	<a target="_blank" 
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
		class="btn btn-block my-2 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>
			<?= $activity->activity_type->name ?>
	</a>
		<a href="#" style="color:#333;" class="btn btn-light float-right" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
			<i class="fas fa-exclamation-triangle"></i>
		</a>	
		<a href="/activities/like/<?= $activity->id ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
		</a>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => '']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'You\'ve completed it, now claim it so it shows up on your profile', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<div class="btn btn-light">CLAIMED <i class="fas fa-check-circle"></i></div>
	<?php endif ?>
	<?php endif ?>




<?php if($role == 2 || $role == 5): ?>
<div class="my-3 p-3" style="background-color: rgba(255,255,255,.3)">
<button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#assignment<?= $activity->id ?>" aria-expanded="false" aria-controls="assignment<?= $activity->id ?>">
    Path Assigment
  </button>

  <?php endif ?>

<?php foreach($activity->steps as $step): ?>
<?php foreach($step->pathways as $path): ?>
<span class="badge badge-light"><a href="/pathways/view/<?= $path->id ?>"><?= $path->name ?> - <?= $step->name ?></a></span>
<?php endforeach ?>
<?php endforeach ?>



<div class="collapse" id="assignment<?= $activity->id ?>">
<?php foreach($allpathways as $pathway): ?>
<div class="my-1 p-3" style="background-color: rgba(255,255,255,.3)">
<?php if($role == 2 || $role == 5): ?>
<button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#steps<?= $pathway->id ?>" aria-expanded="false" aria-controls="steps<?= $pathway->id ?>">
    Steps
  </button>

<a href="/pathways/view/<?= $pathway->id ?>"><?= $pathway->name ?></a>

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
<?php endif ?>
<?php endforeach ?>
</div>
</div>









<div class="card">
<div class="card-body">

<div><?= h($activity->hyperlink) ?></div>
<div><?= __('Isbn') ?></div>
<div><?= h($activity->isbn) ?></div>
<div class="text">
<strong><?= __('Licensing') ?></strong>
<blockquote>
<?= $this->Text->autoParagraph(h($activity->licensing)); ?>
</blockquote>
</div>

<?php if($role == 2 || $role == 5): ?>
<div class="text">
<strong><?= __('Moderator Notes') ?></strong>
<blockquote>
<?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
</blockquote>
</div>
<div class="related">
<h4><?= __('Related Users') ?></h4>
<?php if (!empty($activity->users)) : ?>
<?php foreach ($activity->users as $users) : ?>
<div>
    <?= $this->Html->link($users->name, ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="related">
<h4><?= __('Related Competencies') ?></h4>
<?php if (!empty($activity->competencies)) : ?>
<?php foreach ($activity->competencies as $competencies) : ?>
<div>
<?= $this->Html->link($compentencies->name, ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<?php endif; ?>
</div>
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

<script>


$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();

	$('.likingit').on('click',function(e){
		var url = $(this).attr('href');
		$(this).tooltip('dispose').children('.lcount').html('Liked!');
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
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
	});
});

</script>
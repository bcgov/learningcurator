<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
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
	text-align: center;
	text-transform: uppercase;
	width: 130px;
}

</style>

</style>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="card" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">






	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Form->create(null, ['url' => ['controller' => 'activitys-steps','action' => 'removeactivity', 'class' => '']]) ?>
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $steps->id]) ?>
	<?= $this->Form->button(__('Remove'),['class'=>'btn btn-sm btn-light']) ?>
	<?= $this->Form->end() ?>
	</div>
	<?php if($activity->status_id == 2): ?>
	<span class="badge badge-danger">DEFUNCT</span>
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	<span class="badge badge-warning">INVESTIGATE</span>
	<?php endif ?>


	<?php endif; // role check ?>

	<div class="hours" >
		<i class="fas fa-clock"></i>
		<?= $activity->hours ?> hours
	</div>

	<?php foreach($activity->tags as $tag): ?>
	<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a>
	<?php endforeach ?>


	<h1 class="my-1">
		<?= $activity->name ?>
		<?php if($role == 2 || $role == 5): ?>
		<a class="badge badge-light" href="/activities/view/<?= $activity->id ?>">#</a>
		<?php endif ?>
	</h1>
	<div class=""><?= $activity->description ?></div>
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
		<a href="#" style="color:#333;" class="btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
			5 <i class="fas fa-thumbs-up"></i>
		</a>
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => '']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'You\'ve completed it, now claim it so it shows up on your profile', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: ?>
	<?php
	if($activity->activity_type->name == 'Read') {
		$readclaim++;
	} elseif($activity->activity_type->name == 'Watch') {
		$watchclaim++;
	} elseif($activity->activity_type->name == 'Listen') {
		$listenclaim++;
	} elseif($activity->activity_type->name == 'Participate') {
		$participateclaim++;
	}
	?>
	<div class="btn btn-light">CLAIMED <i class="fas fa-check-circle"></i></div>
	<?php endif ?>
	<?php endif ?>









<hr>




<div class="card">
<div class="card-body">


<div><?= h($activity->hyperlink) ?></div>
<div><?= __('Isbn') ?></div>
<div><?= $activity->has('category') ? $this->Html->link($activity->category->name, ['controller' => 'Categories', 'action' => 'view', $activity->category->id]) : '' ?></div>
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
<div class="related">
<h4><?= __('Related Steps') ?></h4>
<?php if (!empty($activity->steps)) : ?>
<?php foreach ($activity->steps as $steps) : ?>
<div>
   <?= $this->Html->link($steps->name, ['controller' => 'Steps', 'action' => 'view', $steps->id]) ?>
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

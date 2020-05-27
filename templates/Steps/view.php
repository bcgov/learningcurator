<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
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
.active {
    background-color: #FFF;
}
</style>
<div class="row">
<div class="col-md-4">
<?php if (!empty($step->pathways)) : ?>

<?php foreach ($step->pathways as $pathways) : ?>
<div>
<h1><?= $this->Html->link(h($pathways->name), ['controller' => 'Pathways', 'action' => 'path', $pathways->id]) ?></h1>
<?= h($pathways->objective) ?>
<div>
<?php foreach($pathways->steps as $s): ?>
<?php 
$c = '';
if($s->id == $step->id) $c = 'active';
?>
<div class="p-3 <?= $c ?>">
<h2><a href="/steps/view/<?= $s->id ?>"><?= $s->name ?></a></h2>
<?= $s->description ?>
</div>
<?php endforeach ?>
</div>
</div>
<?php endforeach; ?>

<?php endif; ?>


</div>
<div class="col-md-8">
<h1><?= h($step->name) ?></h1>
<div style="font-size: 130%">
<?= $this->Text->autoParagraph(h($step->description)); ?>
</div>
<?php if (!empty($step->activities)) : ?>

<?php foreach ($step->activities as $activity) : ?>
<div class="card mb-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">

	<?php if($role == 2 || $role == 5): ?>
	<div class="btn-group float-right">
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	</div>
	<?php endif; // role check ?>

	<?php foreach($activity->tags as $tag): ?>
	<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
	<?php endforeach ?>

	<h1 class="my-3">
		<?= $activity->name ?>
		<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>
	</h1>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<?= $activity->description ?>
	</div>
	<div class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
		<i class="fas fa-clock"></i>
		<?= $activity->estimated_time ?>
	</div> 
	<?php if(!empty($activity->tags)): ?>
	<?php foreach($activity->tags as $tag): ?>

	<?php if($tag->name == 'Learning System Course'): ?>

	<a target="_blank" 
		data-toggle="tooltip" data-placement="bottom" title="Enrol in this course in the Learning System"
		href="https://learning.gov.bc.ca/psc/CHIPSPLM_6/EMPLOYEE/ELM/c/LM_OD_EMPLOYEE_FL.LM_FND_LRN_FL.GBL?Page=LM_FND_LRN_RSLT_FL&Action=U&KWRD=<?php echo urlencode($activity->name) ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>

	<?php elseif($tag->name == 'YouTube'): ?>
	
	<div class="my-3 p-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); border-radius: 3px;">
		<iframe width="100%" 
			height="315" 
			src="https://www.youtube.com/embed/<?= h($activity->hyperlink) ?>/" 
			frameborder="0" 
			allow="" 
			allowfullscreen>
		</iframe>
	</div>

	<?php endif; // logic check for formatting differently based on tag ?>	

	<?php endforeach; // tags loop ?>

	<?php else: // if there aren't any tags at all, default ?>


	<a target="_blank" 
		data-toggle="tooltip" data-placement="bottom" title="<?= $activity->activity_type->name ?> this activity"
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #FFF; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>

	<?php endif; // are there tags? ?>	

	<?php if(!empty($activity->_joinData->required)): ?>

	<div class="required float-right" data-toggle="tooltip" data-placement="bottom" title="This activity is required to complete the step">
		<i class="fas fa-check-double"></i> Required
	</div>
	<?php else: ?>
	<div class="required float-right" data-toggle="tooltip" data-placement="bottom" title="This activity is supplemtary to completing this step">
		<i class="fas fa-check"></i> Supplementary
	</div>
	
	<?php endif ?>


	<!-- Hiding this until we can get a proper reporting system in place.
	<a href="#" style="color:#333;" class="btn btn-light float-right" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
		<i class="fas fa-exclamation-triangle"></i>
	</a>	-->

	<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
	</a>
	
	<?php if(!empty($uid)): ?>
	<?php if(!in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'claim']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'You\'ve completed it, now claim it so it shows up on your profile', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: // they have claimed it, so show that ?>

	<div class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div>

	<?php endif; // claimed or not ?>
	<?php endif; // logged in ?>

	</div>
	</div>

	<?php endforeach; // end of activities loop for this step ?>


	




<?php endif; ?>
</div>
</div>
</div>
</div>
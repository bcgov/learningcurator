<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
//phpinfo(); exit;
$this->loadHelper('Authentication.Identity');

$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
$role = $this->Identity->get('role');
$uid = $this->Identity->get('id');
}
/** 
 * Most of the following should be moved into the controller
 * I just find it easier to prototype when the logic I'm working
 * with is in the same file
 */
$stepTime = 0;
$archivedacts = array();
$requiredacts = array();
$supplementalacts = array();
$acts = array();

$totalacts = count($step->activities);
$stepclaimcount = 0;

foreach ($step->activities as $activity) {
$stepname = '';
//print_r($activity);
// If this is 'defunct' then we pull it out of the list 
// and add it the defunctacts array so we can show them
// but in a different section
if($activity->status_id == 3) {
array_push($archivedacts,$activity);
} elseif($activity->status_id == 2) {
// if it's required
if($activity->_joinData->required == 1) {
array_push($requiredacts,$activity);
// Otherwise it's teriary
} else {
array_push($supplementalacts,$activity);
}
array_push($acts,$activity);

if(in_array($activity->id,$useractivitylist)) {
$stepclaimcount++;
}
$reqtmp = array();
$suptmp = array();
// Loop through the whole list, add steporder to tmp array
foreach($requiredacts as $line) {
$reqtmp[] = $line->_joinData->steporder;
}
foreach($supplementalacts as $line) {
$suptmp[] = $line->_joinData->steporder;
}
// Use the tmp array to sort acts list
array_multisort($reqtmp, SORT_DESC, $requiredacts);
array_multisort($suptmp, SORT_DESC, $supplementalacts);
//array_multisort($tmp, SORT_DESC, $supplementalacts);
}
}

$pagetitle = $step->name . ' - ' . $step->pathways[0]->name;
$this->assign('title', h($pagetitle));
$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);
$completeclass = 'notcompleted'; 
if($stepclaimcount == $totalacts) {
$completeclass = 'completed';
}

if($stepclaimcount > 0) {
$steppercent = ceil(($stepclaimcount * 100) / $stepacts);
} else {
$steppercent = 0;
}

$current = 0;
$last = 0;
$previousid = 0;
$next = 0;
$nextid = 0;
foreach ($step->pathways as $pathways) {
foreach($pathways->steps as $s) {
$next = next($pathways->steps);
if($s->id == $step->id) {
if($last) {
$previousid = $last->id;
$previousslug = $last->slug;
}
if($next) {
$upnextid = $next->id;
$upnextslug = $next->slug;
}
}
$last = $s;
}
}
?>
<div class="mt-4 dark:text-white">
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="btn-group float-right ml-3">
<?= $this->Html->link(__('Edit'), 
['controller' => 'Steps', 'action' => 'edit', $step->id], 
['class' => 'btn btn-light btn-sm']); 
?>
<?= $this->Form->postLink(__('Delete'), 
['action' => 'delete', $step->id],
['class' => 'btn btn-light btn-sm', 
'confirm' => __('Are you sure you want to delete # {0}?', $step->name)
]);
?>
</div> <!-- /.btn-group -->
<?php endif ?>

<nav class="" aria-label="breadcrumb">

<?= $this->Html->link($step->pathways[0]->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $step->pathways[0]->topic->categories[0]->id]) ?> / 
<?= $this->Html->link($step->pathways[0]->topic->name, ['controller' => 'Topics', 'action' => 'view', $step->pathways[0]->topic->id]) ?> / 
<?= $this->Html->link($step->pathways[0]->name, ['controller' => 'Pathways', 'action' => '/' . $step->pathways[0]->slug], ['class' => 'font-weight-bold']) ?> / 
<?= $step->name ?>
</nav>
<div class="mt-3 text-xl"><?= $step->pathways[0]->name ?></div>
<h1 class="text-4xl"><?= $step->name ?></h1>
<?php if($step->status_id == 1): ?>
<span class="badge badge-warning">DRAFT</span>
<?php endif ?>
<div class="text-lg">
<?= $step->description ?>
</div>

<div class="my-3">
<span class="badge badge-pill badge-light"><?= $totalacts ?> total activities</span> 
<span class="badge badge-pill badge-light"><?= $stepacts ?> required</span>
<span class="badge badge-pill badge-light"><?= $supplmentalcount ?> supplemental</span>

</div>
<div class="progress progress-bar-striped stickyprogress mt-3 rounded-lg">
<div class="progress-bar bg-success" role="progressbar" style="width: <?= $steppercent ?>%" aria-valuenow="<?= $steppercent ?>" aria-valuemin="0" aria-valuemax="100">	
</div>
</div>


<?php if(!empty($previousid)): ?>
<a href="/pathways/<?= $pathways->slug ?>/s/<?= $previousid ?>/<?= $previousslug ?>" class="backstep">
Last Step
</a>
<?php endif ?>

<?php if(!empty($upnextid)): ?>
<a href="/pathways/<?= $pathways->slug ?>/s/<?= $upnextid ?>/<?= $upnextslug ?>" class="nextstep">
Next Step
</a>
<?php endif ?>

<div class="" id="stepnav" aria-labelledby="">
<?php foreach ($step->pathways as $pathways) : ?>
<?php foreach($pathways->steps as $s): ?>
<?php if($s->status_id == 2): ?>
<?php $c = '' ?>
<?php if($s->id == $step->id) $c = 'font-weight-bold' ?>
<div class="px-3 py-1 bg-white dark:bg-gray-900 dark:text-white">
<a class=" <?= $c ?>" href="/pathways/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
<?= $s->name ?> 
<i class="bi bi-arrow-right-circle-fill"></i>
</a>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<?php $c = '' ?>
<?php if($s->id == $step->id) $c = 'font-weight-bold' ?>
<div><a class=" <?= $c ?>" href="/pathways/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
<?php if($s->id == $step->id && $steppercent == 100): ?>
<i class="bi bi-check"></i>
<?php endif ?>
<span class="badge badge-warning">DRAFT</span>
<?= $s->name ?>
</a></div>
<?php endif; // are you a curator? ?>
<?php endif; // is published? ?>
<?php endforeach ?>
<?php endforeach ?>
</div>

<?php if(in_array($uid,$usersonthispathway)): ?>
<div class="">
<div class="mb-3 following"></div>
</div>

<?php else: ?>
<div class="bg-white rounded-lg p-3 shadow-sm mt-3 text-center stickyrings shadow-sm">
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $step->pathways[0]->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'btn btn-block btn-primary mb-0']) ?>
<?= $this->Form->end(); ?>
</div>
<?php endif ?>

</div>

<?php if (!empty($step->activities)) : ?>
<h2 class="text-3xl dark:text-white">Required Activities <?= $stepacts ?></h2>
<?php foreach ($requiredacts as $activity) : ?>

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-gray-900 dark:text-white">

<?php if(!in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>

<?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'claim/' . $activity->id], 'class' => 'claim', 'id' => $activity->id]) ?>
<?php //$this->Form->hidden('users.0.created', ['value' => date('Y-m-d H:i:s')]); ?>
<?= $this->Form->hidden('users.0.id', ['value' => $uid]); ?>
<?= $this->Form->button(__('Complete'),['class'=>'btn btn-primary', 'title' => 'If you\'ve completed this activity, claim it so it counts against your progress']) ?>
<?= $this->Form->end() ?>


<?php else: // they have claimed it, so show that ?>

<div class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="bi bi-bookmark-check-fill"></i></div>
<?php //echo $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $activity->_joinData->id], ['class' => 'btn btn-primary', 'confirm' => __('Really delete?')]) ?>
<?php endif; // claimed or not ?>

<h3 class="my-3 text-3xl">
<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
<!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
</h3>
<div class="mb-4">
<?= $activity->description ?>
</div>

<?php if(!empty($activity->isbn)): ?>
<div class="bg-white p-2 isbn">
ISBN: <?= $activity->isbn ?>
</div>
<?php endif ?>
<?php if(!empty($activity->_joinData->stepcontext)): ?>
<div class="my-4">
<i class="bi bi-person-badge-fill"></i>
Curator says:<br>
<?= $activity->_joinData->stepcontext ?>
</div>
<?php endif ?>


<div class="my-2">
	<a target="_blank" 
		rel="noopener" 
		data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
		href="<?= $activity->hyperlink ?>" 
		class="p-3 bg-gray-700 rounded-lg text-white text-2xl font-bold">
			LAUNCH
	</a>
</div>

</div>
<?php endforeach; // end of activities loop for this step ?>

<?php endif; ?>

<?php if(count($supplementalacts) > 0): ?>

<h3 class="text-2xl dark:text-white">Supplementary Resources <?= $supplmentalcount ?></h3>

<?php foreach ($supplementalacts as $activity): ?>
<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-gray-900 dark:text-white">
<h3 class="text-2xl">
<a href="/activities/view/<?= $activity->id ?>">
<?= $activity->name ?>
</a>
</h3>
<div>
<span class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
<i class="bi bi-clock-history"></i>
<?= h($activity->estimated_time) ?>
<?php //echo $this->Html->link($activity->estimated_time, ['controller' => 'Activities', 'action' => 'estimatedtime', $activity->estimated_time]) ?>
</span> 
</div>
<?= $activity->description ?>

<?php if(!empty($activity->_joinData->stepcontext)): ?>
<div class="bg-light shadow-sm p-3 mt-3">
<strong>Curator says:</strong><br>
<?= $activity->_joinData->stepcontext ?>
</div>
<?php endif ?>
<div class="mt-3">
<a target="_blank" 
rel="noopener" 
data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
href="<?= $activity->hyperlink ?>" 
class="btn btn-block my-3 text-uppercase btn-lg">

LAUNCH

</a>

</div>
</div>

<?php endforeach; // end of activities loop for this step ?>

<?php endif ?>
<?php if(!empty($archivedacts)): ?>
<h4>Archived Activities</h4>
<div class="p-2 bg-white">This step used to have these activities assigned to them, but they are no 
longer considered relevant or appropriate for one reason or another. They 
are listed here for posterity. <a class="" 
data-toggle="collapse" 
href="#defunctacts" 
aria-expanded="false"
aria-controls="defunctacts">View archived activities</a>.
</div>
<div class="collapse bg-white p-3" id="defunctacts">
<?php foreach ($archivedacts as $activity) : ?>
<h5>
<a href="/activities/view/<?= $activity->id ?>">
<i class="bi <?= $activity->activity_type->image_path ?>"></i>
<?= $activity->name ?>
</a>
</h5>
<div class="p-2">
<?= $activity->description ?>
</div>
<?php endforeach ?>
</div>
<?php endif ?>

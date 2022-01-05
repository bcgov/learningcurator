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
							'confirm' => __('Are you sure you want to delete # {0}?', $step->name)]);
?>
</div> <!-- /.btn-group -->
<?php endif ?>

<nav class="bg-slate-200 dark:bg-gray-600 rounded-lg p-3" aria-label="breadcrumb">
	<a href="/categories/index">Categories</a> / 
	<?= $this->Html->link($step->pathways[0]->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $step->pathways[0]->topic->categories[0]->id]) ?> / 
	<?= $this->Html->link($step->pathways[0]->topic->name, ['controller' => 'Topics', 'action' => 'view', $step->pathways[0]->topic->id]) ?> / 
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg>
	<?= $this->Html->link($step->pathways[0]->name, ['controller' => 'Pathways', 'action' => '/' . $step->pathways[0]->slug], ['class' => 'font-weight-bold']) ?> / 
	<?= $step->name ?>
</nav>
<?php if(!in_array($uid,$usersonthispathway)): ?>
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $step->pathways[0]->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'mt-4 bg-white dark:bg-gray-900 rounded-lg p-3 text-center']) ?>
<?= $this->Form->end(); ?>
<?php endif ?>

<h1 class="mt-4 text-4xl">
	<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg>
	<?= $step->pathways[0]->name ?>
</h1>
<div>
<span class="progressbar<?= $step->pathways[0]->id ?> inline-block my-3 bg-green-300 dark:bg-green-700 dark:text-white text-center rounded-lg"></span>
<span class="beginning<?= $step->pathways[0]->id ?> inline-block"></span>
</div>
<script>
var request<?= $step->pathways[0]->id ?> = new XMLHttpRequest();
request<?= $step->pathways[0]->id ?>.open('GET', '/pathways/status/<?= $step->pathways[0]->id ?>', true);
request<?= $step->pathways[0]->id ?>.onload = function() {
	if (this.status >= 200 && this.status < 400) {
		var data<?= $step->pathways[0]->id ?> = JSON.parse(this.response);
		if(data<?= $step->pathways[0]->id ?>.percentage > 0) {
			let percwid = data<?= $step->pathways[0]->id ?>.percentage;
			if(percwid < 10) {
				document.querySelector('.beginning<?= $step->pathways[0]->id ?>').innerHTML = data<?= $step->pathways[0]->id ?>.percentage + '% complete';
				document.querySelector('.progressbar<?= $step->pathways[0]->id ?>').innerHTML = '&nbsp;';
			} else {
				document.querySelector('.progressbar<?= $step->pathways[0]->id ?>').innerHTML = data<?= $step->pathways[0]->id ?>.percentage + '% complete';
			}
			document.querySelector('.progressbar<?= $step->pathways[0]->id ?>').style.width = percwid + '%';
		} else {
			document.querySelector('.beginning<?= $step->pathways[0]->id ?>').innerHTML = 'You\'ve not completed any activities yet. Complete an activity to see your progress bar.';
		}
	}
};
request<?= $step->pathways[0]->id ?>.onerror = function() {
	// There was a connection error of some sort
	document.querySelector('.beginning<?= $step->pathways[0]->id ?>').innerHTML = 'Could not get status :(';
};
request<?= $step->pathways[0]->id ?>.send();
</script>

<!-- start drop-down -->
<div @click.away="open = false" class="relative mb-2" x-data="{ open: false }">
	<button @click="open = !open" class="flex flex-row items-center px-4 py-2 text-sm font-semibold text-left bg-gray-600 text-white rounded-lg dark:bg-black dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
	<span>Modules</span>
	<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-12 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
		<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
	</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
		<div class="px-2 py-2 bg-white rounded-md shadow dark:bg-gray-800">
		<?php foreach ($step->pathways as $pathways) : ?>
		<?php foreach($pathways->steps as $s): ?>
		<?php if($s->status_id == 2): ?>
		<?php $c = '' ?>
		<?php if($s->id == $step->id) $c = 'font-weight-bold' ?>
		<a class="<?= $c ?> block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="/pathways/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
		<?= $s->name ?> 
		</a>
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
		</a>
		<?php endif; // are you a curator? ?>
		<?php endif; // is published? ?>
		<?php endforeach ?>
		<?php endforeach ?>
		</div>
	</div>
</div>
<!-- /end drop-down -->
<div class="p-3 my-3 rounded-lg activity bg-slate-200 dark:bg-gray-900 dark:text-white">
<h2 class="m4-4 text-3xl">
<?= $step->name ?>
</h2>
<?php if($step->status_id == 1): ?>
<span class="badge badge-warning">DRAFT</span>
<?php endif ?>
<div class="my-3 text-lg">
<?= $step->description ?>
</div>


<?php if (!empty($step->activities)) : ?>
<h3 class="mt-6 text-2xl dark:text-white">Required Activities <span class="bg-black text-white dark:bg-white dark:text-black rounded-lg text-lg inline-block px-2"><?= $stepacts ?></span></h3>
<?php foreach ($requiredacts as $activity) : ?>

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-gray-700 dark:text-white">

<?php if(!in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>

<?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'claim/' . $activity->id], 'class' => 'claim', 'id' => $activity->id]) ?>
<?php //$this->Form->hidden('users.0.created', ['value' => date('Y-m-d H:i:s')]); ?>
<?= $this->Form->hidden('users.0.id', ['value' => $uid]); ?>
<?= $this->Form->button(__('Complete'),['class'=>'btn btn-primary', 'title' => 'If you\'ve completed this activity, claim it so it counts against your progress']) ?>
<?= $this->Form->end() ?> 

<?php else: // they have claimed it, so show that ?>
<div class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">Completed! <i class="bi bi-bookmark-check-fill"></i></div>
<?php //echo $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $activity->_joinData->id], ['class' => 'btn btn-primary', 'confirm' => __('Really delete?')]) ?>
<?php endif; // claimed or not ?>
<h4 class="my-3 text-2xl">
<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
<!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
</h4>
<div class="mb-4">
<?= $activity->description ?>
</div>
<div class="mb-4">
Activity type: <?= $activity->activity_type->name ?>
</div>
<?php if(!empty($activity->isbn)): ?>
<div class="bg-white p-2 isbn">
ISBN: <?= $activity->isbn ?>
</div>
<?php endif ?>
<?php if(!empty($activity->_joinData->stepcontext)): ?>
<div class="my-4 p-3 bg-slate-100 dark:bg-gray-800 rounded-lg">
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
		class="block p-3 bg-black rounded-lg text-white text-2xl">
			LAUNCH
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
				<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
			</svg>
	</a>
</div>

</div>
<?php endforeach; // end of activities loop for this step ?>

<?php endif; ?>

<?php if(count($supplementalacts) > 0): ?>

<h3 class="text-2xl dark:text-white">Supplementary Resources <span class="bg-white text-black rounded-lg text-lg inline-block px-2"><?= $supplmentalcount ?></span></h3>

<?php foreach ($supplementalacts as $activity): ?>
<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-gray-900 dark:text-white">
<h4 class="text-2xl">
	<a href="/activities/view/<?= $activity->id ?>">
		<?= $activity->name ?>
	</a>
</h4>

<?= $activity->description ?>

<?php if(!empty($activity->_joinData->stepcontext)): ?>
<div class="my-3 p-3 bg-slate-100">
	<strong>Curator says:</strong><br>
	<?= $activity->_joinData->stepcontext ?>
</div>
<?php endif ?>
<div class="">
<a target="_blank" 
	rel="noopener" 
	data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
	href="<?= $activity->hyperlink ?>" 
	class="block my-5 p-3 bg-gray-700 rounded-lg text-white text-xl">

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
</div>
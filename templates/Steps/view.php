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
$this->assign('title', h($pagetitle));
$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);

?>
<div class="p-6 dark:text-white">

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

<nav class="bg-slate-200 dark:bg-slate-900 rounded-lg p-3" aria-label="breadcrumb">
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

<h1 class="my-6 text-4xl">
	<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg>
	<?= $step->pathways[0]->name ?>
</h1>



<div class="px-8">

<div class="mb-6 text-2xl">
<?= $step->pathways[0]->objective ?> 
</div>



<div
    x-cloak
    x-data="{status: [], 'isLoading': true}"
    x-init="fetch('/pathways/status/<?= $step->pathways[0]->id ?>')
            .then(response => response.json())
            .then(response => { 
                    status = response; 
                    isLoading = false; 
                    //console.log(response); 
                })"
>
<div class="" x-show="isLoading">Loading&hellip;</div>
<div x-show="!isLoading">
	<div class="mb-6 h-6 w-full bg-slate-500 dark:bg-black rounded-lg">
		<span :style="'width:' + status.percentage + '%;'" class="progressbar h-6 inline-block bg-green-600 dark:bg-green-600 text-white text-center rounded-lg">&nbsp;</span>
		<span x-text="status.percentage + '% - ' + status.completed + ' of ' + status.requiredacts" class="beginning inline-block text-white"></span>
	</div>
</div>
</div>

<?php if(empty($followid)): ?>
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $step->pathways[0]->id]) ?>
<?= $this->Form->button(__('Pin to Profile'),['class' => 'mb-4 bg-green-300 dark:bg-green-600 rounded-lg p-3 text-center']) ?>
<?= $this->Form->end(); ?>
<?php endif ?>

</div> <!-- / objective contain -->

<!-- start drop-down -->
<div @click.away="open = false" class="relative ml-8" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-sm font-semibold text-right bg-slate-200 rounded-t-lg dark:bg-slate-900 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		<span>Module Menu</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full origin-top-right shadow-lg">
		<div class="-ml-8 p-6 bg-white rounded-md shadow dark:bg-slate-900">
		<?php foreach ($step->pathways as $pathways) : ?>
		<?php foreach($pathways->steps as $s): ?>
		<?php if($s->status_id == 2): ?>
		<?php $c = '' ?>
		<?php if($s->id == $step->id) $c = 'bg-slate-300 dark:bg-blue-900' ?>
		<a class="<?= $c ?> block px-4 py-2 mt-2 text-sm font-semibold rounded-lg dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="/pathways/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
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

<div class="p-6 rounded-lg activity bg-slate-200 dark:bg-slate-900 dark:text-white">
<h2 class="mb-4 text-3xl">
<?= $step->name ?>
</h2>
<?php if($step->status_id == 1): ?>
<span class="badge badge-warning">DRAFT</span>
<?php endif ?>
<div class="mb-4 text-xl">
<?= $step->description ?>
</div>

<?php if (!empty($step->activities)) : ?>
<h3 class="mt-6 text-2xl dark:text-white">Required Activities <span class="bg-black text-white dark:bg-white dark:text-black rounded-lg text-lg inline-block px-2"><?= $stepacts ?></span></h3>
<?php foreach ($requiredacts as $activity) : ?>
<?php 
$completed = 0;
$actlist = array_count_values($useractivitylist); 
//print_r($actlist);
foreach($actlist as $k => $v) {
	if($k == $activity->id) {
		if($v > 0) $completed = $v;
	}
}
?>
<div class="relative p-3 my-3 rounded-lg activity bg-white dark:bg-blue-900 dark:text-white">
<?php if($completed > 0): ?>
	<div class="w-32 bg-slate-200 text-black text-center uppercase rounded-lg">Complete</div>
<?php endif ?>
<h4 class="mb-3 text-3xl">
	<?= $activity->name ?>
	<a class="text-sm" href="/activities/view/<?= $activity->id ?>">#</a>
</h4>
<div class="mb-6 text-lg">
<?= $activity->description ?>
</div>
<!-- <div class="mb-4">
Activity type: <?= $activity->activity_type->name ?>
</div> -->
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




<div @click.away="open = false" class="relative" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-lg font-semibold text-right bg-green-600 text-white rounded-lg dark:bg-green-600 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline">
		<span>Launch</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
		<div class="p-4 bg-slate-200 rounded-md dark:bg-slate-900">

		<div>
			<a target="_blank" 
				rel="noopener" 
				data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
				href="<?= $activity->hyperlink ?>" 
				class="inline-block mb-3 p-3 bg-green-600 rounded-lg text-white text-2xl">
					Open Activity in new window
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
						<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
					</svg>
			</a>
		</div>

		<div class="my-4">
			<?= $activity->hyperlink ?>
		</div>
		


			<?php if($completed > 0): ?>
			<div class="p-3 my-6" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">
				Completed!
			</div>
			<?php else: ?>
			<div>
				Once you've visited this activity, the next time you come back here, you can "complete" 
				the activity here and record your progress along the pathway.
			</div>
			<?= $this->Form->create(null,['url' => ['controller' => 'ActivitiesUsers', 'action' => 'complete'], 'class' => 'my-6']) ?>
			<?= $this->Form->hidden('activity_id', ['value' => $activity->id]); ?>
			<?= $this->Form->button(__('Complete'),['class'=>'p-3 bg-green-600 rounded-lg', 'title' => 'If you\'ve completed this activity, claim it so it counts against your progress']) ?>
			<?= $this->Form->end() ?> 
			<?php endif ?>




		</div>
	</div>
</div>




</div>
<?php endforeach; // end of activities loop for this step ?>

<?php endif; ?>

<?php if(count($supplementalacts) > 0): ?>

<h3 class="text-2xl dark:text-white">Supplementary Resources <span class="bg-white text-black rounded-lg text-lg inline-block px-2"><?= $supplmentalcount ?></span></h3>

<?php foreach ($supplementalacts as $activity): ?>
<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">
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
</div>
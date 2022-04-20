<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
*/

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
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
<div class="p-6">

<div class="paginator sticky top-0 z-50 py-3 bg-[#c3d4e4] dark:bg-[#003366]">
	<div class="mb-3">
		<?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} activities out of {{count}} total')) ?>
	</div>
	<?= $this->Paginator->first('<< ' . __('first')) ?>
	<?= $this->Paginator->prev('< ' . __('previous')) ?>
	<?php //$this->Paginator->numbers() ?>
	<?= $this->Paginator->next(__('next') . ' >') ?>
	<?= $this->Paginator->last(__('last') . ' >>') ?>

</div>
<div class="p-3 mb-2 bg-slate-100 dark:bg-slate-900 dark:text-white rounded-lg">
<?php foreach ($activities as $activity) : ?>
<?php 
// #TODO move this back into the controller and simplify
// this was an attempt at requiring two launches to satify a complete
$completed = 0;
$actlist = array_count_values($useractivitylist); 
foreach($actlist as $k => $v) {
	if($k == $activity->id) {
		if($v > 0) $completed = $v;
	}
}
?>
<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-800 dark:text-white">

<div x-data="{ count: <?= $completed ?>, liked: <?= $activity->recommended ?> }">
	
	<a href="/profile/launches" 
		x-cloak 
		class="inline-block w-24 bg-slate-100 text-[#003366] dark:bg-slate-900 dark:text-yellow-500 text-sm text-center uppercase rounded-lg"
		:class="[count > '0' ? 'show' : 'hidden']">
			Launched
	</a>

	<h4 class="mb-3 text-2xl">
		<?= $activity->name ?>
	</h4>
	<?php if(!empty($activity->description)): ?>
	<div class="p-2 lg:p-4 text-lg bg-slate-100 dark:bg-[#002850] rounded-lg">
	<?= $activity->description ?>
	</div>
	<?php else: ?>
	<div class="p-2 lg:p-4 text-lg bg-slate-100 dark:bg-[#002850] rounded-lg">
		<em>No description provided&hellip;</em>
	</div>
	<?php endif ?>

	<?php if(!empty($activity->isbn)): ?>
	<div class="p-2 isbn bg-white dark:bg-slate-800">
	ISBN: <?= $activity->isbn ?>
	</div>
	<?php endif ?>


	<!-- <form @submit.prevent="" action="/activities/like/<?= $activity->id ?>"
			x-on:click="liked++">
		<button><span x-text="liked"></span> likes</button>
	</form> -->

	<a target="_blank" 
		x-on:click="count++;"
		rel="noopener" 
		title="Launch this activity"
		href="/activities-users/launch?activity_id=<?= $activity->id ?>"  
		class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
			Launch Activity
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
				<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
			</svg>
	</a>



</div> <!-- click count increment container -->

<div x-data="{ open: false }">
<button @click="open = !open" class="px-4 py-2 text-md font-semibold text-right bg-slate-100 dark:text-white dark:bg-[#002850] dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900 dark:hover:bg-slate-900 md:block hover:text-slate-900 focus:text-slate-900 hover:bg-slate-100 focus:bg-slate-100 focus:outline-none focus:shadow-outline rounded-lg">
	<span>More info</span>
	<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
		<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
	</svg>
</button>
<div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
	<div class="p-4 bg-slate-100 rounded-md dark:bg-slate-900">

	<div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
		<a class="text-lg" href="/activities/view/<?= $activity->id ?>">
			View Activity Record
		</a>
	</div>
	<div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
		<strong>Hyperlink:</strong> <?= $activity->hyperlink ?>
	</div>
	<!-- <div class="mb-3 p-3bg-white dark:bg-slate-800 rounded-lg">
		<strong>Activity type:</strong> <?= $activity->activity_type->name ?>
	</div> -->

	<div class="p-3 bg-white dark:bg-slate-800 rounded-lg">

	<script>
	
	var message = '';
	
	function report<?= $activity->id ?>Form() {
		return {
			form<?= $activity->id ?>Data: {
				activity_id: '<?= $activity->id ?>',
				user_id: '<?= $uid ?>',
				issue: '',
				csrfToken: <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>,
			},
			message: '',
	
			submitData() {
				this.message = ''

				fetch('/reports/add', {
					method: 'POST',
					headers: { 
						'Content-Type': 'application/json', 
						'X-CSRF-Token': <?php echo json_encode($this->request->getAttribute('csrfToken')); ?> 
					},
					body: JSON.stringify(this.form<?= $activity->id ?>Data)
				})
				.then(() => {
					this.message = 'Report sucessfully submitted!';
					this.form<?= $activity->id ?>Data.issue = '';

				})
				.catch(() => {
					this.message = 'Ooops! Something went wrong!';
				})
			}
	}
	}
	</script>
	<?= $this->Form->create(null,
							[
								'url' => [
									'controller' => 'reports',
									'action' => 'add'
								],
								'class' => '',
								'x-data' => 'report' . $activity->id . 'Form()',
								'@submit.prevent' => 'submitData'
							]) ?>

		<p>Is there something wrong with this activity? Report it!</p>
		<?php
		echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
		echo $this->Form->hidden('user_id', ['value' => $uid]);
		echo $this->Form->textarea('issue',
						['class' => 'w-full h-20 p-6 bg-slate-100 dark:bg-slate-700 text-white rounded-lg', 
						'x-model' => 'form'.$activity->id.'Data.issue', 
						'placeholder' => 'Type here ...',
						'required' => 'required']);
		?>
		
		<input type="submit" class="mt-1 mb-4 px-4 py-2 text-white bg-sky-700 hover:bg-sky-800 rounded-lg" value="Submit Report">
		<span x-text="message"></span> <a href="/profile/reports">See all your reports</a>

	<?= $this->Form->end() ?>

	

	</div>
	</div>
</div>
</div>
<?php if(!empty($activity->steps)): ?>
	<div class="mt-2 p-3 bg-slate-100 dark:bg-slate-800 rounded-lg">
		Included in pathways:<br> 
		<?php foreach($activity->steps as $step): ?>
			<?php if(!empty($step->pathways[0]->slug)): ?>
			<div class="p-2 mb-1 bg-slate-100 dark:bg-[#002850] rounded-lg">
			<a href="/<?= $step->pathways[0]->topic->categories[0]->slug ?>/topic/<?= $step->pathways[0]->topic->slug ?>/pathway/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
				
				<i class="bi bi-pin-map-fill"></i>
				<?= $step->pathways[0]->name ?> - 
				<?= $step->name ?>
			</a>
			</div>
			<?php endif ?>
		<?php endforeach ?>

	</div>
	<?php endif ?>



</div>
<?php endforeach; // end of activities loop for this step ?>

</div>
</div>
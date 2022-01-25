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
<div class="p-6 dark:text-white">
<h1 class="text-4xl">Activities</h1>
<div class="paginator sticky top-0 z-50 p-3 bg-[#003366]">
	<?= $this->Paginator->first('<< ' . __('first')) ?>
	<?= $this->Paginator->prev('< ' . __('previous')) ?>
	<?php //$this->Paginator->numbers() ?>
	<?= $this->Paginator->next(__('next') . ' >') ?>
	<?= $this->Paginator->last(__('last') . ' >>') ?>
	<div>
		<?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
	</div>
</div>
<?php foreach ($activities as $activity) : ?>
	
	<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">

	<h2 class="my-3 text-3xl">
		<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
	</h2>



		<?= $activity->description ?>

		<?php if(!empty($activity->_joinData->stepcontext)): ?>
		<div class="">
				Curator says:<br>
				<?= $activity->_joinData->stepcontext ?>
			</div>
			<?php endif ?>


	<div @click.away="open = false" class="relative" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-lg font-semibold text-right bg-green-700 text-white rounded-lg dark:bg-green-700 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		<span>Launch</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 right-0 w-full origin-top-right shadow-lg">
		<div class="p-4 bg-white rounded-md shadow dark:bg-slate-900">

			<div>
				<a target="_blank" 
					rel="noopener" 
					data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
					href="<?= $activity->hyperlink ?>" 
					class="inline-block mb-3 p-3 bg-green-700 rounded-lg text-white text-2xl">
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

		</div>
	</div>
	</div>
		

		

	<?php if(!empty($activity->steps)): ?>
	<div class="mt-2 p-3 bg-slate-200 dark:bg-slate-800 rounded-lg">

		<?php foreach($activity->steps as $step): ?>
			<?php if(!empty($step->pathways[0]->slug)): ?>
			Included in pathways:<br> 
			<a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
				<i class="bi bi-pin-map-fill"></i>
				<?= $step->pathways[0]->name ?> - 
				<?= $step->name ?>
			</a>
			<?php endif ?>
		<?php endforeach ?>

	</div>
	<?php endif ?>


	</div>


	<?php endforeach; // end of activities loop for this step ?>

</div>
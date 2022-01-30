<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="p-6 dark:text-white">
<div @click.away="open = false" class="relative ml-8" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-sm font-semibold text-right bg-slate-200 rounded-t-lg dark:bg-slate-900 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-900 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		<span>Profile Menu</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full origin-top-right shadow-lg">
	<div class="-ml-8 p-6 bg-white rounded-md shadow dark:bg-slate-900">
		<a href="/profile" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-slate-900 dark:hover:bg-blue-900 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Pinned Pathways
		</a> 
		<a href="/profile/completions" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-blue-900 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Completed Activities
		</a> 
		<a href="/profile/reports" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:bg-blue-900 dark:hover:bg-blue-900 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Issues Reported
		</a> 
		    
    	<a href="/logout" class="block p-3 text-sm font-semibold text-gray-900 rounded-lg dark:hover:bg-blue-900 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
			Logout
		</a>
    
	</div>
	</div>
</div>

<div class="p-6 bg-slate-200 dark:bg-slate-900 rounded-lg">
<h1 class="mb-3 text-lg">Issues Reported</h1>
<?php if (!$reports->isEmpty()) : ?>
	
	<?php foreach ($reports as $report) : ?>
	<div class="p-6 bg-white dark:bg-slate-800 rounded-lg">
	<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right btn btn-primary']) ?>
		<?= h($report->created) ?>
		<div><strong><a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></strong></div>
		<blockquote class="p-3 my-1 bg-light">
			<?= h($report->issue) ?>
		</blockquote>
		<?php if(!empty($report->response)): ?>
			<div class="alert alert-success"><?= h($report->response) ?></div>
		<?php else: ?>
			<div class="alert alert-primary">No response yet.</div>
		<?php endif ?>
		<?php if($role == 'curator' || $role == 'superuser'): ?>
		<a href="#curatorresponse<?= $report->id ?>" 
			style="color:#333;" 
			class="btn btn-light" 
			data-toggle="collapse" 
			title="Respond to this report" 
			data-target="#curatorresponse<?= $report->id ?>" 
			aria-expanded="false" 
			aria-controls="curatorresponse<?= $report->id ?>">
				Respond
		</a>	
		<div class="collapse" id="curatorresponse<?= $report->id ?>">
		<?php if($role == 'superuser'): ?>
		<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right btn btn-primary']) ?>
		<?php endif ?>
		<?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'edit', $report->id]]) ?>
		<fieldset>
		<legend><?= __('Respond') ?></legend>
		<?php
		echo $this->Form->hidden('id', ['value' => $report->id]);
		echo $this->Form->hidden('curator_id', ['value' =>  $this->Identity->get('id')]);
		echo $this->Form->textarea('response',['class' => 'form-control', 'placeholder' => 'Type here ...']);
		?>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="Submit Response">
		<?= $this->Form->end() ?>
		</div> <!-- curatorresponse -->
		<?php endif ?>

	</div>
	<?php endforeach ?>
<?php else: ?>
	<p><strong>You've not yet filed any reports.</strong></p>
	<p>You can file reports against any activity. You might find a dead link, 
		or encounter a licensing issue; if you do, you can click the report
		button and tell us what's wrong.</p>
<?php endif ?>

</div>
</div>


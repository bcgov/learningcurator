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


<div class="p-3 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">

<?php if (!$reports->all()->isEmpty()) : ?>
	
	<?php foreach ($reports as $report) : ?>
	<div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
		<?= $this->Form->postLink(__('Remove Issue'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right inline-block p-3 mb-1 ml-3 bg-slate-200 dark:bg-sky-700 dark:hover:bg-sky-800 dark:text-white hover:no-underline rounded-lg']) ?>
		
		<div class="text-sm">
			You filed issue report #<?= $report->id ?> for the following activity on 
			<?= $this->Time->format($report->created,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>:
		</div>
		<div class="my-6 text-xl"><a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></div>
		<div class="text-sm italic">You said:</div>
		<blockquote class="p-3 my-1 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
			<?= h($report->issue) ?>
		</blockquote>
		<?php if(!empty($report->response)): ?>
			<div class="p-3 my-1 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg"><?= h($report->response) ?></div>
		<?php else: ?>
			<div class="text-sm italic">Curator Responds:</div>
			<div class="p-3 my-1 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">There is no response from a Curator yet. Please be patient.</div>
		<?php endif ?>


		<?php if($role == 'curator' || $role == 'superuser'): ?>




			<div x-data="{ open: false }">
			<button @click="open = ! open" class="inline-block p-3 mb-1 ml-3 bg-slate-200 dark:bg-sky-700 dark:hover:bg-sky-800 dark:text-white hover:no-underline rounded-lg">
				Respond
			</button>
			<div xcloak x-show="open" class="p-3 my-3 rounded-lg bg-white dark:bg-slate-800 dark:text-white">

			<?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'edit', $report->id]]) ?>
			<fieldset>
			<legend><?= __('Respond') ?></legend>
			<?php
			echo $this->Form->hidden('id', ['value' => $report->id]);
			echo $this->Form->hidden('curator_id', ['value' =>  $this->Identity->get('id')]);
			echo $this->Form->textarea('response',['class' => 'block w-full px-3 py-1 m-0 dark:text-white dark:bg-slate-900/80 rounded-lg', 'placeholder' => 'Type here ...']);
			?>
			</fieldset>
			<input type="submit" class="btn btn-primary" value="Submit Response">
			<?= $this->Form->end() ?>

			</div>
		</div>


		<?php endif ?>

	</div>
	<?php endforeach ?>
<?php else: ?>
	<h2 class="mb-3 text-3xl">You've not yet filed any reports</h2>
		<div class="p-4 bg-white dark:bg-slate-800 rounded-lg">
			<p class="mb-3 text-xl">
			You can file reports against any activity. You might find a dead link, 
			or encounter a licensing issue; if you do, you can click the report
			button and tell us what's wrong.
			</p>
			
		</div>
		
		<a href="/categories" class="inline-block p-3 mt-4 bg-sky-700 dark:bg-sky-700 text-white text-2xl hover:no-underline rounded-lg">
			Explore Categories
		</a>

<?php endif ?>

</div>
</div>


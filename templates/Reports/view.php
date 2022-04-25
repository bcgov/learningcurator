<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report $report
 */
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">

<div class="p-3 bg-white dark:bg-slate-900 rounded-lg">
<?php if (!empty($report)) : ?>
	
	<h2><?= __('Reports') ?></h2>
	<div class="btn-group">
		<a class="btn btn-light" href="/reports/index">Open Reports</a>
		<a class="btn btn-light" href="/reports/closed">Closed Reports</a>
	</div>
	
	<div class="p-3 mb-2 bg-slate-200 dark:bg-slate-800 rounded-lg">
		
		<?= h($report->created) ?>
		<div><a href="<?= $report->activity->hyperlink ?>" target="_blank"><?= $report->activity->hyperlink ?></a></div>
		<div><strong><a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></strong></div>
		<blockquote class="p-3 my-1 bg-white dark:bg-slate-700">
			<?= h($report->issue) ?>
		</blockquote>
		<?php if(!empty($report->response)): ?>
			<div class="p-3 my-1 bg-white dark:bg-[#003366]"><?= h($report->response) ?></div>
		<?php else: ?>
			<div class="p-3 my-1 bg-white dark:bg-[#003366]">No response yet.</div>
		<?php endif ?>
	
		<div class="" id="curatorresponse<?= $report->id ?>">

		<?php if($this->Identity->get('role') == 'superuser'): ?>
		<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => '']) ?>
		<?php endif ?>

		<?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'edit', $report->id]]) ?>
		<fieldset>
		<legend><?= __('Update Comment') ?></legend>

		<?php
		echo $this->Form->hidden('id', ['value' => $report->id]);
		echo $this->Form->hidden('curator_id', ['value' =>  $this->Identity->get('id')]);
		echo $this->Form->textarea('response',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-700 rounded-lg', 'placeholder' => 'Type here ...']);
		?>
		</fieldset>
		<input type="submit" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline" value="Submit Response">
		<?= $this->Form->end() ?>
		</div> <!-- curatorresponse -->

	</div>
	
<?php endif ?>

</div>
</div>

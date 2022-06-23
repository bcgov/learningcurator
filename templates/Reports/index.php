<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
$this->loadHelper('Authentication.Identity');
?>

<div class="p-6">
<?php if (!empty($reports)) : ?>
	<h2><?= __('Reports') ?></h2>
	<div class="btn-group">
		<span class="btn btn-dark">Open Reports</span>
		<a class="btn btn-light" href="/reports/closed">Closed Reports</a>
	</div>
	<?php foreach ($reports as $report) : ?>
	<div class="p-3 mb-2 bg-white dark:bg-slate-900/80 rounded-lg">
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
		<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right btn btn-primary']) ?>
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

	</div>
	<?php endforeach ?>
<?php endif ?>

</div>

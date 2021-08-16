<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-4">

<div class="my-5 p-3 bg-white rounded-lg">
<?php if (!empty($reports)) : ?>
	<h2><?= __('All Reports') ?></h2>
	<?php foreach ($reports as $report) : ?>
	<div class="p-3 mb-2 bg-white rounded-lg">
		
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
</div>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
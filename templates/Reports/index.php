<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-4">

<div class="mt-5 p-5 bg-white rounded-lg">
<?php if (!empty($reports)) : ?>
	<h2><?= __('All Reports') ?></h2>
	<?php foreach ($reports as $report) : ?>
	<div class="p-3 mb-2 bg-white rounded-lg">
		
		<pre><?= print_r($report) ?><br></pre>
		
		

	</div>
	<?php endforeach ?>
<?php endif ?>

</div>
</div>
</div>
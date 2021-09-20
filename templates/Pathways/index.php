<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'btn btn-light float-right mt-5']) ?>
<h1 class="display-4 my-5"><?= __('All Pathways') ?></h1>

</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center pt-4">
<div class="col-md-10 col-lg-6">


<?php foreach ($pathways as $pathway): ?>
<div class="bg-white p-3 my-2 rounded-lg">
	<span class="badge badge-light"><?= $pathway->status->name ?></span>
	<h2><?= $this->Html->link($pathway->name, ['action' => 'view', $pathway->slug]) ?></h2>
	<?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id],['class' => 'badge badge-light']) ?>
</div>
<?php endforeach; ?>

</div>
</div>
</div>
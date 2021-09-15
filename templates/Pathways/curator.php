<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8">

<?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<h1 class="my-5"><?= __('Your Curated Pathways') ?></h1>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-10 col-lg-8">


<ul class="list-group list-group-flush my-5">
<?php foreach ($pathways as $pathway): ?>
<li class="list-group-item">
	<span class="badge badge-light"><?= $pathway->status->name ?></span>
	<h2><?= $this->Html->link($pathway->name, ['action' => 'view', $pathway->slug]) ?></h2>
	<?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id],['class' => 'badge badge-light']) ?>
</li>
<?php endforeach; ?>
</ul>

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

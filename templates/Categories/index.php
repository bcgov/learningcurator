<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
$this->assign('title', 'All topic areas');
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;

if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<h1 class="display-4 my-5">All Categories</h1>

</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-10 col-lg-6">

<?php foreach ($categories as $category): ?>
<?php if($category->featured == 1): ?>
<div class="p-3 my-3 bg-white rounded-lg shadow-sm">
	<h2 class="">
		<i class="bi bi-diagram-3-fill"></i>
		<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
	</h2>
	<div class="mb-3 p-2">
	<?= $category->description ?>
	</div>

</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="p-3 my-3 bg-white rounded-lg shadow-sm">
		<span class="badge badge-warning">NOT PUBLISHED</span>
	<h2 class="">
		<i class="bi bi-diagram-3-fill"></i>
		<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
	</h2>
	<div class="mb-3 p-2">
	<?= $category->description ?>
	</div>

</div>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>

</div>


</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
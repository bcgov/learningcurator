<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->layout = 'nowrap';
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;

if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-4">
<div class="pad-sm">
<div>Learning Pathways</div>
<?php if($role == 2 || $role == 5): // is curator or admin ?>
<div class="float-right"><?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id],['class' => 'btn btn-light']) ?></div>
<?php endif; // is curator or admin ?>
<h1><?= h($category->name) ?></h1>
<div class="text">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
</div>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center">


<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>
<div class="col-md-4 pt-3">

<h2><?= $topic->name ?></h2>
<div><?= $topic->description ?></div>
<?php foreach ($topic->pathways as $pathway) : ?>

<div class="card card-body mb-3">
<?php if($pathway->status_id != 2): // is not published? ?>
<?php if($role == 2 || $role == 5): // is curator or admin ?>
<span class="badge badge-warning"><?= $pathway->status->name ?></span>
<h2>
	<?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->id]) ?>
</h2>
<div class="mb-3">
<?= h($pathway->objective) ?>
</div>
<?php endif; // is curator or admin ?>
<?php else: ?>
<h3>
<?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->id]) ?>
</h3>
<div class="mb-3">
<?= h($pathway->description) ?>
</div>
<?php endif; // is not published ?>

</div>
<?php endforeach ?>
</div>

<?php endforeach ?>

<?php endif; // topics ?>




</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center">
<div class="col-md-12">


<h3 class="mt-3">Other Categories</h2>
<div class="card-columns">
<?php foreach ($categories as $cat) : ?>
<?php if($cat->id == $category->id) continue ?>
<div class="card card-body">
<h4>
	<?= $this->Html->link($cat->name, ['controller' => 'Categories', 'action' => 'view', $cat->id]) ?>
</h4>
<div><?= h($cat->description) ?></div>
</div>
<?php endforeach; ?>
</div>

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
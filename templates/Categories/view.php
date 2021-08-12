<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;

if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}

?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-4">
<div class="py-3">
<div><?= $this->Html->link(__('All Topic Categories'), ['action' => 'index']) ?></div>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="float-right btn-group">
	<?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id],['class' => 'btn btn-light']) ?>
	<a class="btn btn-light" 
		data-toggle="collapse" 
		href="#addnewtopic" 
		role="button" 
		aria-expanded="false" 
		aria-controls="addnewtopic">
    		New Topic
  	</a>
</div>
<?php endif; // is curator or admin ?>
<h1><?= h($category->name) ?></h1>
<div class="text">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
</div>
</div>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="col-md-3 collapse" id="addnewtopic">
<div class="p-3 my-3 bg-white rounded-lg">
<?= $this->Form->create(null,['url' => ['controller' => 'Topics', 'action' => 'add']]) ?>
<fieldset>
	<legend><?= __('Add Topic') ?></legend>
	<?php
		echo $this->Form->control('name', ['class' => 'form-control']);
		echo $this->Form->control('description', ['class' => 'form-control']);
		//echo $this->Form->control('image_path');
		///echo $this->Form->control('color');
		//echo $this->Form->control('featured');
		echo $this->Form->hidden('user_id', ['value' => $uid]);
		echo $this->Form->hidden('categories.0.id', ['value' => $category->id]);
	?>
</fieldset>
<?= $this->Form->button(__('Add Topic'), ['class' => 'btn btn-primary mt-2']) ?>
<?= $this->Form->end() ?>
</div>
</div>
<?php endif;  // curator or admin? ?>
</div>
</div>

<div class="container-fluid linear">
<div class="row justify-content-md-center">


<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>

<div class="col-md-4 pt-3">
<h2>
	<i class="fas fa-sitemap"></i> <!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
	
</h2>
<div class="p-3"><?= $topic->description ?></div>


<?php foreach ($topic->pathways as $pathway) : ?>

<div class="p-3 my-3 bg-white rounded-lg">
<?php if($pathway->status_id == 2): // is published ?>

	<h3>
<?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->slug]) ?>
</h3>
<div class="mb-3">
<?= h($pathway->description) ?>
</div>

<?php else: ?>
	
<?php if($role == 'curator' || $role == 'superuser'): ?>
<span class="badge badge-warning"><?= $pathway->status->name ?></span>
<h2>
	<?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->slug]) ?>
</h2>
<div class="mb-3">
<?= h($pathway->objective) ?>
</div>
<?php endif; // is curator or admin ?>
<?php endif; // is published ?>
</div>
<?php endforeach ?>

</div>
<?php endforeach ?>
</div>
<?php endif; // topics ?>
</div>

</div>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center">
<div class="col-md-6">


<h3 class="mt-3">Other Topic Areas</h2>
<div class="">
<?php foreach ($categories as $cat) : ?>
<?php if($cat->id == $category->id) continue ?>
<div class="bg-white p-3 m-2 rounded-3">
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
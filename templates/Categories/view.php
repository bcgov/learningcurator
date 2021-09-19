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
$pagetitle = $category->name . ' | Topic | ';
$this->assign('title', $pagetitle);
?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">
<div class="py-3">
<div><?= $this->Html->link(__('All Topic Areas'), ['action' => 'index']) ?></div>
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
<h1>
	<i class="bi bi-diagram-3-fill"></i>
	<?= h($category->name) ?>
</h1>
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

<div class="col-md-6 col-lg-6 pt-3">
<div class="p-3 my-3 bg-white rounded-lg">
<h2>
	<i class="bi bi-diagram-3-fill"></i> <!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
	
</h2>
<div class="p-3"><?= $topic->description ?></div>

<?php foreach ($topic->pathways as $pathway) : ?>

<div class="p-3">
<?php if($pathway->status_id == 2): // is published ?>
	<div>
		<a href="/pathways/<?= h($pathway->slug) ?>" class="font-weight-bold">
			<i class="bi bi-pin-map-fill"></i>
			<?= $pathway->name ?>
		</a>
	</div>
	<div class="mb-3">
	<?= h($pathway->description) ?>
	</div>

<?php else: ?>
	
<?php if($role == 'curator' || $role == 'superuser'): ?>
<span class="badge badge-warning"><?= $pathway->status->name ?></span>
<h3>
	<i class="bi bi-pin-map-fill"></i>
	<?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->slug]) ?>
</h3>
<div class="mb-3">
<?= h($pathway->objective) ?>
</div>
<?php endif; // is curator or admin ?>
<?php endif; // is published ?>
</div>
<?php endforeach ?>

</div>
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
	<i class="bi bi-diagram-3-fill"></i>
	<?= $this->Html->link($cat->name, ['controller' => 'Categories', 'action' => 'view', $cat->id]) ?>
</h4>
<div><?= h($cat->description) ?></div>
</div>
<?php endforeach; ?>
</div>

</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
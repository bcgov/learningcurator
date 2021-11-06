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
$pagetitle = $category->name . '';
$this->assign('title', $pagetitle);
?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">
<div class="py-3">
<div><?= $this->Html->link(__('Categories'), ['action' => 'index']) ?></div>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="float-right btn-group">
	<?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id],['class' => 'btn btn-light']) ?>
	<a class="btn btn-primary" 
		data-toggle="modal" 
		data-target="#addTopicModal" 
		href="#addTopicModal" 
		role="button" 
		aria-expanded="false" 
		aria-controls="addnewtopic">
    		New Topic
  	</a>
</div>
<?php endif; // is curator or admin ?>
<h1 class="display-4">
	<i class="bi bi-diagram-3-fill"></i>
	<?= h($category->name) ?>
</h1>
<div class="text" style="font-size: 120%">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
</div>
</div>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="addTopicLabel">Add a New topic</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
		<?= $this->Form->create(null,['url' => ['controller' => 'Topics', 'action' => 'add']]) ?>
		<fieldset>
			<?php
				echo $this->Form->control('name', ['class' => 'form-control']);
				?>
				<label for="description">Description</label>
				<?php
				echo $this->Form->textarea('description', ['class' => 'form-control', 'id' => 'description']);
				?>
				<?php
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
	</div>
</div>

<?php endif;  // curator or admin? ?>
</div>
</div>

<div class="container-fluid linear">
<div class="row justify-content-md-center">
<div class="col-md-6 col-lg-6 pt-3">

<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>
<?php if($topic->featured == 1): ?>

<div class="p-3 my-3 bg-white rounded-lg shadow-sm">
<h2>
	<!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
	
</h2>
<div class="p-2 mb-3" style="font-size: 110%"><?= $topic->description ?></div>

<?php foreach ($topic->pathways as $pathway) : ?>

<div class="p-2">
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
<div>
	<i class="bi bi-pin-map-fill"></i>
	<?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->slug]) ?>
</div>
<div class="mb-3">
<?= h($pathway->objective) ?>
</div>
<?php endif; // is curator or admin ?>
<?php endif; // is published ?>
</div>
<?php endforeach ?>

</div>
<?php endif; // is published ?>
<?php endforeach ?>


<?php endif; // topics ?>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
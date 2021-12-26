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

<div class="mt-6 dark:text-white">
<div>
	<?= $this->Html->link(__('Categories'), ['action' => 'index']) ?> / 
	<?= h($category->name) ?>
</div>
<h1 class="text-4xl">
	<?= h($category->name) ?>
</h1>
<div class="text">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>

<?php if($role == 'curator' || $role == 'superuser'): ?>

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

<?php endif;  // curator or admin? ?>


<div>Topics included within this category:</div>
</div>
<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>
<?php if($topic->featured == 1): ?>
<div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
<h2>
	<!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
	
</h2>
<div class="py-2 mb-2"><?= $topic->description ?></div>
<div>Pathways included in this topic:</div>
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
<?php else: ?>
	<?php if($role == 'curator' || $role == 'superuser'): ?>

		<div class="p-3 mb-3 bg-white rounded-lg shadow-sm">
		<span class="badge badge-warning">DRAFT</span>
<h2>
	<!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
	
</h2>
<div class="py-2 mb-2" style="font-size: 110%"><?= $topic->description ?></div>

	<?php endif; // is curator or admin ?>
<?php endif; // is published ?>
<?php endforeach ?>


<?php endif; // topics ?>

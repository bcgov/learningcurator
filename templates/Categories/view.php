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

<div class="p-6 dark:text-white">

<nav class="bg-slate-200 dark:bg-slate-900 rounded-lg p-3" aria-label="breadcrumb">
	<?= $this->Html->link(__('Categories'), ['action' => 'index']) ?> / 
	<?= h($category->name) ?>
</nav>

<h1 class="text-4xl my-3">
	<?= h($category->name) ?>
</h1>

<div class="p-3 bg-slate-200 dark:bg-[#002850] rounded-lg">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="hidden">
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
<?php endif;  // curator or admin? ?>



<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>
<?php if($topic->featured == 1): ?>
	
<div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
<h2 class="text-3xl">
	<!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
	
</h2>
<div class="py-2 mb-2"><?= $topic->description ?></div>

<?php foreach ($topic->pathways as $pathway) : ?>

<?php if($pathway->status_id == 2): // is published ?>
	<div class="p-3 bg-slate-200 dark:bg-[#003366] rounded-lg">
		<a href="/pathways/<?= h($pathway->slug) ?>" class="text-2xl">
			<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
				<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
				<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
			</svg>
			<?= $pathway->name ?>
		</a>
		<div class="mt-2 p-3 bg-slate-200 dark:bg-[#002850] rounded-lg">
		<?= h($pathway->description) ?>
		</div>
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


<?php endif; // is published ?>
<?php endforeach ?>
<?php endif; // topics ?>

</div>
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


</div>
<?php endif; // is published ?>
<?php endforeach ?>
<?php endif; // topics ?>

</div>
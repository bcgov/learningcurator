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

<h1 class="my-6 text-4xl dark:text-white">Categories</h1>

<?php foreach ($categories as $category): ?>

<div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-gray-900 dark:text-white">
	<h2 class="text-3xl">
		<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
	</h2>
	<div class="mb-3">
	<?= $category->description ?>
	</div>
	<?php if(!empty($category->topics[0]->pathways[0]->name)): ?>
	<?php foreach ($category->topics as $topic): ?>
		<div class="p-3">
		<h3 class="text-xl"><?= $this->Html->link($topic->name, ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></h3>
		<?= h($topic->description) ?>
		</div>
		<?php foreach ($topic->pathways as $path): ?>
		<div class="mx-3 my-1 p-3 rounded-lg bg-cyan-50 dark:bg-gray-800">
		<h4 class="text-lg"><a href="/pathways/<?= h($path->slug) ?>"><?= h($path->name) ?></a></h4>
		<div><?= h($path->description) ?></div>


		<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
		<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $path->id]) ?>
		<?= $this->Form->button(__('Follow Pathway'),['class' => 'my-3 p-3 bg-slate-200 rounded-lg dark:bg-gray-900 dark:text-white']) ?>
		<?= $this->Form->end() ?>


		</div>
		<?php endforeach ?>
	<?php endforeach ?>
	<?php endif ?>
</div>
<?php endforeach; ?>
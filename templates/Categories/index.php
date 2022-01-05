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
<div class="dark:text-white">
<h1 class="my-6 text-4xl">Categories</h1>

<?php foreach ($categories as $category): ?>

<div class="my-2 p-3 bg-slate-100 dark:bg-gray-900 w-full">
	<div x-data="{ open: false }">
		<h2 class="text-3xl">
			<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
		</h2>
	
		<button @click="open = ! open">Show</button>
	
		<div x-show="open" @click.outside="open = false">
		<?php if(!empty($category->topics[0]->pathways[0]->name)): ?>
		<?php foreach ($category->topics as $topic): ?>
		<div class="mb-6">
			<h3 class="text-2xl"><?= $this->Html->link($topic->name, ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></h3>
			<?php foreach ($topic->pathways as $path): ?>
				<div class="my-1">
				<h4 class="text-xl">
					<a href="/pathways/<?= h($path->slug) ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
						<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
						<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
					</svg>
					<?= h($path->name) ?>
					</a>
				</h4>
				</div>
			<?php endforeach ?>
		</div>
		<?php endforeach ?>
		<?php endif ?>
		</div>
	</div>
</div>
<?php endforeach; ?>

</div>
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
<div class="p-6 dark:text-white">
<h1 class="text-4xl">Categories</h1>

<?php foreach ($categories as $category): ?>

<div class="my-2 p-3 bg-slate-100 dark:bg-slate-900 w-full rounded-lg">
	<div x-data="{ open: false }">
		<h2 class="text-3xl">
			<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
			<button class="inline-block p-2 ml-3 text-xs bg-slate-300 hover:bg-slate-200 dark:bg-[#003366] dark:hover:bg-gray-700 rounded-lg" x-show="!open" @click="open = ! open">
				Show Topics
			</button>
			<button class="inline-block p-2 ml-3 text-xs bg-slate-200 hover:bg-slate-300 dark:bg-[#003366] dark:hover:bg-gray-700 rounded-lg" x-show="open" @click="open = ! open">
				Hide Topics
			</button>
		</h2>
		<div x-show="open" x-transition.duration.500ms @click.outside="open = false">
		<div class="my-3">
			<?= h($category->description) ?>
		</div>
		<?php if(!empty($category->topics[0]->pathways[0]->name)): ?>
		<?php foreach ($category->topics as $topic): ?>
		<div class="p-3 mb-3 bg-slate-200 dark:bg-[#003366] rounded-lg">
			<h3 class="text-2xl"><?= $this->Html->link($topic->name, ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></h3>
			<div class="my-3">
				<?= h($topic->description) ?>
			</div>			
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
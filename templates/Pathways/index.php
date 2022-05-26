<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="p-6 dark:text-white">



<?php foreach ($pathways as $pathway): ?>
	<div class="p-6 mb-3 w-full bg-center bg-no-repeat rounded-lg" style="background-image: url('<?= h($pathway->topic->categories[0]->image_path) ?>')">
	<div class="p-3 text-xl bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
	
	<h2 class="mb-2 text-2xl">
		<a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= h($pathway->topic->slug) ?>/pathway/<?= h($pathway->slug) ?>" class="font-weight-bold">
			<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
				<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
				<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
			</svg>
			<?= h($pathway->name) ?>
		</a> 
	</h2>
	<div class="p-3 bg-white dark:bg-slate-800 rounded-lg">
		<?= h($pathway->description) ?>
	</div>
	<a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= h($pathway->topic->slug) ?>/pathway/<?= h($pathway->slug) ?>" 
		class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
			View Pathway
	</a>
	<div class="p-3 bg-white dark:bg-slate-700 rounded-lg">
		<?php 
		$stat = 'badge-light'; 
		if($pathway->status->name == 'Draft') $stat = 'badge-warning';
		?>
		<?php if($pathway->featured == 1): ?>
		<span class="badge badge-success">Featured</span>
		<?php endif ?>
		<span class="badge <?= $stat ?>"><?= $pathway->status->name ?></span> in 
		<?php $topiclink = $pathway->topic->categories[0]->name . ', ' . $pathway->topic->name ?>
		<a href="/category/<?= $pathway->topic->categories[0]->id ?>/<?= $pathway->topic->categories[0]->slug ?>/topic/<?= $pathway->topic->id ?>/<?= $pathway->topic->slug ?>">
			<?= $topiclink ?>
		</a>

	</div>
</div>
</div>
<?php endforeach; ?>


</div>
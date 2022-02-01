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

<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'mt-5']) ?>
<?php endif ?>

<h1 class="text-3xl"><?= __('All Pathways') ?></h1>

<div class="md:grid md:grid-cols-2 md:gap-4 mt-3">
<?php foreach ($pathways as $pathway): ?>
<div class="p-3 my-3 md:my-0 bg-white dark:bg-slate-900 rounded-lg">
	
	<h2 class="mb-2 text-2xl">
		<a href="/pathways/<?= h($pathway->slug) ?>" class="font-weight-bold">
			<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
				<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
				<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
			</svg>
			<?= h($pathway->name) ?>
		</a> 
	</h2>
	<div class="bg-slate-200 dark:bg-slate-800 p-3">
		<?= h($pathway->description) ?>
	</div>
	<div class="bg-slate-200 dark:bg-slate-700 p-3">
		<?php 
		$stat = 'badge-light'; 
		if($pathway->status->name == 'Draft') $stat = 'badge-warning';
		?>
		<?php if($pathway->featured == 1): ?>
		<span class="badge badge-success">Featured</span>
		<?php endif ?>
		<span class="badge <?= $stat ?>"><?= $pathway->status->name ?></span> in 
		<?php $topiclink = $pathway->topic->categories[0]->name . ', ' . $pathway->topic->name ?>
		<?= $this->Html->link($topiclink, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id],['class' => '']) ?>
	</div>
</div>
<?php endforeach; ?>

</div>
</div>
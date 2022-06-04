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
<div class="p-6 w-full bg-top md:bg-center bg-no-repeat md:bg-fixed min-h-screen rounded-tr-xl" style="background-image: url('<?= h($category->image_path) ?>')">


<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="mt-3 float-right">
<?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'inline-block px-4 py-2 text-md bg-sky-700 dark:text-white dark:bg-sky-700 dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900/80 dark:hover:bg-slate-900/80 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
<?= $this->Html->link(__('Add Topic'), ['controller' => 'Topics', 'action' => 'add'], ['class' => 'inline-block px-4 py-2 text-md bg-sky-700 dark:text-white dark:bg-sky-700 dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900/80 dark:hover:bg-slate-900/80 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
</div>
<?php endif;  // curator or admin? ?>

<nav class="mb-3 p-3 bg-white dark:bg-slate-900 rounded-lg" aria-label="breadcrumb">
    <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'],['class' => '']) ?> / 
    <?= h($category->name) ?>
</nav>

<div class="my-3 p-3 bg-white/80 dark:bg-slate-900/80 rounded-lg">
<h1 class="text-4xl">
	<?= h($category->name) ?>
</h1>
<div class="p-3 mb-2 text-xl bg-white dark:bg-slate-800 rounded-lg">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
</div>

<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>


<?php if($topic->featured == 1): ?>
	<div class="p-3 my-3 bg-white/80 rounded-lg dark:bg-slate-900/80 dark:text-white">
<h2 class="text-3xl">
	<!-- topic_id: <?= $topic->id ?> --> 
	<a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>">
		<?= $topic->name ?>
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
		<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
		</svg>
	</a>
</h2>

<div class="p-3 mb-2 text-xl bg-white dark:bg-slate-800 rounded-lg">
	<?= $topic->description ?>
</div>
<a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
	View Topic
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
	<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
	</svg>
</a>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="p-3 my-3 bg-white/80 rounded-lg dark:bg-slate-900/80 dark:text-white">
DRAFT
<h2 class="text-3xl">
	<!-- topic_id: <?= $topic->id ?> --> 
	<a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>">
		<?= $topic->name ?>
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
		<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
		</svg>
	</a>
</h2>

<div class="p-3 mb-2 text-xl bg-white dark:bg-slate-800 rounded-lg">
	<?= $topic->description ?>
</div>
<a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
	View Topic
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
	<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
	</svg>
</a>
</div>
<?php endif ?>
<?php endif ?>

<?php endforeach ?>
<?php endif; // topics ?>

</div>
</div>
</div>
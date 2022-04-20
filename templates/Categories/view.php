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

<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="mt-3 float-right">
<?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'inline-block px-4 py-2 text-md bg-sky-700 dark:text-white dark:bg-sky-700 dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900 dark:hover:bg-slate-900 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
<?= $this->Html->link(__('Add Topic'), ['controller' => 'Topics', 'action' => 'add'], ['class' => 'inline-block px-4 py-2 text-md bg-sky-700 dark:text-white dark:bg-sky-700 dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900 dark:hover:bg-slate-900 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
</div>
<?php endif;  // curator or admin? ?>

<h1 class="text-4xl my-3">
	<?= h($category->name) ?>
</h1>

<div class="p-3 bg-slate-200 dark:bg-slate-800 rounded-lg">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>

<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>
<?php if($topic->featured == 1): ?>
	
<div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
<h2 class="text-3xl">
	<!-- topic_id: <?= $topic->id ?> --> 
	<a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>"><?= $topic->name ?></a>
</h2>

<div class="p-3 mb-2 bg-slate-100 dark:bg-slate-800">
	<?= $topic->description ?>
</div>
<a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
	View Topic
</a>

</div>
<?php endif; // is published ?>
<?php endforeach ?>
<?php endif; // topics ?>

</div>
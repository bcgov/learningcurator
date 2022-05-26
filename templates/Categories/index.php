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
<div class="px-6">
<div class="grid lg:grid-cols-2 gap-4">

<?php foreach ($categories as $category): ?>

<div class="rounded-lg bg-center bg-cover shadow-lg" style="background-image: url('<?= h($category->image_path) ?>')">
	<div class="my-2 h-40 ">
		<?php if(empty($category->featured)): ?>
			<span class="inline-block py-0 px-2 bg-yellow-600 text-white text-xs" title="Edit to set to publish">DRAFT</span>
		<?php endif ?>

		<h1 class="text-3xl">

			<a class="block mt-6 p-3 bg-white/80 dark:bg-slate-900/80 hover:bg-white dark:hover:bg-slate-900 text-black dark:text-white shadow-lg hover:no-underline" href="/category/<?= $category->id ?>/<?= h($category->slug) ?>">
				<?= h($category->name) ?>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
				<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
				</svg>
			</a>

		</h1>

		<!-- <div class="my-3">
			<?= h($category->description) ?>
		</div> -->

</div> <!-- overlay color -->
</div> <!-- formatting container -->
<?php endforeach; ?>

</div><!--  -->
</div><!-- formatting container -->
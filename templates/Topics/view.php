<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="p-6 w-full bg-top bg-no-repeat md:bg-fixed min-h-screen rounded-tr-xl" style="background-image: url('<?= h($topic->categories[0]->image_path) ?>')">


<nav class="mb-3 p-3 bg-white dark:bg-slate-900 rounded-lg" aria-label="breadcrumb">
    <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'],['class' => '']) ?> / 
    <a href="/category/<?= h($topic->categories[0]->id) ?>/<?= h($topic->categories[0]->slug) ?>"><?= h($topic->categories[0]->name) ?></a> / 
    <?= h($topic->name) ?>
</nav>


<div class="p-4 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
<h1 class="text-3xl">
    <?= h($topic->name) ?>
</h1>
<div class="p-4 text-2xl bg-slate-100/80 dark:bg-slate-800 rounded-lg">
<?= h($topic->description) ?>
</div>
</div>



<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('Edit Topic'), ['action' => 'edit', $topic->id], ['class' => 'inline-block px-4 py-2 text-md bg-sky-700 text-white dark:bg-sky-700 dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900/80 dark:hover:bg-slate-900/80 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
<!-- <a href="/pathways/import/<?= $topic->id ?>">Import a Pathway</a> -->

<form method="GET" action="/pathways/import/<?= $topic->id ?>" class="p-3 m-3 bg-white dark:bg-slate-900">
<input type="text" 
        name="pathimportfile" 
        id="pathimportfile" 
        class="block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg">
<input type="submit" value="Import Pathway">
</form>

<?php endif ?>





<?php foreach($topic->pathways as $pathway): ?>
<?php if($pathway->status_id == 2): ?>


    <div class="p-3 my-3 bg-white/80 rounded-lg shadow-sm dark:bg-slate-900/80 dark:text-white">
    <h2 class="text-3xl">
            <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="inline-block -mt-2" viewBox="0 0 16 16">
                    <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
                </svg>
                <?= h($pathway->name) ?>
            </a>
        </h2>
        <div class="p-4 text-lg bg-slate-100/80 dark:bg-slate-800 rounded-lg">
            <?= h($pathway->description) ?>
        </div>
        <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>"
            class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                View Pathway
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
				<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
				</svg>
        </a>
    </div>


<?php else: ?>
    <?php if($role == 'curator' || $role == 'superuser'): ?>
        <div class="p-3 my-3 bg-white/80 rounded-lg shadow-sm dark:bg-slate-900/80 dark:text-white">
        <div class="badge badge-warning">DRAFT</div>
        <h2 class="text-2xl">
            <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
                    <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
                </svg>
                <?= h($pathway->name) ?>
            </a>
        </h2>
        <div class="p-4 text-lg bg-slate-100/80 dark:bg-slate-800 rounded-lg">
            <?= h($pathway->description) ?>
        </div>
        <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>"
            class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                View Pathway
        </a>
    </div>
    <?php endif ?>
<?php endif ?>
<?php endforeach ?>
</div>

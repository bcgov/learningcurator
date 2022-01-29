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
<div class="p-6 dark:text-white">
<nav class="bg-slate-200 dark:bg-slate-900 rounded-lg p-3" aria-label="breadcrumb">
    <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'],['class' => '']) ?> / 
    <?= $this->Html->link($topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $topic->categories[0]->id],['class' => '']) ?> / 
    <?= h($topic->name) ?>
</nav>

<h1 class="text-3xl mt-4">
    <?= h($topic->name) ?>
</h1>
<div class="mb-5">
<?= h($topic->description) ?>
</div>

<?php foreach($topic->pathways as $pathway): ?>
<?php if($pathway->status_id == 2): ?>
    <div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
    <h2 class="text-2xl">
            <a href="/pathways/<?= h($pathway->slug) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
                    <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
                </svg>
                <?= h($pathway->name) ?>
            </a>
        </h2>
        <div><?= h($pathway->description) ?></div>
    </div>
<?php else: ?>
    <?php if($role == 'curator' || $role == 'superuser'): ?>
        <div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
        <div class="badge badge-warning">DRAFT</div>
        <h2 class="text-2xl">
            <a href="/pathways/<?= h($pathway->slug) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
                    <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
                </svg>
                <?= h($pathway->name) ?>
            </a>
        </h2>
        <div><?= h($pathway->description) ?></div>
    </div>
    <?php endif ?>
<?php endif ?>
<?php endforeach ?>
</div>
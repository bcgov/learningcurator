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
<div class="mt-6 dark:text-white">
<nav aria-label="breadcrumb">
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
</div>
<?php foreach($topic->pathways as $pathway): ?>
<?php if($pathway->status_id == 2): ?>
    <div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
        <h2 class="text-2xl">
            <i class="bi bi-pin-map-fill"></i>
            <?= $this->Html->link($pathway->name, ['controller' => 'Pathways', 'action' => 'view', $pathway->slug],['class' => '']) ?>
        </h2>
        <div><?= h($pathway->description) ?></div>
    </div>
<?php else: ?>
    <?php if($role == 'curator' || $role == 'superuser'): ?>
        <div class="p-3 my-3 bg-white rounded-lg shadow-sm dark:bg-slate-900 dark:text-white">
        <div class="badge badge-warning">DRAFT</div>
        <h2 class="text-2xl">
            <i class="bi bi-pin-map-fill"></i>
            <?= $this->Html->link(h($pathway->name), ['controller' => 'Pathways', 'action' => 'view', $pathway->slug],['class' => '']) ?>
        </h2>
        <div><?= h($pathway->description) ?></div>
    </div>
    <?php endif ?>
<?php endif ?>
<?php endforeach ?>

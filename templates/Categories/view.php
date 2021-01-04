<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;

if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-12">
<div class="my-3 p-5 bg-dark text-white rounded-3 shadow-sm">
<h1 class="display-2"><?= h($category->name) ?></h1>
<div class="text">
<?= $this->Text->autoParagraph(h($category->description)); ?>
</div>
</div>
</div>
<div class="col-md-6">
<?php if (!empty($category->topics)) : ?>
<?php foreach ($category->topics as $topic) : ?>
<div class="bg-dark text-white rounded-3 shadow-sm p-3">
<h2>
	<i class="fas fa-sitemap"></i> <!-- topic_id: <?= $topic->id ?> --> 
	<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
</h2>
<div class="p-3"><?= $topic->description ?></div>
</div>
<?php endforeach ?>
<?php endif; // topics ?>

</div>
</div>
</div>

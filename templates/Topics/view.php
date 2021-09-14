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
<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-4">
<div class="py-3">
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div><?= $this->Html->link(__('Edit'), ['action' => 'edit', $topic->id],['class' => 'btn btn-primary float-right']) ?></div>
<?php endif ?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb mt-3">
	
	<li class="breadcrumb-item">
    <?= $this->Html->link(__('All Topic Areas'), ['controller' => 'Categories', 'action' => 'index'],['class' => '']) ?>
    </li>
	<li class="breadcrumb-item">
    <?= $this->Html->link(h($topic->categories[0]->name), ['controller' => 'Categories', 'action' => 'view', $topic->categories[0]->id],['class' => '']) ?>
    </li>
	
	</ol>
	</nav>

<h1>
    <i class="bi bi-bar-chart-steps"></i>
    <?= h($topic->name) ?>
</h1>
<div class="mb-5">
<?= h($topic->description) ?>
</div>
</div>
</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center">
<div class="col-md-4">
<?php foreach($topic->pathways as $pathway): ?>
<?php if($pathway->status_id == 2): ?>
    <div class="p-3 my-3 bg-white rounded-lg">
        <h2>
            <i class="bi bi-pin-map-fill"></i>
            <?= $this->Html->link(h($pathway->name), ['controller' => 'Pathways', 'action' => 'view', $pathway->slug],['class' => '']) ?>
        </h2>
        <div><?= h($pathway->description) ?></div>
    </div>
<?php else: ?>
    <?php if($role == 'curator' || $role == 'superuser'): ?>
    <div class="p-3 my-3 bg-white rounded-lg">
        <div class="badge badge-warning">DRAFT</div>
        <h2>
            <i class="bi bi-pin-map-fill"></i>
            <?= $this->Html->link(h($pathway->name), ['controller' => 'Pathways', 'action' => 'view', $pathway->slug],['class' => '']) ?>
        </h2>
        <div><?= h($pathway->description) ?></div>
    </div>
    <?php endif ?>
<?php endif ?>
<?php endforeach ?>
</div>
<?php if($role == 'superuser' || $role == 'curator'): ?>
<div class="col-md-3">
<div class="p-3 my-3 bg-white rounded-lg">
    <?= $this->Form->create(null,['url' => ['controller' => 'Pathways', 'action' => 'add']]) ?>
    <?php 
    echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
    echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]); 
    ?>
    <fieldset>
        <legend><?= __('Add Pathway') ?></legend>
        <?php
            echo $this->Form->hidden('topic_id', ['value' => $topic->id]);
            echo $this->Form->hidden('status_id',['value' => 1]);
            echo $this->Form->control('name',['class' => 'form-control']);
            echo $this->Form->control('description',['class' => 'form-control']);
            echo $this->Form->control('objective',['class' => 'form-control']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Add new pathway'),['class' => 'btn btn-block btn-success mt-3']) ?>
    <?= $this->Form->end() ?>
</div>
</div>
<?php endif;  // if curator /admin ?>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
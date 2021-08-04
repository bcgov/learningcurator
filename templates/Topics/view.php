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
<div class="pad-sm">
<div><?= $this->Html->link(h($topic->categories[0]->name), ['controller' => 'Categories', 'action' => 'view', $topic->categories[0]->id],['class' => '']) ?></div>
<h1><?= h($topic->name) ?></h1>
<div>
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
    <div class="p-3 my-3 bg-white rounded-lg">
        <h2><?= $this->Html->link(h($pathway->name), ['controller' => 'Pathways', 'action' => 'view', $pathway->slug],['class' => '']) ?></h2>
        <div><?= h($pathway->description) ?></div>
    </div>
<?php endforeach ?>
</div>
<?php if($role == 'superadmin' || $role == 'curator'): ?>
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
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
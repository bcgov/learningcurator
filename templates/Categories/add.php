<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->loadHelper('Authentication.Identity');
?>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-4">

<div class="mt-5 p-5 bg-white rounded-lg">

<?= $this->Form->create($category) ?>
<fieldset>
<legend><?= __('Add Category') ?></legend>
<?php
echo $this->Form->control('name',['class' => 'form-control']);
echo $this->Form->control('description',['class' => 'form-control']);
//echo $this->Form->control('image_path');
//echo $this->Form->control('color');
//echo $this->Form->control('featured');
echo $this->Form->hidden('createdby',['value' => $this->Identity->get('id')]);
?>
</fieldset>
<?= $this->Form->button(__('Add new Topic Category'),['class' => 'btn btn-success mt-3']) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
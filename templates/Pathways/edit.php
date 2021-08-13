<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-10 col-lg-8 col-xl-5">
<div class="bg-white p-3 my-5">

<?= $this->Form->create($pathway) ?>

<label><?php echo $this->Form->checkbox('featured'); ?> Featured?</label>

<?php echo $this->Form->hidden('modifiedby',['value' => $this->Identity->get('id')]) ?>


<?php echo $this->Form->control('status_id', ['type' => 'select', 'options' => $statuses, 'class' => 'form-control']) ?>


<div>
<label>Topic:
<?php echo $this->Form->select(
    'topic_id',
    $areas,
	['class' => 'form-control'],
);
?></label>
</div>
<?php
echo $this->Form->control('name', ['class' => 'form-control']);
echo $this->Form->control('slug', ['class' => 'form-control']);
echo $this->Form->control('description', ['class' => 'form-control']);
echo $this->Form->control('estimated_time', ['class' => 'form-control']);
echo $this->Form->control('objective', ['class' => 'form-control']);
//echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true, 'class' => 'form-control']);
//echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true, 'class' => 'form-control']);
//echo $this->Form->control('color');
//echo $this->Form->control('file_path');
//echo $this->Form->control('image_path');
//echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
//echo $this->Form->control('competencies._ids', ['options' => $competencies]);
?>
<?= $this->Form->button(__('Save Pathway'), ['class' => 'btn btn-block btn-success mt-3']) ?>
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
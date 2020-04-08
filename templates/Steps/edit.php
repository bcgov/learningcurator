<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
?>

<?= $this->Form->create($step) ?>
<?= $this->Form->hidden('image_path', ['class' => 'form-control']) ?>
<?= $this->Form->hidden('featured', ['class' => 'form-control']) ?>
<?= $this->Form->hidden('modifiedby') ?>
<?= $this->Form->hidden('pathway_id', ['value' => $step->pathway_id]) ?>

<div class="row">
    <div class="col-md-4">
        <?= $this->Form->control('name', ['class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['class' => 'form-control']) ?>
        <?= $this->Form->button(__('Save Step'),['class' => 'btn btn-success btn-block my-3']) ?>
    </div>
    <div class="col-md-4">
        <?= $this->Form->control('activities._ids', ['options' => $activities]) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
<script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry $ministry
 */
?>
<div class="container-fluid" id="colorful">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="m-5 p-5 bg-white rounded-lg shadow-sm">
    <h1>Add Ministry</h1>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="m-5 p-5 bg-white rounded-lg shadow-sm">
<?= $this->Form->create($ministry) ?>
<fieldset>
<?php
echo $this->Form->control('name',['class' => 'form-control']);
echo $this->Form->control('slug',['class' => 'form-control','label'=>'Shortcode']);
echo $this->Form->hidden('elm_learner_group',['value'=>'ALLBCGOV']);
echo $this->Form->control('description',['class' => 'form-control']);
//echo $this->Form->control('hyperlink');
//echo $this->Form->control('image_path');
//echo $this->Form->control('color');
//echo $this->Form->control('featured');
?>
</fieldset>
<?= $this->Form->button(__('Add Ministry'),['class' => 'btn btn-success mt-1']) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>

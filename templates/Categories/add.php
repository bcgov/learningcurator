<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="card mb-3">
<div class="card-body">

<?= $this->Form->create($category) ?>
<fieldset>
<legend><?= __('Add Category') ?></legend>
<?php
echo $this->Form->control('name');
echo $this->Form->control('description');
echo $this->Form->control('image_path');
echo $this->Form->control('color');
echo $this->Form->control('featured');
echo $this->Form->control('createdby');
?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>

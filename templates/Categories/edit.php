<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">
<div class="float-right mt-5">
<?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $category->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'btn btn-danger']
            ) ?>
</div>
    <div class="mt-5">Topic Area</div>
    <h1 class="display-4 mb-5">
        Editing <?= h($category->name) ?>
    </h1>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center">
<div class="col-md-8 col-lg-6 col-xl-4">
<div class="bg-white p-3 my-5 shadow-sm">


<?= $this->Form->create($category) ?>
<fieldset>

<?php
//echo $this->Form->control('topics._ids', ['options' => $topics]);
echo $this->Form->control('name',['class' => 'form-control']);
//echo $this->Form->control('slug');
echo $this->Form->control('description',['class' => 'form-control']);
// echo $this->Form->control('image_path');
// echo $this->Form->control('color');
// echo $this->Form->control('featured');
//echo $this->Form->control('createdby');

?>
</fieldset>
<?= $this->Form->button(__('Update Topic Area'),['class' => 'btn btn-success mt-3']) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
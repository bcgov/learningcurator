<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">
    <h1 class="display-4 my-5">
        Editing <?= h($topic->name) ?>
    </h1>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center">
<div class="col-md-8 col-lg-6 col-xl-4">
<div class="bg-white p-3 my-5 shadow-sm">
<div class="float-right">
<?= $this->Form->postLink(
__('Delete'),
['action' => 'delete', $topic->id],
['confirm' => __('Are you sure you want to delete # {0}?', $topic->id), 
    'class' => 'btn btn-danger']
) ?>
</div>
<?= $this->Form->create($topic) ?>
<fieldset>
<label>Topic Area
<select name="categories[_ids][]" id="categories" class="form-control">
<?php foreach($categories as $c): ?>
    <?php if($topic->categories[0]->id == $c['value']): ?>
        <option selected value="<?= $c['value'] ?>"><?= $c['text'] ?></option>
    <?php else: ?>
        <option value="<?= $c['value'] ?>"><?= $c['text'] ?></option>
    <?php endif ?>
<?php endforeach ?>
</select>
</label>
<?php 
// echo $this->Form->radio('categories._ids', $categories);
//echo $this->Form->control('categories._ids', ['options' => $categories]);
echo $this->Form->control('name',['class' => 'form-control']);
echo $this->Form->hidden('slug');
echo $this->Form->control('description',['class' => 'form-control']);
//echo $this->Form->control('image_path');
//echo $this->Form->control('color');
//echo $this->Form->control('featured');
//echo $this->Form->control('user_id', ['options' => $users]);

?>
</fieldset>
<?= $this->Form->button(__('Save Topic'),['class' => 'btn btn-success mt-3']) ?>
<?= $this->Form->end() ?>


</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
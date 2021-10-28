<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">
    <h1 class="display-4 my-5">
        Add Topic
    </h1>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-4">

<div class="mt-5 p-5 bg-white rounded-lg shadow-sm">

<?= $this->Form->create($topic) ?>
            <fieldset>
  
                <label>Published? <?= $this->Form->checkbox('featured'); ?></label>
                <?php
                echo $this->Form->control('categories._ids', ['type' => 'select','options' => $categories, 'class' => 'form-control', 'label' => 'Category']);
                    echo $this->Form->control('name',['class' => 'form-control']);
                    //echo $this->Form->hidden('slug');
                    echo $this->Form->control('description',['class' => 'form-control']);
                    //echo $this->Form->control('image_path');
                    //echo $this->Form->control('color');
                    
                    //echo $this->Form->control('user_id', ['options' => $users]);
                    
                ?>
            </fieldset>
            <?= $this->Form->button(__('Add Topic'),['class' => 'btn btn-success mt-3']) ?>
            <?= $this->Form->end() ?>

</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
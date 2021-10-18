<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="bg-white p-3 my-5 shadow-sm">
    
            <?= $this->Form->create($pathway) ?>
            <?php 
            echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
            echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]); 
            ?>
            <fieldset>
                <legend><?= __('Add Pathway') ?></legend>
                <?php
                    //echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true,'class'=>'form-control']);
                    //echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true,'class'=>'form-control']);
                    ?>


                    <?php
                    echo $this->Form->control('name',['class' => 'form-control']);
                    echo $this->Form->control('description',['class' => 'form-control']);
                    echo $this->Form->control('objective',['class' => 'form-control']);
                    echo $this->Form->control('estimated_time', ['class' => 'form-control']);
                    echo $this->Form->hidden('status_id',['value' => 1]);
                    //echo $this->Form->control('color');
                    //echo $this->Form->control('file_path');
                    //echo $this->Form->control('image_path');
                    //echo $this->Form->control('featured');
                    //echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
                    //echo $this->Form->control('competencies._ids', ['options' => $competencies]);
                    //echo $this->Form->control('steps._ids', ['options' => $steps]);
                    //echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Add new pathway'),['class' => 'btn btn-block btn-success mt-3']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

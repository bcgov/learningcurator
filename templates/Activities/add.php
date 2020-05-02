<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
?>
<div class="row justify-content-md-center">
<div class="col-md-6 mb-3">
<div class="card mb-3">
<div class="card-header">
	<h1 class="card-title">Add Activity</h1>
</div>
<div class="card-body">
            <?= $this->Form->create($activity) ?>
                <?php
                    echo $this->Form->control('status_id', ['options' => $statuses, 'empty' => true]);
                    echo $this->Form->control('activity_types_id', ['options' => $activityTypes, 'class' => 'form-control']);
                    echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true, 'class' => 'form-control']);
                    echo $this->Form->control('competencies._ids', ['options' => $competencies, 'class' => 'form-control']);
                    //echo $this->Form->control('hours', ['class' => 'form-control']);
                    echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'form-control']);
                    echo $this->Form->control('featured', ['class' => 'form-control']);
                    echo $this->Form->control('moderation_flag', ['class' => 'form-control']);
                    echo $this->Form->control('recommended', ['class' => 'form-control']);
                    echo $this->Form->control('name', ['class' => 'form-control']);
                    echo $this->Form->control('hyperlink', ['class' => 'form-control']);
                    echo $this->Form->control('description', ['class' => 'form-control']);
                    echo $this->Form->control('file_path', ['class' => 'form-control']);
                    echo $this->Form->control('tag_string', ['type' => 'text', 'class' => 'form-control']);
                    echo $this->Form->control('licensing', ['class' => 'form-control']);
                    echo $this->Form->control('moderator_notes', ['class' => 'form-control']);
                    echo $this->Form->control('isbn', ['class' => 'form-control']);
                    //echo $this->Form->control('meta_title');
                    //echo $this->Form->control('meta_description');
                    echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true, 'class' => 'form-control']);
                    //echo $this->Form->control('image_path');
                    echo $this->Form->control('approvedby_id', ['class' => 'form-control']);
                    echo $this->Form->control('users._ids', ['options' => $users, 'class' => 'form-control']);
                    echo $this->Form->control('steps._ids', ['options' => $steps, 'class' => 'form-control']);
                ?>
            <?= $this->Form->button(__('Add Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
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
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
$this->loadHelper('Authentication.Identity');
?>

<?= $this->Form->create($activity) ?>
<?php 
// echo $this->Form->control('ministry_id', ['class' => 'form-control', 'options' => $ministries, 'empty' => true]);
// echo $this->Form->control('category_id', ['class' => 'form-control', 'options' => $categories, 'empty' => true]);
// echo $this->Form->control('approvedby_id', ['class' => 'form-control']);
echo $this->Form->hidden('createdby_id', ['value' => $activity->createdby_id, 'class' => 'form-control']);
echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
?>
<div class="row justify-content-md-center">
<div class="col-md-6">

    <div class="card mb-3">
    <div class="card-body">
    <?php echo $this->Form->control('name', ['class' => 'form-control form-control-lg']); ?>
    <?php echo $this->Form->control('description', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('hyperlink', ['class' => 'form-control']); ?>
    <?php //echo $this->Form->control('steps._ids', ['class' => 'form-control', 'options' => $steps]); ?>
    <?php echo $this->Form->control('licensing', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('moderator_notes', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('isbn', ['class' => 'form-control']); ?>
    </div>
    </div>
    </div>
    <div class="col-md-3">
    <div class="card mb-3">
    <div class="card-body">
    <?php echo $this->Form->control('activity_types_id', ['class' => 'form-control', 'options' => $activityTypes]); ?>
    <?php echo $this->Form->control('status_id', ['class' => 'form-control', 'options' => $statuses, 'empty' => true]); ?>
    <?php //echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'form-control']); ?>
    <label>Estimated Time
    <select name="estimated_time" id="estimated_time_id" class="form-control">
        <option>Under 5 mins</option>
        <option>Under 10 mins</option>
        <option>Under 15 mins </option>
        <option>Under 20 mins</option>
        <option>Under 30 mins</option>
        <option>Under 1 hour</option>
        <option>About an hour</option>
        <option>A couple of hours</option>
        <option>A half day</option>
        <option>About a day</option>
        <option>A couple of days</option>
        <option>About a week</option>
        <option>A week +</option>
    </select>
    </label>
    <?php echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text', 'label' => 'Tags']); ?>
    <?php echo $this->Form->control('users._ids', ['class' => 'form-control', 'options' => $users]); ?>
    <?php echo $this->Form->control('competencies._ids', ['class' => 'form-control', 'options' => $competencies]); ?>
    <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
    </div>
    </div>
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
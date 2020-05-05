<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
$this->loadHelper('Authentication.Identity');
?>

<?= $this->Flash->render() ?>
<?= $this->Form->create($activity) ?>
<?php 
// echo $this->Form->control('ministry_id', ['class' => 'form-control', 'options' => $ministries, 'empty' => true]);
// echo $this->Form->control('category_id', ['class' => 'form-control', 'options' => $categories, 'empty' => true]);
// echo $this->Form->control('approvedby_id', ['class' => 'form-control']);
echo $this->Form->hidden('createdby_id', ['value' => $activity->createdby_id, 'class' => 'form-control']);
echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
?>
<div class="row justify-content-md-center">
<div class="col-md-3">
<div class="card mb-3">
    <div class="card-body">
    <h2>Pathways</h2>
    <?php foreach($activity->steps as $s): ?>
<a href="/pathways/view/<?= $s->pathways[0]['id'] ?>#pathways-<?= $s->name ?>"><?= $s->pathways[0]['name'] ?></a>
<?php endforeach ?>
    </div>
    </div>
    </div>
<div class="col-md-6">
    <div class="card mb-3">
    <div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->Form->control('activity_types_id', ['class' => 'form-control', 'options' => $activityTypes]); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->control('status_id', ['class' => 'form-control', 'options' => $statuses, 'empty' => true]); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-4 pt-3">
            <?php echo $this->Form->control('featured', ['type' => 'checkbox', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-4 pt-3">
            <?php echo $this->Form->control('moderation_flag', ['type' => 'checkbox', 'class' => 'form-control']); ?>
        </div>
        <div class="col-md-4 pt-3">
            <?php echo $this->Form->control('recommended', ['type' => 'text', 'class' => 'form-control']); ?>
        </div>
    </div>
    </div>
    </div>
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
    <?php echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text']); ?>
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
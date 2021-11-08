<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid mb-3">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">
    <h1 class="display-4 mt-5">Add Activity</h1>
    <p class="mb-5">Add an activity by itself, not yet assigned to a pathway step. <strong>Beware:</strong> if you add 
    your activity this way, you will need to use the "Add existing activity" button on the step edit page.
    It is recommended to add your activities directly to a step, rather than this way.</p>
</div>
</div>
</div>
<?= $this->Form->create($activity) ?>
<?php 
// echo $this->Form->control('ministry_id', ['class' => 'form-control', 'options' => $ministries, 'empty' => true]);
// echo $this->Form->control('category_id', ['class' => 'form-control', 'options' => $categories, 'empty' => true]);
// echo $this->Form->control('approvedby_id', ['class' => 'form-control']);
echo $this->Form->hidden('createdby_id', ['value' => $activity->createdby_id, 'class' => 'form-control']);
echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
?>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-6">

    <div class="bg-white p-3">
    <?php echo $this->Form->control('name', ['class' => 'form-control form-control-lg newname']); ?>
    <?php echo $this->Form->control('description', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('hyperlink', ['class' => 'form-control']); ?>
    <div id="linkcheck"></div>
    <?php 
    if ($this->Form->isFieldError('hyperlink')) {
        echo $this->Form->error('hyperlink', 'This link may already exist in the system.');
    }
    ?>
    <?php //echo $this->Form->control('steps._ids', ['class' => 'form-control', 'options' => $steps]); ?>
    <?php //echo $this->Form->control('licensing', ['class' => 'form-control']); ?>
    <?php //echo $this->Form->control('moderator_notes', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('isbn', ['class' => 'form-control']); ?>

    </div>
    </div>
    <div class="col-md-3">

    <div class="bg-white p-3">
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
        <option>Half day or less</option> 
        <option>1 day </option>
        <option>More than 1 day </option>
        <option>Variable</option>
    </select>
    </label>
    <?php //echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text', 'label' => 'Tags']); ?>
    <?php //echo $this->Form->control('users._ids', ['class' => 'form-control', 'options' => $users]); ?>
    <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-control', 'options' => $competencies]); ?>
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

<script>


$(function () {

    $('#hyperlink').on('change', function(e){

        e.preventDefault();

        let urlto = this.value;

        let checkurl = '/activities/linkcheck?search=' + urlto;
        $.ajax({
            type: "GET",
            url: checkurl,
            success: function(data)
            {
                let foo = $.parseJSON(data);
                if(foo[0]) {
                if(foo[0].id) {
                    $('#linkcheck').html('This link already exists in the system.');
                }
                } else {
                    $('#linkcheck').html('');
                }
            },
            statusCode: 
            {
                403: function() {
                    // oh no
                }
            }
        });


        let infourl = '/activities/getinfo?url=' + urlto;
        $.ajax({
            type: "GET",
            url: infourl,
            success: function(data)
            {
                let foo = $.parseJSON(data);
                $('.newname').val(foo.title);
                $('.note-editable').html(foo.description);
            },
            statusCode: 
            {
                403: function() {
                    // oh no
                }
            }
        });
    });

});




</script>
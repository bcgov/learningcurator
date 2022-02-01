<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */

$this->loadHelper('Authentication.Identity');
?>
<div class="p-6 dark:text-white flex">

<div class="">
    Editing <a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
        <?= $step->pathways[0]->name ?> <?= $step->name ?>
        </a>
    <h1>
        <a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
        <?= $step->name ?>
        </a>
    </h1>
    <div class="btn-group">
        <a href="#" class="btn btn-light" data-toggle="modal" data-target="#showactadd">
            Add New Activity
        </a>
        <a href="#" class="btn btn-light" data-toggle="modal" data-target="#showactfind">
            Add Existing Activity
        </a>
        <a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>" class="btn btn-light">
            View Step
        </a>
    </div>

    
<h2>Step Details</h2>
<div class="my-3 p-3 rounded-lg bg-white dark:bg-slate-900">
    <?= $this->Form->create($step) ?>
    <?= $this->Form->hidden('image_path', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>
    <?= $this->Form->hidden('featured', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>
    <?= $this->Form->hidden('modifiedby') ?>
    <?= $this->Form->hidden('pathway_id', ['value' => $step->pathway_id]) ?>

    <?= $this->Form->control('status_id', ['options' => $statuses, 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>
    <?= $this->Form->control('name', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>
    <?php  //$this->Form->control('slug', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <?= $this->Form->control('description', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg summernote', 'label' => 'Objective']) ?>
    <?= $this->Form->button(__('Save Step'),['class' => 'btn btn-success btn-block my-3']) ?>
    <?= $this->Form->end() ?>
    </div>
    </div>

    




    <div class="">
    <h3>Required Activities</h3>
    <div class="mb-3" id="requiredactivities">
    <?php  //$this->Form->control('activities._ids', ['options' => $activities]) 
    $reqtmp = array();
    $supptmp = array();
    $requiredacts = array();
    $supplementalacts = array();
    // Loop through the whole list, add steporder to tmp array
    foreach($step->activities as $line) {
        if($line->_joinData->required == 1) {
            array_push($requiredacts,$line);
        } else {
            array_push($supplementalacts,$line);
        }
    }
    foreach($requiredacts as $line) {
        $reqtmp[] = $line->_joinData->steporder;
    }
    foreach($supplementalacts as $line) {
        $supptmp[] = $line->_joinData->steporder;
    }
    // Use the tmp array to sort acts list
    array_multisort($reqtmp, SORT_DESC, $requiredacts);
    array_multisort($supptmp, SORT_DESC, $supplementalacts);
    ?>
    
    <?php foreach($requiredacts as $a): ?>
        
        <div class="my-3 p-3 dark:bg-slate-900" id="exac-<?= $a->id ?>" data-stepid="<?= $a->_joinData->id ?>">
            <div class="grid gap-4 grid-cols-3">
            <div class="">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="btn btn-light">Up</button>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="btn btn-light">Down</button>
            <?= $this->Form->end() ?>
            </div>
            <div class="col-span-1">

                <div>
                    <span class="badge bg-dark text-white"><?= $a->status->name ?></span> 
                    <span class="badge"><?= $a->activity_type->name ?>
                </div>
                <div class="actname"><a href="/activities/view/<?= $a->id ?>"><?= $a->name ?></a> </div>
                <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'edit/' . $a->_joinData->id], 'class' => '']) ?>
                <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id,]) ?>
                <?= $this->Form->control('stepcontext',['value' => $a->_joinData->stepcontext,'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'label' => '']) ?>
                <button class="btn btn-light btn-sm">Save</button>
                <?= $this->Form->end() ?>

            </div>
            <div class="">

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle/' . $a->_joinData->id, 'class' => '']]) ?>
            <?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?php if($a->_joinData->required == 0): ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
            <?php else: ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
            <?php endif ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <?= $this->Form->button(__('Unrequire'),['class'=>'btn btn-sm btn-light float-left']) ?>
            <?= $this->Form->end() ?>
            <br>
            <?= $this->Form->create(null,['action' => '/activities-steps/delete/' . $a->_joinData->id, 'class' => '']) ?>
            <?= $this->Form->hidden('id', ['value' => $a->_joinData->id]) ?>
            <?= $this->Form->button(__('Remove'),['class' => 'btn btn-sm btn-light']) ?>
            <?= $this->Form->end() ?>
            </div>
            </div>
            </div>
    <?php endforeach ?>
 
    <h3 class="mt-3">Supplemental Activities</h3>
    <div class="" id="supplementalacts">
    <?php foreach($supplementalacts as $supp): ?>
        <div class="p-3 my-3 dark:bg-slate-900" id="exac-<?= $supp->id ?>" data-stepid="<?= $supp->_joinData->id ?>">
            <div class="row">
            <div class="col-1">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $supp->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $supp->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $supp->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $supp->id]) ?>
            <button class="btn btn-light">Up</button>
            <?= $this->Form->end() ?>
            
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $supp->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $supp->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $supp->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $supp->id]) ?>
            <button class="btn btn-light">Down</button>
            <?= $this->Form->end() ?>
            </div>
            <div class="col-9">
            <div>
                    <span class="badge bg-dark text-white"><?= $supp->status->name ?></span> 
                    <span class="badge" style="background-color: rgba(<?= $supp->activity_type->color ?>,1);"><?= $supp->activity_type->name ?>
                </div>
                <?php if($supp->_joinData->required) echo '<span class="badge badge-success">Required</span>' ?> 
                <a href="/activities/view/<?= $supp->id ?>"><?= $supp->name ?></a> 
                <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'edit/' . $supp->_joinData->id], 'class' => '']) ?>
                <?= $this->Form->control('id',['type' => 'hidden', 'value' => $supp->_joinData->id,]) ?>
                <?= $this->Form->control('stepcontext',['value' => $supp->_joinData->stepcontext,'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'label' => '']) ?>
                <button class="btn btn-light btn-sm">Save</button>
                <?= $this->Form->end() ?>
            </div>
            <div class="col-2">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle/' . $supp->_joinData->id, 'class' => '']]) ?>
            <?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $supp->_joinData->id]) ?>
            <?php if($supp->_joinData->required == 0): ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
            <?php else: ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
            <?php endif ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $supp->id]) ?>
            <?= $this->Form->button(__('Require'),['class'=>'btn btn-sm btn-light float-left']) ?>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null,['action' => '/activities-steps/delete/' . $supp->_joinData->id, 'class' => 'form-inline']) ?>
            <?= $this->Form->hidden('id', ['value' => $supp->_joinData->id]) ?>
            <?= $this->Form->button(__('Remove'),['class' => 'btn btn-sm btn-light']) ?>
            <?= $this->Form->end() ?>
            
            </div>
            </div>
            </div>
    <?php endforeach ?>
            </div>




    <div class="modal fade" id="showactfind" tabindex="-1" aria-labelledby="showactfindLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Existing Activity to this step</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">


    <div class="my-3 p-3 rounded-lg bg-white dark:bg-slate-900">
    <form method="get" id="actfind" action="/activities/stepfind" class="form-inline my-2 my-lg-0 mr-3">
        <input class="p-3 bg-slate-300 dark:bg-slate-800 rounded-lg mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
        <input type="hidden" name="step_id" value="<?= $step->id ?>">
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
    </form>
    <ul class="list-group list-group-flush" id="results">
    </ul>
    </div>


</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
</div>
</div>
</div>
</div>





<div class="modal fade" id="showactadd" tabindex="-1" aria-labelledby="showactaddLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add New Activity to this step</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
        
    <?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'addtostep']]) ?>
    <?php 
    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
    echo $this->Form->hidden('step_id', ['value' => $step->id]);
    //echo $this->Form->hidden('activity_types_id', ['value' => '1']); 
    ?>
    <?php echo $this->Form->control('hyperlink', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <?php echo $this->Form->control('name', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg p-3 bg-slate-300 dark:bg-slate-800 rounded-lg-lg newname']); ?>
    <label for="description">Description</label>
    <?php echo $this->Form->textarea('description', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg summernote']) ?>
    <label>Activity Type
    <select name="activity_types_id" id="activity_types_id" class="p-3 bg-slate-300 dark:bg-slate-800 rounded-lg">
        <option value="1">Watch</option>
        <option value="2">Read</option>
        <option value="3">Listen</option>
        <option value="4">Participate</option>
    </select>
    </label>
    <?php //echo $this->Form->control('activity_type_id', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $atypes]); ?>

    <?php //echo $this->Form->control('stepcontext', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'label' => 'Set Context for this step']); ?>
    
    <?php echo $this->Form->control('licensing', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <?php echo $this->Form->control('moderator_notes', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    
    <?php //echo $this->Form->control('isbn', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    
    <?php //echo $this->Form->control('status_id', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $statuses, 'empty' => true]); ?>
    <?php //echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <label>Estimated Time
    <select name="estimated_time" id="estimated_time_id" class="p-3 bg-slate-300 dark:bg-slate-800 rounded-lg">
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
    <?php //echo $this->Form->control('tag_string', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'type' => 'text', 'label' => 'Tags']); ?>
    <?php //echo $this->Form->control('users._ids', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $users]); ?>
    <?php //echo $this->Form->control('competencies._ids', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $competencies]); ?>
    <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
    <?= $this->Form->end() ?>


</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
</div>
</div>
</div>
</div>




            </div> <!-- /.main wrap -->



<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>



<script>


$(function () {
    $('#actfind').on('submit', function(e){

        e.preventDefault();
        
        let form = $(this);

        let url = $(this).attr('action');
        
        $.ajax({
			type: "GET",
			url: url,
			data: form.serialize(),
			success: function(data)
			{
                $('#results').html(data);
			},
			statusCode: 
			{
				403: function() {
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
    });

    $('#hyperlink').on('change', function(e){

        e.preventDefault();

        let urltoscrape = this.value;
        let url = '/activities/getinfo?url=' + urltoscrape;

        $.ajax({
            type: "GET",
            url: url,
            success: function(data)
            {
                let foo = $.parseJSON(data);
                $('.newname').val(foo.title);
                $('.note-editable').html(foo.description);
                console.log(foo.title);
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


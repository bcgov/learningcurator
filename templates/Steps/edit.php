<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */

$this->loadHelper('Authentication.Identity');
?>
<style>
label {
    display: block;
    font-size: 16px;
    font-weight: bold;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-12">

<div class="py-4 text-center">
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

</div>
</div>
</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center pt-3">
<div class="col-md-4 col-lg-4">
<h2>Step Details</h2>
<div class="my-3 p-3 rounded-lg bg-white">
    <?= $this->Form->create($step) ?>
    <?= $this->Form->hidden('image_path', ['class' => 'form-control']) ?>
    <?= $this->Form->hidden('featured', ['class' => 'form-control']) ?>
    <?= $this->Form->hidden('modifiedby') ?>
    <?= $this->Form->hidden('pathway_id', ['value' => $step->pathway_id]) ?>

    <?= $this->Form->control('status_id', ['options' => $statuses, 'class' => 'form-control']) ?>
    <?= $this->Form->control('name', ['class' => 'form-control']) ?>
    <?php  //$this->Form->control('slug', ['class' => 'form-control']); ?>
    <?= $this->Form->control('description', ['class' => 'form-control summernote', 'label' => 'Objective']) ?>
    <?= $this->Form->button(__('Save Step'),['class' => 'btn btn-success btn-block my-3']) ?>
    <?= $this->Form->end() ?>
    </div>
</div>

<div class="col-md-8 col-lg-8">







    <div class="my-3 p-3 rounded-lg bg-white">
    <h3>Required Activities</h3>
    <ul class="list-group list-group-flush mb-3" id="requiredactivities">
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
        
        <li class="list-group-item" id="exac-<?= $a->id ?>" data-stepid="<?= $a->_joinData->id ?>" style="background-color: rgba(<?= $a->activity_type->color ?>,.2); border: 0;">
            <div class="row">
            <div class="col-1">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="btn btn-light"><i class="bi bi-arrow-up-square-fill"></i></button>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="btn btn-light"><i class="bi bi-arrow-down-square-fill"></i></button>
            <?= $this->Form->end() ?>
            </div>
            <div class="col-9">

                <div>
                    <span class="badge bg-dark text-white"><?= $a->status->name ?></span> 
                    <span class="badge" style="background-color: rgba(<?= $a->activity_type->color ?>,1);"><?= $a->activity_type->name ?>
                </div>
                <div class="actname"><a href="/activities/view/<?= $a->id ?>"><?= $a->name ?></a> </div>
                <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'edit/' . $a->_joinData->id], 'class' => '']) ?>
                <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id,]) ?>
                <?= $this->Form->control('stepcontext',['value' => $a->_joinData->stepcontext,'class' => 'form-control', 'label' => '']) ?>
                <button class="btn btn-light btn-sm">Save</button>
                <?= $this->Form->end() ?>

            </div>
            <div class="col-2">

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
        </li>
    <?php endforeach ?>
    </ul>

    <h3 class="mt-3">Supplemental Activities</h3>
    <ul class="list-group list-group-flush" id="supplementalacts">
    <?php foreach($supplementalacts as $supp): ?>
        <li class="list-group-item" id="exac-<?= $supp->id ?>" data-stepid="<?= $supp->_joinData->id ?>">
            <div class="row">
            <div class="col-1">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $supp->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $supp->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $supp->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $supp->id]) ?>
            <button class="btn btn-light"><i class="bi bi-arrow-up-square-fill"></i></button>
            <?= $this->Form->end() ?>
            
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $supp->_joinData->id], 'class' => '']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $supp->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $supp->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $supp->id]) ?>
            <button class="btn btn-light"><i class="bi bi-arrow-down-square-fill"></i></button>
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
                <?= $this->Form->control('stepcontext',['value' => $supp->_joinData->stepcontext,'class' => 'form-control', 'label' => '']) ?>
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
        </li>
    <?php endforeach ?>
    </ul>

    </div>
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


    <div class="my-3 p-3 rounded-lg bg-white">
    <form method="get" id="actfind" action="/activities/stepfind" class="form-inline my-2 my-lg-0 mr-3">
        <input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
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
    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-control']);
    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
    echo $this->Form->hidden('step_id', ['value' => $step->id]);
    //echo $this->Form->hidden('activity_types_id', ['value' => '1']); 
    ?>
    <?php echo $this->Form->control('hyperlink', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('name', ['class' => 'form-control form-control-lg newname']); ?>
    <label for="description">Description</label>
    <?php echo $this->Form->textarea('description', ['class' => 'form-control summernote']) ?>
    <label>Activity Type
    <select name="activity_types_id" id="activity_types_id" class="form-control">
        <option value="1">Watch</option>
        <option value="2">Read</option>
        <option value="3">Listen</option>
        <option value="4">Participate</option>
    </select>
    </label>
    <?php //echo $this->Form->control('activity_type_id', ['class' => 'form-control', 'options' => $atypes]); ?>

    <?php //echo $this->Form->control('stepcontext', ['class' => 'form-control', 'label' => 'Set Context for this step']); ?>
    
    <?php echo $this->Form->control('licensing', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('moderator_notes', ['class' => 'form-control']); ?>
    
    <?php //echo $this->Form->control('isbn', ['class' => 'form-control']); ?>
    
    <?php //echo $this->Form->control('status_id', ['class' => 'form-control', 'options' => $statuses, 'empty' => true]); ?>
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
    <?= $this->Form->end() ?>


</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
</div>
</div>
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


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="/js/summernote-cleaner.js"></script>

<script>
$(document).ready(function() {
    $('.summernote').summernote({
        toolbar:[
            ['style',['style']],
            ['font',['bold','italic','underline','clear']],
            ['para',['ul','ol','paragraph']],
            ['table',['table']],
            ['insert',['media','link','hr']],
            ['cleaner',['cleaner']]
        ],
        cleaner:{
            action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
            newline: '<br>', // Summernote's default is to use '<p><br></p>'
            notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
            icon: '<i class="fas fa-broom"></i>',
            keepHtml: false, // Remove all Html formats
            keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], // If keepHtml is true, remove all tags except these
            keepClasses: false, // Remove Classes
            badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
            badAttributes: ['style', 'start'], // Remove attributes from remaining tags
            limitChars: false, // 0/false|# 0/false disables option
            limitDisplay: 'both', // text|html|both
            limitStop: false // true/false
        }
    });
});
</script>
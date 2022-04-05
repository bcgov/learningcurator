<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */

$this->loadHelper('Authentication.Identity');
?>
<div class="p-6 dark:text-white">


    Editing 
    <h1 class="text-2xl">
        <a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
        <?= $step->pathways[0]->name ?>, <?= $step->name ?>
        </a>
    
    </h1>


<div class="my-3 p-3 rounded-lg bg-white dark:bg-slate-900">
    <?= $this->Form->create($step) ?>
    <?= $this->Form->hidden('image_path', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>
    <?= $this->Form->hidden('featured', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']) ?>
    <?= $this->Form->hidden('modifiedby') ?>
    <?= $this->Form->hidden('pathway_id', ['value' => $step->pathway_id]) ?>
    <?= $this->Form->control('status_id', ['options' => $statuses, 'class' => 'block w-full md:w-1/4 px-3 py-1 m-0 dark:text-white bg-slate-100 dark:bg-slate-800 rounded-lg']) ?>
    <?= $this->Form->control('name', ['class' => 'block w-full px-3 py-1 m-0 dark:text-white bg-slate-100 dark:bg-slate-800 rounded-lg']) ?>
    <?php  //$this->Form->control('slug', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <?= $this->Form->control('description', ['class' => 'block w-full px-3 py-1 m-0 dark:text-white bg-slate-100 dark:bg-slate-800 rounded-lg', 'label' => 'Objective']) ?>
    <?= $this->Form->button(__('Save Step Details'),['class' => 'inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline']) ?>
    <?= $this->Form->end() ?>

</div>

<div class="my-3 p-3 rounded-lg bg-white dark:bg-slate-900">
        <a href="#" class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline" data-toggle="modal" data-target="#showactadd">
            Add New Activity
        </a>
        <a href="#" class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline" data-toggle="modal" data-target="#showactfind">
            Add Existing Activity
        </a>

    </div>
    



    <div class="my-3 p-3 rounded-lg bg-white dark:bg-slate-900 hidden">
    Add Existing Activity to this step
    <form method="get" id="actfind" action="/activities/stepfind" class="form-inline my-2 my-lg-0 mr-3">
        <input class="p-3 bg-slate-300 dark:bg-slate-800 rounded-lg mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
        <input type="hidden" name="step_id" value="<?= $step->id ?>">
        <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline" type="submit">Search</button>
    </form>
    <ul class="list-group list-group-flush" id="results">
    </ul>
    </div>

    <div class="my-3 p-3 dark:bg-slate-900 rounded-lg hidden">
Add New Activity to this Step

    <?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'addtostep']]) ?>
    <?php 
    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id')]);
    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id')]);
    echo $this->Form->hidden('step_id', ['value' => $step->id]);
    //echo $this->Form->hidden('activity_types_id', ['value' => '1']); 
    ?>
    <?php echo $this->Form->control('hyperlink', ['class' => 'block w-full px-3 py-1 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
    <?php echo $this->Form->control('name', ['class' => 'block w-full px-3 py-1 m-0 dark:text-white dark:bg-slate-800 rounded-lg']); ?>
    <label for="description">Description</label>
    <?php echo $this->Form->textarea('description', ['class' => 'block w-full px-3 py-1 m-0 dark:text-white dark:bg-slate-800 rounded-lg']) ?>
    <!-- <label>Activity Type
    <select name="activity_types_id" id="activity_types_id" class="p-3 bg-slate-300 dark:bg-slate-800 rounded-lg">
        <option value="1">Watch</option>
        <option value="2">Read</option>
        <option value="3">Listen</option>
        <option value="4">Participate</option>
    </select>
    </label> -->
    <?php //echo $this->Form->control('activity_type_id', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $atypes]); ?>

    <?php //echo $this->Form->control('stepcontext', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'label' => 'Set Context for this step']); ?>
    
    <?php //echo $this->Form->control('licensing', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <?php //echo $this->Form->control('moderator_notes', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    
    <?php //echo $this->Form->control('isbn', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    
    <?php //echo $this->Form->control('status_id', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $statuses, 'empty' => true]); ?>
    <?php //echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']); ?>
    <!-- <label>Estimated Time
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
    </label> -->
    <?php //echo $this->Form->control('tag_string', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'type' => 'text', 'label' => 'Tags']); ?>
    <?php //echo $this->Form->control('users._ids', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $users]); ?>
    <?php //echo $this->Form->control('competencies._ids', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg', 'options' => $competencies]); ?>
    <?= $this->Form->button(__('Save Activity'), ['class' => 'inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline']) ?>
    <?= $this->Form->end() ?>

</div>




    <h3 class="text-xl">Required Activities</h3>

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
        
        <div class="my-3 p-3 bg-white dark:bg-slate-900 rounded-lg" id="exac-<?= $a->id ?>" data-stepid="<?= $a->_joinData->id ?>">
        <div class="grid gap-4 grid-cols-12 items-center">

        <div class="col-span-2 text-center">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline">Up</button>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline">Down</button>
            <?= $this->Form->end() ?>


        </div>
        <div class="col-span-7">

                <div>
                    <span class="px-2 py-0 bg-emerald-700 text-xs text-white rounded-lg"><?= $a->status->name ?></span> 
                </div>

                <div class="actname text-xl"><a href="/activities/view/<?= $a->id ?>"><?= $a->name ?></a> </div>
                <div class="p-3 bg-slate-200 dark:bg-slate-800 rounded-lg">
                <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'edit/' . $a->_joinData->id], 'class' => '']) ?>
                <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id,]) ?>
                <label>Why is this activity on this step?<br>
                <?= $this->Form->textarea('stepcontext',['value' => $a->_joinData->stepcontext,
                                                            'class' => 'block w-full px-3 py-1 m-0 dark:text-white dark:bg-slate-900 rounded-lg',
                                                            'rows' => 2
                                                        ]) ?>
                </label>
                <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline btn-sm">Save Context</button>
                <?= $this->Form->end() ?>
                </div>



        </div>
        <div class="col-span-3 text-center">

            
            <?= $this->Form->create(null,['action' => '/activities-steps/required-toggle/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
            <?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?php if($a->_joinData->required == 0): ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
            <?php else: ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
            <?php endif ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <?= $this->Form->button(__('Unrequire'),['class'=>'inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline']) ?>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null,['action' => '/activities-steps/delete/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
            <?= $this->Form->hidden('id', ['value' => $a->_joinData->id]) ?>
            <?= $this->Form->button(__('Remove'),['class' => 'inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline']) ?>
            <?= $this->Form->end() ?>
            
            </div>
            </div>
            </div>
    <?php endforeach ?>
 
    <h3 class="mt-10 mb-3 text-xl">Supplemental Activities</h3>
    
    <?php foreach($supplementalacts as $a): ?>
        <div class="my-3 p-3 bg-white dark:bg-slate-900 rounded-lg" id="exac-<?= $a->id ?>" data-stepid="<?= $a->_joinData->id ?>">
            <div class="grid gap-4 grid-cols-12 items-center">

            <div class="col-span-2 text-center">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline">Up</button>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline">Down</button>
            <?= $this->Form->end() ?>
            </div>
            <div class="col-span-7">

                <div>
                    <span class="px-2 py-0 bg-emerald-700 text-xs text-white rounded-lg"><?= $a->status->name ?></span> 
                </div>

                <div class="actname text-xl"><a href="/activities/view/<?= $a->id ?>"><?= $a->name ?></a> </div>
                <div class="p-3 bg-slate-200 dark:bg-slate-800 rounded-lg">
                <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'edit/' . $a->_joinData->id], 'class' => '']) ?>
                <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id,]) ?>
                <label>Why is this activity on this step?<br>
                <?= $this->Form->textarea('stepcontext',['value' => $a->_joinData->stepcontext,
                                                            'class' => 'block w-full px-3 py-1 m-0 dark:text-white dark:bg-slate-900 rounded-lg',
                                                            'rows' => 2
                                                        ]) ?>
                </label>
                <button class="inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline btn-sm">Save Context</button>
                <?= $this->Form->end() ?>
                </div>



            </div>
            <div class="col-span-3 text-center">

            
            <?= $this->Form->create(null,['action' => '/activities-steps/required-toggle/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
            <?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?php if($a->_joinData->required == 0): ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
            <?php else: ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
            <?php endif ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <?= $this->Form->button(__('Require'),['class'=>'inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline']) ?>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null,['action' => '/activities-steps/delete/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
            <?= $this->Form->hidden('id', ['value' => $a->_joinData->id]) ?>
            <?= $this->Form->button(__('Remove'),['class' => 'inline-block my-2 p-2 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-sm hover:no-underline']) ?>
            <?= $this->Form->end() ?>
            
            </div>
            </div>
            </div>
    <?php endforeach ?>
   



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


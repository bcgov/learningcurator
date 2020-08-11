<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
$this->layout = 'nowrap';
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
<div class="pad-md">
    <h1><a href="/learning-curator/steps/view/<?= $step->id ?>"><?= $step->name ?></a></h1>
    <div><a href="/learning-curator/steps/view/<?= $step->id ?>" class="btn btn-light btn-sm">View Step</a></div>
</div>
</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center pt-3">
<div class="col-md-4">
<h2>Step Details</h2>
<div class="my-3 p-3 rounded-lg bg-white">
    <?= $this->Form->create($step) ?>
    <?= $this->Form->hidden('image_path', ['class' => 'form-control']) ?>
    <?= $this->Form->hidden('featured', ['class' => 'form-control']) ?>
    <?= $this->Form->hidden('modifiedby') ?>
    <?= $this->Form->hidden('pathway_id', ['value' => $step->pathway_id]) ?>
    <?= $this->Form->control('name', ['class' => 'form-control']) ?>
    <?= $this->Form->control('description', ['class' => 'form-control']) ?>
    <?= $this->Form->button(__('Save Step'),['class' => 'btn btn-success btn-block my-3']) ?>
    <?= $this->Form->end() ?>
    </div>
</div>

<div class="col-md-4">
    
    <h2>Add Existing Activity</h2>
    <div class="my-3 p-3 rounded-lg bg-white">
    <form method="get" id="actfind" action="/learning-curator/activities/stepfind" class="form-inline my-2 my-lg-0 mr-3">
        <input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
        <input type="hidden" name="step_id" value="<?= $step->id ?>">
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
    </form>
    <ul class="list-group list-group-flush" id="results">
    </ul>
    </div>
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
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => 'form-inline']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'up']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="btn btn-light"><i class="fas fa-chevron-circle-up"></i></button>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'sort/' . $a->_joinData->id], 'class' => 'form-inline']) ?>
            <?= $this->Form->control('sortorder',['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
            <?= $this->Form->control('direction',['type' => 'hidden', 'value' => 'down']) ?>
            <?= $this->Form->control('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <button class="btn btn-light"><i class="fas fa-chevron-circle-down"></i></button>
            <?= $this->Form->end() ?>
            </div>
            <div class="col-8">
                <div><?= $a->activity_type->name ?></div>
                <div class="actname"><a href="/learning-curator/activities/view/<?= $a->id ?>"><?= $a->name ?></a> </div>
            </div>
            <div class="col-3">

            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle/' . $a->_joinData->id, 'class' => '']]) ?>
            <?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
            <?php if($a->_joinData->required == 0): ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
            <?php else: ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
            <?php endif ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $a->id]) ?>
            <?= $this->Form->button(__('Required'),['class'=>'btn btn-sm btn-light float-left']) ?>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null,['action' => '/learning-curator/activities-steps/delete/' . $a->_joinData->id, 'class' => 'form-inline']) ?>
            <?= $this->Form->hidden('id', ['value' => $a->_joinData->id]) ?>
            <?= $this->Form->button(__('Delete'),['class' => 'btn btn-sm btn-light']) ?>
            <?= $this->Form->end() ?>
            </div>
            </div>
        </li>
    <?php endforeach ?>
    </ul>

    <h3 class="mt-3">Supplmental Activities</h3>
    <ul class="list-group list-group-flush" id="supplementalacts">
    <?php foreach($supplementalacts as $supp): ?>
        <li class="list-group-item" id="exac-<?= $supp->id ?>" data-stepid="<?= $supp->_joinData->id ?>">
            <div class="row">
            <div class="col-9">
                <?php if($supp->_joinData->required) echo '<span class="badge badge-success">Required</span>' ?> 
                <a href="/learning-curator/activities/view/<?= $supp->id ?>"><?= $supp->name ?></a> 
            </div>
            <div class="col-3">
            <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'required-toggle/' . $supp->_joinData->id, 'class' => '']]) ?>
            <?= $this->Form->hidden('id',['type' => 'hidden', 'value' => $supp->_joinData->id]) ?>
            <?php if($supp->_joinData->required == 0): ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 1]) ?>
            <?php else: ?>
            <?= $this->Form->hidden('required',['type' => 'hidden', 'value' => 0]) ?>
            <?php endif ?>
            <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => $step->id]) ?>
            <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $supp->id]) ?>
            <?= $this->Form->button(__('r'),['class'=>'btn btn-sm btn-light float-left']) ?>
            <?= $this->Form->end() ?>

            <?= $this->Form->create(null,['action' => '/learning-curator/activities-steps/delete/' . $supp->_joinData->id, 'class' => 'form-inline']) ?>
            <?= $this->Form->hidden('id', ['value' => $supp->_joinData->id]) ?>
            <?= $this->Form->button(__('x'),['class' => 'btn btn-sm btn-light']) ?>
            <?= $this->Form->end() ?>
            
            </div>
            </div>
        </li>
    <?php endforeach ?>
    </ul>

    </div>
</div>
<div class="col-md-4">

    <h2>Add New Activity</h2>
    <div class="my-3 p-3 rounded-lg bg-white">
    <?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'addtostep']]) ?>
    <?php 
    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-control']);
    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
    echo $this->Form->hidden('step_id', ['value' => $step->id]);
    //echo $this->Form->hidden('activity_types_id', ['value' => '1']); 
    ?>
    <label>Activity Type
    <select name="activity_types_id" id="activity_types_id" class="form-control">
        <option value="1">Watch</option>
        <option value="2">Read</option>
        <option value="3">Listen</option>
        <option value="4">Participate</option>
    </select>
    </label>
    <?php //echo $this->Form->control('activity_type_id', ['class' => 'form-control', 'options' => $atypes]); ?>
    <?php echo $this->Form->control('name', ['class' => 'form-control form-control-lg']); ?>
    <?php echo $this->Form->control('description', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('hyperlink', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('licensing', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('moderator_notes', ['class' => 'form-control']); ?>
    <?php //echo $this->Form->control('isbn', ['class' => 'form-control']); ?>
    
    <?php //echo $this->Form->control('status_id', ['class' => 'form-control', 'options' => $statuses, 'empty' => true]); ?>
    <?php echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'form-control']); ?>
    <?php //echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text', 'label' => 'Tags']); ?>
    <?php //echo $this->Form->control('users._ids', ['class' => 'form-control', 'options' => $users]); ?>
    <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-control', 'options' => $competencies]); ?>
    <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
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
<!--
    At some point if this could be made to work, drag-n-drop is a better experience
    for users; currently cakephp returns a 403 unauthorized upon firing this and I
    don't know why. 
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script>
$(function () {
    $('#requiredactivities').sortable({
        onEnd: function (/**Event*/evt) {
            var itemEl = evt.item.id;
            var sid = evt.item.dataset.stepid;
            var foo = itemEl.split('-');
            var formd = {id: sid, activity_id: foo[1], step_id: "<?= $step->id ?>", direction: "down", sortorder: 0};
            //var formd = 'id='+sid+'&activity_id='+foo[1]+'&step_id=<?= $step->id ?>&direction=down&sortorder=0';
            var u = '/learning-curator/activities-steps/sort/' + sid;
            //console.log(sid);
            $.ajax({
                type: "POST",
                url: u,
                data: formd,
                success: function(d)
                {
                    console.log(d);
                },
                statusCode: 
                {
                    403: function() {
                        console.log(formd);
                    }
                }
		    });
	    },
    });
});
</script>-->
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

});
</script>
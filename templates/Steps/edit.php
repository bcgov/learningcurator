<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
?>
<style>
label {
    display: block;
    font-size: 16px;
    font-weight: bold;
}
</style>
<pre><?php //print_r($step); exit; ?></pre>
<h1><a href="/pathways/view/<?= $step->pathways[0]->id ?>"><?= $step->name ?></a></h1>


<div class="row">
    <div class="col-md-4">
    <div class="card card-body">
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
    <div class="card">
        <h2 class="m-3">Existing Activities</h2>
        <ul class="list-group list-group-flush">
        <?php  //$this->Form->control('activities._ids', ['options' => $activities]) ?>
        <?php foreach($step->activities as $a): ?>
            <li class="list-group-item"><a href="/activities/view/<?= $a->id ?>"><?= $a->name ?></a></li>
        <?php endforeach ?>
        </ul>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card card-body">
        <h2>Add Activity</h2>
        <form method="get" id="actfind" action="/activities/stepfind" class="form-inline my-2 my-lg-0 mr-3">
		    <input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
            <input type="hidden" name="step_id" value="<?= $step->id ?>">
		    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	    </form>
        </div>
        <ul class="list-group list-group-flush" id="results">
        </ul>
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
<!-- <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script> -->
<script>
$(function () {
	// $('#activities-ids').multiselect({
    //         enableFiltering: true,
    //         filterBehavior: 'both',
    //         buttonWidth: '100%'
    // });
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
<?php
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">

<h1 class="display-4 mt-5"><?= __('Add an Activity') ?></h1>
<p class="">You can add a new activity directly to a pathway step through this form.</p>
<p class="mb-5">
    <a href="javascript: (() => {const destination = 'https://learningcurator.ca/activities/addtostep?url=' + window.location.href;window.open(destination);})();">
        Add to Curator
    </a> (Drag the bookmarklet to your bookmarks bar, then click on it from any website that you wish to add to a step)</p>
</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-12 col-lg-6">
<div class="mt-5 p-3 bg-white shadow-sm">
<div class="my-3 rounded-lg bg-white">
    <div class="mb-3 font-weight-bold">Start by finding a pathway step to add the activity to:</div> 
    <form method="get" id="pathfind" action="/pathways/find" class="form-inline">
        <label for="q">Find a pathway:</label>
        <input id="q" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
        <button class="btn btn-success" type="submit">Search</button>
    </form>
    <div id="results"></div>
    </div>
    <div class="addform d-none">
    <div class="mb-3 font-weight-bold">Now fill in the activity details:</div>
    <?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'addtostep']]) ?>
    <?php 
    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-control']);
    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
    echo $this->Form->hidden('step_id', ['value' => 0,'id' => 'step_id']);
    ?>
    <label>Activity Type
    <select name="activity_types_id" id="activity_types_id" class="form-control">
        <option value="1">Watch</option>
        <option value="2" selected>Read</option>
        <option value="3">Listen</option>
        <option value="4">Participate</option>
    </select>
    </label>
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
        <option selected>Variable</option>
    </select>
    </label>
    <?php echo $this->Form->control('hyperlink', ['class' => 'form-control', 'value' => $linktoact]); ?>
    <?php echo $this->Form->control('name', ['class' => 'form-control form-control-lg newname']); ?>
    <label for="description">Description</label>
    <?php echo $this->Form->textarea('description', ['class' => 'form-control summernote']) ?>
    <?php //echo $this->Form->control('licensing', ['class' => 'form-control']); ?>
    <?php //echo $this->Form->control('activity_type_id', ['class' => 'form-control', 'options' => $atypes]); ?>
    <?php //echo $this->Form->control('stepcontext', ['class' => 'form-control', 'label' => 'Set Context for this step']); ?>
    <?php //echo $this->Form->control('moderator_notes', ['class' => 'form-control']); ?>
    <?php //echo $this->Form->control('isbn', ['class' => 'form-control']); ?>
    <?php //echo $this->Form->control('status_id', ['class' => 'form-control', 'options' => $statuses, 'empty' => true]); ?>
    <?php //echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'form-control']); ?>
    <?php //echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text', 'label' => 'Tags']); ?>
    <?php //echo $this->Form->control('users._ids', ['class' => 'form-control', 'options' => $users]); ?>
    <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-control', 'options' => $competencies]); ?>
    <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
    <?= $this->Form->end() ?>
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

<?php if($linktoact): ?>

let geturl = '/activities/getinfo?url=<?= urlencode($linktoact) ?>';

$.ajax({
    type: "GET",
    url: geturl,
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
<?php endif ?>

    $('#pathfind').on('submit', function(e){

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
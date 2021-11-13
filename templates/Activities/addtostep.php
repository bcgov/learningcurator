<?php
$this->loadHelper('Authentication.Identity');
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">


<div class="mt-3 p-3">
<div class="p-5 my-3 rounded-lg bg-white shadow-lg">
    
    <div id="linkdeets"></div>
    <div class="my-3 font-weight-bold">Start by finding a pathway step to add the activity to:</div> 
    <form method="get" id="pathfind" action="/pathways/find" class="form-inline mb-2">
        <label for="q">Find a pathway:</label>
        <input id="q" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
        <button class="btn btn-success" type="submit">Search</button>
    </form>
    <div id="results"></div>
    
    <style>.opacity-25 { opacity: 0.25; }</style>
    <div class="addform mt-3 opacity-25">
    <div class="mb-3 font-weight-bold">Now fill in the activity details:</div>
    <?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'addtostep'], 'id' => 'addacttostep']) ?>
    <?php 
    echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-control']);
    echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'),'class' => 'form-control']);
    echo $this->Form->hidden('step_id', ['value' => 0,'id' => 'step_id']);
    ?>
    <div class="row my-3 text-center" id="acttypes">
    <div class="col">
        <a href="#watch" data-id="1" style="background-color: rgba(193,129,183,.2);">
            <i class="bi bi-camera-video-fill"></i><br>
            Watch
        </a>
    </div>
    <div class="col">
        <a href="#read" data-id="2" style="background-color: rgba(249,145,80,.2);">
            <i class="bi bi-book-fill"></i><br>
            Read
        </a>
    </div>
    <div class="col">
        <a href="#listen" data-id="3" style="background-color: rgba(244,105,115,.2);">
            <i class="bi bi-headphones"></i><br>
            Listen
        </a>
    </div>
    <div class="col">
        <a href="#participate" data-id="4" style="background-color: rgba(255,218,96,.2);">
            <i class="bi bi-people-fill"></i><br>
            Participate
        </a>
    </div>
    </div>
    <input type="hidden" name="activity_types_id" id="activity_types_id" value="2">
    
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
    <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3 d-none savebut']) ?>
    <?= $this->Form->end() ?>
    
    <div id="scontext" class="opacity-25">
    <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps','action' => 'edit/'], 'class' => 'contextform']) ?>
    <?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => 1, 'id' => 'actid']) ?>
    <?= $this->Form->control('step_id',['type' => 'hidden', 'value' => 1]) ?>
    <?= $this->Form->control('stepcontext',['class' => 'form-control', 'label' => 'Why are you adding this here?']) ?>
    <div><label>Is this activity required for the step?
    <?= $this->Form->checkbox('required',['label' => 'Is this activity required for the step?']) ?>
    </label></div>
    <button class="btn btn-success addcon d-none">Add context to the activity</button>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
<div>
        <strong>Bookmarklet:</strong><br>
        <a class="btn btn-dark" href="javascript: (() => {const destination = 'https://learningcurator.apps.silver.devops.gov.bc.ca/activities/addtostep?url=' + window.location.href;window.open(destination);})();">
            Add to Curator
        </a>
    </div>
    <div class="">A "bookmarklet" is a special type of bookmark that allows you to take special action when you click it. 
        In this case, if you click the "Add to Curator" bookmarklet while visiting any website, you will open up this
        "Add to Step" form, with the link to that page pre-populated, saving you from having to copy the URL and paste 
        it here manually; furthermore, after you add a link to this page, the system will automatically reach out to that
        page and attempt to bring in its title and description (based on its meta tags).

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

let urlcheck = '/activities/linkcheck?search=<?= urlencode($linktoact) ?>';
$.ajax({
    type: "GET",
    url: urlcheck,
    success: function(data)
    {
        console.log('ALREADY EXISTIS');
        $('.addform').addClass('d-none');
    },
    statusCode: 
    {
        // I don't really want to depend on this behavior to set the UI
        // I am not sure why it's returning 404 and not 500 like it 
        // does when you run the URL in the browser...
        // #TODO fix this to be more robust; just because it works here,
        // this likely isn't sustainable.
        404: function() {
            console.log('GOOD TO GO');
            let geturl = '/activities/getinfo?url=<?= urlencode($linktoact) ?>';
            $.ajax({
                type: "GET",
                url: geturl,
                success: function(data)
                {
                    let deets = $.parseJSON(data);
                    $('.newname').val(deets.title);
                    let descr = '';
                    if(deets.description == '') {
                        descr = '<em>No description found.</em>';
                    } else {
                        descr = deets.description;
                    }
                    $('.note-editable').html(descr);
                    $('#linkdeets').html('<strong>Adding:</strong><br><div class="p-3 bg-light">' + deets.title + '<br>' + descr + '<br>' + '<?= urldecode($linktoact) ?></div>');
                },
                statusCode: 
                {
                    403: function() {
                        // oh no
                    }
                }
            });

        },
        500: function() {
            console.log('GOOD TO GO');
        }
    }
});


<?php endif ?>

    $('#acttypes a').on('click', function(e){
        e.preventDefault();
        let actid = $(this).data('id');
        $('#activity_types_id').val(actid);
        $(this).css('background-color','rgba(0,0,0,.5)')
        $(this).css('color','#FFF')
    });

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

    $('#addacttostep').on('submit', function(e){

    e.preventDefault();
    let form = $(this);
    let url = $(this).attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data)
        {
            console.log(data);
            let deets = $.parseJSON(data);
            console.log(deets.activitystepid);
            $('.contextform').attr('action', '/activities-steps/edit/' + deets.activitystepid);
            $('#actid').val(deets.activityid);
            $('#step-id').val(deets.stepid);
            $('#scontext').removeClass('opacity-25');
            $('.addcon').removeClass('d-none');
            $('.savebut').remove();
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
                let descr = '';
                if(deets.description == '') {
                    descr = '<em>No description found.</em>';
                } else {
                    descr = deets.description;
                }
                $('.note-editable').html(descr);
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
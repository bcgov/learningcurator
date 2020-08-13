<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
$this->layout = 'nowrap';
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
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-12">
<div class="pad-lg">
<h1>
    <a href="/learning-curator/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
</h1>
<a href="/learning-curator/activities/view/<?= $activity->id ?>" class="btn btn-sm btn-light">View</a>
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">
<div class="col-md-7">

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
    <?php echo $this->Form->control('hyperlink', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('description', ['class' => 'form-control summernote']); ?>
    <?php //echo $this->Form->control('steps._ids', ['class' => 'form-control', 'options' => $steps]); ?>
    <?php echo $this->Form->control('licensing', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('moderator_notes', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('isbn', ['class' => 'form-control']); ?>
    </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card mb-3">
    <div class="card-body">
    <?php echo $this->Form->control('tag_string', ['class' => 'form-control', 'type' => 'text']); ?>
    <?php echo $this->Form->control('users._ids', ['class' => 'form-control', 'options' => $users]); ?>
    <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-control', 'options' => $competencies]); ?>
    <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-block btn-success my-3']) ?>
    <h2>Pathways</h2>
    <?php foreach($activity->steps as $s): ?>
<a href="/learning-curator/steps/view/<?= $s->id ?>"><?= $s->pathways[0]['name'] ?> - <?= $s->name ?></a>
<?php endforeach ?>
    </div>
    </div>
    </div>
</div>
<?= $this->Form->end() ?>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="/learning-curator/js/summernote-cleaner.js"></script>

<script>
$(document).ready(function() {
    $('.summernote').summernote({
        toolbar:[
            ['style',['style']],
            ['font',['bold','italic','underline','clear']],
            ['para',['ul','ol','paragraph']],
            ['table',['table']],
            ['insert',['media','link','hr']],
            ['cleaner',['cleaner']], // The Button
            ['help',['help']]
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
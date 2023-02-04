<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<style>
    .pagination {
        background-color: rgba(255, 255, 255, .5);
    }

    .page-item.active .page-link {
        background-color: #000;
        color: #FFF;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-md-center" id="colorful">
        <div class="col-md-6">
            <div class="py-5">

                <h1>Activities</h1>
                <p>The 100 most recently added activities.</p>
            </div>
        </div>
    </div>
    <div class="container-fluid linear">
        <div class="row justify-content-md-center">


            <div class="col-md-10 col-lg-8 col-xl-6">

                <?php foreach ($activities as $activity) : ?>
                    <pre><?php print_r($activity);
                            echo '</pre>';
                            continue; ?>
	<div class=" activity bg-white">
<div class="p-3 my-3 rounded-lg" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2);">



	<h3 class="my-3">
		<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
	</h3>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<div class="mb-3">
		<?php foreach ($activity->tags as $tag) : ?>
		<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
		<?php endforeach ?>
		</div>
        <div class="autop"><?= $this->Text->autoParagraph(h($activity->description)); ?></div>
		<?php if (!empty($activity->_joinData->stepcontext)) : ?>
		<div class="alert alert-light text-dark mt-3 shadow-sm">
				
				Curator says:<br>
				<?= $activity->_joinData->stepcontext ?>
			</div>
			<?php endif ?>

	</div>
	


	<a target="_blank" 
		rel="noopener" 
		data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="bi <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>


	<a href="#newreport<?= $activity->id ?>" 
			style="color:#333;" 
			class="btn btn-light " 
			data-toggle="collapse" 
			title="Report this activity for some reason" 
			data-target="#newreport<?= $activity->id ?>" 
			aria-expanded="false" 
			aria-controls="newreport<?= $activity->id ?>">
				<i class="bi bi-exclamation-triangle-fill"></i> Report
		</a>	
		<div class="collapse" id="newreport<?= $activity->id ?>">
		<div class="my-3 p-3 bg-white rounded-lg">
		<?= $this->Form->create(null, ['url' => ['controller' => 'reports', 'action' => 'add'], 'class' => 'reportform']) ?>
            <fieldset>
                <legend><?= __('Report this activity') ?></legend>
				<p>Is there something wrong with this activity? Tell us about it!</p>
                <?php
                    echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                    echo $this->Form->hidden('user_id', ['value' => $uid]);
                    echo $this->Form->textarea('issue', ['class' => 'form-control', 'placeholder' => 'Type here ...']);
                ?>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Submit Report">
            <?= $this->Form->end() ?>
		</div>
		</div>
	<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="bi bi-hand-thumbs-up-fill"></i>
	</a>




	</div>
	</div>
	

	<?php endforeach; // end of activities loop for this step 
    ?>





</div>


</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

	<script>

$(document).ready(function(){


	$('.claim').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').removeClass('btn-light').addClass('btn-primary').html('CLAIMED! <span class="fas fa-check-circle"></span>').tooltip('dispose').attr('title','Good job!');
		
		$(this).parent('.activity').css('box-shadow','0 0 10px rgba(0,0,0,.4)'); // css('border','2px solid #000')

		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/activities-users/claim',
			data: form.serialize(),
			success: function(data)
			{
				loadStatus();
			},
			statusCode: 
			{
				403: function() {
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
	});

	$('[data-toggle="tooltip"]').tooltip();

	$('.likingit').on('click',function(e){
		var url = $(this).attr('href');
		$(this).children('.lcount').html('Liked!');
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: url,
			data: '',
			success: function(data)
			{
			},
			statusCode: 
			{
				403: function() {
					let alert = 'You must be logged in.</div>';
					console.log(alert);
				}
			}
		});
	});

});

</script>
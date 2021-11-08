<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = '';
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div style="background-color: #FFF;">
<div class="container-fluid">
<div class="row justify-content-md-center"
		style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">

<div class="col-md-12 col-lg-6">
<div class="py-5">

	<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="btn-group float-right">
	<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activity->id], ['confirm' => __('Really delete?'), 'class' => 'btn btn-sm btn-light']) ?>
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	</div>

	<?php if($activity->status_id == 3): ?>
	<span class="badge badge-danger">DEFUNCT</span>
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	<span class="badge badge-warning">INVESTIGATE</span>
	<?php endif ?>
	<?php endif; // role check ?>
	
		<div class="row align-items-center">
		<div class="col-3">
		<div class="activity-icon activity-icon-lg" style="background-color: rgba(<?= $activity->activity_type->color ?>,1)">
			<i class="activity-icon activity-icon-lg fas <?= $activity->activity_type->image_path ?>"></i>
		</div>
		</div>
		<div class="col">
		<?php if(in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>

		<!-- <div class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div> -->
		
		<?php echo $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $claimid], ['class' => 'btn btn-primary', 'confirm' => __('Unclaim?')]) ?>
		
		<?php endif ?>
	
		</div>
	</div>
	<h1 class="my-1">
		<?= $activity->name ?>
	</h1>
	<div class="p-3 rounded-lg" style="background: rgba(255,255,255,.3);">
		<div class="mb-2">
		<span class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
		<i class="bi bi-clock-history"></i>
			<?= h($activity->estimated_time) ?>
			<?php //echo $this->Html->link($activity->estimated_time, ['controller' => 'Activities', 'action' => 'estimatedtime', $activity->estimated_time], ['class' => 'text-dark']) ?>
		</span> 
			<?php foreach($activity->tags as $tag): ?>
			<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
			<?php endforeach ?>
		</div>
		<?= $activity->description ?>
		<?php if(!empty($activity->isbn)): ?>
		<div class="bg-white p-2 my-2 isbn">
			ISBN: <?= $activity->isbn ?>
		</div>
		<?php endif ?>
		<div class="p-2 text-muted" style="background-color: rgba(255,255,255,.5)">
			<?= $this->Time->format($activity->created,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
			<?php if($role == 'curator' || $role == 'superuser'): ?>
				by <a href="/users/view/<?= $activity->createdby_id ?>"><?= $curator[0]->username ?></a>
			<?php endif ?>
		</div>
	</div>
	<?php if($activity->status_id != 3): ?>
	<?php if(!empty($activity->tags)): ?>
	<?php foreach($activity->tags as $tag): ?>
	<?php if($tag->name == 'Learning System Course'): ?>

	<a target="_blank" 
		rel="noopener" 
		data-toggle="tooltip" 
		data-placement="bottom" 
		title="Enrol in this course in the Learning System"
		href="https://learning.gov.bc.ca/psc/CHIPSPLM_6/EMPLOYEE/ELM/c/LM_OD_EMPLOYEE_FL.LM_FND_LRN_FL.GBL?Page=LM_FND_LRN_RSLT_FL&Action=U&KWRD=<?php echo urlencode($activity->name) ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>

	<?php elseif($tag->name == 'YouTube'): ?>
	<?php 
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $activity->hyperlink, $match);
		$youtube_id = $match[1];
		?>
	<div class="my-3 p-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,1); border-radius: 3px;">
		<iframe width="100%" 
			height="315" 
			src="https://www.youtube-nocookie.com/embed/<?= $youtube_id ?>/" 
			frameborder="0" 
			allow="" 
			allowfullscreen>
		</iframe>
	</div>

	<?php elseif($tag->name == 'Vimeo'): ?>
		<?php 
		$vimeoid = substr(parse_url($activity->hyperlink, PHP_URL_PATH), 1);
		?>
		<iframe src="https://player.vimeo.com/video/<?= $vimeoid ?>" 
			width="100%" 
			height="315" 
			frameborder="0" 
			allow="fullscreen" 
			allowfullscreen>
		</iframe>
	
	<?php endif; // logic check for formatting differently based on tag ?>	

	<?php endforeach; // tags loop ?>

	<?php else: // there are no tags ?>
		<div class="my-3 p-3 text-truncate" style="font-size: 130%">
			<?= $activity->activity_type->name ?>: 
			<a href="<?= h($activity->hyperlink) ?>" target="_blank" rel="noopener">
				<?= h($activity->hyperlink) ?>
			</a>
		</div>
	<?php endif; ?>
	<?php else: ?>
		<div class="bg-white p-3 my-3">
			<div><strong>Archived</strong></div>
			<p>This activity has been archived.</p>
		</div>
	<?php endif ?>

	<div class="my-3">
		<a href="#newreport" 
			style="color:#333;" 
			class="btn btn-light float-right" 
			data-toggle="collapse" 
			title="Report this activity for some reason" 
			data-target="#newreport" 
			aria-expanded="false" 
			aria-controls="newreport">
				<i class="fas fa-exclamation-triangle"></i> Report
		</a>	
		<div class="collapse" id="newreport">
		<div class="my-3 p-3 bg-white rounded-lg">
		<?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'add'],'class'=>'reportform']) ?>
            <fieldset>
                <legend><?= __('Report this activity') ?></legend>
				<p>Is there something wrong with this activity? Tell us about it!</p>
                <?php
                    echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                    echo $this->Form->hidden('user_id', ['value' => $uid]);
                    echo $this->Form->textarea('issue',['class' => 'form-control', 'placeholder' => 'Type here ...']);
                ?>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Submit Report">
            <?= $this->Form->end() ?>
		</div>
		</div>
		<a href="/activities/like/<?= $activity->id ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
			<i class="fas fa-thumbs-up"></i> <span class="lcount"><?= h($activity->recommended) ?> likes</span>
		</a>

	
	


	<?php if($role == 'curator' || $role == 'superuser'): ?>
	<?php if (!empty($activity->moderator_notes)) : ?>
	<div class="my-3 p-3 bg-white rounded-lg">
	<h4><?= __('Moderator Notes') ?></h4>
	<blockquote>
	<?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
	</blockquote>
	</div>
	<?php endif ?>
	<?php endif; ?>



	
		</div>

		

</div>
</div>
</div>
</div>
<div class="container-fluid linear">
<div class="row justify-content-md-center">
<?php if(!empty($activity->steps)): ?>
<div class="col-md-4">
<h3 class="mt-3"><i class="fas fa-sitemap"></i> Pathways</h3>

<?php foreach($activity->steps as $step): ?>
<?php foreach($step->pathways as $path): ?>
<?php if($path->status_id == 2): ?>

<div class="my-3 p-3 bg-white" style="background-color: rgba(255,255,255,.3)">
	<h4><a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a></h4>
	<div><?= $step->description ?></div>
</div>

<?php else: ?>

<div class="my-3 p-3 bg-white" style="background-color: rgba(255,255,255,.3)">
<span class="badge badge-warning">DRAFT</span>
<h4><a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a></h4>
	<div><?= $step->description ?></div>
</div>

<?php endif ?>
<?php endforeach ?>
<?php endforeach ?>
</div>
<?php endif ?>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<?php if(!empty($activity->users)): ?>
<div class="col-md-4">
<h3 class="mt-3">Learners</h3>
<div class="my-3 p-3 bg-white rounded-lg">
<div><em>These folx have claimed this activity:</em></div>
<?php foreach($activity->users as $u): ?>
<a href="/users/view/<?= $u->id ?>"><?= $u->idir ?></a>, 
<?php endforeach ?>
</div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<?php if(!empty($allusers)): ?>
<div class="col-md-4">
<h3 class="mt-3">Learners</h3>
<div class="my-3 p-3 bg-white rounded-lg">
<div><em>These folx have claimed this activity:</em></div>
<?php foreach($allusers as $u): ?>
<a href="/users/view/<?= $u->user->id ?>"><?= $u->user->idir ?></a>, 
<?php endforeach ?>
</div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<?php if(!empty($activity->reports)): ?>
<div class="col-md-4">
<h3 class="mt-3"><i class="fas fa-exclamation-triangle"></i> Reports</h3>
<?php foreach($activity->reports as $report): ?>
	
<div class="my-3 p-3 bg-white rounded-lg">
<div><a href="/users/view/<?= $report->user_id ?>">Reporter</a> says:</div>
<div><?= $report->issue ?></div>
<div class="mt-2" style="font-size: 12px">Added on <?= $report->created ?></div>
<?php if(empty($report->response)): ?>
<div class="my-2 alert alert-warning">No reply yet</div>
<?php else: ?>
<div class="mt-3">
	<a href="/users/view/<?= $report->curator_id ?>">Curator</a> repsonse:
	<div class="my-2 alert alert-success"><?= $report->response ?></div>
</div>
<?php endif ?>
<a href="#curatorresponse<?= $report->id ?>" 
	style="color:#333;" 
	class="btn btn-light" 
	data-toggle="collapse" 
	title="Respond to this report" 
	data-target="#curatorresponse<?= $report->id ?>" 
	aria-expanded="false" 
	aria-controls="curatorresponse<?= $report->id ?>">
		Respond
</a>	
<div class="collapse" id="curatorresponse<?= $report->id ?>">
<?= $this->Form->postLink(__('Delete'), ['controller' => 'Reports', 'action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete this report?', $report->id), 'class' => 'float-right btn btn-primary']) ?>
<?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'edit', $report->id]]) ?>
<fieldset>
<legend><?= __('Respond') ?></legend>
<?php
echo $this->Form->hidden('id', ['value' => $report->id]);
echo $this->Form->hidden('curator_id', ['value' => $uid]);
echo $this->Form->textarea('response',['class' => 'form-control', 'placeholder' => 'Type here ...']);
?>
</fieldset>
<input type="submit" class="btn btn-primary" value="Submit Response">
<?= $this->Form->end() ?>
</div> <!-- curatorresponse -->

</div>
<?php endforeach ?>
<?php endif ?>
<?php endif ?>


</div>
</div>

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

	$('.reportform').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.after('<div class="alert alert-success">Thank you for your report. A curator will respond. <a href="/profile/reports">View all your reports</a>.').remove();
		
		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/reports/add',
			data: form.serialize(),
			success: function(data)
			{
				
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
		$(this).tooltip('dispose').children('.lcount').html('Liked!');
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
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
	});
});

</script>
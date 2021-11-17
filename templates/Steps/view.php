<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
//phpinfo(); exit;
$this->loadHelper('Authentication.Identity');

$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
/** 
 * Most of the following should be moved into the controller
 * I just find it easier to prototype when the logic I'm working
 * with is in the same file
 */
$stepTime = 0;
$archivedacts = array();
$requiredacts = array();
$supplementalacts = array();
$acts = array();

$readstepcount = 0;
$watchstepcount = 0;
$listenstepcount = 0;
$participatestepcount = 0;
$allreadstepcount = 0;
$allwatchstepcount = 0;
$alllistenstepcount = 0;
$allparticipatestepcount = 0;
$readcolor = '';
$watchcolor = '';
$listencolor = '';
$participatecolor = '';

$totalacts = count($step->activities);
$stepclaimcount = 0;

foreach ($step->activities as $activity) {
	$stepname = '';
	//print_r($activity);
	// If this is 'defunct' then we pull it out of the list 
	// and add it the defunctacts array so we can show them
	// but in a different section
	if($activity->status_id == 3) {
		array_push($archivedacts,$activity);
	} elseif($activity->status_id == 2) {
		// if it's required
		if($activity->_joinData->required == 1) {
			array_push($requiredacts,$activity);
			if($activity->activity_types_id == 1) {
				$watchstepcount++;
			} elseif($activity->activity_types_id == 2) {
				$readstepcount++;
				
			} elseif($activity->activity_types_id == 3) {
				$listenstepcount++;
				
			} elseif($activity->activity_types_id == 4) {
				$participatestepcount++;
				
			}
		// Otherwise it's teriary
		} else {
			array_push($supplementalacts,$activity);
		}
		array_push($acts,$activity);

		if($activity->activity_types_id == 1) {
			$allwatchstepcount++;
			$watchcolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 2) {
			$allreadstepcount++;
			$readcolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 3) {
			$alllistenstepcount++;
			$listencolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 4) {
			$allparticipatestepcount++;
			$participatecolor = $activity->activity_type->color;
		}

		if(in_array($activity->id,$useractivitylist)) {
			$stepclaimcount++;
		}
		$reqtmp = array();
		$suptmp = array();
		// Loop through the whole list, add steporder to tmp array
		foreach($requiredacts as $line) {
			$reqtmp[] = $line->_joinData->steporder;
		}
		foreach($supplementalacts as $line) {
			$suptmp[] = $line->_joinData->steporder;
		}
		// Use the tmp array to sort acts list
		array_multisort($reqtmp, SORT_DESC, $requiredacts);
		array_multisort($suptmp, SORT_DESC, $supplementalacts);
		//array_multisort($tmp, SORT_DESC, $supplementalacts);
	}
}

$pagetitle = $step->name . ' - ' . $step->pathways[0]->name;
$this->assign('title', h($pagetitle));
$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);
$completeclass = 'notcompleted'; 
if($stepclaimcount == $totalacts) {
	$completeclass = 'completed';
}

if($stepclaimcount > 0) {
	$steppercent = ceil(($stepclaimcount * 100) / $stepacts);
} else {
	$steppercent = 0;
}

$current = 0;
$last = 0;
$previousid = 0;
$next = 0;
$nextid = 0;
foreach ($step->pathways as $pathways) {
	foreach($pathways->steps as $s) {
		$next = next($pathways->steps);
		if($s->id == $step->id) {
			if($last) {
				$previousid = $last->id;
				$previousslug = $last->slug;
			}
			if($next) {
				$upnextid = $next->id;
				$upnextslug = $next->slug;
			}
		}
		$last = $s;
	}
}
?>
<style>
/* Start desktop-specific code for this page.
Arbitrarily set to 45em based on sample code from ...somewhere. 
This seems to work out, but #TODO investigate optimizing this
*/
@media (min-width: 45em) {

	.stickyrings {

		position: -webkit-sticky;
		position: sticky;
		top: 86px;
		z-index: 1000;
	}
} /* end desktop-specific code */

</style>
<?php //echo $this->Session->read('Config.time') ?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">

<div class="col-md-12 col-lg-8 col-xl-6">
<div class="p-3">


<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="btn-group float-right ml-3">
<?= $this->Html->link(__('Edit'), 
						['controller' => 'Steps', 'action' => 'edit', $step->id], 
						['class' => 'btn btn-light btn-sm']); 
?>
<?= $this->Form->postLink(__('Delete'), 
							['action' => 'delete', $step->id],
							['class' => 'btn btn-light btn-sm', 
								'confirm' => __('Are you sure you want to delete # {0}?', $step->name)
						]);
 ?>
</div> <!-- /.btn-group -->
<?php endif ?>

	<nav aria-label="breadcrumb mt-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><?= $this->Html->link($step->pathways[0]->topic->categories[0]->name, ['controller' => 'Categories', 'action' => 'view', $step->pathways[0]->topic->categories[0]->id]) ?></li>
		<li class="breadcrumb-item"><?= $this->Html->link($step->pathways[0]->topic->name, ['controller' => 'Topics', 'action' => 'view', $step->pathways[0]->topic->id]) ?></li>
		
	</ol>
	</nav> 
	<div>
	<i class="bi bi-pin-map-fill"></i>	
	<?= $this->Html->link($step->pathways[0]->name, ['controller' => 'Pathways', 'action' => '/' . $step->pathways[0]->slug], ['class' => 'font-weight-bold']) ?>
	</div>

	

	<h1 class="mt-3"><?= $step->name ?></h1>
	<?php if($step->status_id == 1): ?>
	<span class="badge badge-warning">DRAFT</span>
	<?php endif ?>
	<div style="font-size: 120%;">
		<?= $step->description ?>
	</div>



	
	<div class="my-3">
		<span class="badge badge-pill badge-light"><?= $totalacts ?> total activities</span> 
		<span class="badge badge-pill badge-light"><?= $stepacts ?> required</span>
		<span class="badge badge-pill badge-light"><?= $supplmentalcount ?> supplemental</span>
		<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $readcolor ?>,1)">
			<?= $allreadstepcount ?> to read
		</span>  
		<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $watchcolor ?>,1)">
			<?= $allwatchstepcount ?> to watch
		</span>  
		<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $listencolor ?>,1)">
			<?= $alllistenstepcount ?> to listen to
		</span>  
		<span class="badge badge-pill badge-light" style="background-color: rgba(<?= $participatecolor ?>,1)">
			<?= $allparticipatestepcount ?> to participate in
		</span>  
	</div>
	<div class="progress progress-bar-striped stickyprogress mt-3 rounded-lg" style="background-color: #F1F1F1; border-radius: 0; height: 18px;">
		<div class="progress-bar bg-success" role="progressbar" style="width: <?= $steppercent ?>%" aria-valuenow="<?= $steppercent ?>" aria-valuemin="0" aria-valuemax="100">	
		</div>
	</div>






	<div class="row mt-2">
	<div class="col-2 text-center pt-2">
	<?php if(!empty($previousid)): ?>
		<a href="/pathways/<?= $pathways->slug ?>/s/<?= $previousid ?>/<?= $previousslug ?>" class="backstep">
			<i class="bi bi-arrow-left-circle-fill" style="font-size: 150%"></i>
			<br>
			Back
		</a>
	<?php endif ?>
	</div>
	<div class="col">
	<?php if(count($step->pathways[0]->steps) > 1): ?>
	<div class="mt-4">
	<a class="btn btn-light btn-block" 
		data-toggle="collapse" 
		href="#stepnav" 
		role="button" 
		aria-expanded="false" 
		aria-controls="stepnav">
			Step Menu
	</a>
	</div>
	<?php endif ?>
	</div>
	<div class="col-2 text-center pt-2">

	<?php if(!empty($upnextid)): ?>
		<a href="/pathways/<?= $pathways->slug ?>/s/<?= $upnextid ?>/<?= $upnextslug ?>" class="nextstep">
			<i class="bi bi-arrow-right-circle-fill" style="font-size: 150%"></i>
			<br>
			Next
		</a>
	<?php endif ?>
	</div>
	</div>
	<div class="collapse" id="stepnav" aria-labelledby="">
	<?php foreach ($step->pathways as $pathways) : ?>
		<?php foreach($pathways->steps as $s): ?>
			<?php if($s->status_id == 2): ?>
			<?php $c = '' ?>
			<?php if($s->id == $step->id) $c = 'font-weight-bold' ?>
			<div class="px-3 py-1 bg-white">
				<a class=" <?= $c ?>" href="/pathways/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
					<?= $s->name ?> 
					<i class="bi bi-arrow-right-circle-fill"></i>
				</a>
			</div>
			<?php else: ?>
			<?php if($role == 'curator' || $role == 'superuser'): ?>
			<?php $c = '' ?>
			<?php if($s->id == $step->id) $c = 'font-weight-bold' ?>
			<div><a class=" <?= $c ?>" href="/pathways/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
				<?php if($s->id == $step->id && $steppercent == 100): ?>
					<i class="bi bi-check"></i>
				<?php endif ?>
				<span class="badge badge-warning">DRAFT</span>
					<?= $s->name ?>
			</a></div>
			<?php endif; // are you a curator? ?>
			<?php endif; // is published? ?>
		<?php endforeach ?>
	<?php endforeach ?>
	</div>




</div>
</div>
</div>
</div>
<div class="container-fluid bg-white pt-3">
<div class="row justify-content-md-center">
<div class="col-md-3 col-lg-2 col-xl-2 order-md-last">
<?php if(in_array($uid,$usersonthispathway)): ?>
<div class="p-3 bg-white mb-3 mt-3 text-center stickyrings rounded-lg shadow-sm">
<div class="mb-3 following"></div>
<canvas id="myChart" width="250" height="250"></canvas>
</div>

<?php else: ?>
<div class="bg-white rounded-lg p-3 shadow-sm mt-3 text-center stickyrings shadow-sm">
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $step->pathways[0]->id]) ?>
<?= $this->Form->button(__('Follow Pathway'),['class' => 'btn btn-block btn-primary mb-0']) ?>
<?= $this->Form->end(); ?>
</div>
<?php endif ?>
</div>

<div class="col-md-9 col-lg-6 col-xl-4">

<?php if (!empty($step->activities)) : ?>

<?php foreach ($requiredacts as $activity) : ?>
	<div class="activity rounded-lg" style="background-color: #FFF !important;">
	<div class="p-3 my-3 rounded-lg activity" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); color: #111;">

	<?php if(!in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>
		<a class="btn btn-primary" 
			id="claimbutton<?= $activity->id ?>"
			data-toggle="collapse" 
			href="#claimconfirm<?= $activity->id ?>" 
			role="button" 
			aria-expanded="false" 
			aria-controls="claimconfirm<?= $activity->id ?>">
				<i class="bi bi-bookmark-check-fill"></i>
				Claim
		</a>
	<div class="collapse" id="claimconfirm<?= $activity->id ?>">
		<div class="p-3 mt-2" style="background-color: rgba(255,255,255,.5)" id="claimhelp<?= $activity->id ?>">
		If you've completed this activity, claim it so it counts against your progress!
	</div>
		<?= $this->Form->create(null,['url' => ['controller' => 'Activities', 'action' => 'claim/' . $activity->id], 'class' => 'claim', 'id' => $activity->id]) ?>
		<?php //$this->Form->hidden('users.0.created', ['value' => date('Y-m-d H:i:s')]); ?>
		<?= $this->Form->hidden('users.0.id', ['value' => $uid]); ?>
		<?= $this->Form->button(__('Confirm Claim'),['class'=>'btn btn-primary', 'title' => 'If you\'ve completed this activity, claim it so it counts against your progress']) ?>
		<?= $this->Form->end() ?>
	</div>

	<?php else: // they have claimed it, so show that ?>

	<div class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="bi bi-bookmark-check-fill"></i></div>
	<?php //echo $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $activity->_joinData->id], ['class' => 'btn btn-primary', 'confirm' => __('Really delete?')]) ?>
	<?php endif; // claimed or not ?>

	<h2 class="my-3">
		<a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<!--<a class="btn btn-sm btn-light" href="/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
	</h2>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<div class="mb-3">
		<span class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
			<i class="bi bi-clock-history"></i>
			<?= h($activity->estimated_time) ?>
			<?php //echo $this->Html->link($activity->estimated_time, ['controller' => 'Activities', 'action' => 'estimatedtime', $activity->estimated_time]) ?>
		</span> 
		<?php foreach($activity->tags as $tag): ?>
		<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
		<?php endforeach ?>
		</div>

		<?= $activity->description ?>
		<?php if(!empty($activity->isbn)): ?>
		<div class="bg-white p-2 isbn">
			ISBN: <?= $activity->isbn ?>
		</div>
		<?php endif ?>
		<?php if(!empty($activity->_joinData->stepcontext)): ?>
		<div class="alert alert-light text-dark mt-3 shadow-sm">
			<i class="bi bi-person-badge-fill"></i>
			Curator says:<br>
			<?= $activity->_joinData->stepcontext ?>
		</div>
		<?php endif ?>
		<div class="text-muted p-2 mt-2" style="background-color: rgba(255,255,255,.2)">
			Added on 
			<?= $this->Time->format($activity->created,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
			<?php if($role == 'curator' || $role == 'superuser'): ?>
			by <a href="/users/view/<?= $activity->createdby_id ?>">curator</a>
			<?php endif ?>
		</div>
	</div>
	
	<?php if(!empty($activity->tags)): ?>
	<?php foreach($activity->tags as $tag): ?>

	<?php if($tag->name == 'Learning System Course'): ?>

	<a target="_blank" 
		rel="noopener" 
		data-toggle="tooltip" data-placement="bottom" title="Enrol in this course in the Learning System"
		href="https://learning.gov.bc.ca/psc/CHIPSPLM_6/EMPLOYEE/ELM/c/LM_OD_EMPLOYEE_FL.LM_FND_LRN_FL.GBL?Page=LM_FND_LRN_RSLT_FL&Action=U&KWRD=<?php echo urlencode($activity->name) ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			

			<?= $activity->activity_type->name ?>

			<small><i class="bi bi-box-arrow-up-right"></i></small>

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

	<?php else: // if there aren't any tags at all, default ?>


	<a target="_blank" 
		rel="noopener" 
		data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<?= $activity->activity_type->name ?>

			<i class="bi bi-box-arrow-up-right"></i>

	</a>

	<?php endif; // are there tags? ?>	


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
	<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="bi bi-hand-thumbs-up-fill"></i>
	</a>
	

	</div>
	</div>
	

	<?php endforeach; // end of activities loop for this step ?>

<?php endif; ?>

<?php if(count($supplementalacts) > 0): ?>

	<h3>Supplementary Resources</h3>

	<?php foreach ($supplementalacts as $activity): ?>

	<div class="p-3 my-3 bg-white rounded-lg">

		<h4>
			<a href="/activities/view/<?= $activity->id ?>">
				<?= $activity->name ?>
			</a>
		</h4>
		<div class="p-2">
			<div>
				<span class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
					<i class="bi bi-clock-history"></i>
					<?= h($activity->estimated_time) ?>
					<?php //echo $this->Html->link($activity->estimated_time, ['controller' => 'Activities', 'action' => 'estimatedtime', $activity->estimated_time]) ?>
				</span> 
			</div>
			<?= $activity->description ?>

			<?php if(!empty($activity->_joinData->stepcontext)): ?>
			<div class="bg-light shadow-sm p-3 mt-3">
				<strong>Curator says:</strong><br>
				<?= $activity->_joinData->stepcontext ?>
			</div>
			<?php endif ?>

			<a target="_blank" 
				rel="noopener" 
				data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
				href="<?= $activity->hyperlink ?>" 
				style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
				class="btn btn-block my-3 text-uppercase btn-lg">

					<?= $activity->activity_type->name ?>
					<i class="bi bi-box-arrow-up-right"></i>

			</a>
		</div>
		<div>
		<a href="#newreport<?= $activity->id ?>" 
			style="color:#333;" 
			class="btn btn-light" 
			data-toggle="collapse" 
			title="Report this activity for some reason" 
			data-target="#newreport<?= $activity->id ?>" 
			aria-expanded="false" 
			aria-controls="newreport<?= $activity->id ?>">
				<i class="fas fa-exclamation-triangle"></i> Report
		</a>	
		<div class="collapse" id="newreport<?= $activity->id ?>">
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
		<a href="/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
			<span class="lcount"><?= h($activity->recommended) ?></span> <i class="bi bi-hand-thumbs-up-fill"></i>
		</a>


		</div>
	</div>

	<?php endforeach; // end of activities loop for this step ?>

<?php endif ?>
<?php if(!empty($archivedacts)): ?>
	<h4>Archived Activities</h4>
	<div class="p-2 bg-white">This step used to have these activities assigned to them, but they are no 
		longer considered relevant or appropriate for one reason or another. They 
		are listed here for posterity. <a class="" 
											data-toggle="collapse" 
											href="#defunctacts" 
											aria-expanded="false"
											aria-controls="defunctacts">View archived activities</a>.
	</div>
	<div class="collapse bg-white p-3" id="defunctacts">
	<?php foreach ($archivedacts as $activity) : ?>
	<h5>
	<a href="/activities/view/<?= $activity->id ?>">
		<i class="bi <?= $activity->activity_type->image_path ?>"></i>
		<?= $activity->name ?>
	</a>
	</h5>
	<div class="p-2">
		<?= $activity->description ?>
	</div>
	<?php endforeach ?>
	</div>
<?php endif ?>
</div>
</div>
</div>
</div>

</div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


<script type="text/javascript" src="/js/jquery.scrollTo.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script>

$(document).ready(function(){

	// load up the activity rings
	loadStatus();

	$('.claim').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		var url = form.attr('action');
		var buttonid = '#claimbutton' + form.attr('id');
		var helphide = '#claimhelp' + form.attr('id');
		//console.log(buttonid);
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			success: function(data)
			{
				form.children('button').html('CLAIMED! <i class="bi bi-bookmark-check-fill"></i>').tooltip('dispose').attr('title','Good job!');
				$(buttonid).hide();
				$(helphide).hide();
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
	
	$(window).keydown(function(e) {
		switch (e.keyCode) {
			case 37: // left arrow key
				e.preventDefault(); // avoid browser scrolling due to pressed key
				
			case 38: // up arrow key
			return;
			case 39: // right arrow key
				e.preventDefault();
				$('.nextstep').click();
			case 40: // up arrow key
			return;
		}
	});

});

//
// Get the summary for this pathway independently of the page load
//
function loadStatus() {

	$.ajax({
		type: "GET",
		url: '/pathways/status/<?= $step->pathways[0]->id ?>',
		data: '',
		success: function(data)
		{
			var pathstatus = JSON.parse(data);

			$('.following').html('Overall Progress: ' + pathstatus.status + '%');

			//console.log(pathstatus.typecolors);
			$('.readtotal').html(pathstatus.typecounts.readtotal + ' to read')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.readcolor + ',1)');
			$('.watchtotal').html(pathstatus.typecounts.watchtotal + ' to watch')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.watchcolor + ',1)');
			$('.listentotal').html(pathstatus.typecounts.listentotal + ' to listen to')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.listencolor + ',1)');
			$('.participatetotal').html(pathstatus.typecounts.participatetotal + ' to participate in')
							.css('backgroundColor','rgba(' + pathstatus.typecolors.participatecolor + ',1)');

			
			
			var ctx = document.getElementById('myChart').getContext('2d');
			var myDoughnutChart = new Chart(ctx, {
				type: 'doughnut',
				data: JSON.parse(pathstatus.chartjs),
				options: { 
					legend: { 
						display: false 
					},
				}
			});
		},
		statusCode: 
		{
			403: function() {
				console.log('You must be logged in.');
			}
		}
	});

	$.ajax({
		type: "GET",
		url: '/steps/status/<?= $step->id ?>',
		data: '',
		success: function(data)
		{
			var stepstatus = JSON.parse(data);

			console.log(stepstatus.steppercent);
			if(stepstatus.steppercent == 100) {
				$('.finish').removeClass('hide').addClass('show');
			}
			$('.progress-bar').width(stepstatus.steppercent+'%').html('' + stepstatus.steppercent + '% done');
			
		},
		statusCode: 
		{
			403: function() {
				console.log('You must be logged in.');
			}
		}
	});

}

</script>

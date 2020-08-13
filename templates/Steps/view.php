<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
$this->layout = 'nowrap';
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}

$stepTime = 0;
$defunctacts = array();
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
	//print_r($activity);
	// If this is 'defunct' then we pull it out of the list 
	if($activity->status_id == 3) {
		array_push($defunctacts,$activity);
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
		$tmp = array();
		// Loop through the whole list, add steporder to tmp array
		foreach($requiredacts as $line) {
			$tmp[] = $line->_joinData->steporder;
		}
		// Use the tmp array to sort acts list
		array_multisort($tmp, SORT_DESC, $requiredacts);
		//array_multisort($tmp, SORT_DESC, $supplementalacts);
	}
}
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
?>
<style>
.dotactive {
	color: #000;
    font-size: 140%;
}
.dot {
	color: #000;
}

</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-8">
<?php if (!empty($step->pathways)) : ?>
<?php if($role == 2 || $role == 5): ?>
<div class="btn-group float-right mt-3 ml-3">
<?= $this->Html->link(__('Edit'), ['controller' => 'Steps', 'action' => 'edit', $step->id], ['class' => 'btn btn-light btn-sm']) ?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $step->id],['class' => 'btn btn-light btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $step->name)]) ?>
</div> <!-- /.btn-group -->
<?php endif ?>

<?php foreach ($step->pathways as $pathways) : ?>
<?php $totalsteps = count($pathways->steps) ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb mt-3">
  	<li class="breadcrumb-item"><?= $pathways->has('category') ? $this->Html->link($pathways->category->name, ['controller' => 'Categories', 'action' => 'view', $pathways->category->id]) : '' ?></li>
	<li class="breadcrumb-item"><a href="/learning-curator/pathways/view/<?= $pathways->id ?>"><?= h($pathways->name) ?></a></li>
	<!--<li class="breadcrumb-item" aria-current="page"><?= h($pathways->steps[0]->name) ?> </li>-->
  </ol>
</nav> 

<!--<div class="float-right"><a href="/learning-curator/pathways/path/<?= $pathways->id ?>"><i class="fas fa-scroll"></i></a></div>-->
<h1>
	<?= h($pathways->name) ?>
	<?php //$this->Html->link(h($pathways->name), ['controller' => 'Pathways', 'action' => 'path', $pathways->id]) ?>
</h1>

<!--<?= $this->Text->autoParagraph(h($pathways->objective)); ?>-->

<?php foreach($pathways->steps as $s): ?>
<?php $c = ''; ?>
<?php $n = next($pathways->steps) ?>
<?php if($s->id == $step->id): ?>
<div class="row mx-0">
	<div class="col" style="background-color: rgba(255,255,255,.5); border-radius: .25rem;">
		<h2 class="mt-2">
			<?= $s->name ?> 
			<?php if($steppercent == 100): ?>
				<i class="fas fas fa-check-circle"></i>
			<?php endif ?>
			<!--<small><span class="badge badge-dark"><?= $totalsteps ?></span> total steps</small>-->
		</h2>	
		<div class="" style="font-size: 130%;"><em>Goal:</em> <?= h($s->description); ?></div>
		<div class="my-3">
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

			<span class="badge badge-pill badge-light"><?= $totalacts ?> total</span> 
			<span class="badge badge-pill badge-light"><?= $stepacts ?> required</span>
			<span class="badge badge-pill badge-light"><?= $supplmentalcount ?> supplemental</span>
		</div>
	</div>
	<div class="col-2">
		<?php if(!empty($laststep)): ?>
		<a href="/learning-curator/steps/view/<?= $laststep ?>" style="color: #000; font-size: 250%;"><i class="fas fa-arrow-circle-left"></i></a>
		<?php endif ?>

		<?php if(!empty($n->id)): ?>
		<a href="/learning-curator/steps/view/<?= $n->id ?>" style="color: #000; font-size: 250%; float: right;"><i class="fas fa-arrow-circle-right"></i></a>
		<?php endif ?>
		
	</div>
</div>

<?php endif ?>
<?php 
$laststep = $s->id;
$lastname = $s->name;
$lastobj = $s->description;
?>
<?php endforeach ?>
<div class="my-3">
<?php $count = 1 ?>
<?php foreach($pathways->steps as $s): ?>
	<?php $c = 'dot' ?>
	<?php if($s->id == $step->id) $c = 'dotactive' ?>
	<a href="/learning-curator/steps/view/<?= $s->id ?>">
		<i class="fas fa-dot-circle <?= $c ?>" title="Step <?= $count ?>"></i>
	</a>
<?php $count++ ?>
<?php endforeach ?>
</div>
</div>
</div>
<?php endforeach; ?>

<?php endif; ?>



</div>
</div>
</div>

<div class="progress progress-bar-striped stickyprogress" style="background-color: #F1F1F1; border-radius: 0; height: 18px;">
		<div class="progress-bar" role="progressbar" style="background-color: rgba(88,174,36,1); color: #FFF; width: <?= $steppercent ?>%" aria-valuenow="<?= $steppercent ?>" aria-valuemin="0" aria-valuemax="100">
		This step is <?= $steppercent ?>% done
	  </div>
</div>

<div class="container-fluid linear pt-3">
<div class="row justify-content-md-center">

<div class="col-md-6 col-lg-6">
<?php if (!empty($step->activities)) : ?>

<?php foreach ($requiredacts as $activity) : ?>

<div class="bg-white rounded-lg">
<div class="p-3 mb-3 rounded-lg activity" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,.2);">


	<?php if(!in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>
	<?= $this->Form->create(null, ['url' => ['controller' => 'activities-users','action' => 'claim'], 'class' => 'claim']) ?>
	<?= $this->Form->control('activity_id',['type' => 'hidden', 'value' => $activity->id]) ?>
	<?= $this->Form->button(__('Claim'),['class'=>'btn btn-light', 'title' => 'If you\'ve completed this activity, claim it so it counts against your progress', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom']) ?>
	<?= $this->Form->end() ?>
	<?php else: // they have claimed it, so show that ?>

	<div class="btn btn-dark" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div>
	<?= $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesSteps','action' => 'delete/'. $activity->id], ['class' => 'btn btn-sm btn-dark', 'confirm' => __('Really delete?')]) ?>
	<?php endif; // claimed or not ?>

	<h3 class="my-3">
		<a href="/learning-curator/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
		<!--<a class="btn btn-sm btn-light" href="/learning-curator/activities/view/<?= $activity->id ?>"><i class="fas fa-angle-double-right"></i></a>-->
	</h3>
	<div class="p-3" style="background: rgba(255,255,255,.3);">
		<div class="mb-3">
		<span class="badge badge-light" data-toggle="tooltip" data-placement="bottom" title="This activity should take <?= $activity->estimated_time ?> to complete">
			<i class="fas fa-clock"></i>
			<?= $activity->estimated_time ?>
		</span> 
		<?php foreach($activity->tags as $tag): ?>
		<a href="/learning-curator/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
		<?php endforeach ?>
		</div>

		<?= $activity->description ?>

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

	<?php endif; // logic check for formatting differently based on tag ?>	

	<?php endforeach; // tags loop ?>

	<?php else: // if there aren't any tags at all, default ?>


	<a target="_blank" 
		rel="noopener" 
		data-toggle="tooltip" data-placement="bottom" title="<?= $activity->activity_type->name ?> this activity"
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
		class="btn btn-block my-3 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>

			<?= $activity->activity_type->name ?>

	</a>

	<?php endif; // are there tags? ?>	


	<a href="#newreport<?= $activity->id ?>" 
			style="color:#333;" 
			class="btn btn-light float-right" 
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
            <input type="submit" class="btn btn-dark" value="Submit Report">
            <?= $this->Form->end() ?>
		</div>
		</div>
	<a href="/learning-curator/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
		<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
	</a>
	<?php if(!in_array($activity->id,$userbooklist)): // if the user hasn't bookmarked this, then show them claim form ?>
	<?= $this->Form->create(null,['url' => ['controller' => 'activities-bookmarks', 'action' => 'add'], 'class' => 'bookmark form-inline']) ?>
		<?= $this->Form->hidden('activity_id',['value' => $activity->id]) ?>
		<button class="btn btn-light"><i class="fas fa-bookmark"></i> Bookmark</button>
		<?php //$this->Form->button(__('Bookmark'),['class' => 'btn btn-light']) ?>
		<?= $this->Form->end() ?>
	<?php else: ?>
		<span class="btn btn-dark"><i class="fas fa-bookmark"></i> Bookmarked</span>
	<?php endif ?>
		<!--
	<a href="#" style="color:#333;" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
		<i class="fas fa-bookmark"></i> Bookmark
	</a>-->




	</div>
	</div> <!-- whitebg -->

	<?php endforeach; // end of activities loop for this step ?>

<?php endif; ?>

<?php if(count($supplementalacts) > 0): ?>

	<h3>Supplementary Resources</h3>
	<div class="row">
	<?php foreach ($supplementalacts as $activity): ?>
	<div class="col-6">
	<div class="p-3 my-3 bg-white rounded-lg">
		<h4>
			<a href="/learning-curator/activities/view/<?= $activity->id ?>">
				<?= $activity->name ?>
			</a>
		</h4>
		<div class="">
			<?= $activity->description ?>
			
			<a target="_blank" 
				rel="noopener" 
				data-toggle="tooltip" data-placement="bottom" title="<?= $activity->activity_type->name ?> this activity"
				href="<?= $activity->hyperlink ?>" 
				style="background-color: rgba(<?= $activity->activity_type->color ?>,1); color: #000; font-weight: bold;" 
				class="btn btn-block my-3 text-uppercase btn-lg">

					<i class="fas <?= $activity->activity_type->image_path ?>"></i>

					<?= $activity->activity_type->name ?>

			</a>
		</div>
		<div>
		<a href="#newreport<?= $activity->id ?>" 
			style="color:#333;" 
			class="btn btn-light float-right" 
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
            <input type="submit" class="btn btn-dark" value="Submit Report">
            <?= $this->Form->end() ?>
		</div>
		</div>
		<a href="/learning-curator/activities/like/<?= h($activity->id) ?>" style="color:#333;" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
			<span class="lcount"><?= h($activity->recommended) ?></span> <i class="fas fa-thumbs-up"></i>
		</a>
		<?php if(!in_array($activity->id,$userbooklist)): // if the user hasn't bookmarked this, then show them claim form ?>
			<?= $this->Form->create(null,['url' => ['controller' => 'activities-bookmarks', 'action' => 'add'], 'class' => 'bookmark']) ?>
			<?= $this->Form->hidden('activity_id',['value' => $activity->id]) ?>
			<button class="btn btn-light"><i class="fas fa-bookmark"></i> Bookmark</button>
			<?php //$this->Form->button(__('Bookmark'),['class' => 'btn btn-light']) ?>
			<?= $this->Form->end() ?>
		<?php else: ?>
			<span class="btn btn-dark"><i class="fas fa-bookmark"></i> Bookmarked</span>
		<?php endif ?>

			<!--<a href="#" style="color:#333;" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Report this activity for some reason">
				<i class="fas fa-bookmark"></i> Bookmark
			</a>-->

		</div>
	</div>
	</div>
	<?php endforeach; // end of activities loop for this step ?>
</div>

<?php endif ?>
</div>
<div class="col-8 col-md-3 col-lg-2">
<?php if(in_array($uid,$usersonthispathway)): ?>
<div class="p-3 bg-white mb-3 text-center stickyrings rounded-lg">
<div class="mb-3 following"></div>
<canvas id="myChart" width="250" height="250"></canvas>
</div>
<?php else: ?>
<div class="card card-body mt-3 text-center stickyrings">
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'add']]) ?>
<?php
echo $this->Form->control('user_id',['type' => 'hidden', 'value' => $uid]);
echo $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathways->id]);
echo $this->Form->control('status_id',['type' => 'hidden', 'value' => 1]);
?>
<?= $this->Form->button(__('Follow this pathway'),['class' => 'btn btn-block btn-dark mb-0']) ?>
<?= $this->Form->end() ?>
</div>
<?php endif ?>
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


<script type="text/javascript" src="/learning-curator/js/jquery.scrollTo.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script>

$(document).ready(function(){

	// load up the activity rings
	loadStatus();

	$('.bookmark').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').removeClass('btn-light').addClass('btn-dark').html('<span class="fas fa-bookmark"></span> Bookmarked!').tooltip('dispose').attr('title','Good job!');
		
		//$(this).parent('.activity').css('box-shadow','0 0 10px rgba(0,0,0,.4)'); // css('border','2px solid #000')

		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/learning-curator/activities-bookmarks/add',
			data: form.serialize(),
			success: function(data)
			{
				//loadStatus();
			},
			statusCode: 
			{
				403: function() {
					form.after('<div class="alert alert-warning">You must be logged in.</div>');
				}
			}
		});
	});
	$('.claim').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.children('button').removeClass('btn-light').addClass('btn-dark').html('CLAIMED! <span class="fas fa-check-circle"></span>').tooltip('dispose').attr('title','Good job!');
		
		//$(this).parent('.activity').css('box-shadow','0 0 10px rgba(0,0,0,.4)'); // css('border','2px solid #000')

		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/learning-curator/activities-users/claim',
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
	$('.reportform').on('submit', function(e){
		
		e.preventDefault();
		var form = $(this);
		form.after('<div class="alert alert-success">Thank you for your report. A curator will respond. <a href="/learning-curator/users/reports">View all your reports</a>.').remove();
		
		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: '/learning-curator/reports/add',
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

});

//
// Get the summary for this pathway independently of the page load
//
function loadStatus() {

	$.ajax({
		type: "GET",
		url: '/learning-curator/pathways/status/<?= $step->pathways[0]->id ?>',
		data: '',
		success: function(data)
		{
			var pathstatus = JSON.parse(data);

			$('.following').html('Overall Progress: %' + pathstatus.status);

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
		url: '/learning-curator/steps/status/<?= $step->id ?>',
		data: '',
		success: function(data)
		{
			var stepstatus = JSON.parse(data);

			console.log(stepstatus.steppercent);
			if(stepstatus.steppercent == 100) {
				$('.finish').removeClass('hide').addClass('show');
			}
			$('.progress-bar').width(stepstatus.steppercent+'%').html('This step is ' + stepstatus.steppercent + '% completed');
			
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
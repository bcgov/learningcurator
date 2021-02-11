<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->layout = 'nowrap';
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
$totalusers = count($usersonthispathway);
$this->assign('title', h($pathway->name));

?>
<style>
/* Start desktop-specific code for this page.
Arbitrarily set to 45em based on sample code from ...somewhere. 
This seems to work out, but #TODO investigate optimizing this
*/
@media (min-width: 45em) {
	/* probably can be removed as probably not using columns any more */
    .card-columns {
        -webkit-column-count:2;
        -moz-column-count:2;
        column-count:2;
    }
	
	.stickyrings {
		align-self: flex-start; 
		position: -webkit-sticky;
		position: sticky;
		
		top: 86px;
		z-index: 1000;
	}
} /* end desktop-specific code */

.following {
	font-size: 20px;
	font-weight: 200;
	text-align: center;
}
.stickynav {
	align-self: flex-start; 
	position: -webkit-sticky;
	position: sticky;
	top: 0;
	z-index: 1000;
}
#stepnav {
	box-shadow: 0 0 20px rgba(0,0,0,.05);
}
.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
	background-color: #F1F1F1;
	color: #333;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="p-3">
	<?php if($pathway->status_id == 1): ?>
	<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
	<?php endif ?>

	<nav aria-label="breadcrumb">
	<ol class="breadcrumb mt-3">
		<li class="breadcrumb-item"><?= $pathway->has('category') ? $this->Html->link($pathway->category->name, ['controller' => 'Categories', 'action' => 'view', $pathway->category->id]) : '' ?></li>
		<li class="breadcrumb-item" aria-current="page"><?= h($pathway->name) ?> </li>
	</ol>
	</nav> 


	<h1><?= h($pathway->name) ?></h1>

	<!-- totals below updated via JS -->

	<div class="py-3" style="background-color: rgba(255,255,255,.5)">
	<?= $this->Text->autoParagraph(h($pathway->objective)); ?> 
	<div class="mb-2">
	<span class="badge badge-light readtotal"></span>  
	<span class="badge badge-light watchtotal"></span>  
	<span class="badge badge-light listentotal"></span>  
	<span class="badge badge-light participatetotal"></span>  
	</div>

<?php if (!empty($pathway->steps)) : ?>

<div class="col-md-6 col-lg-4">

<?php foreach ($pathway->steps as $steps) : ?>

<?php 

$stepTime = 0;
$defunctacts = array();
$requiredacts = array();
$supplementalacts = array();
$acts = array();

$readstepcount = 0;
$watchstepcount = 0;
$listenstepcount = 0;
$participatestepcount = 0;
$readcolor = '';
$watchcolor = '';
$listencolor = '';
$participatecolor = '';

$totalacts = count($steps->activities);
$stepclaimcount = 0;

foreach ($steps->activities as $activity) {
	//print_r($activity);
	// If this is 'defunct' then we pull it out of the list 
	if($activity->status_id == 3) {
		array_push($defunctacts,$activity);
	} elseif($activity->status_id == 2) {
		// if it's required
		if($activity->_joinData->required == 1) {
			array_push($requiredacts,$activity);

		// Otherwise it's supplemental
		} else {
			array_push($supplementalacts,$activity);
		}
		array_push($acts,$activity);
		if($activity->activity_types_id == 1) {
			$watchstepcount++;
			$watchcolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 2) {
			$readstepcount++;
			$readcolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 3) {
			$listenstepcount++;
			$listencolor = $activity->activity_type->color;
		} elseif($activity->activity_types_id == 4) {
			$participatestepcount++;
			$participatecolor = $activity->activity_type->color;
		}

		$tmp = array();
		// Loop through the whole list, add steporder to tmp array
		foreach($acts as $line) {
			$tmp[] = $line->_joinData->steporder;
		}
		// Use the tmp array to sort acts list
		array_multisort($tmp, SORT_DESC, $acts);
	}
}

?>

<?php
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

<div class="p-3 my-3 bg-white rounded-lg">
	<h2>

		<a href="/steps/view/<?= $steps->id ?>">
			<?= h($steps->name) ?> 
			<i class="fas fa-arrow-circle-right"></i>
		</a>
	</h2>
	
	<div style="font-size; 130%"><?= h($steps->description) ?></div>
	
	<div class="my-3">
		<span class="badge badge-light" style="background-color: rgba(<?= $readcolor ?>,1)"><?= $readstepcount ?> to read</span>  
		<span class="badge badge-light" style="background-color: rgba(<?= $watchcolor ?>,1)"><?= $watchstepcount ?> to watch</span>  
		<span class="badge badge-light" style="background-color: rgba(<?= $listencolor ?>,1)"><?= $listenstepcount ?> to listen to</span>  
		<span class="badge badge-light" style="background-color: rgba(<?= $participatecolor ?>,1)"><?= $participatestepcount ?> to participate in</span>  
		
		<span class="badge badge-pill badge-light"><?= $totalacts ?> total</span> 
		<span class="badge badge-pill badge-light"><?= $stepacts ?> required</span>
		<span class="badge badge-pill badge-light"><?= $supplmentalcount ?> supplemental</span>
	</div>

	
</div>
<?php endforeach ?>


</div> <!-- /.col-md -->
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

</div>

</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>


<?php
$HtmlCode= ob_get_contents(); 
ob_end_flush();
$fh=fopen('bar.html','w'); 
fwrite($fh,$HtmlCode);
fclose($fh);
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->layout = 'public';
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}

$this->assign('title', h($pathway->name));
$pathallactivities = '';
?>

<div class="sticky-top bg-white shadow-sm p-4">
	<span class="navbar-brand">
	<?= h($pathway->name) ?>
	</span>
	<div class="progress">
		<div class="progress-bar bg-success" 
				id="pathprogress"
				role="progressbar" 
				style="width: 0" 
				aria-valuenow="0" 
				aria-valuemin="0" 
				aria-valuemax="100"></div>
	</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center" id="">
<div class="col">
	
<div class="p-3">
	
	<div class="bg-white p-2 rounded-3">
	<a href="index.html">
		<?= $pathway->category->name ?> <?= $pathway->topics[0]->name ?>
	</a>
	</div>
	

	<h1 class="display-3"><?= h($pathway->name) ?></h1>



	<h2 class="fs-2 fw-light"><?= h($pathway->objective); ?> </h2>

	

<?php if (!empty($pathway->steps)) : ?>
<?php foreach ($pathway->steps as $steps) : ?>
<?php 
$stepTime = 0;
$defunctacts = array();
$requiredacts = array();
$supplementalacts = array();
$acts = array();

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
			$pathallactivities = $pathallactivities . ',' . $activity->id;
		// Otherwise it's supplemental
		} else {
			array_push($supplementalacts,$activity);
		}
		array_push($acts,$activity);
		$tmp = array();
		// Loop through the whole list, add steporder to tmp array
		foreach($acts as $line) {
			$tmp[] = $line->_joinData->steporder;
		}
		// Use the tmp array to sort acts list
		array_multisort($tmp, SORT_DESC, $acts);
		array_multisort($tmp, SORT_DESC, $requiredacts);
		
		//array_multisort($tmp, SORT_DESC, $acts);
	}
}
$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);
?>

<div class="p-3 my-3 rounded-lg">
	<h3 class="fs-2">
			<?= h($steps->name) ?> 
	</h3>
	
	<div class="fs-3 fw-light"><?= h($steps->description) ?></div>

	<div class="p-3 bg-white shadow-sm rounded-3">
	<?php foreach($requiredacts as $activity): ?>
	<div class="p-1 my-1">
		<i class="bi bi-check-circle-fill d-none" style="color: rgba(88,174,36,1)" id="actcheck-<?= $activity->id ?>"></i>
		<a class="fs-5" 
			data-bs-toggle="collapse" 
			href="#actinfo-<?= $activity->id ?>" 
			role="button" 
			aria-expanded="false" 
			aria-controls="actinfo-<?= $activity->id ?>">
				<?= $activity->name ?>
		</a>
		<div class="collapse p-5 bg-light rounded-lg shadow-sm" id="actinfo-<?= $activity->id ?>">


			<div class="activity" id="activity-<?= $activity->id ?>">
				<a href="#" 
					class="btn btn-success btn-lg" 
					onclick="return claimit('<?= $activity->id ?>')">

						Claim 
						

				</a>
			</div>




			<h4><?= $activity->name ?></h4>
			<div><?= $activity->description ?></div>
			<a class="btn btn-lg btn-primary" href="<?= $activity->hyperlink ?>" target="_blank">
				<?= $activity->activity_type->name ?>
			</a>
		</div>
	</div>
	<?php endforeach ?>
	<?php if(count($supplementalacts) > 0): ?>
	<h5>
		<a class="btn bg-white mt-0" 
			data-bs-toggle="collapse" 
			href="#supplemental-step-<?= $steps->id ?>" 
			role="button" 
			aria-expanded="false" 
			aria-controls="supplemental-step-<?= $steps->id ?>">
				Supplemental Activities
		</a>
	</h5>
	<div class="collapse bg-white p-3 mt-0" id="supplemental-step-<?= $steps->id ?>">
	<?php foreach($supplementalacts as $activity): ?>
	<div class="p-1 my-1">
		<a class="" data-bs-toggle="collapse" href="#actinfo-<?= $activity->id ?>" role="button" aria-expanded="false" aria-controls="actinfo-<?= $activity->id ?>">
			<?= $activity->name ?>
		</a>
		<div class="collapse p-5 bg-light rounded-3" id="actinfo-<?= $activity->id ?>">
			<h4><?= $activity->name ?></h4>
			<div><?= $activity->description ?></div>
			<a class="btn btn-lg btn-dark" href="<?= $activity->hyperlink ?>" target="_blank">
				<?= $activity->activity_type->name ?>
			</a>
		</div>
	</div>
	<?php endforeach ?>
	</div>
	<?php endif ?>

	</div>

</div>

<?php endforeach ?>


</div> <!-- /.col-md -->
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

</div>

</div>

<script src="//cdn.jsdelivr.net/npm/pouchdb@7.2.1/dist/pouchdb.min.js"></script>
<script>

// A list of all activity IDs from the *pathway*
// We use this list when we build the activity rings
var pathallactivities = '<?= rtrim($pathallactivities,',') ?>';

// A list of all activity IDs from this step
// We use this list when we compare it with IDs 
// that are listed in the localstore 
var stepactivitylist = '<?= rtrim($stepactivitylist,',') ?>';

// The PHP generated the comma-separated list
// now split into an array
var acts = pathallactivities.split(',');

// The pathway ID of this step
var pathwayid = <?= $pathway->id ?>;

// Open the localstore database
// If we're planning on synching this to a remote, that 
// is where we're going to absolutely need a session/unique id 
// variable to create a new database for each user; otherwise, 
// everyone is writing to the same datbase and if I claim something
// it's now claimed for you too.
// If we're not going to create a unique DB for each user, we still
// need the unique ID as we'll have to store the value with 
// each entry and modify below to use a query instead of 
// db.allDocs()
var db = new PouchDB('curator-ta'); // http://localhost:5984/

//
// Initialize activity ring load on page load
//
loadStatus();

function loadStatus() {


	var overallprogress = 0;

	// Start looping through each item in the localstore
	// A record will either be a pathway or an activity
	// so we perform a check for either and update the UI 
	// accordingly
	db.allDocs({include_docs: true, descending: true}, function(err, doc) {

		doc.rows.forEach(function(e,index){

			//
			// Activities
			//
			// Take the list of all activities on this pathway and 
			// break it into an array. Then loop through said array
			// and compare each of the IDs against the ID from our
			// localstore. If there's a match, then update the claim
			// button to indicate you've already claimed.
			//
			// We also build up the vars necessary to show
			// the activity rings .
			//
			// #TODO implement unclaim
			// 
			acts.forEach(function(item, index, arr) {
				
				// Does the ID in the localstore equal an ID from the path?
				if(e.doc['activity'] === item) {

					// Use the activity ID so that we can target the cooresponding
					// dom id and update things accordingly
					let iid = 'activity-' + item;
					let actchk = 'actcheck-' + item;
				
					// Does the activity appear on this page? If so, 
					// update the UI to show it's claimed
					if(document.getElementById(iid)) {
						let newbutton = '<span class="btn btn-dark btn-lg">';
						newbutton += 'Claimed ';
						newbutton += '<i class="fas fa-check-circle">';
						newbutton += '</span>';
						document.getElementById(iid).innerHTML = newbutton;
					}
					if(document.getElementById(actchk)) {
						document.getElementById(actchk).classList.remove('d-none');
					}
					// Update the overall progress counter
					overallprogress++;
				}
			});
			

		}); // end of db.allDocs()

		var totalacts = acts.length;
		var percent = (Number(overallprogress) * 100) / Number(totalacts);
		var percentleft = 100 - percent;

		// UPDATE UI...
		let progress = Math.ceil(percent);
		let attwidth = 'width: ' + progress + '%;';
		console.log(attwidth);
		//#pathprogress
		document.getElementById('pathprogress').setAttribute('aria-valuenow',progress);
		document.getElementById('pathprogress').setAttribute('style',attwidth);


	});

	
}

//
// When the user clicks on the "Claim" button
// this function fires and inserts the ID for 
// activity into the localstore.
// We also update the UI immediately to indicate the claim.
// We are encoding both the activity ID and the its 
// associated activity type ID so that we can properly
// build the activity rings on each page 
//
function claimit (activityid) {	

	// use a simple timestamp as the id	
	rightnow = new Date().getTime();
	var doc = {
		"_id": rightnow.toString(),
		"date": rightnow.toString(),
		"activity": activityid,
	};
	db.put(doc);

	var iid = 'activity-' + activityid;
	newbutton = '<span class="btn btn-dark btn-lg">';
	newbutton += 'Claimed ';
	newbutton += '<i class="fas fa-check-circle"></i>';
	newbutton += '</span> ';
	//newbutton += 'View all of your claims on <a href="#">your dashboard</a>';
	document.getElementById(iid).innerHTML = newbutton;

	loadStatus();

	return false;
}

</script>
</body>
</html>
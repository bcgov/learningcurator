<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}

$this->assign('title', h($pathway->name));

?>

<div class="p-6 w-full bg-top  bg-no-repeat md:bg-fixed min-h-screen rounded-tr-xl" style="background-image: url('<?= h($pathway->topic->categories[0]->image_path) ?>')">
<?php if($pathway->status_id == 1): ?>
<span class="badge badge-warning" title="Edit to set to publish">DRAFT</span>
<?php endif ?>

<nav class="mb-3 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg p-3" aria-label="breadcrumb">
	<a href="/category/<?= h($pathway->topic->categories[0]->id) ?>/<?= h($pathway->topic->categories[0]->slug) ?>" class="hover:underline"><?= h($pathway->topic->categories[0]->name) ?></a> / 
	<a href="/category/<?= h($pathway->topic->categories[0]->id) ?>/<?= h($pathway->topic->categories[0]->slug) ?>/topic/<?= h($pathway->topic->id) ?>/<?= h($pathway->topic->slug) ?>" class="hover:underline"><?= h($pathway->topic->name) ?></a> / 
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block -mt-1 bi bi-compass" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg> <?= h($pathway->name) ?>
</nav>

<?php if(empty($followid)): ?>
<div class="m-3 float-right">
<?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users','action' => 'follow']]) ?>
<?= $this->Form->control('pathway_id',['type' => 'hidden', 'value' => $pathway->id]) ?>
<button class="p-3 bg-sky-700 dark:bg-sky-700 text-white rounded-lg text-center">
<svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-fill" viewBox="0 0 16 16">
  <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354z"/>
</svg> Follow Pathway
</button>
<?= $this->Form->end(); ?>
</div>
<?php else: ?>
	<?php 
	echo $this->Form->postLink(__('Un-Follow Pathway'), 
									['controller' => 'PathwaysUsers', 'action' => 'delete/'. $followid], 
									['class' => 'm-3 float-right inline-block p-3 bg-sky-700 hover:bg-sky-800 text-white rounded-lg text-center hover:no-underline',
									 'title' => 'Stop seeing this pathway on your profile', 
									 'confirm' => '']); 
	?>
<?php endif ?>

<div class="p-4 text-2xl bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
<h1 class="mb-6 text-4xl">
	<!-- <?= h($pathway->id) ?>.  -->
	<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="inline-block -mt-2" viewBox="0 0 16 16">
		<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
		<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
	</svg>
	<?= h($pathway->name) ?>
</h1>

<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="float-right ml-3 mt-1">
<?= $this->Html->link(__('Edit Pathway'), ['action' => 'edit', $pathway->id], ['class' => 'p-3 bg-slate-100/80 dark:bg-black hover:no-underline rounded-lg']) ?>

</div>
<?php endif ?>

<div class="p-4 text-2xl bg-white dark:bg-slate-900/80 rounded-lg shadow-lg">
<div class="text-xs">Objective</div>
	<?= $pathway->objective ?> 
</div>
</div>

<div id="progress" class="flex pbarcontainer sticky top-0 mt-1 mb-6 w-full h-8 bg-slate-50 dark:bg-slate-900/80 rounded-lg">
	
</div>
<script>

fetch('/pathways/status/<?= $pathway->id ?>', { method: 'GET' })
	.then((res) => res.json())
	.then((json) => {
		if(json.percentage > 0) {
			let message = json.completed + ' of ' + json.requiredacts + ' launched';
			let count = parseInt(json.requiredacts);
			let compd = parseInt(json.completed);
			 console.log(compd);
			const progress = document.getElementById('progress');
			for (let i = 0; i < count; i++) {
				//console.log(i);
				const ele = document.createElement('div');     // Create a DIV element.
				
				//ele.setAttribute ('class', '');
				if(i < compd) {
					ele.setAttribute ('class', 'grow md:p-1 bg-slate-700');
					ele.innerHTML = i; 
				} else {
					ele.setAttribute ('class', 'grow md:p-1 bg-sky-600');
					ele.innerHTML = i; 
				}
				
				progress.appendChild(ele); 
			}

			// if(json.percentage > 25) {
			// 	document.querySelector('.pbar').style.width = json.percentage + '%';
			// } 
			// if(json.percentage == 100) {
			// 	document.querySelector('.pbar').innerHTML = message + ' - COMPLETED!';
			// } else {
			// 	document.querySelector('.pbar').innerHTML = message;
			// }



		} else {
			document.querySelector('.pbarcontainer').innerHTML = ''; //'<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>';
		}
		//console.log(json);
	})
	.catch((err) => console.error("error:", err));

</script>




<?php if($role == 'curator' || $role == 'superuser'): ?>

<div x-data="{ open: false }">
<button @click="open = ! open" class="float-right inline-block p-3 mb-1 ml-3 bg-slate-200 dark:bg-black dark:text-white hover:no-underline rounded-lg">
	Add a Step
</button>
<div xcloak x-show="open" class="p-6 my-3 rounded-lg bg-white dark:bg-slate-800 dark:text-white">

	<?= $this->Form->create(null, ['url' => [
		'controller' => 'Steps',
		'action' => 'add'
]]) ?>
	<?php
	echo $this->Form->control('name',['class'=>'block w-full px-3 py-2 m-0 bg-slate-100/80 dark:text-white dark:bg-slate-900/80 rounded-lg']);
	echo $this->Form->control('description',['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 dark:text-white dark:bg-slate-900/80 rounded-lg', 'type' => 'textarea','label'=>'Objective']);
	echo $this->Form->hidden('createdby', ['value' => $uid]);
	echo $this->Form->hidden('modifiedby', ['value' => $uid]);
	echo $this->Form->hidden('pathways.0.id', ['value' => $pathway->id]);
	?>
	<?= $this->Form->button(__('Add Step'), ['class'=>'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
	<?= $this->Form->end() ?>
</div>
</div>


<?php endif ?>


<h2 class="text-3xl p-6 my-3 rounded-lg bg-white/80 dark:bg-slate-900/80 dark:text-white">
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white rounded-full">
		<?= $stepcount ?>
	</span> 
	steps along this pathway
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-sm rounded-full">
		<?= $requiredacts ?> required activities</span>
</h2>





<?php if (!empty($pathway->steps)) : ?>
<?php foreach ($pathway->steps as $steps): ?>
<?php $requiredacts = 0; ?>
<?php foreach($steps->activities as $act): ?>
<?php if($act->_joinData->required == 1) $requiredacts++; ?>
<?php endforeach ?>

<?php //echo '<pre>'; print_r($steps); continue; ?>
<?php if($steps->status->name == 'Published'): ?>
<div class="p-6 my-3 rounded-lg bg-white/80 dark:bg-slate-900/80 dark:text-white">
<h3 class="text-2xl">
<a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= $pathway->topic->slug ?>/pathway/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
		<?= h($steps->name) ?> 
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
		<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
		</svg>
	</a>
	<?php if($role == 'curator' || $role == 'superuser'): ?>
	<span class="text-xs px-4 bg-slate-100/80 dark:bg-emerald-700 rounded-lg"><?= $steps->status->name ?></span>
	<?php endif ?>
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-xs rounded-full">
		<?= $requiredacts ?> activities
	</span>
</h3>


<div class="mt-3 p-3 bg-white dark:bg-slate-800 text-xl rounded-lg">
	<?= $steps->description ?>
</div>


<div class="steppbarcontainer<?= $steps->id ?> sticky top-0 my-1 w-full h-8 bg-slate-50 dark:bg-slate-900/80 rounded-lg">
	<span class="inline-block pbar<?= $steps->id ?> pt-1 px-6 h-8 bg-sky-700 text-white rounded-lg"></span>
</div>
<script>

fetch('/steps/status/<?= $steps->id ?>', { method: 'GET' })
	.then((res<?= $steps->id ?>) => res<?= $steps->id ?>.json())
	.then((json<?= $steps->id ?>) => {
		if(json<?= $steps->id ?>.steppercent > 0) {
			let message = json<?= $steps->id ?>.steppercent + '% - ' + json<?= $steps->id ?>.stepclaimcount + ' of ' + json<?= $steps->id ?>.requiredacts;
			if(json<?= $steps->id ?>.steppercent > 25) {
				document.querySelector('.pbar<?= $steps->id ?>').style.width = json<?= $steps->id ?>.steppercent + '%';
			} 
			if(json<?= $steps->id ?>.steppercent == 100) {
				document.querySelector('.pbar<?= $steps->id ?>').innerHTML = message + ' - COMPLETED!';
			} else {
				document.querySelector('.pbar<?= $steps->id ?>').innerHTML = message;
			}
		} else {
			document.querySelector('.steppbarcontainer<?= $steps->id ?>').innerHTML = ''; //<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>
		}
		//console.log(json);
	})
	.catch((err) => console.error("error:", err));

</script>


<a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= $pathway->topic->slug ?>/pathway/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>"
	class="inline-block p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
	View Step
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
	<path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
	</svg>
</a>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="p-6 my-3 rounded-lg bg-white dark:bg-slate-900/80 dark:text-white">
<h3 class="text-2xl">
	<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>">
		<?= h($steps->name) ?> 
	</a>
	<?php if($role == 'curator' || $role == 'superuser'): ?>

	<span class="text-xs px-4  bg-yellow-700 text-white rounded-lg"><?= $steps->status->name ?></span>

	<?php endif ?>
	<span class="inline-block px-2 bg-slate-500 dark:bg-black text-white text-xs rounded-full">
		<?= $requiredacts ?> activities
	</span>
</h3>


<div class="my-3 p-3 bg-slate-100/80 dark:bg-[#002850] text-xl rounded-lg">
	<?= $steps->description ?>
</div>

<a href="/pathways/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>"
	class="inline-block p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
	View Draft Step
</a>

	<a href="/steps/publishtoggle/<?= $steps->id ?>">Publish Step</a>
</div>
<?php endif; // if curator or admin ?>
<?php endif; // if published ?>

<?php endforeach ?>
<?php else: ?>
<div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? ?>

</div>

<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
$this->assign('title', 'Learning on demand.');
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<h1 class="display-4 mt-5">Learning on demand.</h1>

<div class="p-3 rounded-lg mb-5 bg-white shadow-sm">
<p style="font-size: 1.3rem">Learning Curator Pathways feature informal learning by 
theme or community. Here you’ll find recommendations for resources to watch, read, 
listen to, and courses that will help you reach your goals. Pathways are created by 
BC Public Service learning curators.

</p>
<p style="font-size: 1.5rem"><strong>What do you want to learn today?</strong> </p>

</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-10 col-lg-6">
<h2 class="mt-3">Topic Areas</h2>
<?php foreach ($categories as $category): ?>

<div class="p-3 mb-5 bg-white rounded-lg shadow-sm">
	<h3 class=""><?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?></h3>
	<div class="mb-3" style="font-size: 1.2rem">
	<?= $category->description ?>
	</div>
	
	<a class="btn btn-primary btn-lg" 
		data-toggle="collapse" 
		href="#topics<?= $category->id ?>" 
		role="button" 
		aria-expanded="false" 
		aria-controls="topics<?= $category->id ?>">
    		View Topics
	</a>
	
	<div class="collapse" id="topics<?= $category->id ?>">

	<div class="">
	<?php foreach ($category->topics as $topic): ?>
	<div class="p-3 my-3 bg-light shadow-sm">
	
		<h3><?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></h3>
		<div class="mb-3"><?= h($topic->description) ?></div>
		<a class="btn btn-primary btn-lg" 
			data-toggle="collapse" 
			href="#paths<?= $topic->id ?>" 
			role="button" 
			aria-expanded="false" 
			aria-controls="paths<?= $topic->id ?>">
				View Pathways
		</a>
		<div class="collapse" id="paths<?= $topic->id ?>">
		<!-- <h5>Pathways</h5> -->
		<?php foreach ($topic->pathways as $path): ?>
		<?php if($path->status_id === 2): ?>
		<div class="p-2 my-3 bg-white rounded-lg shadow-sm">
		<h4><?= $this->Html->link(h($path->name), ['controller' => 'Pathways', 'action' => 'view', $path->slug]) ?></h4>
		<div><?= h($path->description) ?></div>
		</div>
		<?php endif ?>
		<?php endforeach; ?>
		</div>
	</div>
	<?php endforeach; ?>
	
	</div>
	</div>
</div>
<?php endforeach; ?>

</div>
<div class="col-md-10 col-lg-6">
<h2 class="mt-3">Featured Pathways</h2>
<div>
<?php foreach($featuredpathways as $path): ?>
	
<?php if($path->status_id != 2): ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="p-3 mb-3 bg-white rounded-lg">
		<span class="badge badge-warning"><?= $path->status->name ?></span>
		<h3><a href="/pathways/<?= $path->slug ?>"><?= $path->name ?></a></h3>
		<div><?= $path->description ?></div>
		<div><?= $path->topic->category[0]->name ?> <?= $path->topic->name ?></div>
		
		<div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div>
	</div>
<?php endif ?>
<?php else: ?>
	<div class="p-3 mb-3 bg-white rounded-lg shadow-sm">
		
		<h3><a href="/pathways/<?= $path->slug ?>"><?= $path->name ?></a></h3>
		<?= $path->objective ?>
		<div>
			
			<?php $topiclink = $path->topic->categories[0]->name . ' - ' . $path->topic->name ?>
			<div><?= $this->Html->link(h($topiclink), ['controller' => 'Topics', 'action' => 'view', $path->topic->id],['class' => 'badge badge-light']) ?></div>
		</div>
		<!-- <div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div> -->
	</div>
<?php endif ?>

<?php endforeach ?>

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
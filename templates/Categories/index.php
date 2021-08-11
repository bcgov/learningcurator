<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
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
<h2 class="mt-3">All Topics</h2>
<?php foreach ($categories as $category): ?>

<div class="p-3 mb-5 bg-white rounded-lg">
	<h3 class=""><?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?></h3>
	<div class="mb-3" style="font-size: 1.2rem">
	<?= $category->description ?>
	</div>
	
	<a class="btn btn-dark btn-lg" 
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
	<div class="p-3 my-3 bg-light">
	
		<h3><?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></h3>
		<div class="mb-3"><?= h($topic->description) ?></div>
		<a class="btn btn-dark btn-lg" 
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
	<div class="p-3 mb-3 bg-white rounded-lg">
		
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
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
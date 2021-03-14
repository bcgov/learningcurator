<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="py-5">
<?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'btn btn-dark float-right']) ?>
<h1 class="display-2"><?= __('Categories') ?></h1>
<div>Categories can contain numerous topics, with each topic containing numerous learning pathways.</div>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-12">

<?php foreach ($categories as $category): ?>

<div class="p-5 my-5 bg-white rounded-lg">
	<h2 class="display-3"><?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?></h2>
	<div class="mb-5" style="font-size: 2rem">
	<?= $category->description ?>
	</div>
	
	<a class="btn btn-dark" 
		data-toggle="collapse" 
		href="#topics<?= $category->id ?>" 
		role="button" 
		aria-expanded="false" 
		aria-controls="topics<?= $category->id ?>">
    		View Topics
	</a>
	
	<div class="collapse" id="topics<?= $category->id ?>">
	<h3>Topics</h3>
	<div class="card-columns">
	<?php foreach ($category->topics as $topic): ?>
	<div class="card card-body bg-light">
	
		<h4><?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?></h4>
		<div class="mb-3"><?= h($topic->description) ?></div>
		<a class="btn btn-dark" 
			data-toggle="collapse" 
			href="#paths<?= $topic->id ?>" 
			role="button" 
			aria-expanded="false" 
			aria-controls="paths<?= $topic->id ?>">
				View Pathways
		</a>
		<div class="collapse" id="paths<?= $topic->id ?>">
		<h5>Pathways</h5>
		<?php foreach ($topic->pathways as $path): ?>
		<?php if($path->status_id === 2): ?>
		<div class="p-2 my-3 bg-white rounded-lg shadow-sm">
		<div class="font-weight-bold"><?= $this->Html->link(h($path->name), ['controller' => 'Pathways', 'action' => 'view', $path->slug]) ?></div>
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
</div>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
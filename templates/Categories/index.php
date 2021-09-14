<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
$this->assign('title', 'All topic areas');
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<h1 class="display-4 my-5">All topic areas</h1>

</div>
</div>
</div>

<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-10 col-lg-6">

<?php foreach ($categories as $category): ?>

<div class="p-3 my-5 bg-white rounded-lg shadow-sm">
	<h2 class="">
		<i class="bi bi-diagram-3-fill"></i>
		<?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?>
	</h2>
	<div class="mb-3" style="font-size: 1.2rem">
	<?= $category->description ?>
	</div>
	

	
	<div class="" id="topics<?= $category->id ?>">

	<div class="">
	<?php foreach ($category->topics as $topic): ?>
	<div class="p-3 my-3 bg-light shadow-sm">
	
		<h3>
			<i class="bi bi-bar-chart-steps"></i>
			<?= $this->Html->link(h($topic->name), ['controller' => 'Topics', 'action' => 'view', $topic->id]) ?>
		</h3>
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
		<h4>
			<i class="bi bi-pin-map-fill"></i>
			<?= $this->Html->link(h($path->name), ['controller' => 'Pathways', 'action' => 'view', $path->slug]) ?>
		</h4>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
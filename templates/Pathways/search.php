<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'btn btn-light float-right mt-5']) ?>
<h1 class="display-4 mt-5"><?= __('All Pathways') ?></h1>
<form method="get" action="/pathways/search" class="mb-5">
	<label>Search
			<input class="form-control" 
					type="search" 
					placeholder="Pathway Search" 
					aria-label="Search" 
					name="q"
					value="<?= $q ?>">
	</label>
	<button class="btn btn-outline-dark" type="submit">Search</button>
</form>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center pt-4">
<div class="col-md-10 col-lg-6">


<?php foreach ($pathways as $pathway): ?>
<div class="bg-white p-3 my-2 rounded-lg">
	
	<div>
		<a href="/pathways/<?= h($pathway->slug) ?>">
			<i class="bi bi-pin-map-fill"></i>
			<?= h($pathway->name) ?>
		</a> 
		<span class=""><?= $pathway->status->name ?></span> in 
		
		<?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id],['class' => '']) ?>
	</div>
</div>
<?php endforeach; ?>

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

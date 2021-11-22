<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
*/
$this->assign('title', 'Learning Curator. Learning on demand.');
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6" role="main" aria-labelledby="hero">

<h1 class="display-4 mt-5">Learning on demand.</h1>

<div class="p-3 rounded-lg mb-5 bg-white shadow-lg">
<p style="font-size: 1.3rem">Learning Curator Pathways feature informal learning by 
theme or community. Here you’ll find recommendations for resources to watch, read, 
listen to, and courses that will help you reach your goals. Pathways are created by 
BC Public Service learning curators.</p>
<p style="font-size: 1.5rem"><strong>What do you want to learn today?</strong> </p>

<a href="/categories/index" class="btn btn-primary btn-lg" role="button">All Categories</a>
<a href="/profile/pathways" class="btn btn-dark btn-lg" role="button">
	<i class="bi bi-person-circle"></i>
	Your Profile
</a>
</div>

</div>
</div>
</div>


<div class="container-fluid" role="main" aria-labelledby="featuredpaths">
<div class="row justify-content-md-center linear">
<div class="col-md-10 col-lg-8 col-xl-6">
<!-- <div class="row justify-content-md-center mt-3">
	<div class="col-xl-6">
		<h2>Follow Pathways</h2>
		<div class="p-3 mb-3 bg-white rounded-lg shadow-sm">
		<video controls loop autoplay>
			<source src="/img/follow.mp4" type="video/mp4">
			<p>Your browser doesn't support HTML5 video. Here is
				a <a href="follow.mp4">link to the video</a> instead.</p>
		</video>
		</div>
	</div>
	<div class="col-xl-6">
		<h2>Claim Activities</h2>
		<div class="p-3 mb-3 bg-white rounded-lg shadow-sm">
		<video controls loop autoplay>
			<source src="/img/claim.mp4" type="video/mp4">
			<p>Your browser doesn't support HTML5 video. Here is
				a <a href="follow.mp4">link to the video</a> instead.</p>
		</video>
		</div>
	</div>
</div> -->

<h2 id="featuredpaths" class="mt-3">Featured Pathways</h2>
<div class="row">
<?php foreach($featuredpathways as $path): ?>
<div class="col-lg-12 col-xl-6">
	<div class="p-3 mb-3 bg-white rounded-lg shadow-sm">
		<div>
			<a href="/pathways/<?= $path->slug ?>" class="font-weight-bold">
				<i class="bi bi-pin-map-fill"></i>
				<?= $path->name ?>
			</a>
		</div>
		<?= $path->objective ?>
		<div>
			
			<?php $topiclink = $path->topic->categories[0]->name . ' - ' . $path->topic->name ?>
			<div><?= $this->Html->link($topiclink, ['controller' => 'Topics', 'action' => 'view', $path->topic->id],['class' => 'badge badge-light']) ?></div>
		</div>
		<!-- <div><span class="badge badge-light">Added: <?= h($path->created) ?></span></div> -->
	</div>
</div>
<?php endforeach ?>
</div>


</div> 
</div> 
</div><!-- /.featured -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
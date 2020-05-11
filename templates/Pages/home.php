<div class="row justify-content-md-center">
<div class="col-md-8">
<div class="card">
<div class="card-body">
<h1>Learning Curator</h1>
<div class="my-3" style="font-size: 180%">
<?php foreach($atypes as $type): ?>
	<div class="">
		<span class="fas <?= $type->image_path ?>" style="color: rgba(<?= $type->color ?>,1);"></span>
		<?= $type->name ?>
	</div>
<?php endforeach ?>
</div>
<h2>A curation space for informal learning resources.</h2>
<h3>Explore Learning Pathways in the following areas:</h3>
<div class="card card-body mb-3">
        <a href="/categories/view/1" class="btn btn-lg btn-light">Leadership</a>
</div>
<p>Just as a museum selects artifacts to display on a theme, BCPS specialist curators have chosen resources that meet a standard of quality to help you on your path to specific leadership development goals.</p>
<p>Learning curation offers a dynamic approach to supporting your performance. As a self-directed experience, you select what, and when, and how much to engage with the learning here. If you want to dip into a few resources and sample what’s on offer, that’s fine. If you want to keep track of your progress through a learning pathway, that’s fine too! You’re in control. </p>
<p>Begin by selecting a pathway that appeals to your needs. The next time you visit the resource, you will be taken to your profile page, where the Learning Agent keeps track of which pathways you’re on, and which learning you’ve begun.</p>
<p>The Learning Agent does not offer credit for courses. While some pathways include recommendations to take Learning Centre courses, you will be directed to register for those through the Learning Centre as usual.  </p>
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

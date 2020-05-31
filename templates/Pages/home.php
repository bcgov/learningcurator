<?php $this->layout = 'nowrap'; ?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-9">
<div class="pad-lg">
<h1>Learning Curator</h1>
<h2>A curation space for informal learning resources</h2>
<h3>Explore Learning Pathways in the following areas:</h3>

<div>
	<a href="/categories/view/1" class="btn btn-lg btn-light">Leading Self</a>
	<a href="/categories/view/2" class="btn btn-lg btn-light">Leading Others</a>
	<a href="/categories/view/3" class="btn btn-lg btn-light">Leading Organizations</a>
	
</div>
</div>

</div>
</div>

<div class="row justify-content-md-center bg-white align-items-center">

<div class="col-md-10 col-lg-5">

<div class="sectiontext">
<div class="my-3 row justify-content-md-center" style="font-size: 180%">
<?php foreach($atypes as $type): ?>
	<div class="col-md-6">
		<span class="fas <?= $type->image_path ?>" style="color: rgba(<?= $type->color ?>,1);"></span>
		<?= $type->name ?>
	</div>
<?php endforeach ?>
</div>

</div>

</div>
<div class="col-md-2 text-center">
	
</div>
</div>

<div class="row justify-content-md-center align-items-center">

<div class="col-md-5">

<div class="sectiontext">Just as a museum selects artifacts to display on a theme, BCPS specialist curators have chosen resources that meet a standard of quality to help you on your path to specific leadership development goals.</div>

</div>
<div class="col-md-2 text-center">
	<i class="fas fa-bezier-curve" style="font-size: 300%"></i>
</div>
</div>


<div class="row justify-content-md-center bg-white align-items-center">

<div class="col-md-7">

<div class="sectiontext">
	

<div class="row mb-3">
<div class="col-md-4">
	
	<h3>
	<i class="fas fa-thermometer-quarter" style="font-size: 300%"></i>
	Dip</h3>
	<p>Just dip your toe in the pool to see if there's anything that can inspire you.</p>
</div>
<div class="col-md-4">
	
	<h3>
	<i class="fas fa-thermometer-half" style="font-size: 300%"></i>
	Deeper</h3>
	<p>Go a bit deeper and look into following a pathway and tracking your progress.</p>
</div>
<div class="col-md-4">
	
	<h3>
	<i class="fas fa-thermometer-full" style="font-size: 300%"></i>
	Dive</h3>
	<p>Go all in and set a MyPerformance goal to complete your pathways.</p>
</div>
<div class="col-md-8 pt-3">
<div class="my-3">Learning curation offers a dynamic approach to supporting your performance. As a self-directed experience, 
	you select what, and when, and how much to engage with the learning here. If you want to dip into a few 
	resources and sample what’s on offer, that’s fine. If you want to keep track of your progress through a 
	learning pathway, that’s fine too! You’re in control. </div>
</div>
</div>

</div>

</div>

</div>



<div class="row justify-content-md-center align-items-center">

<div class="col-md-5">

<div class="sectiontext">
	Begin by selecting a pathway that appeals to your needs. 
	The next time you visit the resource, you will be taken to your profile page, 
	where the Learning Agent keeps track of which pathways you’re on, and which learning you’ve begun.
	<div class="m-3 p-3" style="background-color: rgba(255,255,255,.5)">
	<a class="btn btn-lg btn-light" href="/users/home">Check out your Profile</a>
	</div>
</div>

</div>
<div class="col-md-2 text-center">
	<img src="/img/curator-rings-logo.png" alt="Logo">
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

<?php $this->layout = 'nowrap'; ?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-12">
<div class="pad-lg">
<h1>Learning Curator</h1>
<h2>The best educational resources organized by expert teams on different topic areas:</h2>

<div class="row mt-3">
<div class="col-md-4">
<div class="p-3 rounded-lg my-3" style="background-color: rgba(255,255,255,.3)">
	<h3><a href="/learning-curator/categories/view/1" class="">Leadership</a></h3>
	<div>These pathways focus on building a solid personal foundation—whether 
	your interest is in developing your skills where you are right now or to 
	develop for future roles.</div>
</div>
</div>
<div class="col-md-4">
<div class="p-3 rounded-lg my-3" style="background-color: rgba(255,255,255,.3)">
	<h3><a href="/learning-curator/categories/view/2" class="">Role Specific</a></h3>
	<div>These pathways focus on building a solid personal foundation—whether 
	your interest is in developing your skills where you are right now or to 
	develop for future roles.</div>
</div>
</div>
<div class="col-md-4">
<div class="p-3 rounded-lg my-3" style="background-color: rgba(255,255,255,.3)">
	<h3><a href="/learning-curator/categories/view/3" class="">Technology</a></h3>
	<div>These pathways focus on building a solid personal foundation—whether 
	your interest is in developing your skills where you are right now or to 
	develop for future roles.</div>
	</div>
</div>	
</div>


</div>

<div class="text-center">
<a href="#activitytypes">
<i class="fas fa-chevron-circle-down" style="color: #000; font-size: 300%; margin: 0 0 30px 0;"></i>
</a>
</div>
</div>
</div>



<div class="row justify-content-md-center bg-white">
<?php $count = 0 ?>
<?php foreach($atypes as $type): ?>
<?php $count++ ?>
	<div class="col-md-6" style="background-color: rgba(<?= $type->color ?>,.2)">
	<div class="m-3 p-3">
	<div class="mb-3">
		<a href="/learning-curator/activity-types/view/<?= $type->id ?>" class="activity-icon" style="background-color: rgba(<?= $type->color ?>,1)">
			<i class="activity-icon fas <?= $type->image_path ?>"></i>
			
		</a>
		<a href="/learning-curator/activity-types/view/<?= $type->id ?>" class="" style="color: #333; font-size: 230%">
			<?= h($type->name) ?>
		</a>
	</div>
		<div class="mb-3" style="font-size: 120%;">
		<?= $type->description ?>
		</div>
	</div>
	</div>
<?php endforeach ?>
</div>





<div class="row justify-content-md-center bg-white align-items-center" id="linear">

<div class="col-md-10">

<div class="sectiontext">
	

<div class="row">
<div class="col-md-4">
	
	<h3>
	<i class="fas fa-thermometer-quarter" style="font-size: 300%"></i>
	Dip</h3>
	<p>Just dip your toe in the pool to see if there's anything that can inspire you.</p>
	
	<a class="btn btn-lg btn-dark btn-block" href="/learning-curator/activities">The Latest Stuff</a>
	
</div>
<div class="col-md-4">
	
	<h3>
	<i class="fas fa-thermometer-half" style="font-size: 300%"></i>
	Deeper</h3>
	<p>Go a bit deeper and look into following a pathway and tracking your progress.</p>
	
	<a class="btn btn-lg btn-dark btn-block" href="/learning-curator/users/home">Check out your Profile</a>
	

</div>
<div class="col-md-4">
	
	<h3>
	<i class="fas fa-thermometer-full" style="font-size: 300%"></i>
	Dive</h3>
	<p>Go all in and set a MyPerformance goal to complete your pathways.</p>
	<a class="btn btn-lg btn-dark btn-block" href="/learning-curator/users/home">Read More</a>
</div>
</div>


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

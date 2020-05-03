<div class="row justify-content-md-center">
<div class="col-md-8">
<div class="card">
<div class="card-body">
<h1>The Learning Agent</h1>
<div class="my-3" style="font-size: 200%">
<?php foreach($atypes as $type): ?>
		<span class="fas fa-dot-circle" style="color: rgba(<?= $type->color ?>,1);"></span>
		<?= $type->name ?>
<?php endforeach ?>
</div>
<p>Expertly chosen activities structured into pathways that you can follow while measuring your progress along the way.</p> 
<h2>We've got learning pathways in the following areas:</h2>
<div class="py-3"><a href="/categories/view/1" class="btn btn-lg btn-light">Leadership</a></div>


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

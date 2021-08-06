<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
use Cake\Core\Configure;
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">

<h1 class="display-4 mt-5">Learning on demand.</h1>

<div class="p-3 rounded-lg mb-5 bg-white shadow-sm">
<p style="font-size: 1.5rem">Learning Curator Pathways feature informal learning by theme or community. 
Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help 
you reach your goals. Pathways are created by BC Public Service learning curators.</p>
<div><a href="/auth/azuread" class="btn btn-lg btn-success">Sign In  with your.name@gov.bc.ca address to continue</a></div>
<div class="mt-3">
<a class="" 
	data-toggle="collapse" 
	href="#adminlogin" 
	role="button" 
	aria-expanded="false" 
	aria-controls="adminlogin">
		&nbsp;&nbsp;&nbsp;
</a>
</div>
<div class="collapse m-4 p-3 bg-light" id="adminlogin">
<p><em>If you're a curator or an admin:</em></p>
<?= $this->Form->create() ?>
<?= $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'required' => true, 'class'=>'form-control']) ?>
<?= $this->Form->control('password', ['label' => __d('cake_d_c/users', 'Password'), 'required' => true, 'class'=>'form-control']) ?>
<?= $this->Form->button(__d('cake_d_c/users', 'Login as an admin'),['class'=>'btn btn-light mt-2']); ?>
<?= $this->Form->end() ?>
</div> <!-- /.p-5 -->
</div> <!-- /.bgwhite -->

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
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
$this->assign('title', 'Learning on demand');
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-10 col-lg-8 col-xl-6">

<h1 class="display-4 mt-5">Learning on demand.</h1>

<div class="p-3 rounded-lg mb-5 bg-white shadow-sm">
<p style="font-size: 1.3rem">Learning Curator Pathways feature informal learning by theme or community. 
Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help 
you reach your goals. Pathways are created by BC Public Service learning curators.</p>
<div><a href="/auth/azuread" class="btn btn-lg btn-primary">Sign In  with your.name@gov.bc.ca address to continue</a></div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
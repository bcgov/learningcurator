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

<div class="bg-cover bg-center min-h-full" style="background-image: url('/img/courses2.jpg')">
<div class="p-20 min-h-screen text-white bg-[#003366]/80">

	<h1 class="text-6xl">Learning on demand</h1>
	<div class="mt-6 p-3 text-3xl bg-[#003366]/50 rounded-lg">Learning Curator Pathways feature informal learning by theme or community. 
	Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help 
	you reach your goals. Pathways are created by BC Public Service learning curators.</div>

	<div class="mt-8">
		<a href="/auth/azuread" class="font-bold inline-block p-3 rounded-lg bg-gray-900 dark:bg-[#003366] text-lg shadow-lg text-white">
			Sign In  with your.name@gov.bc.ca address to continue
		</a>
	</div>

	<!--
	<div class="p-3 bg-[#003366]/50" id="adminlogin">
	<p><em>If you're a curator or an admin:</em></p>
	<?= $this->Form->create() ?>
	<?= $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'required' => true, 'class'=>'p-1 dark:bg-black dark:text-white']) ?>
	<?= $this->Form->control('password', ['label' => __d('cake_d_c/users', 'Password'), 'required' => true, 'class'=>'p-1 dark:bg-black dark:text-white']) ?>
	<?= $this->Form->button(__d('cake_d_c/users', 'Login as an admin'),['class'=>'btn btn-light mt-2']); ?>
	<?= $this->Form->end() ?>
	</div> -->

</div>
</div>
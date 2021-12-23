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

<div class="p-3 mt-6 rounded-lg activity bg-white dark:bg-gray-900 dark:text-white">

	<h1 class="text-4xl mt-5">Learning on demand.</h1>

	<p style="font-size: 1.3rem">Learning Curator Pathways feature informal learning by theme or community. 
	Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help 
	you reach your goals. Pathways are created by BC Public Service learning curators.</p>

	<div class="my-5">
		<a href="/auth/azuread" class="block p-3 rounded-lg bg-gray-800">
			Sign In  with your.name@gov.bc.ca address to continue
		</a>
	</div>

	<div class="" id="adminlogin">
	<p><em>If you're a curator or an admin:</em></p>
	<?= $this->Form->create() ?>
	<?= $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'required' => true, 'class'=>'p-1 dark:bg-black dark:text-white']) ?>
	<?= $this->Form->control('password', ['label' => __d('cake_d_c/users', 'Password'), 'required' => true, 'class'=>'p-1 dark:bg-black dark:text-white']) ?>
	<?= $this->Form->button(__d('cake_d_c/users', 'Login as an admin'),['class'=>'btn btn-light mt-2']); ?>
	<?= $this->Form->end() ?>
	</div> <!-- /.p -->

</div>
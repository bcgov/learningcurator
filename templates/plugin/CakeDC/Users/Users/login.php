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
<div class="p-20 min-h-screen bg-white/50 dark:bg-blue-900/80 dark:text-white">

	<h1 class="text-6xl">Learning on demand</h1>
	<div class="mt-6 p-3 text-3xl bg-white/80 dark:bg-blue-900/50 rounded-lg">PSA Curator Pathways feature informal learning by theme or community. 
	Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help 
	you reach your goals. Pathways are created by BC Public Service curators.</div>

	<div class="mt-8">
		<a href="/auth/azuread" class="inline-block p-3 rounded-lg bg-blue-900 hover:bg-blue-800 dark:bg-blue-800 dark:hover:bg-blue-900 text-xl shadow-lg no-underline text-white" x-transition>
			Sign In  with your.name@gov.bc.ca address to continue
		</a>
	</div>

	
	<div class="w-64 mt-24 p-3 bg-white/50 dark:bg-blue-900/40 dark:text-white rounded-lg" id="adminlogin">
	<?= $this->Form->create() ?>
	<?= $this->Form->control('username', ['label' => '', 'required' => true, 'class'=>'p-1 mb-1 bg-white text-black dark:bg-blue-900 dark:text-white rounded-lg']) ?>
	<?= $this->Form->control('password', ['label' => '', 'required' => true, 'class'=>'p-1 mb-1 bg-white text-black dark:bg-blue-900 dark:text-white rounded-lg']) ?>
	<?= $this->Form->button(__d('cake_d_c/users', 'Admins Only'),['class'=>'p-3 bg-white dark:bg-blue-900 dark:text-white text-sm text-black hover:text-gray-500 rounded-lg']); ?>
	<?= $this->Form->end() ?>
	</div> 

</div>
</div>
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
$this->layout = 'ajax';
$this->assign('title', 'Learning on demand');
?>
<?php $this->loadHelper('Authentication.Identity') ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<?= $this->Html->charset() ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= $this->fetch('title') ?> | Learning Curator</title>
<link href="/css/tailwind.css" rel="stylesheet">
</head>

<body class="bg-cover bg-center min-h-full" style="background-image: url('/img/cape-scott-trail-n-r-t-on-flckr.jpg')">
	
<div class="p-3 py-10 bg-white/95 dark:bg-slate-900/9 flex justify-between" role="banner">
<span class="leading-3 text-xl font-semibold tracking-widest text-slate-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline ">
      <span class="text-xs">Learning</span>
      <br>
      <span class="text-[#003366] dark:text-yellow-500">Curator</span>
    </span>
    <div x-data="{ open: false }">
	<button @click="open = true" class="inline dark:text-white">
		Admin Login
	</button>
	<div x-show="open" x-cloak >
		<?= $this->Form->create() ?>
		<?= $this->Form->control('username', ['label' => '', 'required' => true, 'class'=>'p-1 mb-1 bg-white text-black dark:bg-blue-900 dark:text-white rounded-lg']) ?>
		<?= $this->Form->control('password', ['label' => '', 'required' => true, 'class'=>'p-1 mb-1 bg-white text-black dark:bg-blue-900 dark:text-white rounded-lg']) ?>
		<?= $this->Form->button(__d('cake_d_c/users', 'Admin Login'),['class'=>'p-3 bg-white dark:bg-blue-900 dark:text-white text-sm text-black hover:text-gray-500 rounded-lg']); ?>
		<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="w-full lg:w-1/2 px-3 py-10 lg:p-20 min-h-screen dark:text-white">

	<div class="p-6 lg:p-10 text-2xl bg-white/80 dark:bg-[#003366]/80 rounded-lg">

		<h1 class="mb-6 text-4xl text-[#003366] dark:text-white">
			Learning on demand
		</h1>
		
		<div>
        Expertly curated materials and clear pathways to help you meet your learning goals. 
		</div>

		<div class="mt-8">
			<a href="/auth/azuread" class="inline-block p-3 rounded-lg bg-[#003366] hover:bg-blue-800 dark:bg-blue-800 dark:hover:bg-[#003366] text-xl shadow-lg hover:no-underline text-white" x-transition>
				Sign in
			</a>
		</div>

	</div>








</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
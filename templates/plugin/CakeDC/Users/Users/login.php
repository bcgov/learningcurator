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
	
<div class="p-5 bg-white/95 dark:bg-slate-900/9 flex justify-between" role="banner">
<span class="leading-3 text-xl font-semibold tracking-widest text-slate-900 uppercase rounded-lg focus:outline-none focus:shadow-outline ">
      <span class="text-xs">Learning</span>
      <br>
      <span class="text-darkblue">Curator</span>
    </span>
    <div x-data="{ open: false }">
	<button @click="open = true" class="text-sm text-[@003366] hover:underline">
		Admin Login
	</button>
	<div x-show="open" x-cloak >
		<?= $this->Form->create() ?>
		<?= $this->Form->control('username', ['label' => '', 'required' => true, 'class'=>'p-1 mb-1 bg-white text-black  rounded-lg mt-1']) ?>
		<?= $this->Form->control('password', ['label' => '', 'required' => true, 'class'=>'p-1 mb-1 bg-white text-black  rounded-lg']) ?>
		<?= $this->Form->button(__d('cake_d_c/users', 'Login'),['class'=>'p-2 mt-2 bg-darkblue text-white text-sm dark:bg-white   hover:bg-darkblue/80 rounded-lg']); ?>
		<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="w-full md:w-3/4 lg:w-2/3 xl:w-3/5 px-6 py-10 md:p-20 min-h-screen">

	<div class="p-6 md:p-10 text-2xl bg-white/80 rounded-lg">
		<h1 class="mb-6 text-4xl text-darkblue">
			Learning on demand
		</h1>
		
		<div>
        Expertly curated materials and clear pathways to help you meet your learning goals. 
		</div>

		<div class="mt-8">
			<a href="/auth/azuread" class="inline-block p-3 rounded-lg bg-darkblue hover:bg-darkblue/80 text-xl shadow-lg hover:no-underline text-white" x-transition>
				Sign in
			</a>
		</div>

	</div>








</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
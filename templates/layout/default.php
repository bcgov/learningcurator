<?php
$this->loadHelper('Authentication.Identity');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?= $this->fetch('title') ?> | Learning Curator</title>
	
<script src="/js/tailwind.js"></script>

</head>
<body class="bg-white dark:bg-gray-800">
<div class="md:flex flex-col md:flex-row md:min-h-screen w-full">
  <div @click.away="open = false" class="flex flex-col w-full md:w-64 text-gray-700 bg-white dark:text-gray-200 bg-slate-200 dark:bg-gray-900 flex-shrink-0" x-data="{ open: false }">
    <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between">
      <a href="/" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline">
          PSA Curator
      </a>
      <button class="rounded-lg md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
          <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto">
        <?php 
        $active = '';
        $currentpage = $_SERVER["REQUEST_URI"];
        $navigation = array(
            ['name'=>'Profile','link' => '/'],
            ['name'=>'Categories','link' => '/categories'],
            ['name'=>'Pathways','link' => '/pathways'],
            ['name'=>'Activities','link' => '/activities/index'],
            ['name'=>'About','link' => '/questions/index']
        );
        foreach($navigation as $page): ?>
        <?php if($page['link'] == $currentpage) $active = 'bg-gray-300 dark:bg-gray-700'; ?>
        <a class="block px-4 py-2 mt-2 text-sm font-semibold <?= $active ?> text-gray-900 rounded-lg dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="<?= $page['link'] ?>">
        <?= $page['name'] ?>
        </a>
        <?php $active = ''; ?>
        <?php endforeach ?>


    </nav>
  </div>


<div class="flex flex-col dark:bg-gray-800 p-6">
<?= $this->fetch('content') ?>
</div>

</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>
</html>
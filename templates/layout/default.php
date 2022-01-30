<?php $this->loadHelper('Authentication.Identity') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->Html->charset() ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= $this->fetch('title') ?> | Learning Curator</title>
<link href="/css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-slate-100 dark:bg-slate-800">
<div class="md:flex flex-col md:flex-row md:min-h-screen w-full rounded-br-lg">
<div @click.away="open = false" class="flex flex-col w-full md:w-56 text-gray-700 dark:text-gray-200 bg-slate-100 dark:bg-slate-900 flex-shrink-0" x-data="{ open: false }">
  <div class="flex-shrink-0 px-8 py-5 flex flex-row items-center justify-between h-16 "> <!-- sticky top-0 bg-slate-200 dark:bg-[#002850]-->
    <span class="leading-3 text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline">
      <span class="text-xs">Learning</span>
      <br>
      <span class="text-[#003366] dark:text-yellow-500">Curator</span>
    </span>
    <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open" aria-label="Menu Toggle">
      <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
  </div>

  <?php if(!empty($this->Identity->get('id'))): ?>
  <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto">
  <?php 
  #TODO re-write all of this
  $active = '';
  $currentpage = $_SERVER["REQUEST_URI"];
  $navigation = array(
    ['name'=>'Profile','link' => '/profile'],
    ['name'=>'Categories','link' => '/categories'], 
    ['name'=>'Pathways','link' => '/pathways'],
    ['name'=>'Activities','link' => '/activities'],
    ['name'=>'About','link' => '/questions']
  );
  foreach($navigation as $page): ?>
  <?php if(strpos($currentpage,$page['link']) !== false) $active = 'bg-[#c3d4e4] dark:bg-blue-900'; ?>
  <?php if($currentpage == '/' && $page['link'] == '/profile') $active = 'bg-[#c3d4e4] dark:bg-blue-900'; ?>
  <a class="no-underline block px-4 py-2 mt-2 text-sm font-semibold <?= $active ?> text-gray-900 rounded-lg dark:hover:bg-blue-900 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
    href="<?= $page['link'] ?>">
      <?= $page['name'] ?>
  </a>
  <?php $active = ''; ?>
  <?php endforeach ?>
  </nav>
  <?php endif ?>
</div>

<div class="bg-[#c3d4e4] dark:bg-blue-900 dark:text-white w-full 2xl:w-2/3">

  <?php if(!empty($this->Identity->get('id'))): ?>
  <div class="flex h-16 w-full px-6 pt-3 bg-slate-200 dark:bg-[#002850]"> <!-- sticky top-0 z-50 -->

    <div class="p-2 mr-6 w-50 hidden md:block">
      Welcome <a href="/profile" ><?= $this->Identity->get('first_name') ?></a>
      <?php if($this->Identity->get('role') == 'curator'): ?>
      <span class="px-3 text-xs bg-blue-900 text-white rounded-lg">Curator</span>
      <?php elseif($this->Identity->get('role') == 'superuser'): ?>
      <span class="px-3 text-xs bg-blue-900 rounded-lg">Super</span>
      <?php endif ?>
    </div>

    <form method="get" action="/find" class="w-50" role="search">
    <input class="px-3 py-2 m-0 dark:text-white dark:bg-slate-900 rounded-l-lg" type="search" placeholder="" aria-label="Search" name="search"><button class="px-3 py-2 m-0 bg-slate-300 dark:text-white dark:bg-slate-900 dark:hover:bg-slate-800 rounded-r-lg" type="submit">Search</button>
    </form>

  </div>
  <?php endif ?>

  <?= $this->fetch('content') ?>

  </div>
</div>

<div class="py-6 bg-white dark:bg-slate-900">
  <img class="my-6 hidden dark:inline-block" src="/img/wiw-white-text.svg" height="110" width="380px" alt="Where Ideas Work logo">
  <img class="my-6 inline-block dark:hidden" src="/img/wiw-dark-text.svg" height="110" width="380px" alt="Where Ideas Work logo">
  <img class="my-6 hidden dark:inline-block" src="/img/learning-centre-logo-wordmark-darkmode.svg" height="100px" width="300px" alt="Learning Centre Logo">
  <img class="my-6 inline-block dark:hidden" src="/img/learning-centre-logo-wordmark.svg" height="100px" width="300px" alt="Learning Centre Logo">
  <a href="#privacy" class="inline-block p-3 ml-3 bg-slate-200 dark:bg-blue-900 dark:text-white no-underline rounded-lg">
    Privacy Statement
  </a>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
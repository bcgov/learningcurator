<?php $this->loadHelper('Authentication.Identity') ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= $this->fetch('title') ?> | Learning Curator</title>
<link rel="preload">
<link href="/css/tailwind.css" rel="stylesheet">
</head>

<body class="bg-white dark:bg-black font-BCSans" >
  
<!-- :class="{'dark': darkMode === true}"
      x-data="{'darkMode': false}" 
      x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" -->

<div class="md:flex flex-col md:flex-row md:min-h-screen w-full rounded-br-lg" >
<div @click.away="open = false" class="flex flex-col flex-shrink-0 w-full md:w-56 text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-900" x-data="{ open: false }">
<div class="sticky top-0">
  <div class="flex-shrink-0 px-8 py-5 flex flex-row items-center justify-between h-16 " role="banner"> <!-- sticky top-0 bg-slate-200 dark:bg-[#002850]-->
    <span class="leading-3 text-xl  tracking-widest text-slate-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline">
      <span class="text-xs">Learning</span>
      <br>
      <span class="text-[#003366] dark:text-sky-500">Curator</span>
    </span>
    <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open" aria-label="Menu Toggle">
      <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
  </div>

  <?php if(!empty($this->Identity->get('id'))): ?>
  <nav :class="{'block': open, 'hidden': !open}" class="mt-4 flex-grow md:block pb-4 md:pb-0 md:overflow-y-auto" role="navigation">
  <?php 
    $active = 'border-slate-400 dark:border-slate-800';
    $currentpage = $_SERVER["REQUEST_URI"];
   ?>
  <?php if($this->Identity->get('role') == 'curator' || $this->Identity->get('role') == 'superuser'): ?>
    <?php if(strpos($currentpage,'/users') !== false) $active = 'bg-[#c3d4e4] dark:bg-[#003366] border-[#003366] dark:border-white'; ?>
    <?php if(strpos($currentpage,'/reports') !== false) $active = 'bg-[#c3d4e4] dark:bg-[#003366] border-[#003366] dark:border-white'; ?>
    <?php if(strpos($currentpage,'/profile/contributions') !== false) $active = 'bg-[#c3d4e4] dark:bg-[#003366] border-[#003366] dark:border-white'; ?>
  <a class="hover:no-underline inline-block px-4 py-1 mt-2 ml-4 text-sm  dark:text-white dark:hover:bg-sky-500 hover:bg-sky-700 hover:text-white rounded-lg <?= $active ?>"
      href="/users/index">
    Curator Dashboard
  </a>
  <?php 
  // reset state
  $active = 'border-slate-400 dark:border-slate-800';
  endif; 
  ?>
  <?php 
  #TODO re-write all of this
  $navigation = array(
    ['name'=>'Categories','link' => '/categories'], 
    ['name'=>'Pathways','link' => '/pathways'],
    ['name'=>'Activities','link' => '/activities'],
    ['name'=>'Followed Pathways','link' => '/profile/follows'],
    ['name'=>'Launched Activities','link' => '/profile/launches'],
    ['name'=>'Issues Reported','link' => '/profile/reports'],
    ['name'=>'About','link' => '/questions'],
    ['name'=>'Logout','link' => '/logout']  
  );

  foreach($navigation as $page): ?>
  <div>
  <?php if(strpos($currentpage,$page['link']) !== false) $active = 'text-white bg-sky-700'; ?>
  <?php if(strpos($currentpage,'/topics') !== false && $page['name'] == 'Categories') $active = 'text-white bg-sky-700'; ?>
  <?php if(strpos($currentpage,'/category') !== false && $page['name'] == 'Categories') $active = 'text-white bg-sky-700'; ?>
  <?php if(strpos($currentpage,'/pathway') !== false && $page['name'] == 'Pathways') $active = 'text-white bg-sky-700'; ?>
  <a class="hover:no-underline inline-block px-4 py-1 mt-2 ml-4 text-sm  dark:text-white dark:hover:bg-sky-500 hover:bg-sky-700 hover:text-white rounded-lg <?= $active ?>"
    href="<?= $page['link'] ?>">
      <?= $page['name'] ?>
  </a>
  <?php $active = 'text-slate-900'; ?>
  </div>
  <?php endforeach ?>
  </nav>
  <?php endif ?>
  
   

   
<!-- <div class="flex items-center justify-center space-x-2">
  <span class="text-sm text-gray-800 dark:text-gray-500">Light</span>
  <label for="toggle"
    class="flex items-center h-5 p-1 duration-300 ease-in-out bg-gray-300 rounded-full cursor-pointer w-9 dark:bg-gray-600">
    <div
      class="w-4 h-4 duration-300 ease-in-out transform bg-white rounded-full shadow-md toggle-dot dark:translate-x-3">
    </div>
  </label>
  <span class="text-sm text-gray-400 dark:text-white">Dark</span>
  <input id="toggle" type="checkbox" class="hidden" :value="darkMode" @change="darkMode = !darkMode" />
</div> -->

   

</div>
</div>
<div class="bg-white dark:bg-black dark:text-white w-full 2xl:w-2/3" role="main">

  

  <?= $this->fetch('content') ?>

  </div>
</div>

<div class="py-6 bg-slate-100/80 dark:bg-slate-900 dark:text-white text-center" role="contentinfo">

<div class="mx-auto mb-10 p-6 md:w-2/3 lg:w-1/4 bg-white dark:bg-slate-800 dark:text-slate-300 text-lg rounded-lg text-slate-700 text-center">
  We acknowledge with respect that the Learning Curator operates throughout B.C.
   on the traditional lands of Indigenous peoples.
</div>

  <div x-data="{ open: false }">
    <button @click="open = ! open" class="inline-block p-3 ml-3 bg-slate-200 dark:bg-sky-700 dark:hover:bg-sky-800 dark:text-white hover:no-underline rounded-lg">Privacy Statement</button>
    <div x-show="open" @click.outside="open = false" class="md:w-2/3 p-6 my-3 mx-auto rounded-lg bg-white dark:bg-slate-800 dark:text-white">
      Your personal information is collected by the BC Public Service Agency
      in accordance with section 26(c) of the Freedom of Information and 
      Protection of Privacy Act for the purposes of managing and administering 
      employee development and training. If you have any questions, submit an 
      AskMyHR request at www.gov.bc.ca/myhr/contact or call 250-952-6000. 
    </div>
  </div>

  <img class="my-6 inline-block" src="/img/wiw.svg" height="110" width="380px" alt="Where Ideas Work logo">
  
  <img class="my-6 inline-block" src="/img/learning-centre-logo-wordmark.svg" height="100px" width="300px" alt="Learning Centre Logo">


</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>

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

<body class="bg-slate-100 font-BCSans">

    <!-- :class="{'dark': darkMode === true}"
      x-data="{'darkMode': false}" 
      x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" -->

    <div class="md:flex flex-col md:flex-row md:min-h-screen max-w-7xl justify-center mx-auto">
        <div @click.away="open = false" class="flex flex-col flex-shrink-0 w-full md:w-60 text-slate-700 bg-sagegreen" x-data="{ open: false }">
            <div class="sticky top-0">
                <div class="flex-shrink-0 px-8 py-5 flex flex-row items-center justify-between h-16 " role="banner">
                    <!-- sticky top-0 bg-slate-200-->
                    <span class="leading-3 text-xl tracking-widest text-slate-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">
                        <span class="text-xs">Learning</span>
                        <br>
                        <span class="text-[#003366]">Curator</span>
                    </span>
                    <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open" aria-label="Menu Toggle">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                            <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <?php if (!empty($this->Identity->get('id'))) : ?>
                    <nav :class="{'block': open, 'hidden': !open}" class="mt-4 flex-grow md:block pb-4 md:pb-0 md:overflow-y-auto" role="navigation">

                        <?php
                        $active = 'border-slate-400';
                        $currentpage = $_SERVER["REQUEST_URI"];
                        ?>
                        <?php if ($this->Identity->get('role') == 'curator' || $this->Identity->get('role') == 'superuser') : ?>
                            <?php if (strpos($currentpage, '/users') !== false) $active = 'text-white bg-sagedark'; ?>
                            <?php if (strpos($currentpage, '/reports') !== false) $active = 'text-white bg-sagedark'; ?>
                            <?php if (strpos($currentpage, '/profile/contributions') !== false) $active = 'text-white bg-sagedark'; ?>
                            <a class="hover:no-underline block px-4 py-1 mt-2 mb-4 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?= $active ?>" href="/users/index">
                                Curator Dashboard
                            </a>
                        
                            <p class="font-semibold block mt-2 mb-1 mx-4 text-base">Explore</p>
                            
                            <a href="/categories" class="hover:no-underline block px-4 py-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ((strpos($currentpage, '/category') !== false) || ($currentpage == '/categories')) {echo 'text-white bg-sagedark'; }?>">Categories</a>
                       <?php endif; ?>

                        <a href="/pathways" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ((strpos($currentpage, '/pathway') !== false) || ($currentpage == '/pathways')) {echo 'text-white bg-sagedark'; }?>">Pathways</a>
                        <a href="/activities" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ((strpos($currentpage, '/activity') !== false) || ($currentpage == '/activities')) {echo 'text-white bg-sagedark'; }?>">Activities</a>
                        <a href="/questions" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/questions') {echo 'text-white bg-sagedark'; }?>">About</a>
                        <p class="font-semibold block mt-4 mb-1 mx-4 text-base">My Curator</p>
                        <a href="/profile/follows" class="hover:no-underline block px-4 py-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/profile/follows') {echo 'text-white bg-sagedark'; }?>">Followed Pathways</a>
                        <a href="/profile/launches" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/profile/launches') {echo 'text-white bg-sagedark'; }?>">Launched Activities</a>
                        <a href="/profile/reports" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/profile/reports') {echo 'text-white bg-sagedark'; }?>">Issues Reported</a>
                        <a href="/logout" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg">Logout</a>

                        <!-- search box -->


                        <!-- <form method="get" action="/find" class="w-3/4 inline-block" role="search">
    <label for="search" class="sr-only">Search</label>
    <input class="px-3 py-2 m-0 bg-slate-100/80 rounded-l-lg" type="search" placeholder="" aria-label="Search" name="search" id="search"><button class="px-3 py-2 m-0 bg-slate-200 rounded-r-lg" type="submit">Search</button>
  </form> -->

                        <div class="relative pointer-events-auto mx-3 m-2 rounded-md"><button type="button" class="hidden bg-white w-full lg:flex items-center text-sm leading-6 text-slate-400 rounded-md ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-300"><svg width="24" height="24" fill="none" aria-hidden="true" class="mr-3 flex-none">
                                    <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg>Quick search...<span class="ml-auto pl-3 flex-none text-xs font-semibold">Ctrl K</span></button></div>
                        <!-- TODO Allan add working search modal like on Tailwind CSS site -->


                        <!-- end search box -->
                    </nav>

                <?php endif ?>



                <!-- <div class="flex items-center justify-center space-x-2">
  <span class="text-sm text-gray-800">Light</span>
  <label for="toggle"
    class="flex items-center h-5 p-1 duration-300 ease-in-out bg-gray-300 rounded-full cursor-pointer w-9">
    <div
      class="w-4 h-4 duration-300 ease-in-out transform bg-white rounded-full shadow-md toggle-dot">
    </div>
  </label>
  <span class="text-sm text-gray-400">Dark</span>
  <input id="toggle" type="checkbox" class="hidden" :value="darkMode" @change="darkMode = !darkMode" />
</div> -->



            </div>
        </div>
        <div class="bg-white w-full" role="main">



            <?= $this->fetch('content') ?>

        </div>
    </div>

    <div class="p-6 bg-slate-100/80 text-center" role="contentinfo">
        <!-- TODO Nori still needs some formatting help. Seems not quite right yet  -->
        <div class="mb-6 max-w-prose text-lg text-slate-700 mx-auto italic">
            We acknowledge with respect that the Learning Curator operates throughout B.C.
            on the traditional lands of Indigenous peoples.
        </div>

        <div x-data="{ open: false }">
            <button @click="open = ! open" class="inline-block p-3 bg-slate-200 hover:no-underline rounded-lg text-sm">Privacy Statement</button>
            <div x-show="open" @click.outside="open = false" class="md:w-2/3 p-6 my-3 mx-auto rounded-lg bg-white text-sm">
                Your personal information is collected by the BC Public Service Agency
                in accordance with section 26(c) of the Freedom of Information and
                Protection of Privacy Act for the purposes of managing and administering
                employee development and training. If you have any questions, submit an
                AskMyHR request at www.gov.bc.ca/myhr/contact or call 250-952-6000.
            </div>
        </div>

        <div class="flex justify-between">
            <img class="mt-3 inline-block" src="/img/wiw.svg" height="110" width="380px" alt="Where Ideas Work logo">

            <img class="mt-3 inline-block" src="/img/learning-centre-logo-wordmark.svg" height="100px" width="300px" alt="Learning Centre Logo">
        </div>


    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
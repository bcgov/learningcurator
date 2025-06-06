<?php $this->loadHelper('Authentication.Identity') ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head> <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->fetch('title') ?> | Learning Curator</title>


    <link href="/css/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body class="bg-slate-50 font-BCSans dark:bg-slate-900">
<a href="#mainContent" class="sr-only focus:not-sr-only"><span class="p-3">Skip to Content</span></a>
<?php $environment = $_SERVER['SERVER_NAME'] ?>
<?php if($environment == 'learningcurator.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center">
    You're in ALLAN'S LOCAL ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php elseif($environment == 'nori.learningcurator.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center">
    You're in NORI'S LOCAL ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php elseif($environment == 'learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center">
    You're in the OpenShift DEVELOPMENT ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php elseif($environment == 'learningcurator-a58ce1-test.apps.silver.devops.gov.bc.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center">
    You're in the OpenShift TEST ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php endif ?>
    <!-- :class="{'dark': darkMode === true}"
  x-data="{'darkMode': false}" 
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
 $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" -->
    <div class="flex flex-col max-w-7xl mx-auto min-h-screen justify-between">
        <div class="flex flex-col md:flex-row grow">
            <div @click.away="open = false" class="flex flex-col shrink-0 justify-between w-full md:w-60 text-slate-700 bg-sagegreen" x-data="{ open: false }">
                <div class="sticky top-0">
                    <div class="shrink-0 px-8 py-5 flex flex-row items-center justify-between h-16" role="banner">
                        <a class="leading-3 text-xl tracking-widest text-slate-900 uppercase rounded-lg focus:outline-none focus:shadow-outline hover:no-underline"
                            href="/">
                            <span class="text-xs">Learning</span>
                            <br>
                            <span class="text-darkblue">Curator</span>
                        </a>
                        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open" aria-label="Menu Toggle">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                                <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                
                    <nav :class="{'block': open, 'hidden': !open}" class="mt-4 flex-grow md:block pb-4 md:pb-0 md:overflow-y-auto" role="navigation">
                        <?php
                        $active = 'border-slate-400';
                        $currentpage = $_SERVER["REQUEST_URI"];
                        ?>
                        <?php if ($this->Identity->get('role') == 'curator' || $this->Identity->get('role') == 'manager' || $this->Identity->get('role') == 'superuser') : ?>

                            <?php if (strpos($currentpage, '/users/index') !== false) $active = 'text-white bg-sagedark'; ?>
                            <a class="hover:no-underline block px-4 py-1 mt-2 mb-4 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?= $active ?>" href="/users/index">
                                Curator Dashboard
                            </a>
                        <?php endif; ?>
                        

                        <p class="font-semibold block mt-2 mb-1 mx-4 text-base">Explore</p>
                        <a href="/topics" class="hover:no-underline block px-4 py-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/topics') {
                                                                                                                                                            echo 'text-white bg-sagedark';
                                                                                                                                                        } ?>">All Topics</a>
                        <a href="/pathways" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/pathways') {
                                                                                                                                                                echo 'text-white bg-sagedark';
                                                                                                                                                            } ?>">Recent Pathways</a>
                        <a href="/activities" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/activities') {
                                                                                                                                                                echo 'text-white bg-sagedark';
                                                                                                                                                            } ?>">Recent Activities</a>
                        <a href="/questions" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/questions') {
                                                                                                                                                                echo 'text-white bg-sagedark';
                                                                                                                                                            } ?>">About</a>
                        <p class="font-semibold block mt-4 mb-1 mx-4 text-base"><?= $this->Identity->get('username') ?> </p>
                        <a href="/profile/follows" class="hover:no-underline block px-4 py-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/profile/follows') {
                                                                                                                                                                echo 'text-white bg-sagedark';
                                                                                                                                                            } ?>">Followed Pathways</a>
                        <a href="/profile/launches" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/profile/launches') {
                                                                                                                                                                        echo 'text-white bg-sagedark';
                                                                                                                                                                    } ?>">Launched Activities</a>
                        <a href="/profile/reports" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg <?php if ($currentpage == '/profile/reports') {
                                                                                                                                                                    echo 'text-white bg-sagedark';
                                                                                                                                                                } ?>">Issues Reported</a>
                        <a href="/logout" class="hover:no-underline block px-4 py-1 mt-1 mx-4 text-sm hover:bg-sagedark/60 hover:text-white rounded-lg">Logout</a>


                        <div class="py-2 px-4 mt-3 w-full">
                            <form method="get" action="/find" class="flex gap-[1px]" role="search">
                                <label for="search" class="sr-only">Search</label>
                                <input x-ref="input" placeholder="Search" required class="w-40 bg-white text-sm text-slate-700 rounded-l-md ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-700 flex-1" type="search" aria-label="Search" name="search" id="search">
                                <button title="Click here or press Enter to search" class="bg-white text-sm leading-6 text-slate-700 ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-700 rounded-r-lg" type="submit">
                                    <svg width="24" height="24" fill="none" aria-hidden="true" class="flex-none">
                                        <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </nav> 

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


            <main class="bg-white w-full"> 
            <!-- dark:bg-slate-800 dark:text-white -->
                <?= $this->fetch('content') ?>

            </main>
        </div>
        <div class="md:grid md:gap-4 md:grid-cols-3 p-6 bg-slate-200">
        
        
            <div class="p-6 my-3 md:my-0 bg-slate-100 rounded-lg text-slate-600">
        
                The BC Public Service acknowledges the territories of First Nations 
                around B.C. and is grateful to carry out our work on these lands. 
                We acknowledge the rights, interests, priorities and concerns of all 
                Indigenous Peoples (First Nations, Métis and Inuit), respecting and 
                acknowledging their distinct cultures, histories, rights, laws and governments.
            </div>
        
        
            
            <div class="p-6 my-3 md:my-0 bg-slate-100 rounded-lg text-slate-600">
                <div class="text-lg">Your one-stop-shop for learning that is available to 
                    public service employees from any ministry:</div>
                <a class="inline-block my-3 px-5 py-2 rounded-lg text-white bg-slate-700 hover:no-underline hover:bg-slate-800" 
                    href="https://learningcentre.gww.gov.bc.ca/learninghub/"
                    target="_blank"
                    rel="noopener">
                        Visit the Learning<span class="text-yellow-500 font-bold">HUB</span>
                </a>
            </div>
        <div class="p-3 my-3 md:my-0 bg-slate-100 rounded-lg text-slate-700">

            <img class="block" src="/img/wiw.svg" height="110" width="380px" alt="Where Ideas Work logo">

            <details class="leading-snug my-4 mx-8">
                <summary class="text-darkblue text-sm hover:underline hover:cursor-pointer">Privacy Statement</summary>
                <div class="text-sm my-3">
                    Your personal information is collected by the BC Public Service Agency
                    in accordance with section 26(c) of the Freedom of Information and
                    Protection of Privacy Act for the purposes of managing and administering
                    employee development and training. If you have any questions, submit an
                    AskMyHR request at www.gov.bc.ca/myhr/contact or call 250-952-6000.
                </div>
            </details>
            
        </div>

    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@2.x.x/dist/alpine-clipboard.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


</body>

</html>
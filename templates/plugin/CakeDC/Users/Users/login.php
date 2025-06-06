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

// This should happen at the controller level, likely, but I'm hoping this works
// as a band-aid until I can figure this out properly.
$environment = urlencode($_SERVER['SERVER_NAME']);
$go = $_GET['redirect'] ?? 'https://' . $environment . '/categories';
// echo $go; exit;
$rediroldprodtonew = str_replace('learningcurator.apps.silver.devops.gov.bc.ca','learningcurator.gww.gov.bc.ca',$go);
// echo $rediroldprodtonew; exit;
if($environment == 'learningcurator.apps.silver.devops.gov.bc.ca') {
    header('Location: https://learningcurator.gww.gov.bc.ca/login?redirect=' . $rediroldprodtonew);
    exit;
}

if($go) {
    setcookie("RedirectionTo", $rediroldprodtonew, time()+3600);  /* expire in 1 hour */
}

use Cake\Core\Configure;
$this->loadHelper('Authentication.Identity');
$this->layout = 'ajax';
$this->assign('title', 'Learning on demand');

?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <script>
        let hashfrag = document.location.hash;
        document.cookie = "hash="+hashfrag;
    </script>
    <?= $this->Html->charset() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->fetch('title') ?> | Learning Curator</title>
    <link href="/css/tailwind.css" rel="stylesheet">
</head>

<body class="bg-cover bg-center font-BCSans" style="background-image: url('/img/cape-scott-trail-n-r-t-on-flckr.jpg')">

<?php if($environment == 'learningcurator.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center" role="alert">
    You're in ALLAN'S LOCAL ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php elseif($environment == 'nori.learningcurator.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center" role="alert">
    You're in NORI'S LOCAL ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php elseif($environment == 'learningcurator-a58ce1-dev.apps.silver.devops.gov.bc.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center" role="alert">
    You're in the OpenShift DEVELOPMENT ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php elseif($environment == 'learningcurator-a58ce1-test.apps.silver.devops.gov.bc.ca') : ?>
<div class="px-3 py-2 bg-yellow-100 font-bold text-center" role="alert">
    You're in the OpenShift TEST ENVIRONMENT - 
    <a href="https://learningcurator.gww.gov.bc.ca" target="_blank">
        Production
    </a>
</div>
<?php endif ?>
    <div class="flex flex-col  min-h-screen justify-start">
        <div class="p-5 bg-white/95 flex justify-between flex-none" role="banner">
            <span class="leading-3 text-xl tracking-widest text-slate-900 uppercase rounded-lg focus:outline-none focus:shadow-outline ">
                <span class="text-xs">Learning</span>
                <br>
                <span class="text-darkblue">Curator</span>
            </span>
            <div x-data="{ open: false }">
                <button @click="open = true" class="text-sm text-[@003366] hover:underline">
                    Admin Login
                </button>
                <div x-show="open" x-cloak>
                    <?= $this->Form->create() ?>
                    <?= $this->Form->control('username', ['label' => '', 'required' => true, 'class' => 'p-1 mb-1 bg-white text-black  rounded-lg mt-1']) ?>
                    <?= $this->Form->control('password', ['label' => '', 'required' => true, 'class' => 'p-1 mb-1 bg-white text-black  rounded-lg']) ?>
                    <?= $this->Form->button(__d('cake_d_c/users', 'Login'), ['class' => 'p-2 mt-2 bg-darkblue text-white text-sm hover:bg-darkblue/80 rounded-lg']); ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <main class="w-full md:w-3/4 lg:w-2/3 xl:w-3/5 px-6 py-10 md:p-20 grow gap-4 flex flex-col justify-between">

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

            <p class="bg-white/50 flex-none self-start py-1 px-2 rounded-md mb-0">Photo: <a href="https://www.flickr.com/photos/n-r-t/1200374518/" target="_blank">Cape Scott Trail</a> by <a href="https://www.flickr.com/photos/n-r-t/" target="_blank">Nick Thompson on Flickr</a> (<a href="https://creativecommons.org/licenses/by-nc-nd/2.0/">CC BY-NC-ND 2.0</a>)</p>

        </main>
        <div class="p-10 pb-0 bg-slate-900/90 text-white flex-none" role="contentinfo">
            <div class="flex flex-col md:flex-row justify-between">
            <div class="my-5 max-w-prose text-slate-50">
                The BC Public Service acknowledges the territories of First Nations 
                around B.C. and is grateful to carry out our work on these lands. 
                We acknowledge the rights, interests, priorities and concerns of all 
                Indigenous Peoples (First Nations, Métis and Inuit), respecting and 
                acknowledging their distinct cultures, histories, rights, laws and governments.
            </div>

                <img class="max-h-[100px] md:-mt-4 md:-mr-4 mx-auto md:mx-0" src="/img/where-ideas-work-whitetext.svg" height="100px" width="380px" alt="Where Ideas Work logo">
            </div>
            <div x-data="{ open: false }" class="leading-snug mb-4 text-slate-300">
                <button @click="open = ! open" class="inline text-sm hover:underline">Privacy Statement<span x-show="open">:</span></button>
                <div x-show="open" @click.outside="open = false" class="inline text-sm">Your personal information is collected by the BC Public Service Agency in accordance with section 26(c) of the Freedom of Information and Protection of Privacy Act for the purposes of managing and administering employee development and training. If you have any questions, submit an AskMyHR request at www.gov.bc.ca/myhr/contact or call 250-952-6000. </div>
            </div>
        </div>
    </div>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
// <!-- Snowplow starts plowing - Standalone vE.2.14.0 -->

;(function(p,l,o,w,i,n,g){if(!p[i]){p.GlobalSnowplowNamespace=p.GlobalSnowplowNamespace||[];
p.GlobalSnowplowNamespace.push(i);p[i]=function(){(p[i].q=p[i].q||[]).push(arguments)
};p[i].q=p[i].q||[];n=l.createElement(o);g=l.getElementsByTagName(o)[0];n.async=1;
n.src=w;g.parentNode.insertBefore(n,g)}}(window,document,"script","https://www2.gov.bc.ca/StaticWebResources/static/sp/sp-2-14-0.js","snowplow"));

<?php $environment = $_SERVER['SERVER_NAME'] ?>
<?php if($environment == 'learningcurator.apps.silver.devops.gov.bc.ca' || $environment == 'learningcurator.gww.gov.bc.ca') : ?>
var collector = 'spt.apps.gov.bc.ca';
<?php else: ?>
var collector = 'spm.apps.gov.bc.ca';
<?php endif ?>

window.snowplow('newTracker','rt',collector, {
 appId: 'Snowplow_standalone_PSA',
 cookieLifetime: 86400 * 548,
 platform: 'web',
 post: true,
 forceSecureTracker: true,
 contexts: {
  webPage: true,
  performanceTiming: true
 }
});
window.snowplow('enableActivityTracking', 30, 30); // Ping every 30 seconds after 30 seconds
window.snowplow('enableLinkClickTracking');
window.snowplow('trackPageView');

// <!-- Snowplow stops plowing -->
</script>
</body>
</html>
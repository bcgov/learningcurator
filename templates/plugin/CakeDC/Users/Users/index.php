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

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
$environment = $_SERVER['SERVER_NAME'];
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex flex-col justify-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
    <p class="flex-none text-white">Welcome <?= $this->Identity->get('first_name') ?> <?= $this->Identity->get('last_name') ?></p>
</header>
<div class="p-8 text-lg" id="mainContent">
    <div class="lg:grid lg:grid-cols-5 lg:gap-4 items-start">
        <div class="lg:col-span-3">
            <div class="p-3 rounded-lg bg-slate-100">
                <h2 class="text-2xl text-darkblue font-semibold mb-2">Admin Options</h2>
                <p><i class="bi bi-info-circle"></i> <strong>Not sure where to start?</strong> Read the <a href="https://bcgov.sharepoint.com/:f:/r/teams/00404/Shared%20Documents/Curators/Handbook%20-%20Documentation%20for%20Curators?csf=1&web=1&e=Y7b0BO" target="_blank" class="text-sky-700 hover:underline">Curator's Handbook</a>.</p>
                <h3 class="mt-4 font-semibold">Search for a User</h3>
                <form method="get" action="/users/search" class="mt-2">
                    <label class="">
                        <input class="px-3 py-2 m-0 border rounded-l-lg" type="search" placeholder="first or last name ..." aria-label="User Search" name="q"></label><button class="px-3 py-2 m-0 bg-slate-400 hover:bg-slate-300 rounded-r-lg" type="submit">User Search</button>
                    <div class="inline-block ml-2 text-sky-700 hover:underline text-base"><a href="/users/search">Show All Users</a></div>
                </form>
                <div class="flex">
                <div class="basis-1/2">
                <h3 class="mt-4 font-bold">Curators</h3> 
                <p>Curators have full access to create draft pathways but cannot publish.</p>
                <ul class="list-disc pl-8 mt-2">
                <?php foreach($curators as $cur): ?>
                    <li><a href="/users/view/<?= $cur->id ?>"><?= $cur->first_name ?> <?= $cur->last_name ?></a></li>
                <?php endforeach ?>
                </ul>
                </div>
                <div class="basis-1/2">
                
                <h3 class="mt-4 font-bold">Managers</h3> 
                <p>Managers can do what Curators do, but they can also publish pathways to production.</p>
                <ul class="list-disc pl-8 mt-2">
                <?php foreach($managers as $man): ?>
                    <li>
                        <a href="/users/view/<?= $man->id ?>">
                            <?= $man->first_name ?> <?= $man->last_name ?>
                            <?= $man->topics ?>
                        </a>
                    </li>
                <?php endforeach ?>
                <?php foreach($supers as $s): ?>
                    <?php if($s->username == 'superadmin') continue ?>
                    <li><a href="/users/view/<?= $s->id ?>"><?= $s->first_name ?> <?= $s->last_name ?></a> <span title="Super User">&#8902;</span> <!-- flag: &#128681;--> <!--(super)--></li>
                <?php endforeach ?>
                </ul>
                </div>
                </div>
                <div class="flex">
                <div class="basis-1/2">
                <h3 class="mt-4 font-bold">View</h3>
                <ul class="list-disc pl-8 mt-2">
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/reports/index">Open Issue Reports</a></li>
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/reports/closed">Closed Issue Reports</a></li>
                    <!-- <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/activity-types">Activity Types</a></li> -->
                    <!--<li class="px-2"><a class="hover:underline hover:text-sky-700" href="/ministries">Ministries</a></li> -->
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/profile/contributions">
                            My Contributions
                        </a></li>
                    <!-- <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/activities/audit">
                            "Auto" Link Audit
                        </a></li> -->
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/activities/flagged">
                            Manual Link Review
                        </a></li>
                </ul>
                </div>
                <div class="basis-1/2">
                <h3 class="mt-4 font-semibold">Create New</h3>
                <ul class="list-disc pl-8 mt-2">
                    <?php if ($role == 'superuser') : ?><li class="px-2"><a class="hover:underline hover:text-sky-700" href="/categories/add">Category</a></li> <?php endif ?>
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/topics/add">Topic</a></li>
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/pathways/add">Pathway</a></li>
                    <li class="px-2"><a class="hover:underline hover:text-sky-700" href="/activities/add">Activity</a></li>
                    <!-- <li class="px-2"> <a class="hover:underline hover:text-sky-700" href=" /activities/addtostep">Add Activity to Step</a></li> -->
                </ul>
                </div>
                </div>
            </div>
   
            <?php $rcount = $noresponses->count() ?? 0 ?>
            <h2 class="text-2xl text-darkblue font-semibold mt-6"><span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2 mr-2"><?= $rcount ?></span> Open Reports</h2>
            <div class="max-w-prose">
                <div class="mt-4">
                    <?php
                    // these links are templated/built within the controller for noted reasons there

                    ?>
                    <?php if (!$noresponses->all()->isEmpty()) : ?>
                        <?php foreach ($noresponses as $report) : ?>
                            <div class="border-2 border-slate-700 mb-3 rounded-md">
                                <div class="flex justify-between gap-4 items-center bg-slate-700 text-white p-2"> <span class="ml-2 font-semibold">Issue report #<?= $report->id ?></span>
                                    <span class="text-sm"><?= $this->Time->format($report->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></span>
                                </div>
                                <div class="p-3">
                                    <div class="text-xl"><span class="font-semibold">Activity Reported:</span> <a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></div>
                                    <div class="text-sm italic mt-2">User said:</div>
                                    <blockquote class="border-l-2 p-2 m-2">
                                        <?= h($report->issue) ?>
                                    </blockquote>
                                    <a title="View this report" href="/reports/view/<?= $report->id ?>" class="inline-block px-4 py-2 text-md text-white bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg mt-3 mb-1">
                                        View Report
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="flex justify-between gap-4 border-2 p-3 rounded-md my-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-info-circle-fill flex-none" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </svg>
                            <div class="grow">
                                <h3 class="mb-3 text-xl font-semibold">No open reported issues to address! Good job.</h3>
                            </div>
                        </div>

                    <?php endif ?>
                </div>

            </div>
        </div>
        <?php if($environment == 'learningcurator.apps.silver.devops.gov.bc.ca' || $environment == 'learningcurator.gww.gov.bc.ca') : ?>
        <div class="border-2 border-darkblue p-3 rounded-lg lg:col-span-2 lg:grid order-2">
            <h2 class="text-2xl text-darkblue">Stats To Date</h2>

            <div class="text-xl">
                <p class="mt-2"><span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $totalfollowcount ?></span> Pathway Follows</p>
                <h3 class="mt-4 font-semibold">Top 5 Followed Pathways</h3>
                <!-- TODO Nori add styling to the follows piece of the link - formatting in SimpleCrudTrait.php -->
                <ol class="pl-8 text-base mt-2 list-decimal leading-snug">
                    <?php
                    // these links are templated/built within the controller for noted reasons there
                    ?>
                    <?php foreach ($top5follows as $link) : ?>
                        <li class="px-2 "><?= $link ?></li>
                    <?php endforeach ?>
                </ol>

                <p class="mt-4"><span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $launchcount ?></span> Activity Launches
                </p>
                <h3 class="mt-2 font-semibold">Top 5 Launched Activities</h3>
                <ol class="pl-8 text-base mt-2 list-decimal leading-snug">
                    <?php
                    // these links are templated/built within the controller for noted reasons there

                    ?>
                    <?php foreach ($top5links as $link) : ?>
                        <li class="px-2 "><?= $link ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>
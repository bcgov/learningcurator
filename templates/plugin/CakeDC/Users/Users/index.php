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
?>
<header class="w-full h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg">
    <div class="border-2 border-darkblue p-3 rounded-lg">
        <h2 class="text-2xl text-darkblue">Today's Stats</h2>
        <div class="lg:grid lg:grid-cols-2 lg:gap-4 mt-1">
            <div class="text-xl">
                <p class="mt-2"><span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $totalfollowcount ?></span> Pathway Follows</p>
                <h3 class="mt-4 font-semibold">Top 5 Followed Pathways</h3>
                <!-- TODO Nori add styling to the follows piece of the link -->
                <ol class="pl-8 text-base">
                    <?php
                    // these links are templated/built within the controller for noted reasons there
                    ?>
                    <?php foreach ($top5follows as $link) : ?>
                        <li class="my-1 px-2 list-decimal leading-snug"><?= $link ?></li>
                    <?php endforeach ?>
                </ol>
            </div>


            <div class="text-lg">
                <p class="mt-2"><span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $launchcount ?></span> Activity Launches
                </p>
                <h3 class="mt-4 font-semibold">Top 5 Launched Activities</h3>
                <ol class="pl-8 text-base">
                    <?php
                    // these links are templated/built within the controller for noted reasons there

                    ?>
                    <?php foreach ($top5links as $link) : ?>
                        <li class="my-1 px-2 list-decimal leading-snug"><?= $link ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>




    <form method="get" action="/users/search" class="p-3 bg-slate-200 dark:bg-slate-900/80 rounded-lg">
        <label class="">Search for a user:
            <input class="px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-l-lg" type="search" placeholder="first or last name ..." aria-label="User Search" name="q"></label><button class="px-3 py-2 m-0 bg-slate-300 dark:text-white dark:bg-slate-800 dark:hover:bg-slate-700 rounded-r-lg" type="submit">User Search</button>
    </form>

    <!-- <div class="mt-6 mb-2">
    View: 
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/reports/index">Reports</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activity-types">Activity Types</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/ministries">Ministries</a>
</div> -->
    <div class="p-3 my-4 bg-slate-200 dark:bg-slate-800 rounded-lg">
        View:
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/profile/contributions">
            Your Contributions
        </a>
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/activities/audit">
            "Auto" Link Audit
        </a>
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/activities/flagged">
            Manual Link Review
        </a>
    </div>
    <div class="p-3 my-4 bg-slate-200 dark:bg-slate-800 rounded-lg">
        Create new:
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/categories/add">Category</a>
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/topics/add">Topic</a>
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/pathways/add">Pathway</a>
        <a class="inline-block p-3 mr-1 bg-sky-700 hover:no-underline hover:bg-sky-800 text-white rounded-lg" href="/activities/add">Activity</a>
        <!-- <a class="inline-block p-3 my-3 bg-slate-200 dark:bg-sky-700" href="/activities/addtostep">Add Activity to Step</a> -->
    </div>

    <div class="md:grid md:grid-cols-2 md:gap-4">
        <div>
            <?php $rcount = $noresponses->count() ?? 0 ?>
            <h2 class="mt-4 text-2xl">Open Reports <span class="inline-block py-0 px-2 text-sm text-white bg-slate-900/80 rounded-lg"><?= $rcount ?></span></h2>
            <div class="p-3 bg-slate-200 dark:bg-slate-900/80 rounded-lg">
                <?php
                // these links are templated/built within the controller for noted reasons there

                ?>
                <?php if (!$noresponses->all()->isEmpty()) : ?>

                    <?php foreach ($noresponses as $report) : ?>
                        <div class="p-3 mb-2 bg-slate-200 dark:bg-slate-800 rounded-lg">

                            <?= h($report->created) ?>
                            <div><strong><a href="/activities/view/<?= $report->activity->id ?>"><?= $report->activity->name ?></a></strong></div>
                            <blockquote class="p-3 mt-1 bg-white dark:bg-slate-700 rounded-lg">
                                <?= h($report->issue) ?>
                            </blockquote>
                            <a title="View this report" href="/reports/view/<?= $report->id ?>" class="inline-block mt-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                                View Report
                            </a>
                        </div>
                    <?php endforeach ?>
                <?php else : ?>
                    <div class="p-3 mb-2 bg-slate-200 dark:bg-slate-800 rounded-lg">
                        <p>No open reported issues to address! Good job.</p>
                    </div>
                <?php endif ?>
            </div>


        </div> <!-- grid-col -->

    </div> <!-- /.grid -->


</div>
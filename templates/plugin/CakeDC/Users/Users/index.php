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
<div class="p-6 dark:text-white">

<div class="text-3xl mb-3">
    <span class="inline-block p-3 rounded-full bg-slate-300 dark:bg-black"><?= $totalfollowcount ?></span> Pathway Pins 
    <span class="inline-block p-3 rounded-full bg-slate-300 dark:bg-black"><?= $launchcount ?></span> Activity Launches
</div>

<form method="get" action="/users/search" class="pt-3">
<label class="">Search for a user:
<input class="px-3 py-2 m-0 dark:text-white dark:bg-slate-900 rounded-l-lg" 
        type="search" 
        placeholder="first or last name ..." 
        aria-label="User Search" 
        name="q"></label><button class="px-3 py-2 m-0 bg-slate-300 dark:text-white dark:bg-slate-900 dark:hover:bg-slate-800 rounded-r-lg" type="submit">User Search</button>
</form>

<div class="mt-6 mb-2">
    View: 
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/reports/index">Reports</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activity-types">Activity Types</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/ministries">Ministries</a>
</div>
<div class="mb-4">
    Create new: 
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/categories/add">Category</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/topics/add">Topic</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/pathways/add">Pathway</a> 
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activities/add">Activity</a>
    <!-- <a class="inline-block p-3 my-3 bg-slate-200 dark:bg-sky-700" href="/activities/addtostep">Add Activity to Step</a> -->
</div>



<h2 class="mt-4 text-2xl">Top 5 Followed Pathways</h2>
<div class="p-3 bg-slate-200 dark:bg-slate-900 rounded-lg">
<ol class="pl-10">
<?php 
// these links are templated/built within the controller for noted reasons there

?>
<?php foreach($top5follows as $link): ?>
    <li class="p-2 list-decimal text-xl"><?= $link ?></li>
<?php endforeach ?>
</ol>
</div>


<h2 class="mt-4 text-2xl">Top 5 Launched Activities</h2>
<div class="p-3 bg-slate-200 dark:bg-slate-900 rounded-lg">
<ol class="pl-10">
<?php 
// these links are templated/built within the controller for noted reasons there

?>
<?php foreach($top5links as $link): ?>
    <li class="p-2 list-decimal text-xl"><?= $link ?></li>
<?php endforeach ?>
</ol>
</div>


</div>
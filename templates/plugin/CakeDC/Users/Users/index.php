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
    <span class="inline-block p-3 rounded-full bg-slate-300 dark:bg-black"><?= $ppincount ?></span> Pathway Pins 
    <span class="inline-block p-3 rounded-full bg-slate-300 dark:bg-black"><?= $launchcount ?></span> Activity Launches
</div>

<div class="mt-6 mb-2">
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/reports/index">Reports</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activity-types">Activity Types</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/ministries">Ministries</a>
</div>
<div class="mb-4">
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/categories/add">New Category</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/topics/add">New Topic</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/pathways/add">New Pathway</a> 
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activities/add">New Activity</a>
    <!-- <a class="inline-block p-3 my-3 bg-slate-200 dark:bg-sky-700" href="/activities/addtostep">Add Activity to Step</a> -->
</div>

<h2 class="mt-4 text-2xl">Top 5 Launched Activities</h2>
<div class="p-3 bg-slate-200 dark:bg-slate-900 rounded-lg">
<ol class="pl-10">
<?php 
// these links are templated/built within the controller for noted reasons there
$count = 4;
?>
<?php foreach($top5links as $link): ?>
    <li class="p-2 list-decimal text-xl"><?= $link ?></li>
    <?php $count-- ?>
<?php endforeach ?>
</ol>
</div>


<form method="get" action="/users/search" class="pt-6">
<label class="">Search for a user:
<input class="px-3 py-2 m-0 dark:text-white dark:bg-slate-900 rounded-l-lg" 
        type="search" 
        placeholder="first or last name ..." 
        aria-label="Search" 
        name="q"></label><button class="px-3 py-2 m-0 bg-slate-300 dark:text-white dark:bg-slate-900 dark:hover:bg-slate-800 rounded-r-lg" type="submit">Search</button>
</form>
<div class="mt-1 p-3 bg-white dark:bg-slate-900 rounded-lg">
<table class="w-full">
    <tr class="bg-slate-200 dark:bg-slate-800">
        <th>User name</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
    </tr>  
<?php foreach (${$tableAlias} as $user) : ?>
<tr class="bg-white dark:bg-black mb-3 p-3">
    <td class="px-3 py-1">
        <?= $this->Html->link(__d('cake_d_c/users', h($user->username)), ['action' => 'view', $user->id],['class' => 'font-bold']) ?> 
    </td>
    <td>
        <?= h($user->first_name) ?> 
    </td>
    <td>
        <?= h($user->last_name) ?>
    </td>
    <td>
        <?= h($user->email) ?>
    </td>
    </div>
</tr>
<?php endforeach; ?>
</table>
<div class="paginator m-3 p-3 bg-slate-200 dark:bg-slate-800 rounded-lg">
<div class="pagination">
<?= $this->Paginator->prev('< ' . __d('cake_d_c/users', 'previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__d('cake_d_c/users', 'next') . ' >') ?>
</div>
<div><?= $this->Paginator->counter() ?></div>
</div>
</div>
</div>
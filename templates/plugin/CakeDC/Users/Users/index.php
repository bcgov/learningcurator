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
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/reports/index">View Reports</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activity-types">View Activity Types</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/ministries">View Ministries</a>
</div>
<div class="mb-8">
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/categories/add">New Category</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/topics/add">New Topic</a>
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/pathways/add">New Pathway</a> 
    <a class="inline-block p-3 mr-1 bg-slate-200 dark:bg-sky-700 hover:no-underline hover:bg-sky-800 rounded-lg" href="/activities/add">New Activity</a>
    <!-- <a class="inline-block p-3 my-3 bg-slate-200 dark:bg-sky-700" href="/activities/addtostep">Add Activity to Step</a> -->
</div>

<form method="get" action="/users/search" class="pt-6 border-t-2 border-slate-900">
<label class="">Search for a user:
<input class="px-3 py-2 m-0 dark:text-white dark:bg-slate-900 rounded-l-lg" 
        type="search" 
        placeholder="first or last name ..." 
        aria-label="Search" 
        name="q"></label><button class="px-3 py-2 m-0 bg-slate-300 dark:text-white dark:bg-slate-900 dark:hover:bg-slate-800 rounded-r-lg" type="submit">Search</button>
</form>
    
<div class="mt-1 p-3 bg-white dark:bg-slate-900 rounded-lg">
<table class="w-full">
    <tr>
        <th>User name</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
    </tr>  
<?php foreach (${$tableAlias} as $user) : ?>
<tr class="bg-white dark:bg-black mb-3 p-3">
    <td class="">
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
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __d('cake_d_c/users', 'previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__d('cake_d_c/users', 'next') . ' >') ?>
</ul>
<p><?= $this->Paginator->counter() ?></p>
</div>
</div>
</div>
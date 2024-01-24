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
    <p class="flex-none text-white">Welcome <?= $this->Identity->get('username') ?></p>
</header>
<div class="p-6">
<h2 class="text-2xl mb-3">Ministries Report</h2>


<ul class="flex flex-wrap text-sm font-medium text-center">
    <li class="me-2">
        <a href="/activities/stats" class="inline-block p-4">
            Activities
        </a>
    </li>
    <li class="me-2">
        <a href="/ministries" class="inline-block p-4">
            Ministries
        </a>
    </li>
    <li class="me-2">
        <a href="/stats" aria-current="page" class="inline-block p-4 ">
            Topics
        </a>
    </li>
</ul>

<table class="w-full table-auto">
<thead>
<tr class="text-left">
    <th class="w-2/3">Ministry</th>
    <th class="p-1 text-center">Learners</th>
    <th class="p-1 text-center">Follows</th>
    <th class="p-1 text-center">Launches</th>
</tr>
</thead>
<tbody>
<?php foreach ($orderedmins as $ministry): ?>
    <tr class="even:bg-slate-100 odd:bg-slate-200 hover:bg-white">
        <td class="w-2/3 pr-4 p-1">
            <?= $ministry['name'] ?>
            <span class="text-xs"><?= $ministry['id'] ?></span> - 
            <span class="text-xs"><?= $ministry['slug'] ?></span>
        </td>
        <td class="p-1 text-center"><?= h($ministry['usercount']) ?></td> 
        <td class="p-1 text-center"><?= h($ministry['followcount']) ?></td>
        <td class="p-1 text-center"><?= h($ministry['launchcount']) ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>


</div>
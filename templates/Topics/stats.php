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
<div class="p-6">
<h2 class="text-2xl mb-3">Activity Stats</h2>
<?php foreach($newtopics as $t): ?>
<div class="mb-3 p-3 bg-slate-100 rounded-lg">
<h3 class="text-xl mb-3">
    <a href="/topic/<?= $t['topicslug'] ?>"><?= $t['topicname'] ?></a>
</h3>
<table class="w-full table-auto">
<thead>
<tr class="text-left">
    <th class="w-2/3">Pathway</th>
    <th>Steps</th>
    <th>Activities</th>
    <th>Follows</th>
    <th>Launches</th>
</tr>
</thead>
<tbody>
<?php foreach($t['pathways'] as $path): ?>
<tr class="even:bg-slate-100 odd:bg-slate-200 hover:bg-white">
    <td class="w-2/3 pr-4 py-1">
        <a href="/p/<?= $path['pathslug'] ?>">
            <?= $path['pathname'] ?>
        </a>
    </td>
    <td class="py-1 text-center"><?= $path['pathstepcount'] ?></td>
    <td class="py-1 text-center"><?= $path['pathactcount'] ?></td>
    <td class="py-1 text-center"><?= $path['pathfollowcount'] ?></td>
    <td class="py-1 text-center"><?= $path['launchcount'] ?></td>
</tr>
<?php endforeach ?>
<tr class="even:bg-slate-100 odd:bg-slate-200">
    <td class="w-2/3 pr-4 py-1 text-right">
        Totals:
    </td>
    <td class="py-1 text-center"><strong><?= $t['topicsteps'] ?></strong></td>
    <td class="py-1 text-center"><strong><?= $t['topicactvitities'] ?></strong></td>
    <td class="py-1 text-center"><strong><?= $t['topicfollows'] ?></strong></td>
    <td class="py-1 text-center"><strong><?= $t['topiclaunches'] ?></strong></td>
</tr>
</tbody>
</table>
</div>
<?php endforeach ?>
</div>
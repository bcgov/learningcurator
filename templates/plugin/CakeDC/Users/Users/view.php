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

$Users = ${$tableAlias};
$usenam = $Users->first_name . ' ' . $Users->last_name . ' profile';
$this->assign('title', $usenam);
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>

<header class="w-full h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">User Profile</h2>
    <h3 class="mt-4 text-xl font-semibold"><?= h($Users->first_name) ?> <?= h($Users->last_name) ?></h3>
    <?php if ($role == 'superuser') : ?>
        <div class="btn-group float-right mt-5">
            <?= $this->Html->link(__d('cake_d_c/users', 'Edit User'), ['action' => 'edit', $Users->id], ['class' => 'inline-block px-4 py-2 text-md text-white bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
            <?= $this->Form->postLink(
                __d('cake_d_c/users', 'Delete User'),
                ['action' => 'delete', $Users->id],
                [
                    'confirm' => __d('cake_d_c/users', 'Are you sure you want to delete # {0}?', $Users->id),
                    'class' => 'inline-block px-3 py-1 text-base hover:bg-red-700/80 text-white bg-red-700 hover:no-underline rounded-lg'
                ]
            ) ?>
        </div>
    <?php endif ?>

    <div class="mb-3">
        <ul class="list-disc pl-8 mt-2">
            <li class="px-2"><strong>Status:</strong> <?php if ($this->Number->format($Users->active) == 1) : ?>
                    Active
                <?php endif ?> </li>
            <li class="px-2"><strong>Role:</strong> <?= ucfirst($Users->role) ?></li>
            <!-- TODO Nori/Allan add other status options here? -->
            <?php if ($Users->ministry_id == 2) : ?>
                <li class="px-2"><strong>Ministry:</strong> Public Service Agency</li>
            <?php elseif ($Users->ministry_id == 3) : ?>
                <li class="px-2"><strong>Ministry:</strong> Citizen Services</li>
            <?php endif ?>
            <li class="px-2"><strong>Username:</strong> <?= h($Users->username) ?></li>
            <li class="px-2"><strong>Email:</strong> <a href="mailto:<?= h($Users->email) ?>" class="font-weight-bold"><?= h($Users->email) ?></a></li>
            <li class="px-2"><strong>User Created:</strong> <?= $this->Time->format($Users->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></li>
            <li class="px-2"><strong>Last Modified:</strong> <?= $this->Time->format($Users->modified, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></li>
        </ul>
    </div>
    <!-- TODO Nori/Allan should we add icons or cards or other additional formatting here? -->
    <h3 class="mt-4 font-semibold text-xl">Activities Claimed</h3>
    <?php if (!empty($Users->activities_users)) : ?>
        <ul class="list-disc pl-8 mt-2">
            <?php foreach ($Users->activities_users as $act) : ?>
                <li class="px-2"><a href="/activities/view/<?= $act->activity->id ?>"><?= h($act->activity->name) ?></a>
                </li>
            <?php endforeach ?>
        </ul>
        <!-- TODO Nori/Allan add claimed date? -->
    <?php else : ?>
        <p>This user hasn't claimed any activities yet.</p>
    <?php endif ?>
    <h3 class="mt-4 font-semibold text-xl">Activities Contributed</h3>
    <?php if (!$actsadded->isEmpty()) : ?>
        <ul class="list-disc pl-8 mt-2">
            <?php foreach ($actsadded as $act) : ?>
                <li class="px-2"> <a href="/activities/view/<?= $act->id ?>">
                        <?= h($act->name) ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    <?php else : ?>
        <p>This user hasn't contributed any activities yet.</p>
    <?php endif ?>
    <h3 class="mt-4 font-semibold text-xl">Pathways Followed</h3>
    <?php if (!empty($Users->pathways_users)) : ?>
        <ul class="list-disc pl-8 mt-2">
            <?php foreach ($Users->pathways_users as $path) : ?>
                <li class="px-2"><a href="/pathways/<?= $path->pathway->slug ?>">
                        <i class="bi bi-pin-map-fill"></i>
                        <?= $path->pathway->name ?>
                    </a></li>

            <?php endforeach ?>
        </ul>
    <?php else : ?>
        <p>This user hasn't followed any pathways yet.</p>
    <?php endif ?>
    <h3 class="mt-4 font-semibold text-xl">Pathways Contributed</h3>
    <?php if (!$pathsadded->isEmpty()) : ?>
        <!-- TODO Allan deprecation error for isEmpty -->
        <ul class="list-disc pl-8 mt-2">

            <?php foreach ($pathsadded as $path) : ?>
                <li class="px-2"> <a href="/pathways/<?= $path->slug ?>">
                        <?= $path->name ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    <?php else : ?>
        <p>This user hasn't contributed any pathways yet.</p>
    <?php endif ?>
</div>
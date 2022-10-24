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
    <h2 class="text-2xl text-darkblue font-semibold mb-3">User Search</h2>
    <h3 class="mt-4 font-semibold">Search for a User</h3>
    <form method="get" action="/users/search" class="mt-2">
        <label class="">
            <input class="px-3 py-2 m-0 border rounded-l-lg" type="search" placeholder="first or last name ..." aria-label="User Search" name="q" value="<?= h($q) ?>"></label><button class="px-3 py-2 m-0 bg-slate-400 hover:bg-slate-300 rounded-r-lg" type="submit">User Search</button>
        <div class="inline-block ml-2 text-sky-700 hover:underline text-base"><a href="/users/search">Show All Users</a></div>
    </form>

    <h3 class="mt-4 font-semibold">All Users</h3>
    <p>Click on any username to see information about that user and their contributions to the Learning Curator.</p>
    <p class="mt-3 text-base">Page <?= $this->Paginator->counter() ?></p>
    <table class="border-collapse border border-slate-400">
        <thead>
            <tr>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left">Username</th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left">First Name</th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left">Last Name</th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left">Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (${$tableAlias} as $user) : ?>
                <tr>
                    <td class="px-2 py-1 border border-slate-300"><?= $this->Html->link(__d('cake_d_c/users', h($user->username)), ['action' => 'view', $user->id], ['class' => 'font-weight-bold']) ?></td>

                    <td class="px-2 py-1 border border-slate-300">
                        <?= h($user->first_name) ?>
                    </td>
                    <td class="px-2 py-1 border border-slate-300">
                        <?= h($user->last_name) ?>
                    </td>
                    <td class="px-2 py-1 border border-slate-300">
                        <a href="mailto:<?= h($user->email) ?>" class="hover:underline"><?= h($user->email) ?></a>
                    </td>
                </tr>


            <?php endforeach; ?>

        </tbody>
    </table>

    <div class="paginator">
        <ul class="flex items-center gap-2">
            <?= $this->Paginator->prev('< ' . __d('cake_d_c/users', 'Previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__d('cake_d_c/users', 'Next') . ' >') ?>
        </ul>
        
    </div>


</div>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>

<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex flex-col justify-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
    <p class="flex-none text-white">Welcome <?= $this->Identity->get('username') ?></p>
</header>

<div class="p-6" id="mainContent">
<h2 class="text-2xl mb-3">Activities Report</h2>
<div class="px-6 py-3 bg-yellow-200 rounded-lg hover:bg-yellow-100">
    <strong>Please note:</strong> the data represented on this page is intended for internal 
    Curator use only and should only be used for maintenance purposes. 
    The data is not reflective of actual usage and should not be used in any 
    data analytics or reporting capacity.
</div>
<ul class="flex flex-wrap text-sm font-medium text-center">
    <li class="me-2 list-none">
        <a href="/activities/stats" class="inline-block p-4">
            Activities
        </a>
    </li>
    <?php if ($role == 'superuser') : ?>
    <li class="me-2 list-none">
        <a href="/ministries" class="inline-block p-4">
            Ministries
        </a>
    </li>
    <?php endif ?>
    <li class="me-2 list-none">
        <a href="/stats" aria-current="page" class="inline-block p-4 ">
            Topics
        </a>
    </li>
</ul>

<table class="w-full table-auto">
<thead>
<tr class="text-left">
    <th class="w-2/3">Activity</th>
    <th class="py-1 text-center">Steps</th>
    <th class="py-1 text-center">Reports</th>
    <th class="py-1 text-center">Launches</th>
</tr>
</thead>
<tbody>
<?php $activitycount = 0 ?>
<?php foreach ($activities as $activity) : ?>
    <?php $activitycount = $activitycount + $activity[2] ?>
    <?php $highlightzerosteps = ''; if($activity[3] == 0) $highlightzerosteps = 'bg-yellow-500 text-white' ?>
    <tr class="even:bg-slate-100 odd:bg-slate-200 hover:bg-white">
        <td class="w-2/3 pr-4 py-1">
            <a href="/activities/view/<?= $activity[1] ?>"><?= $activity[0] ?></a>
        </td>
        <td class="py-1 text-center <?= $highlightzerosteps ?>"><?= $activity[3] ?> </td>
        <td class="py-1 text-center"><?= $activity[4] ?> </td>
        <td class="py-1 text-center"><?= $activity[2] ?> </td>
    </tr>
<?php endforeach; // end of activities loop for this step ?>
<tr class="even:bg-slate-100 odd:bg-slate-200">
    <td class="w-2/3 pr-4 py-1 text-right">
        Totals:
    </td>
    <td class="py-1 text-center"><strong></strong></td>
    <td class="py-1 text-center"><strong></strong></td>
    <td class="py-1 text-center"><strong><?= $activitycount ?></strong></td>
</tr>
</tbody>
</table>

</div>


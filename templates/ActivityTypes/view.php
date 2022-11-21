<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */

?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">View Activity Type: <span class="text-slate-900">
            <!-- <span class="fas <?= h($activityType->image_path) ?>"></span> -->
            <?= h($activityType->name) ?>
        </span> <a href="/activity-types/" class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal">View all Activity Types</a></h2>
    <!-- TODO alphabetize the list or sort options? -->
    <div class="mt-2 mb-3 text-xl"><?= $activityType->description; ?></div>

    <?= $this->Html->link(('Edit the ' . $activityType->name . ' activity type'), ['controller' => 'ActivityTypes', 'action' => 'edit', $activityType->id], ['class' => 'mt-3 mb-5 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>

    <ul class="pl-8 list-disc">
        <?php foreach ($activities as $activity) : ?>
            <li class="px-2"><?= $this->Html->link(($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></li>
        <?php endforeach ?>
    </ul>
</div>
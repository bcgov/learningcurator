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
    <h2 class="text-2xl text-darkblue font-semibold mb-1">View Activity Type</h2>
    <!-- TODO alphabetize the list or sort options? -->
    <div class="mt-0 mb-3 text-xl">
        <h3 class="font-semibold text-2xl"><i class="<?= h($activityType->image_path) ?> text-2xl mr-2" aria-hidden="true"></i><?= h($activityType->name) ?></h3>
        <?= $activityType->description; ?>
    </div>
    <div class="mt-2">
        <a title="View this activity type" href="/activity-types/" class="mb-3 inline-block px-3 py-1 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg">
            View All Types
        </a>
        <?= $this->Html->link(('Edit'), ['controller' => 'ActivityTypes', 'action' => 'edit', $activityType->id], ['class' => 'mt-3 mb-5 inline-block px-3 py-1 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
    </div>


    <ul class="pl-8 list-disc">
        <?php foreach ($activities as $activity) : ?>
            <li class="px-2"><?= $this->Html->link(($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></li>
        <?php endforeach ?>
    </ul>
</div>
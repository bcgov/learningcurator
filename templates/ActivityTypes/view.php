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
        </span></h2>
    <!-- TODO alphabetize the list or sort options? -->
    <div class="my-2 text-xl"><?= $activityType->description; ?></div>
    <ul class="pl-8 list-disc">
        <?php foreach ($activities as $activity) : ?>
            <li class="px-2"><?= $this->Html->link(($activity->name), ['controller' => 'Activities', 'action' => 'view', $activity->id]) ?></li>
        <?php endforeach ?>
    </ul>
</div>
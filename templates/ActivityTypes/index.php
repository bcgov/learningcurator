<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType[]|\Cake\Collection\CollectionInterface $activityTypes
 */
$count = 0;
?>
<script>
    function componentToHex(c) {
        var hex = c.toString(16);
        return hex.length == 1 ? "0" + hex : hex;
    }

    function rgbToHex(r, g, b) {
        return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
    }

    //alert(rgbToHex(0, 51, 255)); // #0033ff
</script>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Activity Types</h2>
    <div class="max-w-prose">

        <?php foreach ($activityTypes as $type) : ?>
            <div class="mt-3">

                <h3 class="text-xl font-semibold mb-1">
                    <i class="<?= h($type->image_path) ?> text-2xl mr-2" aria-hidden="true"></i><?= h($type->name) ?>
                </h3>

                <p class="mb-2"><?= h($type->description) ?></p>

                <div class="mt-2">
                    <a title="View this activity type" href="/activity-types/view/<?= $type->id ?>" class="mb-3 inline-block px-3 py-1 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg">
                        View
                    </a>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $type->id], ['class' => 'mb-3 inline-block px-3 py-1 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
                </div>

            </div>
        <?php endforeach ?>
    </div>
</div>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Your Contributions');
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

    <h2 class="text-2xl text-darkblue font-semibold"><?= __('My Contributions') ?></h2>

    <?php if (!$pathways->all()->isEmpty()) : ?>
        <h3 class="mt-4 font-semibold text-xl">My Pathways</h3>
        <?php foreach ($pathways as $pathway) : ?>
            <div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">

                <div>
                    <a href="/pathways/<?= h($pathway->slug) ?>" class="font-weight-bold">
                        <i class="bi bi-pin-map-fill"></i>
                        <?= h($pathway->name) ?>
                    </a>
                </div>
                <div>
                    <span class=""><?= $pathway->status->name ?></span> in
                    <?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id], ['class' => '']) ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
            <p><strong>You have yet to contribute any pathways.</strong></p>
            <p>If you want to work with us, we're always looking for help!</p>
        </div>
    <?php endif ?>

    <?php if (!$activities->all()->isEmpty()) : ?>
        <h3 class="mt-4 font-semibold text-xl">My Activities</h3>
        <div class="lg:columns-2 gap-4">
            <?php foreach ($activities as $a) : ?>
                <div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
                    <div>
                        <i class="bi <?= $a->activity_type->image_path ?>"></i>
                        <a href="/activities/view/<?= $a->id ?>" class="font-weight-bold"><?= h($a->name) ?></a>
                    </div>
                    <?= $a->status->name ?>
                    <?php if (!empty($a->steps)) : ?> in <?php endif ?>
                    <?php foreach ($a->steps as $step) : ?>
                        <?php if (!empty($step->pathways[0]->slug)) : ?>
                            <a href="/pathways/<?= h($step->pathways[0]->slug) ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
                                <?= h($step->pathways[0]->name) ?> - <?= h($step->name) ?>
                            </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
    <?php else : ?>
        <div class="p-3 mb-2 bg-white dark:bg-slate-800 rounded-lg">
            <p><strong>You have yet to contribute any activities.</strong></p>
            <p>If you want to work with us, we're always looking for help!</p>
            </p>
        </div>
    <?php endif ?>
</div>


</div>
</div>
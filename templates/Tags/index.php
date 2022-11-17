<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">All Activity Tags</h2>
    <p class="text-xl">Click on any tag to see its description and the activities tagged with it.</p>
<!-- Can this be alphabetical - would need to pull from database that way through the controller-->
    <ul class="list-disc pl-8 mt-2">
        <?php foreach ($tags as $tag) : ?>
            <li class="px-2"> <?= $this->Html->link(h($tag->name), ['action' => 'view', $tag->id]) ?>
            </li>
        <?php endforeach ?>
</div>
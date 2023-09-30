<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic[]|\Cake\Collection\CollectionInterface $topics
 */
?>
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-2 px-2" style="background-image: url(/img/categories/1200w/Path_at_French_Beach_BC_Canada_-_panoramio_1200w.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Topics</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://commons.wikimedia.org/wiki/File:Path_at_French_Beach_BC_Canada_-_panoramio.jpg">Path at French Beach</a> by MaryConverse via Wikimedia Commons (<a href="https://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>)</p>
</header>

<p class="m-3">
    Topics align with the 
    <a href="https://learningcentre.gww.gov.bc.ca/learninghub/what-is-corp-learning-framework/" target="_blank" rel="noopener">
        Corporate Learning Framework
    </a>.
</p>
<div class="grid grid-cols-2 gap-2">
<?php foreach ($topics as $topic) : ?>
<div class="p-2 m-3 bg-slate-50">
    <h2 class="text-xl"><a href="/topic/<?= h($topic->slug) ?>"><?= h($topic->name) ?></a></h2>
    <div>
        <?= h($topic->description) ?>
    </div>
</div>
<?php endforeach; ?>
</div>
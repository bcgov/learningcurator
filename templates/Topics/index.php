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

<p class="m-5">
    Topics align with the 
    <a href="https://learningcentre.gww.gov.bc.ca/learninghub/what-is-corp-learning-framework/" target="_blank" rel="noopener">
        Corporate Learning Framework.
    </a>
</p>
<div class="grid grid-cols-2 gap-4 m-4">
<?php foreach ($topics as $topic) : ?>
<div class="">
    <div>
        <a href="/topic/<?= h($topic->slug) ?>" class="block text-xl pl-2 pr-3 py-2 mb-3 mt-8 bg-bluegreen text-white hover:bg-bluegreen/80  w-full rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag inline-block mr-1" viewBox="0 0 16 16">
                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
            </svg>
            <?= h($topic->name) ?>
        </a>
    </div>
    <div class="px-3">
        <?= h($topic->description) ?>
        <div class="mt-3 font-bold">
            <a href="/topic/<?= h($topic->slug) ?>">
                <?php echo count($topic->pathways) ?> Pathways
            </a>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
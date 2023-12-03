<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic[]|\Cake\Collection\CollectionInterface $topics
 */
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-2 px-2" style="background-image: url(/img/categories/1200w/Path_at_French_Beach_BC_Canada_-_panoramio_1200w.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Topics</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://commons.wikimedia.org/wiki/File:Path_at_French_Beach_BC_Canada_-_panoramio.jpg">Path at French Beach</a> by MaryConverse via Wikimedia Commons (<a href="https://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>)</p>
</header>
<div class="p-8 pt-4 w-full text-lg" id="mainContent">
<p class="text-lg">
    Topics align with the 
    <a href="https://learningcentre.gww.gov.bc.ca/learninghub/what-is-corp-learning-framework/" target="_blank" rel="noopener" class="underline">
        Corporate Learning Framework.
    </a>
</p>
<div class="flex flex-col lg:flex-row lg:gap-4 w-full">
<div class="order-last lg:order-first">
<?php foreach ($topics as $topic) : ?>
    <details class="mb-2 p-3 bg-slate-100 rounded-lg w-full">
        <summary>
            <?= h($topic->name) ?>
            <?php if($topic->featured == 1): ?>
                <span class="inline-block px-3 text-sm bg-white rounded-lg">Published</span>
            <?php endif ?>
        </summary>
        <div>
            <?= h($topic->description) ?>
        </div>
        <div class="my-3 p-3 bg-white rounded-lg">
            Topic Manager: 
            <a href="/users/view/<?= $topic->user->id ?>">
                <?= $topic->user->username ?>
            </a>
        </div>
        <div class="m-3 p-3 bg-white rounded-lg">
        <?php foreach($topic->pathways as $path): ?>
            <details>
                <summary><?= $path->name ?></summary>
                <?php foreach($path->steps as $step): ?>
                    <div><?= $step->name ?></div>
                    <div><?= $step->description ?></div>
                <?php endforeach ?>
            </details>
        <?php endforeach ?>
        </div>
    </details>

<?php endforeach; ?>
</div>
</div>
</div>
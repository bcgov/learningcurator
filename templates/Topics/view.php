<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-8 px-8" style="background-image: url(/img/categories/Path_in_Sumallo_Grove-compressed.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Categories</h1>
    </div>
</header>
<!-- TODO should this be Pathways or Categories label here? -->


<div class="p-8 pt-4 w-full text-xl">
    <nav class="mb-4 text-sagedark text-sm" aria-label="breadcrumb">
        <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'], ['class' => '']) ?> /
        <a href="/category/<?= h($topic->categories[0]->id) ?>/<?= h($topic->categories[0]->slug) ?>"><?= h($topic->categories[0]->name) ?></a> /
        <?= h($topic->name) ?>
    </nav>
    <?php if ($role == 'curator' || $role == 'superuser') : ?>
        <div class="p-4 float-right">
            <?= $this->Html->link(__('Edit Topic'), ['action' => 'edit', $topic->id], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
            <!-- <a href="/pathways/import/<?= $topic->id ?>">Import a Pathway</a> -->
        </div>


    <?php endif ?>

    <div class="max-w-prose">
        <h2 class="text-2xl text-darkblue font-semibold mb-3"> <?= h($topic->name) ?></h2>
        <?= $this->Text->autoParagraph(h($topic->description)); ?>
        <?php if ($role == 'curator' || $role == 'superuser') : ?>

            <form method="GET" action="/pathways/import/<?= $topic->id ?>" class="mt-3 mb-5">
                <input type="text" name="pathimportfile" id="pathimportfile" class="inline-block px-4 py-2 text-md bg-slate-200 hover:border-bg-slate-700 focus:outline focus:shadow-outline hover:no-underline rounded-lg">
                <input type="submit" value="Import Pathway" class="inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg">
            </form>

        <?php endif ?>



        <?php foreach ($topic->pathways as $pathway) : ?>
            <?php if ($pathway->status_id == 2) : ?>


            
                    
                <div class="p-3 my-3 bg-bluegreen text-white inline-block w-full rounded-l-full">
                    <h3 class="text-2xl">
                        <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-2" viewBox="0 0 16 16">
                                <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                            </svg>
                            <?= h($pathway->name) ?>
                        </a>
                    </h3>
                </div>
                <div class="p-4 text-lg bg-slate-100/80 dark:bg-slate-800 rounded-lg">
                    <?= h($pathway->description) ?>
                </div>
                <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                    View Pathway
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                    </svg>
                </a>
    </div>


<?php else : ?>
    <?php if ($role == 'curator' || $role == 'superuser') : ?>
        <div class="p-3 my-3 bg-white/80 rounded-lg shadow-sm dark:bg-slate-900/80 dark:text-white">
            <div class="badge badge-warning">DRAFT</div>
            <h2 class="text-2xl">
                <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
                        <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                        <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z" />
                    </svg>
                    <?= h($pathway->name) ?>
                </a>
            </h2>
            <div class="p-4 text-lg bg-slate-100/80 dark:bg-slate-800 rounded-lg">
                <?= h($pathway->description) ?>
            </div>
            <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                View Pathway
            </a>
        </div>
    <?php endif ?>
<?php endif ?>
<?php endforeach ?>
</div>
</div>
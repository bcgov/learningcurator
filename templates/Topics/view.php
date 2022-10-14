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


<div class="p-8 pt-4 w-full text-xl">
    <nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'], ['class' => '']) ?> >
        <a href="/category/<?= h($topic->categories[0]->id) ?>/<?= h($topic->categories[0]->slug) ?>"><?= h($topic->categories[0]->name) ?></a> >
        <?= h($topic->name) ?>
    </nav>
    <?php if ($role == 'curator' || $role == 'superuser') : ?>
        <div class="p-4 float-right">
            <?= $this->Html->link(__('Edit Topic'), ['action' => 'edit', $topic->id], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>

        </div>


    <?php endif ?>

    <div class="max-w-prose">

        <h2 class="text-2xl text-darkblue font-semibold mb-3"> <?= h($topic->name) ?></h2>
        <?= $this->Text->autoParagraph(h($topic->description)); ?>
        <?php if ($role == 'curator' || $role == 'superuser') : ?>

            <form method="GET" action="/pathways/import/<?= $topic->id ?>" class="mt-3 mb-4">
                <input type="text" name="pathimportfile" id="pathimportfile" class="inline-block px-4 py-2 text-md bg-slate-200 hover:border-bg-slate-700 focus:outline focus:shadow-outline hover:no-underline rounded-lg">
                <input type="submit" value="Import Pathway" class="inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg">
            </form>

        <?php endif ?>

    </div>
    <div class="flex flex-col lg:flex-row lg:gap-4 w-full">
        <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
            <!-- TODO Nori add mobile collapse options -->
            <?php foreach ($topic->pathways as $pathway) : ?>
                <?php if ($pathway->status_id == 2) : ?>
                    <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>" class="hover:no-underline">
                        <div class="p-3 mb-3 mt-8 bg-bluegreen text-white  hover:bg-bluegreen/80  w-full rounded-l-full flex items-center justify-between">
                            <h3 class="text-2xl ">

                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-3" viewBox="0 0 16 16">
                                    <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                                </svg><?= h($pathway->name) ?>

                            </h3>
                            <!-- <span class="text-sm">8 steps | 23 activities</span> -->

                            <!-- TODO Allan eventually add code to pull in steps/activities -->
                        </div>
                    </a>
                    <div class="pl-10 text-lg">
                        <p><?= h($pathway->description) ?></p>

                        <p> <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>" class="text-sky-700 underline">
                                View the <strong><?= h($pathway->name) ?></strong> pathway
                            </a></p>
                    </div>



                <?php else : ?>
                    <?php if ($role == 'curator' || $role == 'superuser') : ?>
                        <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>" class="hover:no-underline">
                            <div class="p-3 mb-3 mt-8 bg-bluegreen text-white  hover:bg-bluegreen/80 w-full rounded-l-full">

                                <h3 class="text-2xl flex items-center justify-start">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-3 flex-none" viewBox="0 0 16 16">
                                        <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                                    </svg><span class="flex-1 items-center"><?= h($pathway->name) ?> <span class="bg-orange-400 text-white text-xs rounded-full px-2 py-1 mx-2 align-middle">DRAFT</span></span>
                                    <span class="text-sm justify-self-end flex-none">8 steps | 23 activities</span>
                                </h3>
                            </div>
                        </a>
                        <div class="pl-10 text-lg">

                            <?= h($pathway->description) ?>
                            <p> <a href="/<?= h($topic->categories[0]->slug) ?>/<?= $topic->slug ?>/pathway/<?= h($pathway->slug) ?>" class="text-sky-700 underline">
                                    View the <strong><?= h($pathway->name) ?></strong> pathway
                                </a> </p>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </div> <!-- formatting container -->

        <!-- sort options appear to the side on larger screens, but on top on smaller screens -->
        <div class="lg:mt-8 lg:basis-1/5">
            <div class="flex justify-end lg:justify-start gap-4 sticky top-4">
                <!-- TODO Allan add working sort and filter options -->
                <a href="" class="hover:text-sky-700">
                    <div class="flex flex-col justify items-center gap-1">

                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                            <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3z" />
                        </svg>
                        <p class="text-xs text-center">List View</p>

                    </div>
                </a>
                <a href="" class="hover:text-sky-700">
                    <div class="flex flex-col justify items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z" />
                        </svg>
                        <p class="text-xs text-center">Grid View</p>
                    </div>
                </a>
                <a href="" class="hover:text-sky-700">
                    <div class="flex flex-col justify items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                        </svg>
                        <p class="text-xs text-center">Filter</p>
                    </div>
                </a>
                <a href="" class="hover:text-sky-700">
                    <div class="flex flex-col justify items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                            <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                        </svg>
                        <p class="text-xs text-center">Sort</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;

if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
$pagetitle = $category->name . '';
$this->assign('title', $pagetitle);
?>
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-8 px-8" style="background-image: url(/img/categories/1200w/Path_in_Sumallo_Grove-compressed_1200w.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Categories</h1>
    </div>
</header>
<?php if ($role == 'curator' || $role == 'superuser') : ?>
    <div class="p-4 float-right">
        <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'inline-block px-4 py-2 text-md text-white bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg mr-2']) ?>
        <?= $this->Html->link(__('Add Topic'), ['controller' => 'Topics', 'action' => 'add'], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
    </div>
<?php endif;  // curator or admin? 
?>
<div class="p-8 pt-4 w-full text-xl">
    <nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'], ['class' => '']) ?> >
        <?= h($category->name) ?>
    </nav>

    <div class="max-w-prose">
        <h2 class="text-2xl text-darkblue font-semibold mb-3"> <?= h($category->name) ?></h2>
        <?= $this->Text->autoParagraph(h($category->description)); ?>
    </div>
    <div class="flex flex-col lg:flex-row lg:gap-4">
        <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
            <!-- TODO Allan sort alphabetically as initial view? -->
            <!-- TODO Nori add mobile collapse options -->



            <?php if (!empty($category->topics)) : ?>
                <?php foreach ($category->topics as $topic) : ?>
                    <?php if ($topic->featured == 1) : ?>
                        <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="hover:no-underline group">
                            <div class="rounded-md shadow-lg p-0.5 bg-sky-700  group-hover:bg-sky-700/80 mb-4">
                                <h3 class="text-xl text-white p-2"><?= $topic->name ?>
                                    <!-- topic_id: <?= $topic->id ?> -->
                                </h3>
                                <div class="bg-white inset-1 rounded-b-sm">
                                    <div class="p-3 text-lg">
                                        <p class="mb-0"><?= h($topic->description) ?></p>
                                        <p class="mb-2 inline-block mt-4 hover:text-sky-600 underline text-sky-700 ">
Explore <strong><?= $topic->name ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </a> <!-- formatting container -->

                    <?php else : ?>
                        <?php if ($role == 'curator' || $role == 'superuser') : ?>
                            <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="hover:no-underline group">
                                <div class="rounded-md shadow-lg p-0.5 bg-sky-700  group-hover:bg-sky-700/80 mb-4">
                                <span class="bg-orange-400 text-white rounded-lg px-2 py-1 m-2 text-sm align-middle float-right" title="Edit to set to publish">DRAFT</span>
                                    <h3 class="text-xl text-white p-2 hover:no-underline "><?= $topic->name ?>
                                        <!-- topic_id: <?= $topic->id ?> -->
                                    </h3>
                                    <div class="bg-white inset-1 rounded-b-sm">
                                        <div class="p-3 text-lg">
                                            <p class="mb-0"><?= h($topic->description) ?></p>
                                            <p class="mb-2 inline-block mt-4 hover:text-sky-600 underline text-sky-700">
Explore <strong><?= $topic->name ?></strong></p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        <?php endif ?>
                    <?php endif ?>

                <?php endforeach ?>
            <?php endif; // topics 
            ?>

        </div>
        <!-- sort options appear to the side on larger screens, but on top on smaller screens -->
        <div class="lg:my-3 lg:basis-1/5">
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
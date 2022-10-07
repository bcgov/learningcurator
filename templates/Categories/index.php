<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
$this->assign('title', 'All topic areas');
$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;

if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-8 px-8" style="background-image: url(/img/categories/Path_in_Sumallo_Grove-compressed.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex"><span class="text-white text-3xl font-bold m-auto tracking-wide">Categories</span></div>
</header>

<div class="p-8 text-lg">
    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">TBD</h2>

        <p class="mb-3">
            Category intro text here</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-7 lg:gap-4">
        <div class="lg:col-span-5 max-w-prose order-last lg:order-first">
            <!-- TODO sort alphabetically? -->
            <?php foreach ($categories as $category) : ?>

                <div class="rounded-md shadow-lg border-2 border-sky-700 mb-4">

                    <?php if (empty($category->featured)) : ?>
                        <span class="inline-block py-0 px-2 my-2 bg-yellow-600 text-white text-xs" title="Edit to set to publish">DRAFT</span>
                    <?php endif ?>

                    <h1 class="text-2xl bg-sky-700 text-white p-3">
                        <?= h($category->name) ?>
                    </h1>
                    <div class="p-3">
                        <p class="mb-0"><?= h($category->description) ?></p>

                        <a class="inline-block p-3 mt-4 bg-sky-700 text-white text-xl hover:no-underline rounded-lg" href="/category/<?= $category->id ?>/<?= h($category->slug) ?>">
                            Explore <span class="font-bold"><?= h($category->name) ?></span>
                        </a>
                    </div>
                </div> <!-- formatting container -->
            <?php endforeach; ?>
        </div>
        <!-- sort options appear to the side on larger screens, but on top on smaller screens -->
        <div class="lg:my-3 lg:col-span-2">
            <div class="flex justify-start gap-4">
                <!-- TODO add working sort and filter options -->
                <a href="" class="hover:text-sky-700">
                    <div class="flex flex-col justify items-center gap-1">

                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                            <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3z" />
                        </svg>
                        <p class="text-xs text-center">List View</p>

                    </div>
                </a>
                <div class="flex flex-col justify items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                        <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3z" />
                    </svg>
                    <p class="text-xs text-center">List View</p>
                </div>
                <div class="flex flex-col justify items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                        <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3z" />
                    </svg>
                    <p class="text-xs text-center">List View</p>
                </div>
                <div class="flex flex-col justify items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                        <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3z" />
                    </svg>
                    <p class="text-xs text-center">List View</p>
                </div>

            </div>
        </div>

    </div>


</div><!--  -->
</div><!-- formatting container -->
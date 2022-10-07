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


</div><!--  -->
</div><!-- formatting container -->
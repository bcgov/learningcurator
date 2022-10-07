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

<div class="p-8 text-xl">
    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">TBD</h2>

        <p class="mb-3">
            Category intro text here</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-7 lg:gap-4">
        <div class="lg:col-span-5 max-w-prose order-last lg:order-first">

            <?php foreach ($categories as $category) : ?>

                <div class="rounded-lg shadow-lg border">
                    <div class="my-2 h-40 ">
                        <?php if (empty($category->featured)) : ?>
                            <span class="inline-block py-0 px-2 bg-yellow-600 text-white text-xs" title="Edit to set to publish">DRAFT</span>
                        <?php endif ?>

                        <h1 class="text-3xl">

                            <a class="block mt-6 p-3 bg-white/80 hover:bg-white text-black shadow-lg hover:no-underline" href="/category/<?= $category->id ?>/<?= h($category->slug) ?>">
                                <?= h($category->name) ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg>
                            </a>

                        </h1>

                        <!-- <div class="my-3">
    <?= h($category->description) ?>
</div> -->

                    </div> <!-- overlay color -->
                </div> <!-- formatting container -->
            <?php endforeach; ?>
        </div>
        <!-- sort options appear to the side on larger screens, but on top on smaller screens -->
        <div class="my-3 lg:col-span-2">
            Sort options
        </div>

    </div>


</div><!--  -->
</div><!-- formatting container -->
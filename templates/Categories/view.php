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
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-8 px-8" style="background-image: url(/img/categories/Path_in_Sumallo_Grove-compressed.jpg);">
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
        <div class="flex flex-col lg:flex-row lg:gap-4">
            <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
                <!-- TODO Allan sort alphabetically as initial view? -->
                <!-- TODO Nori add mobile collapse options -->



                <?php if (!empty($category->topics)) : ?>
                    <?php foreach ($category->topics as $topic) : ?>
                        <?php if ($topic->featured == 1) : ?>
                            <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="hover:no-underline">
                                <div class="rounded-md shadow-lg border-2 border-sky-700 hover:border-sky-700/80 mb-4">
                                    <h3 class="text-xl bg-sky-700 text-white p-2 hover:no-underline hover:bg-sky-700/80 "><?= $topic->name ?>
                                        <!-- topic_id: <?= $topic->id ?> -->


                                    </h3>
                                    <div class="p-3 text-lg">
                                        <p class="mb-0"><?= h($topic->description) ?></p>


                                    </div>
                                </div>
                            </a> <!-- formatting container -->

                        <?php else : ?>
                            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                                <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="hover:no-underline">
                                    <div class="rounded-md shadow-lg border-2 border-sky-700 hover:border-sky-700/80 mb-4">
                                        DRAFT
                                        <h3 class="text-xl bg-sky-700 text-white p-2 hover:no-underline hover:bg-sky-700/80 ">
                                            <!-- topic_id: <?= $topic->id ?> --><?= $topic->name ?>


                                        </h3>
                                        <div class="p-3 text-lg">
                                            <p class="mb-0"><?= h($topic->description) ?></p>


                                        </div>
                                    </div>
                                </a>

                            <?php endif ?>
                        <?php endif ?>

                    <?php endforeach ?>
                <?php endif; // topics 
                ?>

            </div>
        </div>
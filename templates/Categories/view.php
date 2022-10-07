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
    <nav class="mb-3 text-sagedark text-sm" aria-label="breadcrumb">
        <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'], ['class' => '']) ?> /
        <?= h($category->name) ?>
    </nav>


    <div class="max-w-prose">
        <h2 class="text-2xl text-darkblue font-semibold"> <?= h($category->name) ?></h2>

        <p>
            <?= $this->Text->autoParagraph(h($category->description)); ?></p>

        <?php if (!empty($category->topics)) : ?>
            <?php foreach ($category->topics as $topic) : ?>
                <?php if ($topic->featured == 1) : ?>
                    <div class="my-3">
                        <h3 class="text-2xl text-sky-700 mb-2 border-b-2 border-sky-700 block">
                            <!-- topic_id: <?= $topic->id ?> -->
                            <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="hover:no-underline hover:bg-slate-100 hover:p-2 hover:rounded-t-lg block">
                                <?= $topic->name ?>
                            </a>
                        </h3>

                        <div class="mb-4 text-lg pl-3">
                            <?= $topic->description ?>

                        </div>

                    </div>
                <?php else : ?>
                    <?php if ($role == 'curator' || $role == 'superuser') : ?>
                        <div class="my-3">
                            DRAFT
                            <h3 class="text-2xl text-sky-700 mb-2 border-b-2 border-sky-700 block">
                                <!-- topic_id: <?= $topic->id ?> -->
                                <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>">
                                    <?= $topic->name ?>

                                </a>
                            </h3>

                            <div class="mb-4 text-lg pl-3">
                                <?= $topic->description ?>
                            </div>

                        </div>
                    <?php endif ?>
                <?php endif ?>

            <?php endforeach ?>
        <?php endif; // topics 
        ?>

    </div>
</div>
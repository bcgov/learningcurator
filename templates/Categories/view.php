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
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex"><span class="text-white text-3xl font-bold m-auto tracking-wide">Categories</span></div>
</header>
<?php if ($role == 'curator' || $role == 'superuser') : ?>
        <div class="p-4 float-right">
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'inline-block px-4 py-2 text-md text-white bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg mr-2']) ?>
            <?= $this->Html->link(__('Add Topic'), ['controller' => 'Topics', 'action' => 'add'], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
        </div>
    <?php endif;  // curator or admin? 
    ?>
<div class="p-8 pt-4 w-full">




    <nav class="mb-3 p-2 text-sagedark text-sm" aria-label="breadcrumb">
        <?= $this->Html->link(__('Categories'), ['controller' => 'Categories', 'action' => 'index'], ['class' => '']) ?> /
        <?= h($category->name) ?>
    </nav>

    <div class="my-3 p-3 bg-white/80 rounded-lg">
        <h1 class="text-4xl">
            <?= h($category->name) ?>
        </h1>
        <div class="p-3 mb-2 text-xl bg-white rounded-lg">
            <?= $this->Text->autoParagraph(h($category->description)); ?>
        </div>
    </div>

    <?php if (!empty($category->topics)) : ?>
        <?php foreach ($category->topics as $topic) : ?>


            <?php if ($topic->featured == 1) : ?>
                <div class="p-3 my-3 bg-white/80 rounded-lg">
                    <h2 class="text-3xl">
                        <!-- topic_id: <?= $topic->id ?> -->
                        <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>">
                            <?= $topic->name ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg>
                        </a>
                    </h2>

                    <div class="p-3 mb-2 text-xl bg-white rounded-lg">
                        <?= $topic->description ?>
                    </div>
                    <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                        View Topic
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </a>
                </div>
            <?php else : ?>
                <?php if ($role == 'curator' || $role == 'superuser') : ?>
                    <div class="p-3 my-3 bg-white/80 rounded-lg">
                        DRAFT
                        <h2 class="text-3xl">
                            <!-- topic_id: <?= $topic->id ?> -->
                            <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>">
                                <?= $topic->name ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg>
                            </a>
                        </h2>

                        <div class="p-3 mb-2 text-xl bg-white rounded-lg">
                            <?= $topic->description ?>
                        </div>
                        <a href="/category/<?= h($category->id) ?>/<?= h($category->slug) ?>/topic/<?= $topic->id ?>/<?= $topic->slug ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                            View Topic
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg>
                        </a>
                    </div>
                <?php endif ?>
            <?php endif ?>

        <?php endforeach ?>
    <?php endif; // topics 
    ?>

</div>
</div>
</div>
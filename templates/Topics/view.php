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
$followcount = 0;
?>
<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-2 px-2" style="background-image: url(/img/categories/1200w/Path_at_French_Beach_BC_Canada_-_panoramio_1200w.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Topic</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://commons.wikimedia.org/wiki/File:Path_at_French_Beach_BC_Canada_-_panoramio.jpg">Path at French Beach</a> by MaryConverse via Wikimedia Commons (<a href="https://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>)</p>
</header>
<?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
    <div class="p-4 float-right">
        <?= $this->Html->link(__('Edit Topic'), ['action' => 'edit', $topic->id], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
        <?= $this->Html->link(__('Add Pathway'), ['controller' => 'Pathways', 'action' => 'add'], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
    </div>
<?php endif;  // curator or admin? ?>

<div class="p-8 pt-4 w-full text-lg" id="mainContent">
    <nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <?= $this->Html->link(__('All Topics'), ['controller' => 'Topics', 'action' => 'index'], ['class' => '']) ?> >
        <?= h($topic->name) ?>
    </nav>






    <?php if ($role == 'manager' || $role == 'superuser') : ?>
    <!-- <form class="my-2" method="get" action="/pathways/import/<?= h($topic->id) ?>">
        <input type="text" name="importcode" id="importcode" class="bg-slate-100 p-2" placeholder="Paste import code here">
        <button class="bg-emerald-600 text-white p-2">Publish New Pathway</button>
        <div class="text-sm">
            When you clicked "Publish" in the development environment 
            you were given a code.<br>
            Please paste that code in the field
            above and click the Publish New Pathway button to bring your
            pathway over and fully publish it here.
        </div>
    </form> -->
    <?php endif;  // curator or admin? ?>






    <div class="max-w-prose">

        <h2 class="text-2xl text-darkblue font-semibold mb-3"> <?= h($topic->name) ?></h2>
        <div class="text-xl autop"><?= $this->Text->autoParagraph(h($topic->description)); ?></div>
        <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
        <div class="my-3 p-3 bg-slate-100 rounded-lg">
            Topic Manager: 
            <a href="/users/view/<?= $topic->user->id ?>">
                <?= $topic->user->username ?>
            </a>
        </div>
        <?php endif ?>
    </div>
    <div class="flex flex-col lg:flex-row lg:gap-4 w-full">
        <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
            <!-- TODO Nori add mobile collapse options -->
            
            <?php foreach ($topic->pathways as $pathway) : ?>
                <?php if(!empty($pathway->users)): ?>
                <?php foreach($pathway->users as $u) { $followcount++; } ?>
                <?php endif ?>
                <?php if ($pathway->status_id == 2) : ?>
                    <a href="/topic/<?= $topic->slug ?>/<?= h($pathway->id) ?>/<?= h($pathway->slug) ?>" class="hover:no-underline">
                        <!-- <a href="/a/<?= h($pathway->slug) ?>" class="hover:no-underline"> -->
                            <div class="pl-2 pr-3 py-2 mb-3 mt-8 bg-bluegreen text-white  hover:bg-bluegreen/80  w-full rounded-lg flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-3 flex-none" viewBox="0 0 16 16">
                                    <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                                </svg>
                                <h3 class="text-2xl flex-1">
                                    <?= h($pathway->name) ?>
                                </h3>
                                <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                                <div><?= $followcount ?> followers</div>
                                <?php endif ?>
                            <!-- <span class="text-sm ml-3 justify-self-end flex-none"><?= h($pathway->stepcount) ?> steps | <?= h($pathway->requiredacts) ?> activities</span> -->


                            <!-- TODO Allan eventually add code to pull in steps/activities -->
                        </div>
                    </a>
                    <div class="pl-10">
                        <div class="autop"><?= $this->Text->autoParagraph(h($pathway->description)); ?></div>
                        <p class="mb-4"> 
                            <a href="/topic/<?= $topic->slug ?>/<?= h($pathway->id) ?>/<?= h($pathway->slug) ?>" class="text-sky-700 underline">
                            <!-- <a href="/a/<?= h($pathway->slug) ?>" class="text-sky-700 underline"> -->
                                View the <strong><?= h($pathway->name) ?></strong> pathway
                            </a></p>
                    </div>



                <?php else : ?>
                    <?php if ($role == 'curator' || $role == 'manager' || $role == 'superuser') : ?>
                        <a href="/topic/<?= $topic->slug ?>/<?= h($pathway->id) ?>/<?= h($pathway->slug) ?>" class="hover:no-underline">
                            <div class="pl-2 pr-3 py-2 mb-3 mt-8 bg-bluegreen text-white  hover:bg-bluegreen/80  w-full rounded-lg flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-3 flex-none" viewBox="0 0 16 16">
                                    <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                                </svg>
                                <h3 class="text-2xl flex-1">
                                    <?= h($pathway->name) ?>
                                </h3>
                                <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-1 text-sm align-middle" title="Edit to set to publish">DRAFT</span>
                            </div>
                        </a>
                        <div class="pl-10">

                            <div class="autop"><?= $this->Text->autoParagraph(h($pathway->description)); ?></div>

                            <p class="mb-4"> <a href="/topic/<?= $topic->slug ?>/<?= h($pathway->id) ?>/<?= h($pathway->slug) ?>" class="text-sky-700 underline">
                                    View the <strong><?= h($pathway->name) ?></strong> pathway
                                </a> </p>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <?php $followcount = 0 ?>
            <?php endforeach ?>
            
        </div> <!-- formatting container -->

        <!-- sort options appear to the side on larger screens, but on top on smaller screens -->
        <!-- #TODO come back to this when there's more capacity to implement properly
        <div class="lg:mt-8 lg:basis-1/5">
            <div class="flex justify-end lg:justify-start gap-4 top-4">
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
        </div>-->
    </div>
</div>
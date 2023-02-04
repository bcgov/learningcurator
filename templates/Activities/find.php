<?php

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role_id');
    $uid = $this->Identity->get('id');
}

?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Searching Curator for &quot;<?= $search ?>&quot;</h1>
</header>
<div class="p-8">
    <?php if (!$numcats && !$numpaths && !$numacts) : ?>
        <div class="mb-3 bg-gray-100 p-3 border-2 rounded-lg">No results found.</div>

        <form method="get" action="/find" class="w-fit flex" role="search">
            <label for="search" class="sr-only">Search</label>
            <input x-ref="input" placeholder="Search again" required class="w-40 bg-white text-sm text-slate-700 rounded-l-md ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-700" type="search" aria-label="Search" name="search" id="search">
            <button title="Click here or press Enter to search" class="bg-white text-sm leading-6 text-slate-700 ring-1 ring-slate-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-slate-700 rounded-r-lg" type="submit">
                <svg width="24" height="24" fill="none" aria-hidden="true" class="flex-none">
                    <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                </svg>
            </button>
        </form>
    <?php endif ?>
    <div class="flex flex-col">

        <?php if ($numcats === 1) : ?>
            <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numcats ?></span> category</h2>
            <?php foreach ($categories as $c) : ?>
                <div class="flex flex-row justify-start mt-3 mb-0">
                    <i class="bi bi-folder mr-2 flex-none" style="font-size: 1.25rem; color: rgb(3 105 161);" aria-label="Category"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-xl text-sky-700 ">
                            <a href="/categories/view/<?= $c->id ?>">
                                <?= $c->name ?>
                            </a>
                        </h3>
                        <p class="line-clamp-4 mb-0"><?= $this->Text->autoParagraph(h($c->description)); ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numcats ?></span> category</h2>
            <?php foreach ($categories as $c) : ?>
                <div class="flex flex-row justify-start first:mt-0 mt-3 last:mb-0">
                    <i class="bi bi-folder mr-2 flex-none" style="font-size: 1.25rem; color: rgb(3 105 161);" aria-label="Category"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-xl text-sky-700 ">
                            <a href="/categories/view/<?= $c->id ?>">
                                <?= $c->name ?>
                            </a>
                        </h3>
                        <p class="line-clamp-4 mb-0"><?= $this->Text->autoParagraph(h($c->description)); ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>



        <?php if ($numpaths === 1) : ?>
            <h2 class="text-2xl mt-5">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numpaths ?></span> pathway</h2>
            <?php foreach ($pathwaywithsteps as $p) : ?>
                <!-- <pre><?php print_r($p) ?></pre> -->
                <div class="flex flex-row justify-start mt-3 last:mb-0">
                    <i class="bi bi-signpost-2 mr-2 flex-none" style="font-size: 1.25rem; color: rgb(3 105 161);" aria-label="Pathway"></i>
                    <div class="flex-1">
                        <h3 class="text-sky-700 text-xl font-semibold ">
                            <a href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>">
                                <?= $p[0]['name'] ?>
                            </a>
                        </h3>
                        <p class="line-clamp-3 "><?= h($p[0]['goal']) ?></p>
                        <!-- <div><?= $p[0][5] ?></div> -->
                        <?php foreach ($p[1] as $step) : ?>
                            &bull;<a class="px-1" href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>/s/<?= $step['id'] ?>/<?= $step['slug'] ?>"><?= $step['name'] ?></a>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <h2 class="text-2xl mt-5">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numpaths ?></span> pathways</h2>
            <?php foreach ($pathwaywithsteps as $p) : ?>
                <!-- <pre><?php print_r($p) ?></pre> -->
                <div class="flex flex-row justify-start mt-3 last:mb-0">
                    <i class="bi bi-signpost-2 mr-2 flex-none" style="font-size: 1.25rem; color: rgb(3 105 161);" aria-label="Pathway"></i>
                    <div class="flex-1">
                        <h3 class="text-sky-700 text-xl font-semibold ">
                            <a href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>">
                                <?= $p[0]['name'] ?>
                            </a>
                        </h3>
                        <p class="line-clamp-3 mb-1"><?= h($p[0]['goal']) ?></p>
                        <!-- <div><?= $p[0][5] ?></div> -->
                        <?php foreach ($p[1] as $step) : ?>
                            &bull;<a class="px-1" href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>/s/<?= $step['id'] ?>/<?= $step['slug'] ?>"><?= $step['name'] ?></a>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>


        <?php if ($numacts === 1) : ?>
            <h2 class="text-2xl mt-5">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numacts ?></span> activity</h2>
            <?php
            //echo '<pre>';
            foreach ($activities as $activity) :
                //print_r($activity); continue;
            ?>
                <div class="flex flex-row justify-start mt-3">
                    <i class="<?= h($activity->activity_type->image_path) ?> flex-none mr-2" style="font-size: 1.25rem;" aria-label="<?= h($activity->activity_type->name) ?>"></i>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold">
                            <a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
                            <?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) 
                            ?>
                        </h3>
                        <p class="line-clamp-2 mb-0"><?= $this->Text->autoParagraph(h($activity->description)); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <h2 class="text-2xl mt-5">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numacts ?></span> activities</h2>
            <?php
            //echo '<pre>';
            foreach ($activities as $activity) :
                //print_r($activity); continue;
            ?>
                <div class="flex flex-row justify-start mt-3">
                    <i class="<?= h($activity->activity_type->image_path) ?> flex-none mr-2" style="font-size: 1.25rem;" aria-label="<?= h($activity->activity_type->name) ?>"></i>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold">
                            <a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
                            <?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) 
                            ?>
                        </h3>
                        <p class="line-clamp-2 mb-1 last:mb-0"><?= $this->Text->autoParagraph(h($activity->description)); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div> <!-- /.row -->
</div> <!-- /.container -->
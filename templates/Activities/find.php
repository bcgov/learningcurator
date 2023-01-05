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
<div class="p-6">
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
            <div class="p-3">
                <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numcats ?></span> category</h2>
                <ul class="list-disc pl-8 mt-2">
                    <?php foreach ($categories as $c) : ?>
                        <li class="text-xl px-2">
                            <a href="/categories/view/<?= $c->id ?>">
                                <?= $c->name ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php else : ?>
            <div class="p-3">
                <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numcats ?></span> categories</h2>
                <ul class="list-disc pl-8 mt-2">
                <?php foreach ($categories as $c) : ?>
                    <li class="text-xl px-2">
                        <a href="/categories/view/<?= $c->id ?>">
                            <?= $c->name ?>
                        </a>
                    </li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>



        <?php if ($numpaths === 1) : ?>
            <div class="p-3">
                <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numpaths ?></span> pathways</h2>
                <?php foreach ($pathwaywithsteps as $p) : ?>
                    <!-- <pre><?php print_r($p) ?></pre> -->
                    <div class="p-3 mb-1">
                        <h3 class="text-bluegreen text-xl">
                            <i class="bi bi-signpost-2"></i> <a href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>">
                                <?= $p[0]['name'] ?>
                            </a>
                        </h3>
                        <!-- <div><?= $p[0][5] ?></div> -->
                        <div class="ml-6">
                            <?php foreach ($p[1] as $step) : ?>
                                &bull;<a class="px-1" href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>/s/<?= $step['id'] ?>/<?= $step['slug'] ?>">
                                    <?= $step['name'] ?>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else : ?>
            <div class="p-3">
                <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numpaths ?></span> pathways</h2>
                <?php foreach ($pathwaywithsteps as $p) : ?>
                    <!-- <pre><?php print_r($p) ?></pre> -->
                    <div class="p-3 mb-1">
                        <h3 class="text-bluegreen text-xl">
                            <i class="bi bi-signpost-2"></i> <a href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>">
                                <?= $p[0]['name'] ?>
                            </a>
                        </h3>
                        <!-- <div><?= $p[0][5] ?></div> -->
                        <div class="ml-6">
                            <?php foreach ($p[1] as $step) : ?>
                                &bull;<a class="px-1" href="/<?= $p[0]['category'] ?>/<?= $p[0]['topic'] ?>/pathway/<?= $p[0]['slug'] ?>/s/<?= $step['id'] ?>/<?= $step['slug'] ?>">
                                    <?= $step['name'] ?>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>


        <?php if ($numacts === 0) : ?>
            <div class="p-3">
                <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numacts ?></span> activities</h2>
                <ul class="list-disc pl-8 mt-2">
                <?php
                //echo '<pre>';
                foreach ($activities as $activity) :
                    //print_r($activity); continue;
                ?>
                    <li class="text-xl px-2">
                            <a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
                            <?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) 
                            ?>
                        </li>
                        <!-- <div class="py-3 ">
		<?= $activity->description ?>
	</div> -->
                <?php endforeach; ?>
                </ul>
            </div>
        <?php else : ?>
            <div class="p-3">
                <h2 class="text-2xl">Found <span class="bg-sky-700 text-white rounded-lg text-lg inline-block px-2"><?= $numacts ?></span> activities</h2>
                <ul class="list-disc pl-8 mt-2">
                <?php
                //echo '<pre>';
                foreach ($activities as $activity) :
                    //print_r($activity); continue;
                ?>
                    <li class="text-xl px-2">
                            <a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a>
                            <?php //$this->Html->link($activity->name, ['action' => 'view', $activity->id]) 
                            ?>
                        </li>
                        <!-- <div class="py-3 ">
		<?= $activity->description ?>
	</div> -->
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif ?>
    </div> <!-- /.row -->
</div> <!-- /.container -->
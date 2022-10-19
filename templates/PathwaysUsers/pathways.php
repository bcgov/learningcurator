<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Pathways you follow');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>




<?php if (!$pathways->isEmpty()) : ?><header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed.jpg);">
        <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg p-4 flex">
            <h1 class="text-white text-3xl font-bold m-auto tracking-wide">My Curator</h1>
        </div>
    </header>
    <!-- TODO Q should the title be followed pathways? My Curator? -->
    <div class="p-8 text-lg">
        <div class="max-w-prose">
            <h2 class="mb-3 text-2xl text-darkblue font-semibold">Followed Pathways</h2>

            <p class="mb-3">
            When you follow a pathway, it will be listed here, so you can jump right to it.</p>
        </div>
<!-- TODO Q do we want to have sort/filter options here? -->
        <?php foreach ($pathways as $path) : ?>

            <div class="rounded-md  bg-bluegreen hover:bg-bluegreen/80 mb-4 p-0.5">
                    <div class="flex flex-row justify-between">

                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-signpost-2 mx-3 my-4 flex-none" viewBox="0 0 16 16">
                            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                        </svg>


                        <div class="bg-white inset-1 rounded-r-sm flex-1">
                            <div class="p-3 text-lg">
                                <a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= h($pathway->topic->slug) ?>/pathway/<?= h($pathway->slug) ?>" class="hover:no-underline">
                                    <h3 class="text-xl text-bluegreen font-bold hover:no-underline "> <?= h($pathway->name) ?>
                                    </h3>
                                </a>
                                <!-- <span class="text-sm ml-3 justify-self-end flex-none">8 steps | 23 activities</span> -->
                                <div class="flex justify-between items-center text-xs text-slate-500 mt-2 mb-3">
                                    <?php
                                    $stat = 'bg-slate-200';
                                    if ($pathway->status->name == 'Draft') $stat = 'bg-orange-400 text-white';
                                    ?>
                                    <?php if ($pathway->featured == 1) : ?>
                                        <span class="bg-green-600 text-white py-1 px-2 rounded-full mr-3">Featured</span>
                                    <?php endif ?>
                                    <span class="<?= $stat ?> py-1 px-2 rounded-full mr-3"><?= $pathway->status->name ?></span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag inline-block" viewBox="0 0 16 16">
                                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                            <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                                        </svg><?php $topiclink = $pathway->topic->categories[0]->name . ' > ' . $pathway->topic->name ?>
                                        <a href="/category/<?= $pathway->topic->categories[0]->id ?>/<?= $pathway->topic->categories[0]->slug ?>/topic/<?= $pathway->topic->id ?>/<?= $pathway->topic->slug ?>">
                                            <?= $topiclink ?>
                                        </a></span>
                                </div>

                                <p><?php if (!empty($pathway->description)) : ?>
                                        <?= h($pathway->description) ?>
                                    <?php else : ?>
                                        <?= h($pathway->objective) ?>
                                    <?php endif ?></p>
                                <!-- This conditional is kind of a hack and we need to make people aware that the description isn't actually optional -->
                                <p class="mb-2"> <a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= h($pathway->topic->slug) ?>/pathway/<?= h($pathway->slug) ?>" class="text-sky-700 underline">
                                        View the <strong><?= h($pathway->name) ?></strong> pathway</a>
                                </p>
                            </div>
                        </div>

                        <!-- TODO Allan require curators to enter descriptions and have a minimum/maximum length of 130 chars/ 325 chars (2 lines prose length/5 lines prose length) -->
                        <!-- TODO Shannon Q: objectives vs descriptions and when to use each -->
                    </div>
                </div>
            <div class="p-6 mb-3 w-full bg-center bg-no-repeat rounded-lg" style="background-image: url('<?= h($path->pathway->topic->categories[0]->image_path) ?>')">
                <div class="p-3 text-xl bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
                    <?php
                    echo $this->Form->postLink(
                        __('Un-Follow'),
                        ['controller' => 'PathwaysUsers', 'action' => 'delete/' . $path->id],
                        ['class' => 'float-right inline-block p-3 bg-sky-700 hover:bg-sky-800 text-white hover:no-underline rounded-lg', 'title' => 'Stop seeing your progress on this pathway', 'confirm' => __('')]
                    );
                    ?>

                    <a href="/category/<?= $path->pathway->topic->categories[0]->id ?>/<?= $path->pathway->topic->categories[0]->slug ?>"><?= $path->pathway->topic->categories[0]->name ?></a> /
                    <a href="/category/<?= $path->pathway->topic->categories[0]->id ?>/<?= $path->pathway->topic->categories[0]->slug ?>/topic/<?= $path->pathway->topic->id ?>/<?= $path->pathway->topic->slug ?>"><?= $path->pathway->topic->name ?></a>
                    <h2 class="text-4xl mb-3">
                        <a href="/<?= $path->pathway->topic->categories[0]->slug ?>/<?= $path->pathway->topic->slug ?>/pathway/<?= $path->pathway->slug ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="inline-block -mt-2" viewBox="0 0 16 16">
                                <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                                <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z" />
                            </svg>
                            <?= $path->pathway->name ?>
                        </a>
                    </h2>

                    <div class="p-4 text-xl bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
                        <div class="text-xs">Objective</div>
                        <?= h($path->pathway->objective) ?>
                    </div>
                    <!-- <div>Followed on:
		<?= $this->Time->format($path->date_start, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
		</div> -->
                    <?php if (!empty($path->date_complete)) : ?>
                        <div>
                            Completed:
                            <?= $this->Time->format($path->date_complete, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                        </div>
                    <?php endif ?>


                    <div class="pbarcontainer<?= $path->pathway->id ?> sticky top-0 my-1 w-full h-8 bg-slate-50 dark:bg-slate-900/80 rounded-lg">
                        <span class="inline-block pbar<?= $path->pathway->id ?> pt-2 px-6 h-8 text-sm bg-sky-700 text-white rounded-lg"></span>
                    </div>
                    <script>
                        fetch('/pathways/status/<?= $path->pathway->id ?>', {
                                method: 'GET'
                            })
                            .then((res<?= $path->pathway->id ?>) => res<?= $path->pathway->id ?>.json())
                            .then((json<?= $path->pathway->id ?>) => {
                                if (json<?= $path->pathway->id ?>.percentage > 0) {
                                    let message = json<?= $path->pathway->id ?>.percentage + '% - ' + json<?= $path->pathway->id ?>.completed + ' of ' + json<?= $path->pathway->id ?>.requiredacts;
                                    if (json<?= $path->pathway->id ?>.percentage > 25) {
                                        document.querySelector('.pbar<?= $path->pathway->id ?>').style.width = json<?= $path->pathway->id ?>.percentage + '%';
                                    }
                                    if (json<?= $path->pathway->id ?>.percentage == 100) {
                                        document.querySelector('.pbar<?= $path->pathway->id ?>').innerHTML = message + ' - COMPLETED!';
                                    } else {
                                        document.querySelector('.pbar<?= $path->pathway->id ?>').innerHTML = message;
                                    }
                                } else {
                                    document.querySelector('.pbarcontainer<?= $path->pathway->id ?>').innerHTML = ''; //'<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>';
                                }
                                //console.log(json);
                            })
                            .catch((err) => console.error("error:", err));
                    </script>

                    <a href="/pathways/<?= h($path->pathway->slug) ?>" class="inline-block p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                        View Pathway
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </a>


                </div>
            </div>
        <?php endforeach; ?>

    <?php else : ?>

        <header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/cape-scott-trail-n-r-t-on-flckr.jpg);">
            <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg p-4 flex">
                <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Getting Started</h1>
            </div>
        </header>
        <div class="p-8 text-xl max-w-prose">
            <h2 class="mb-3 text-2xl text-darkblue font-semibold">Find your path</h2>

            <p class="mb-3">
                Curator pathways are organized into <a href="/categories" class="underline font-medium">categories</a> and then <span class="font-italic">topics</span>. You can explore all the <a href="/pathways" class="underline font-medium">pathways</a> we have to offer and when you see one you like, you can follow it.</p>
            <p>When you follow a pathway, it will be listed here, so the next time you login, you can jump right to it.
            </p>
            <p>As you launch activities contained in a pathway you'll be able to see your progress here too.</p>


            <a href="/categories" class="inline-block p-3 mt-4 mr-4 bg-sagedark text-white text-xl hover:no-underline rounded-lg">
                Explore Categories
            </a>
            <a href="/pathways" class="inline-block p-3 mt-4 bg-darkblue text-white text-xl hover:no-underline rounded-lg">
                Explore Pathways
            </a>

        </div>


    <?php endif ?>


    </div>
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




<?php if (!$pathways->isEmpty()) : ?>
    <div class="p-6 dark:text-white">
        <h1 class="mb-3 text-lg sr-only">Followed Pathways</h1>
        <?php foreach ($pathways as $path) : ?>

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
            <div class="bg-bluegreen/90 h-44 w-1/3 drop-shadow-lg p-4 flex"><span class="text-white text-3xl font-bold m-auto tracking-wide">Getting Started</span></div>
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
            <a href="/categories" class="inline-block p-3 mt-4 bg-darkblue text-white text-xl hover:no-underline rounded-lg">
                Explore Pathways
            </a>

        </div>


    <?php endif ?>


    </div>
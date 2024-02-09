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
    <header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/1200w/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed_1200w.jpg);">
        <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
            <h1 class="text-white text-3xl font-bold m-auto tracking-wide">My Curator</h1>
        </div>
        <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://flic.kr/p/JULZFP" target="_blank">Paradise Meadows Boardwalk</a> by <a href="https://flic.kr/ps/3bxUBu" target="_blank">Fyre Mael on Flickr</a> (<a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">CC BY 2.0</a>)</p>
    </header>
    <div class="p-8 text-lg" id="mainContent">
        <div class="max-w-prose">
            <h2 class="mb-3 text-2xl text-darkblue font-semibold">Followed Pathways</h2>

            <p class="mb-3 text-xl">
                When you follow a pathway, it will be listed here, so you can jump right to it.</p>

            <?php foreach ($pathways as $path) : ?>

                <a href="/p/<?= h($path->pathway->slug) ?>" class="hover:no-underline">

                    <div class="pl-2 pr-3 py-2 mb-3 mt-8 bg-bluegreen text-white  hover:bg-bluegreen/80  w-full rounded-lg flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 inline-block mx-3 flex-none" viewBox="0 0 16 16">
                            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
                        </svg>
                        <h3 class="text-2xl flex-1">
                            <?= h($path->pathway->name) ?>
                        </h3>
                        <!-- <span class="text-sm ml-3 justify-self-end flex-none"><?= h($path->pathway->steps) ?> steps | <?= h($path->pathway->requiredacts) ?> activities</span> -->
                    </div>
                </a>
                <div class="pl-10">
                    <div class="flex justify-end items-center text-xs text-slate-500 mt-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag inline-block mr-1" viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                        <a href="/topic/<?= $path->pathway->topic->slug ?>">
                            <?= $path->pathway->topic->name ?>
                        </a></span>
                    </div>
                    <div class="flex gap-2">
                        <p class="text-base mb-0 flex-none"><strong>Followed on:</strong>
                            <?= $this->Time->format($path->date_start, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                        </p>
                        <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'delete/' . $path->id]]) ?>
                        <button class="block text-slate-500 underline hover:text-slate-700 hover:cursor-pointer mt-0 text-base mb-3 flex-none">Un-Follow Pathway</button>
                        <?= $this->Form->end(); ?>
                    </div>
                    <?php if (!empty($path->date_complete)) : ?>
                        <p class="text-base">
                            <strong>Completed:</strong>
                            <?= $this->Time->format($path->date_complete, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                        </p>
                    <?php endif ?>
                    <p><span class="font-bold">Pathway Goal: </span><?= h($path->pathway->objective); ?></p>
                    <h3 class="mt-4 mb-1 text-darkblue font-semibold">Pathway Activity Progress</h3>
                    <div class="flex pbarcontainer_<?= $path->pathway->id ?> mb-4 w-full bg-slate-200 rounded-lg content-center justify-start">
                        <span class="hidden py-2 px-3 bg-darkblue text-white rounded-lg text-base pbar_<?= $path->pathway->id ?> flex-none"></span>
                        <span class="py-2 px-3 text-base pbar_<?= $path->pathway->id ?> pro_sm_<?= $path->pathway->id ?> flex-none"></span>
                        <span class="py-2 px-3 text-base total_<?= $path->pathway->id ?> flex-1 text-right"></span>
                        <span class="zero_<?= $path->pathway->id ?> hidden py-2 px-3 text-base text-right"></span>
                    </div>
                    <script>
                        fetch('/pathways/status/<?= $path->pathway->id ?>', {
                                method: 'GET'
                            })
                            .then((res) => res.json())
                            .then((json) => {

                                if (json.percentage > 0) {
                                    // Phrasing
                                    let launched = json.completed + ' launched';
                                    let remaining = (json.requiredacts - json.completed) + ' to go';
                                    document.querySelector('.zero_<?= $path->pathway->id ?>').classList.add('hidden');
                                    document.querySelector('.pbar_<?= $path->pathway->id ?>').classList.remove('hidden');
                                    document.querySelector('.pbar_<?= $path->pathway->id ?>').style.width = json.percentage + '%';

                                    if (json.percentage == 100) {

                                        document.querySelector('.pbar_<?= $path->pathway->id ?>').innerHTML = 'Pathway completed!';
                                        document.querySelector('.zero_<?= $path->pathway->id ?>').innerHTML = '';
                                    } else if (json.percentage < 20) {

                                        document.querySelector('.pbar_<?= $path->pathway->id ?>').innerHTML = '';
                                        document.querySelector('.pro_sm_<?= $path->pathway->id ?>').innerHTML = launched;
                                        document.querySelector('.total_<?= $path->pathway->id ?>').innerHTML = remaining;
                                        document.querySelector('.zero_<?= $path->pathway->id ?>').innerHTML = '';
                                    } else if (json.percentage > 90) {
                                        document.querySelector('.pro_sm_<?= $path->pathway->id ?>').innerHTML = '';
                                        document.querySelector('.total_<?= $path->pathway->id ?>').innerHTML = '';
                                        document.querySelector('.pbar_<?= $path->pathway->id ?>').innerHTML = launched + ', ' + remaining;
                                        document.querySelector('.zero_<?= $path->pathway->id ?>').innerHTML = '';
                                    } else {
                                        document.querySelector('.pbar_<?= $path->pathway->id ?>').innerHTML = launched;
                                        document.querySelector('.total_<?= $path->pathway->id ?>').innerHTML = remaining;
                                        document.querySelector('.pro_sm_<?= $path->pathway->id ?>').innerHTML = '';
                                        document.querySelector('.zero_<?= $path->pathway->id ?>').innerHTML = '';
                                    }

                                } else {
                                    document.querySelector('.zero_<?= $path->pathway->id ?>').classList.remove('hidden');
                                    document.querySelector('.zero_<?= $path->pathway->id ?>').innerHTML = '' + json.requiredacts + ' activities to go';
                                }
                            })
                            .catch((err) => console.error("error:", err));
                    </script>

                    <p class="my-4"> <a href="/p/<?= h($path->pathway->slug) ?>" class="text-sky-700 underline">
                            View the <strong><?= h($path->pathway->name) ?></strong> pathway
                        </a> </p>


                </div>
            <?php endforeach; ?>
        </div>
    </div>


<?php else : ?>

    <header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/cape-scott-trail-n-r-t-on-flckr.jpg);">
        <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
            <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Getting Started</h1>
        </div>
        <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://www.flickr.com/photos/n-r-t/1200374518/" target="_blank">Cape Scott Trail</a> by <a href="https://www.flickr.com/photos/n-r-t/" target="_blank">Nick Thompson on Flickr</a> (<a href="https://creativecommons.org/licenses/by-nc-nd/2.0/">CC BY-NC-ND 2.0</a>)</p>
    </header>
    <div class="p-8 text-xl max-w-prose" id="mainContent">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">Find your path</h2>

        <p class="mb-3">
            Curator pathways are organized into <a href="/topics" class="underline font-medium">topics</a>. 
            You can explore all the <a href="/pathways" class="underline font-medium">pathways</a> we have 
            to offer and when you see one you like, you can follow it.
        </p>

        <p>When you follow a pathway, it will be listed here, so the next time you login, you can jump right to it.
        </p>
        <p>As you launch activities contained in a pathway you'll be able to see your progress here too.</p>


        <a href="/topics" class="inline-block p-3 mt-4 mr-4 bg-sagedark text-white text-xl hover:no-underline rounded-lg">
            Explore Topics
        </a>
        <a href="/pathways" class="inline-block p-3 mt-4 bg-darkblue text-white text-xl hover:no-underline rounded-lg">
            Explore Pathways
        </a>

    </div>


<?php endif ?>
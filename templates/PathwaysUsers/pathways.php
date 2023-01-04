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

                <a href="/<?= h($path->pathway->topic->categories[0]->slug) ?>/<?= h($path->pathway->topic->slug) ?>/pathway/<?= h($path->pathway->slug) ?>" class="hover:no-underline">

                    <div class="pl-2 pr-3 py-2 mb-3 mt-8 bg-bluegreen text-white  hover:bg-bluegreen/80  w-full rounded-l-full flex items-center justify-between">
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
                        </svg><?php $topiclink = $path->pathway->topic->categories[0]->name . ' > ' . $path->pathway->topic->name ?>
                        <a href="/category/<?= $path->pathway->topic->categories[0]->id ?>/<?= $path->pathway->topic->categories[0]->slug ?>/topic/<?= $path->pathway->topic->id ?>/<?= $path->pathway->topic->slug ?>">
                            <?= $topiclink ?>
                        </a></span>
                    </div>
                    <p class="text-base"><strong>Followed on:</strong>
                        <?= $this->Time->format($path->date_start, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                    </p>

                    <?php if (!empty($path->date_complete)) : ?>
                        <p class="text-base">
                            <strong>Completed:</strong>
                            <?= $this->Time->format($path->date_complete, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                        </p>
                    <?php endif ?>

                    <div class="autop"><?= $this->Text->autoParagraph(h($path->pathway->description)); ?></div>


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

                    <p class="my-4"> <a href="/<?= h($path->pathway->topic->categories[0]->slug) ?>/<?= $path->pathway->topic->slug ?>/pathway/<?= h($path->pathway->slug) ?>" class="text-sky-700 underline">
                            View the <strong><?= h($path->pathway->name) ?></strong> pathway
                        </a> </p>

                    <div class="my-3">
                        <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'delete/' . $path->id]]) ?>
                        <button class="py-2 px-4 bg-darkblue text-white rounded-lg hover:bg-darkblue/80">
                            Un-Follow Pathway <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pin-angle inline" viewBox="0 0 16 16">
                                <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a5.927 5.927 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707-.195-.195.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a5.922 5.922 0 0 1 1.013.16l3.134-3.133a2.772 2.772 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146zm.122 2.112v-.002.002zm0-.002v.002a.5.5 0 0 1-.122.51L6.293 6.878a.5.5 0 0 1-.511.12H5.78l-.014-.004a4.507 4.507 0 0 0-.288-.076 4.922 4.922 0 0 0-.765-.116c-.422-.028-.836.008-1.175.15l5.51 5.509c.141-.34.177-.753.149-1.175a4.924 4.924 0 0 0-.192-1.054l-.004-.013v-.001a.5.5 0 0 1 .12-.512l3.536-3.535a.5.5 0 0 1 .532-.115l.096.022c.087.017.208.034.344.034.114 0 .23-.011.343-.04L9.927 2.028c-.029.113-.04.23-.04.343a1.779 1.779 0 0 0 .062.46z"/>
                            </svg>
                        </button>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


<?php else : ?>

    <header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/cape-scott-trail-n-r-t-on-flckr.jpg);">
        <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg p-4 flex">
            <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Getting Started</h1>
        </div>
        <p class="text-xs text-white float-right -mt-3 mb-0">Photo: <a href="https://www.flickr.com/photos/n-r-t/1200374518/" target="_blank">Cape Scott Trail</a> by <a href="https://www.flickr.com/photos/n-r-t/" target="_blank">Nick Thompson on Flickr</a> (<a href="https://creativecommons.org/licenses/by-nc-nd/2.0/">CC BY-NC-ND 2.0</a>)</p>
    </header>
    <div class="p-8 text-xl max-w-prose" id="mainContent">
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

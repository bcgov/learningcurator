<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */
//phpinfo(); exit;
$this->loadHelper('Authentication.Identity');

$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
$this->assign('title', h($pagetitle));
$stepacts = count($requiredacts);
$supplmentalcount = count($supplementalacts);


#TODO Allan move this into the controller
$last = 0;
$previousid = 0;
$next = 0;
$nextid = 0;
foreach ($step->pathways as $pathways) {
    foreach ($pathways->steps as $s) {
        $next = next($pathways->steps);
        if ($s->id == $step->id) {
            if ($last) {
                $previousid = $last->id;
                $previousslug = $last->slug;
            }
            if ($next) {
                $upnextid = $next->id;
                $upnextslug = $next->slug;
            }
        }
        $last = $s;
    }
}
?>

<header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/1200w/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed_1200w.jpg);">
    <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Pathways</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://flic.kr/p/JULZFP" target="_blank">Paradise Meadows Boardwalk</a> by <a href="https://flic.kr/ps/3bxUBu" target="_blank">Fyre Mael on Flickr</a> (<a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">CC BY 2.0</a>)</p>
</header>
<div class="p-8 pt-4 w-full text-xl" id="mainContent">
    <nav class="mb-4 ml-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <a href="/category/<?= h($step->pathways[0]->topic->categories[0]->id) ?>/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>" class="hover:underline"><?= h($step->pathways[0]->topic->categories[0]->name) ?></a> >
        <a href="/category/<?= h($step->pathways[0]->topic->categories[0]->id) ?>/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/topic/<?= h($step->pathways[0]->topic->id) ?>/<?= h($step->pathways[0]->topic->slug) ?>" class="hover:underline"><?= h($step->pathways[0]->topic->name) ?></a> >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost-2 mr-1 inline-block" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg><a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= h($step->pathways[0]->slug) ?>"><?= h($step->pathways[0]->name) ?></a> >
        <?= $step->name ?>
    </nav>

    <div class="max-w-3xl ml-8">
        <div class="p-3 mb-3 mt-8 bg-bluegreen text-white rounded-l-full  flex justify-end items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 mx-4 grow-0" viewBox="0 0 16 16">
                <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
            </svg>
            <h2 class="text-2xl flex-1">
                <?= h($step->pathways[0]->name) ?>

            </h2>
        </div>
        <div class="pl-16 pr-4 mb-5 text-lg">
            <p class="text-xl"><span class="font-bold">Pathway Goal: </span>
                <?= h($step->pathways[0]->objective) ?></p>




            <?php if (empty($followid)) : ?>
                <div class="my-3">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'follow']]) ?>
                    <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $step->pathways[0]->id]) ?>
                    <button class="py-2 px-4 bg-darkblue text-white rounded-lg hover:bg-darkblue/80">
                        Follow Pathway<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pin ml-2 inline" viewBox="0 0 16 16">
                            <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354zm1.58 1.408-.002-.001.002.001zm-.002-.001.002.001A.5.5 0 0 1 6 2v5a.5.5 0 0 1-.276.447h-.002l-.012.007-.054.03a4.922 4.922 0 0 0-.827.58c-.318.278-.585.596-.725.936h7.792c-.14-.34-.407-.658-.725-.936a4.915 4.915 0 0 0-.881-.61l-.012-.006h-.002A.5.5 0 0 1 10 7V2a.5.5 0 0 1 .295-.458 1.775 1.775 0 0 0 .351-.271c.08-.08.155-.17.214-.271H5.14c.06.1.133.191.214.271a1.78 1.78 0 0 0 .37.282z" />
                        </svg></button>
                    <?= $this->Form->end(); ?>
                </div>
            <?php else : ?>
                <div class="my-3">
                    <!-- TODO Allan add pin-angle to unfollow button to match follow button-->
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-angle" viewBox="0 0 16 16">
                    <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a5.927 5.927 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707-.195-.195.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a5.922 5.922 0 0 1 1.013.16l3.134-3.133a2.772 2.772 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146zm.122 2.112v-.002.002zm0-.002v.002a.5.5 0 0 1-.122.51L6.293 6.878a.5.5 0 0 1-.511.12H5.78l-.014-.004a4.507 4.507 0 0 0-.288-.076 4.922 4.922 0 0 0-.765-.116c-.422-.028-.836.008-1.175.15l5.51 5.509c.141-.34.177-.753.149-1.175a4.924 4.924 0 0 0-.192-1.054l-.004-.013v-.001a.5.5 0 0 1 .12-.512l3.536-3.535a.5.5 0 0 1 .532-.115l.096.022c.087.017.208.034.344.034.114 0 .23-.011.343-.04L9.927 2.028c-.029.113-.04.23-.04.343a1.779 1.779 0 0 0 .062.46z"/>
                  </svg> -->
                    <?php
                    echo $this->Form->postLink(
                        __('Un-Follow Pathway'),
                        ['controller' => 'PathwaysUsers', 'action' => 'delete/' . $followid],
                        [
                            'class' => 'p-2 bg-darkblue text-white rounded-lg hover:no-underline',
                            'title' => 'Stop seeing this pathway on your profile',
                            'confirm' => ''
                        ]
                    );
                    ?>
                </div>
            <?php endif ?>


            <h3 class="mt-6 mb-1 text-darkblue font-semibold">Pathway Activity Progress</h3>
            <div class="flex pbarcontainer mb-3 w-full bg-slate-200 rounded-lg outline-slate-500 outline outline-1 outline-offset-2 content-center justify-start">
                <span class="py-2 px-3 bg-darkblue text-white rounded-lg text-base pbar pro flex-none"></span>
                <span class="py-2 px-3 text-base pbar pro_sm flex-none"></span>
                <span class="py-2 px-3 text-base total flex-1 text-right"></span>
            </div>


            <script>
                fetch('/pathways/status/<?= $step->pathways[0]->id ?>', {
                        method: 'GET'
                    })
                    .then((res) => res.json())
                    .then((json) => {
                        if (json.percentage > 0) {
                            let launched = json.completed + ' launched';
                            let remaining = (json.requiredacts - json.completed) + ' to go';

                            document.querySelector('.pbar').style.width = json.percentage + '%';

                            if (json.percentage == 100) {
                                document.querySelector('.pro').innerHTML = 'Pathway completed!';
                            }
                            if (json.percentage < 20) {
                                document.querySelector('.pro_sm').innerHTML = launched;
                                document.querySelector('.total').innerHTML = remaining;
                            } else {
                                document.querySelector('.pro').innerHTML = launched;
                                document.querySelector('.total').innerHTML = remaining;
                            }

                        } else {
                            document.querySelector('.pbarcontainer').innerHTML = '<span class="py-2 px-3 text-base text-right flex-1">' + json.requiredacts + ' activities to go</span>';
                        }
                        //console.log(json);
                    })
                    .catch((err) => console.error("error:", err));
            </script>
            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                <?= $this->Html->link(
                    __('Edit Step'),
                    ['controller' => 'Steps', 'action' => 'edit', $step->id],
                    ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']
                ) ?>
            <?php endif ?>
        </div>
    </div>


    <!-- TODO Allan prevent current tab from being clicked -->
    <div class="flex mt-8">
        <div class="basis-1/7 flex-none">
            <nav class="flex flex-col gap-2">

                <?php foreach ($step->pathways as $pathways) : ?>
                    <?php $count = 0 ?>
                    <?php foreach ($pathways->steps as $s) : ?>
                        <?php if ($s->status_id == 2) : ?>
                            <?php $count++ ?>
                            <?php $c = 'bg-gray-500' ?>
                            <?php if ($s->id == $step->id)  $c = 'active bg-bluegreen -ml-4' ?>
                            <a class="border border-slate-200 rounded-l-lg py-3 px-4 hover:bg-bluegreen/80 text-white hover:no-underline <?= $c ?>" href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
                                Step <?= $count ?>
                            </a>
                        <?php else : ?>
                            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                                <?php $c = 'bg-gray-500' ?>
                                <a class="border border-slate-200 rounded-l-lg py-3 px-4 hover:bg-bluegreen/80 text-white hover:no-underline <?= $c ?>" href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
                                    DRAFT
                                </a>
                            <?php endif; // are you a curator?
                            ?>
                        <?php endif; // is published?
                        ?> <?php endforeach ?>
                <?php endforeach ?>
            </nav>
        </div>
        <!-- TODO Allan/Nori - Title vs step name/subtitle -->
        <div class="basis-6/7 flex-1 border-2 border-bluegreen rounded-r-lg p-6 max-w-prose">
            <?php if ($step->status_id == 1) : ?>
                <span class="bg-orange-400 text-white text-xs rounded-full px-2 py-1 align-middle">DRAFT</span>
            <?php endif ?>
            <h2 class="mb-4 text-2xl">
                <strong><?= $step->name ?></strong>
            </h2>

            <p><span class="font-bold">Objective: </span>
                <?= h($step->description) ?>
            </p>
            <!-- TODO objectives should be edited to remove p tags, or use autoparagraph and change heading to not be inline. Or can we omit the word objective entirely? -->
            <?php if (!empty($requiredacts)) : ?>
                <?php if (count($requiredacts) === 1) : ?>
                    <h4 class="mt-6 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-1">1</span>Required Activity </h4>
                <?php else : ?>
                    <h4 class="mt-6 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-1"><?= $stepacts ?></span>Required Activities </h4>
                <?php endif ?>
                <p class="text-base"><em>Launch these activities and fill in your progress bar.</em></p>
                <?php foreach ($requiredacts as $activity) : ?>
                    <?php
                    // #TODO Allan move this back into the controller and simplify
                    // this was an attempt at requiring two launches to satify a complete
                    $completed = 0;
                    $actlist = array_count_values($useractivitylist);
                    foreach ($actlist as $k => $v) {
                        if ($k == $activity->id) {
                            if ($v > 0) $completed = $v;
                        }
                    }
                    ?>
                    <div class="rounded-md bg-sagedark mb-4 p-0.5">
                        <div class="flex flex-row justify-between">
                        <i class="<?= h($activity->activity_type->image_path) ?> mx-3 my-4 flex-none" style="color:white; font-size: 2rem;" aria-label="<?= h($activity->activity_type->name) ?>"></i>
                            <div class="bg-white inset-1 rounded-r-sm flex-1">
                                <div x-data="{ count: <?= $completed ?>, liked: <?= $activity->recommended ?> }">
                                    <div class="p-3 text-lg">
                                        <a href="/profile/launches" class="inline-block p-0.5 px-2 bg-sky-700 text-white text-xs text-center uppercase rounded-lg hover:no-underline hover:bg-sky-700/80" :class="[count > '0' ? 'show' : 'hidden']">
                                            Launched
                                        </a>
                                        <h4 class="mb-3 mt-1 text-xl font-semibold">
                                            <?= $activity->name ?>
                                        </h4>
                                        <div class="text-lg">
                                            <?php if (!empty($activity->description)) : ?>
                                                <?= $activity->description ?>
                                            <?php else : ?>
                                                <p><em>No description provided&hellip;</em></p>
                                            <?php endif ?>
                                            <?php if (!empty($activity->_joinData->stepcontext)) : ?>
                                                <div class="text-sm italic mt-2">Curator says:</div>
                                                <blockquote class="border-l-2 p-2 m-2"><?= h($activity->_joinData->stepcontext) ?></blockquote>
                                            <?php endif ?>
                                            <?php if (!empty($activity->isbn)) : ?>
                                                ISBN: <?= $activity->isbn ?>
                                            <?php endif ?>
                                        </div>
                                        <!-- <form action="/activities/like/<?= $activity->id ?>"
    x-on:click="liked++"
    @submit.prevent="submitData">
    <button><span x-text="liked"></span> likes</button>
    </form> -->
                                        <?php
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $activity->hyperlink, $youtube);
                                        if (!empty($youtube[1])) :
                                        ?>
                                            <!-- <img src="https://i.ytimg.com/vi/<?= $youtube[1] ?>/hqdefault.jpg" x-on:click="count++; fetch('/activities-users/launch?activity_id=<?= $activity->id ?>')">
                                            <div class="hidden w-full z-50 h-auto bg-black/50" x-on:click="count++; fetch('/activities-users/launch?activity_id=<?= $activity->id ?>')">
                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $youtube[1] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div> -->
                                        <?php endif ?>
                                        <a target="_blank" x-on:click="count++;" onclick="loadStatus();" rel="noopener" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $activity->id ?>" class="inline-block my-2 p-2 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-lg hover:no-underline">
                                            Launch
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="ml-1 inline align-baseline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                                <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                            </svg>
                                        </a>
                                        <!-- TODO Nori Long hyperlinks breaking cards on more info -->
                                        <div x-data="{ open: false }">
                                            <button @click="open = !open" class="text-sm text-sky-700 text-right">
                                                <span>More info</span>
                                                <svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
                                                <ul class="list-disc pl-6 mt-2">
                                                    <li x-data="{ input: '<?= $activity->hyperlink ?>', tooltip: 'Click to copy link', showMsg: false }" class="px-1"><strong>Hyperlink: </strong>
                                                        <?= $activity->hyperlink ?> <button @click="$clipboard(input), showMsg = true" class="bg-sky-700 text-white rounded-lg py-1 px-2 text-base hover:cursor-pointer hover:bg-sky-700/80"><i class="" :class="{'bi bi-clipboard2 ': !showMsg, 'bi bi-clipboard2-check': showMsg }" alt="Copy link"></i> <span x-show="!showMsg">Copy link</span><span x-cloak x-show="showMsg">Copied!</span></button></li>
                                                    <li class="px-1">
                                                        <a class="text-lg text-sky-700 hover:underline" href="/activities/view/<?= $activity->id ?>">
                                                            View Activity Record
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!-- <div class="mb-3 p-3 bg-white rounded-lg">
    <strong>Activity type:</strong> <?= $activity->activity_type->name ?>
    </div> -->

                                                <div class="border-2 border-slate-700 rounded-md mt-5">
                                                    <h4 class="bg-slate-700 text-white p-2">Report an Issue with this Activity</h4>
                                                    <div class="p-3 pb-1">
                                                        <script>
                                                            var message = '';

                                                            function report<?= $activity->id ?>Form() {
                                                                return {
                                                                    form<?= $activity->id ?>Data: {
                                                                        activity_id: '<?= $activity->id ?>',
                                                                        user_id: '<?= $uid ?>',
                                                                        issue: '',
                                                                        csrfToken: <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>,
                                                                    },
                                                                    message: '',
                                                                    submitData() {
                                                                        this.message = ''
                                                                        fetch('/reports/add', {
                                                                                method: 'POST',
                                                                                headers: {
                                                                                    'Content-Type': 'application/json',
                                                                                    'X-CSRF-Token': <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>
                                                                                },
                                                                                body: JSON.stringify(this.form<?= $activity->id ?>Data)
                                                                            })
                                                                            .then(() => {
                                                                                this.message = 'Report sucessfully submitted!';
                                                                                this.form<?= $activity->id ?>Data.issue = '';
                                                                            })
                                                                            .catch(() => {
                                                                                this.message = 'Ooops! Something went wrong!';
                                                                            })
                                                                    }
                                                                }
                                                            }
                                                        </script>
                                                        <?= $this->Form->create(
                                                            null,
                                                            [
                                                                'url' => [
                                                                    'controller' => 'reports',
                                                                    'action' => 'add'
                                                                ],
                                                                'class' => '',
                                                                'x-data' => 'report' . $activity->id . 'Form()',
                                                                '@submit.prevent' => 'submitData'
                                                            ]
                                                        ) ?>
                                                        <?php
                                                        echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                                                        echo $this->Form->hidden('user_id', ['value' => $uid]);
                                                        ?>
                                                        <label>
                                                            <?php
                                                            echo $this->Form->textarea(
                                                                'issue',
                                                                [
                                                                    'class' => 'form-field',
                                                                    'x-model' => 'form' . $activity->id . 'Data.issue',
                                                                    'placeholder' => 'Type here ...',
                                                                    'required' => 'required',
                                                                    'rows' => '2'
                                                                ]
                                                            );
                                                            ?>
                                                        </label>
                                                        <input type="submit" class="inline-block px-3 py-1 text-white text-sm bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg cursor-pointer mt-3 mb-1" value="Submit Report">
                                                        <span x-text="message" class="ml-1 text-sm text-sky-700"></span>
                                                        <?= $this->Form->end() ?>
                                                    </div>
                                                </div>
                                            </div> <!-- end hidden more info -->
                                        </div><!-- end more info dropdown -->
                                    </div>
                                </div> <!-- click count increment container -->
                            </div>
                        </div> <!-- end white inner box -->
                    </div>
                    <!-- end activity card -->
                <?php endforeach; // end of activities loop for this step
                ?>
            <?php endif; //end of required activities
            ?>
            <?php if (count($supplementalacts) > 0) : ?>
                <div class="my-3 text-center text-sm">End of required activities for this module.</div>
                <?php if (count($supplementalacts) === 1) : ?>
                    <h4 class="mt-6 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-1"><?= $supplmentalcount ?></span>Supplementary Resource </h4>
                <?php else : ?>
                    <h4 class="mt-6 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-1"><?= $supplmentalcount ?></span>Supplementary Resources </h4>
                <?php endif ?>
                <p class="text-base"><em>Launching these activities does not count towards your progress along this pathway.</em></p>
                <?php foreach ($supplementalacts as $activity) : ?>
                    <?php
                    // #TODO Allan move this back into the controller and simplify
                    // this was an attempt at requiring two launches to satify a complete
                    $completed = 0;
                    $actlist = array_count_values($useractivitylist);
                    foreach ($actlist as $k => $v) {
                        if ($k == $activity->id) {
                            if ($v > 0) $completed = $v;
                        }
                    }
                    ?>
                    <div class="rounded-md bg-sagedark mb-4 p-0.5">
                        <div class="flex flex-row justify-between">
                        <i class="<?= h($activity->activity_type->image_path) ?> mx-3 my-4 flex-none" style="color:white; font-size: 2rem;" aria-label="<?= h($activity->activity_type->name) ?>"></i>
                            <div class="bg-white inset-1 rounded-r-sm flex-1">
                                <div x-data="{ count: <?= $completed ?> }">
                                    <div class="p-3 text-lg">
                                        <a href="/profile/launches" class="inline-block p-0.5 px-2 bg-sky-700 text-white text-xs text-center uppercase rounded-lg hover:no-underline hover:bg-sky-700/80" :class="[count > '0' ? 'show' : 'hidden']">
                                            Launched
                                        </a>
                                        <h4 class="mb-3 mt-1 text-xl font-semibold">
                                            <?= $activity->name ?>
                                        </h4>
                                        <div class="text-lg">
                                            <?php if (!empty($activity->description)) : ?>
                                                <p><?= h($activity->description) ?></p>
                                            <?php else : ?>
                                                <p><em>No description provided&hellip;</em></p>
                                            <?php endif ?>
                                            <?php if (!empty($activity->_joinData->stepcontext)) : ?>
                                                <div class="text-sm italic mt-2">Curator says:</div>
                                                <blockquote class="border-l-2 p-2 m-2"><?= h($activity->_joinData->stepcontext) ?></blockquote>

                                            <?php endif ?>
                                            <div class="">
                                                <a target="_blank" x-on:click="count++;" onclick="loadStatus();" rel="noopener" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $activity->id ?>" class="inline-block my-2 p-2 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-lg hover:no-underline">
                                                    Launch
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div x-data="{ open: false }">
                                                <button @click="open = !open" class="text-sm text-sky-700 text-right">
                                                    <span>More info</span>
                                                    <svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                                <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
                                                    <ul class="list-disc pl-6 mt-2">
                                                        <li x-data="{ input: '<?= $activity->hyperlink ?>', tooltip: 'Click to copy link', showMsg: false }" class="px-1"><strong>Hyperlink: </strong>
                                                            <?= $activity->hyperlink ?> <button @click="$clipboard(input), showMsg = true" class="bg-sky-700 text-white rounded-lg py-1 px-2 text-base hover:cursor-pointer hover:bg-sky-700/80"><i class="" :class="{'bi bi-clipboard2 ': !showMsg, 'bi bi-clipboard2-check': showMsg }" alt="Copy link"></i> <span x-show="!showMsg">Copy link</span><span x-cloak x-show="showMsg">Copied!</span></button></li>
                                                        <li class="px-1">
                                                            <a class="text-lg text-sky-700 hover:underline" href="/activities/view/<?= $activity->id ?>">
                                                                View Activity Record
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!-- <div class="mb-3 p-3 bg-white rounded-lg">
    <strong>Activity type:</strong> <?= $activity->activity_type->name ?>
    </div> -->

                                                    <div class="border-2 border-slate-700 rounded-md mt-5">
                                                        <h4 class="bg-slate-700 text-white p-2">Report an Issue with this Activity</h4>
                                                        <div class="p-3 pb-1">
                                                            <script>
                                                                var message = '';

                                                                function report<?= $activity->id ?>Form() {
                                                                    return {
                                                                        form<?= $activity->id ?>Data: {
                                                                            activity_id: '<?= $activity->id ?>',
                                                                            user_id: '<?= $uid ?>',
                                                                            issue: '',
                                                                            csrfToken: <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>,
                                                                        },
                                                                        message: '',
                                                                        submitData() {
                                                                            this.message = ''
                                                                            fetch('/reports/add', {
                                                                                    method: 'POST',
                                                                                    headers: {
                                                                                        'Content-Type': 'application/json',
                                                                                        'X-CSRF-Token': <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>
                                                                                    },
                                                                                    body: JSON.stringify(this.form<?= $activity->id ?>Data)
                                                                                })
                                                                                .then(() => {
                                                                                    this.message = 'Report sucessfully submitted!';
                                                                                    this.form<?= $activity->id ?>Data.issue = '';
                                                                                })
                                                                                .catch(() => {
                                                                                    this.message = 'Ooops! Something went wrong!';
                                                                                })
                                                                        }
                                                                    }
                                                                }
                                                            </script>
                                                            <?= $this->Form->create(
                                                                null,
                                                                [
                                                                    'url' => [
                                                                        'controller' => 'reports',
                                                                        'action' => 'add'
                                                                    ],
                                                                    'class' => '',
                                                                    'x-data' => 'report' . $activity->id . 'Form()',
                                                                    '@submit.prevent' => 'submitData'
                                                                ]
                                                            ) ?>
                                                            <?php
                                                            echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                                                            echo $this->Form->hidden('user_id', ['value' => $uid]);
                                                            ?>
                                                            <label>
                                                                <?php
                                                                echo $this->Form->textarea(
                                                                    'issue',
                                                                    [
                                                                        'class' => 'form-field',
                                                                        'x-model' => 'form' . $activity->id . 'Data.issue',
                                                                        'placeholder' => 'Type here ...',
                                                                        'required' => 'required',
                                                                        'rows' => '2'
                                                                    ]
                                                                );
                                                                ?>
                                                            </label>
                                                            <input type="submit" class="inline-block px-3 py-1 text-white text-sm bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg cursor-pointer mt-3 mb-1" value="Submit Report">
                                                            <span x-text="message" class="ml-1 text-sm text-sky-700"></span>
                                                            <?= $this->Form->end() ?>
                                                        </div>
                                                    </div>
                                                </div> <!-- end hidden more info -->
                                            </div><!-- end more info dropdown -->
                                        </div>
                                    </div> <!-- click count increment container -->
                                </div> <!-- end white inner box -->
                            </div>
                        </div>
                    </div><!-- end activity card -->
                <?php endforeach; // end of activities loop for this step
                ?>
            <?php endif ?>
            <?php if (!empty($archivedacts)) : ?>
                <div x-data="{ open: false }">
                    <h4>Archived Activities</h4>
                    <p>This step used to have these activities assigned to them, but they are no
                        longer considered relevant or appropriate for one reason or another. They
                        are listed here for posterity. <a class="underline text-sky-700" @click="open = !open">View archived activities</a>.
                    </p>
                    <div x-cloak x-show="open">
                        <?php foreach ($archivedacts as $activity) : ?>
                            <h5>
                                <a href="/activities/view/<?= $activity->id ?>">
                                    <i class="bi <?= $activity->activity_type->image_path ?>"></i>
                                    <?= $activity->name ?>
                                </a>
                            </h5>
                            <?= $activity->description ?>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
            <?php if (!empty($previousid) || !empty($upnextid)) : ?>
                <div class="flex justify-items-stretch">
                    <div class="flex-1 justify-self-start">
                        <?php if (!empty($previousid)) : ?>
                            <a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $previousid ?>/<?= $previousslug ?>" class="inline-block p-2 bg-darkblue hover:darkblue/80 rounded-lg text-white text-lg hover:no-underline">
                                Previous Step
                            </a>
                        <?php endif ?>
                    </div>
                    <div class="flex-none justify-self-end">
                        <?php if (!empty($upnextid)) : ?>
                            <a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $upnextid ?>/<?= $upnextslug ?>" class="inline-block p-2 bg-darkblue hover:darkblue/80  rounded-lg text-white text-lg hover:no-underline">
                                Next Step
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>
            <!--end next/previous buttons-->
        </div>
        <!--end step outer box -->
    </div>
</div>
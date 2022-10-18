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

<header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Pathways</h1>
    </div>
</header>
<div class="p-8 pt-4 w-full text-xl">
<nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <a href="/category/<?= h($step->pathways[0]->topic->categories[0]->id) ?>/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>" class="hover:underline"><?= h($step->pathways[0]->topic->categories[0]->name) ?></a> >
        <a href="/category/<?= h($step->pathways[0]->topic->categories[0]->id) ?>/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/topic/<?= h($step->pathways[0]->topic->id) ?>/<?= h($step->pathways[0]->topic->slug) ?>" class="hover:underline"><?= h($step->pathways[0]->topic->name) ?></a> >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost-2 mr-1 inline-block" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg><a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= h($step->pathways[0]->slug) ?>"><?= h($step->pathways[0]->name) ?></a> /
        <?= $step->name ?>
    </nav>
    





    <div class="p-4 bg-slate-100/80  dark:bg-slate-900/80 rounded-lg">
        <?php if (empty($followid)) : ?>
            <div class="mb-2 float-right">
                <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'follow']]) ?>
                <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $step->pathways[0]->id]) ?>
                <button class="p-3 ml-3 bg-sky-700 hover:bg-sky-800 text-white rounded-lg text-center hover:no-underline">
                    <svg class="inline-block" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-fill" viewBox="0 0 16 16">
                        <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354z" />
                    </svg> Follow Pathway
                </button>
                <?= $this->Form->end(); ?>
            </div>
        <?php else : ?>
            <?php
            echo $this->Form->postLink(
                __('Un-Follow Pathway'),
                ['controller' => 'PathwaysUsers', 'action' => 'delete/' . $followid],
                [
                    'class' => 'mt-0 ml-3 float-right inline-block p-3 bg-sky-700 hover:bg-sky-800 text-white rounded-lg text-center hover:no-underline',
                    'title' => 'Stop seeing your progress on this pathway',
                    'confirm' => ''
                ]
            );
            ?>
        <?php endif ?>

        <?php if ($role == 'curator' || $role == 'superuser') : ?>
            <div class="float-right ml-3">
                <?= $this->Html->link(
                    __('Edit Step'),
                    ['controller' => 'Steps', 'action' => 'edit', $step->id],
                    ['class' => 'mt-2 inline-block py-2 px-6 bg-slate-200 text-black rounded-lg text-center hover:no-underline']
                );
                ?>
            </div> <!-- /.btn-group -->
        <?php endif ?>


        <h1 class="mb-6 text-4xl">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="inline-block -mt-2" viewBox="0 0 16 16">
                <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                <path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z" />
            </svg>
            <?= $step->pathways[0]->name ?>
        </h1>
        <div class="mb-4 p-3 text-xl bg-white  dark:bg-slate-800 rounded-lg shadow-lg">
            <div class="text-xs">Pathway Objective</div>
            <?= $step->pathways[0]->objective ?>
        </div>
    </div>

    <div class="pbarcontainer mt-1 mb-6 w-full h-8 bg-slate-50 dark:bg-slate-900/80 rounded-lg">
        <span class="inline-block pbar pt-1 px-6 h-8 bg-sky-700 text-white rounded-lg"></span>
    </div>






    <!-- start drop-down -->
    <div x-cloak @click.away="open = false" class="relative ml-16" x-data="{ open: false }">
        <button @click="open = !open" class="px-4 py-2 text-sm font-semibold text-right bg-slate-200/80 rounded-t-lg dark:bg-slate-900 dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900/80 dark:hover:bg-slate-900 md:block hover:text-slate-900 focus:text-slate-900 hover:bg-slate-100/80  focus:bg-white focus:outline-none focus:shadow-outline">
            <span>Step Menu</span>
            <svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="z-50 absolute left-0 w-full md:w-3/4 lg:w-1/2 origin-top-left -ml-6 bg-white dark:bg-slate-900 shadow-lg rounded-lg">
            <div class="p-6">


                <h3 class="mb-3 text-2xl">Steps along this pathway</h3>
                <div class="">
                    <!-- grid grid-cols-2 gap-4 -->
                    <?php foreach ($step->pathways as $pathways) : ?>
                        <?php foreach ($pathways->steps as $s) : ?>
                            <div class="">
                                <?php if ($s->status_id == 2) : ?>
                                    <?php $c = '' ?>
                                    <?php if ($s->id == $step->id) $c = 'bg-sky-700 text-white' ?>
                                    <a class="block py-1 px-3 <?= $c ?> hover:bg-sky-700 hover:text-white hover:no-underline rounded-lg" href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
                                        <?= h($s->name) ?>
                                    </a>
                                    <!--<?= h($s->description) ?> -->
                                <?php else : ?>
                                    <?php if ($role == 'curator' || $role == 'superuser') : ?>
                                        <a class="block py-1 px-3 hover:bg-sky-700 hover:text-white hover:no-underline rounded-lg" href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
                                            <span class="badge badge-warning">DRAFT</span> -
                                            <?= h($s->name) ?>
                                        </a>
                                    <?php endif; // are you a curator? 
                                    ?>
                                <?php endif; // is published? 
                                ?>
                            </div>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </div>

                <?php if (!empty($previousid) || !empty($upnextid)) : ?>
                    <div class="flex justify-center p-3 bg-white dark:bg-slate-900/80 rounded-lg">
                        <?php if (!empty($previousid)) : ?>
                            <a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $previousid ?>/<?= $previousslug ?>" class="inline-block m-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-lg hover:no-underline">
                                Previous Step
                            </a>
                        <?php endif ?>

                        <?php if (!empty($upnextid)) : ?>
                            <a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $upnextid ?>/<?= $upnextslug ?>" class="inline-block m-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-lg hover:no-underline">
                                Next Step
                            </a>
                        <?php endif ?>
                    </div>
                <?php endif ?>


            </div>
        </div>
    </div>
    <!-- /end drop-down -->

    <div class="p-6 rounded-lg activity bg-slate-200/80 dark:bg-slate-900/80 dark:text-white">
        <h2 class="mb-4 text-3xl">
            <?= $step->name ?>
        </h2>
        <?php if ($step->status_id == 1) : ?>
            <span class="badge badge-warning">DRAFT</span>
        <?php endif ?>
        <div class="mb-4 p-3 text-xl bg-white  dark:bg-slate-800 rounded-lg shadow-lg">
            <div class="text-xs">Step Objective</div>
            <?= $step->description ?>
        </div>
        <div class="">
            <?php if (!empty($requiredacts)) : ?>
                <h3 class="mt-6 text-2xl dark:text-white">Required Activities <span class="bg-black text-white dark:bg-white dark:text-black rounded-lg text-lg inline-block px-2"><?= $stepacts ?></span></h3>
                <div><em>Launch these activities and fill in your progress bar.</em></div>
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
                    <div class="p-3 my-3 rounded-lg activity bg-white dark:bg-[#003366]/80 dark:text-white shadow-lg">

                        <div x-data="{ count: <?= $completed ?>, liked: <?= $activity->recommended ?> }">

                            <a href="/profile/launches" class="inline-block w-24 bg-sky-700 dark:bg-slate-900/80 text-white dark:text-yellow-500 text-sm text-center uppercase rounded-lg" :class="[count > '0' ? 'show' : 'hidden']">
                                Launched
                            </a>

                            <h4 class="mb-3 text-2xl">
                                <?= $activity->name ?>
                            </h4>
                            <?php if (!empty($activity->description)) : ?>
                                <div class="p-2 lg:p-4 text-lg bg-slate-200/80 dark:bg-[#002850] rounded-t-lg">
                                    <?= $activity->description ?>
                                </div>
                            <?php else : ?>
                                <div class="p-2 lg:p-4 text-lg bg-slate-200/80 dark:bg-[#002850] rounded-t-lg">
                                    <em>No description provided&hellip;</em>
                                </div>
                            <?php endif ?>

                            <?php if (!empty($activity->_joinData->stepcontext)) : ?>
                                <div class="p-3 lg:p-4 mb-2 bg-slate-100/80  dark:bg-slate-900/80 rounded-b-lg">
                                    <em>Curator says:</em><br>
                                    <?= $activity->_joinData->stepcontext ?>
                                </div>
                            <?php endif ?>

                            <?php if (!empty($activity->isbn)) : ?>
                                <div class="p-2 isbn bg-white dark:bg-slate-800">
                                    ISBN: <?= $activity->isbn ?>
                                </div>
                            <?php endif ?>


                            <!-- <form action="/activities/like/<?= $activity->id ?>"
				x-on:click="liked++"
				@submit.prevent="submitData">
			<button><span x-text="liked"></span> likes</button>
		</form> -->

                            <?php
                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $activity->hyperlink, $youtube);
                            if (!empty($youtube[1])) :
                            ?>
                                <img src="https://i.ytimg.com/vi/<?= $youtube[1] ?>/hqdefault.jpg" x-on:click="count++; fetch('/activities-users/launch?activity_id=<?= $activity->id ?>')">

                                <div class="hidden w-full z-50 h-auto bg-black/50" x-on:click="count++; fetch('/activities-users/launch?activity_id=<?= $activity->id ?>')">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $youtube[1] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            <?php endif ?>



                            <a target="_blank" x-on:click="count++;" onclick="loadStatus();" rel="noopener" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $activity->id ?>" class="inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
                                Launch Activity
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                </svg>
                            </a>



                        </div> <!-- click count increment container -->

                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="px-4 py-2 text-md font-semibold text-right bg-slate-200/80 dark:text-white dark:bg-[#002850] dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900/80 dark:hover:bg-slate-900/80 md:block hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200/80 focus:bg-slate-200/80 focus:outline-none focus:shadow-outline rounded-lg">
                                <span>More info</span>
                                <svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
                                <div class="p-4 bg-slate-200/80 rounded-md dark:bg-slate-900/80">

                                    <div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
                                        <a class="text-lg" href="/activities/view/<?= $activity->id ?>">
                                            View Activity Record
                                        </a>
                                    </div>
                                    <div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
                                        <strong>Hyperlink:</strong> <?= $activity->hyperlink ?>
                                    </div>
                                    <!-- <div class="mb-3 p-3bg-white dark:bg-slate-800 rounded-lg">
			<strong>Activity type:</strong> <?= $activity->activity_type->name ?>
		</div> -->

                                    <div class="p-3 bg-white dark:bg-slate-800 rounded-lg">

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

                                        <p>Is there something wrong with this activity? Report it!</p>
                                        <?php
                                        echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                                        echo $this->Form->hidden('user_id', ['value' => $uid]);
                                        ?>
                                        <label>Your Issue
                                            <?php
                                            echo $this->Form->textarea(
                                                'issue',
                                                [
                                                    'class' => 'w-full h-20 p-6 bg-slate-200/80 dark:bg-slate-700 text-white rounded-lg',
                                                    'x-model' => 'form' . $activity->id . 'Data.issue',
                                                    'placeholder' => 'Type here ...',
                                                    'required' => 'required'
                                                ]
                                            );
                                            ?>
                                        </label>
                                        <input type="submit" class="mt-1 mb-4 px-4 py-2 text-white bg-sky-700 hover:bg-sky-800 rounded-lg" value="Submit Report">
                                        <span x-text="message"></span> <a href="/profile/reports">See all your reports</a>

                                        <?= $this->Form->end() ?>



                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                <?php endforeach; // end of activities loop for this step 
                ?>
        </div> <!-- /.snap-y -->

    <?php endif; ?>

    <?php if (count($supplementalacts) > 0) : ?>
        <div class="my-3 text-center text-sm">End of required activities for this module.</div>
        <h3 class="mt-20 text-2xl dark:text-white">
            Supplementary Resources
            <span class="bg-white text-black rounded-lg text-lg inline-block px-2">
                <?= $supplmentalcount ?>
            </span>
        </h3>
        <p><em>Launching these activities does not count towards your progress along this pathway.</em></p>
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
            <div class="p-3 my-3 rounded-lg activity bg-white dark:bg-[#003366] dark:text-white">

                <div x-data="{ count: <?= $completed ?> }">

                    <a href="/profile/launches" class="inline-block w-24 bg-slate-200/80 text-[#003366] dark:bg-slate-900/80 dark:text-yellow-500 text-sm text-center uppercase rounded-lg" :class="[count > '0' ? 'show' : 'hidden']">
                        Launched
                    </a>

                    <h4 class="mb-3 text-2xl">
                        <?= $activity->name ?>
                    </h4>
                    <?php if (!empty($activity->description)) : ?>
                        <div class="p-2 lg:p-4 text-lg bg-slate-200/80 dark:bg-[#002850] rounded-t-lg">
                            <?= $activity->description ?>
                        </div>
                    <?php else : ?>
                        <div class="p-2 lg:p-4 text-lg bg-slate-200/80 dark:bg-[#002850] rounded-t-lg">
                            <em>No description provided&hellip;</em>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($activity->_joinData->stepcontext)) : ?>
                        <div class="p-3 lg:p-4 mb-2 bg-slate-100/80  dark:bg-slate-900/80 rounded-b-lg">
                            <em>Curator says:</em><br>
                            <?= $activity->_joinData->stepcontext ?>
                        </div>
                    <?php endif ?>


                    <a target="_blank" x-on:click="count++;" rel="noopener" data-toggle="tooltip" data-placement="bottom" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $activity->id ?>" class="inline-block my-2 p-3 bg-sky-700 rounded-lg text-white text-xl hover:no-underline">
                        Launch Activity
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                            <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                        </svg>
                    </a>
                </div>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="px-4 py-2 text-lg font-semibold text-right bg-slate-200/80 dark:text-white dark:bg-[#002850] dark:focus:text-white dark:hover:text-white dark:focus:bg-slate-900/80 dark:hover:bg-slate-900/80 md:block hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200/80 focus:bg-slate-200/80 focus:outline-none focus:shadow-outline focus:rounded-b-none rounded-lg">
                        <span>More info</span>
                        <svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
                        <div class="p-4 bg-slate-200/80 rounded-lg rounded-tl-none dark:bg-slate-900/80">

                            <div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
                                <a class="text-lg" href="/activities/view/<?= $activity->id ?>">
                                    View Activity Record
                                </a>
                            </div>
                            <div class="mb-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
                                <strong>Hyperlink:</strong> <?= $activity->hyperlink ?>
                            </div>
                            <!-- <div class="mb-3 p-3 bg-slate-800 rounded-lg">
			<strong>Activity type:</strong> <?= $activity->activity_type->name ?>
		</div> -->

                            <div class="p-3 bg-white dark:bg-slate-800 rounded-lg">
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
                                                this.message = '';
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
                                        'url' =>
                                        ['controller' => 'reports', 'action' => 'add'],
                                        'class' => '',
                                        'x-data' => 'report' . $activity->id . 'Form()',
                                        '@submit.prevent' => 'submitData'
                                    ]
                                ) ?>

                                <p>Is there something wrong with this activity? Report it!</p>
                                <?php
                                echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                                echo $this->Form->hidden('user_id', ['value' => $uid]);
                                ?>
                                <label>Your Issue
                                    <?php
                                    echo $this->Form->textarea('issue', [
                                        'class' =>
                                        'w-full h-20 bg-slate-200/80 dark:bg-slate-700 text-white rounded-lg',
                                        'x-model' => 'form' . $activity->id . 'Data.issue',
                                        'placeholder' => 'Type here ...',
                                        'required' => 'required'
                                    ]);
                                    ?>
                                </label>
                                <input type="submit" class="mt-1 mb-4 px-4 py-2 text-white bg-sky-700 rounded-lg" value="Submit Report">

                                <!--
<button class="mt-1 mb-4 px-4 py-2 bg-sky-700 rounded-lg" :disabled="formLoading" x-text="buttonText"></button>
-->

                                <span x-text="message"></span> <a href="/profile/reports">See all your reports</a>

                                <?= $this->Form->end() ?>

                            </div>
                        </div>
                    </div>
                </div>



            </div>
        <?php endforeach; // end of activities loop for this step 
        ?>

    <?php endif ?>


    <?php if (!empty($archivedacts)) : ?>
        <h4>Archived Activities</h4>
        <div class="p-2 bg-white dark:bg-black">This step used to have these activities assigned to them, but they are no
            longer considered relevant or appropriate for one reason or another. They
            are listed here for posterity. <a class="" data-toggle="collapse" href="#defunctacts" aria-expanded="false" aria-controls="defunctacts">View archived activities</a>.
        </div>
        <div class="collapse bg-white p-3" id="defunctacts">
            <?php foreach ($archivedacts as $activity) : ?>
                <h5>
                    <a href="/activities/view/<?= $activity->id ?>">
                        <i class="bi <?= $activity->activity_type->image_path ?>"></i>
                        <?= $activity->name ?>
                    </a>
                </h5>
                <div class="p-2">
                    <?= $activity->description ?>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (!empty($previousid) || !empty($upnextid)) : ?>
        <div class="flex justify-center p-3 bg-white dark:bg-slate-900/80 rounded-lg">
            <?php if (!empty($previousid)) : ?>
                <a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $previousid ?>/<?= $previousslug ?>" class="inline-block m-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-lg hover:no-underline">
                    Previous Step
                </a>
            <?php endif ?>

            <?php if (!empty($upnextid)) : ?>
                <a href="/<?= h($step->pathways[0]->topic->categories[0]->slug) ?>/<?= h($step->pathways[0]->topic->slug) ?>/pathway/<?= $pathways->slug ?>/s/<?= $upnextid ?>/<?= $upnextslug ?>" class="inline-block m-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-lg hover:no-underline">
                    Next Step
                </a>
            <?php endif ?>
        </div>
    <?php endif ?>

    </div>
</div>
</div>

<script>
    window.onload = function(event) {
        loadStatus();
    };

    function loadStatus() {
        fetch('/pathways/status/<?= $step->pathways[0]->id ?>', {
                method: 'GET'
            })
            .then((res) => res.json())
            .then((json) => {
                if (json.percentage > 0) {
                    let message = json.percentage + '% - ' + json.completed + ' of ' + json.requiredacts + '';
                    if (json.percentage > 25) {
                        document.querySelector('.pbar').style.width = json.percentage + '%';
                    }
                    if (json.percentage == 100) {
                        document.querySelector('.pbar').innerHTML = message + ' - COMPLETED!';
                    } else {
                        document.querySelector('.pbar').innerHTML = message;
                    }
                } else {
                    document.querySelector('.pbarcontainer').innerHTML = '<span class="inline-block pt-1 px-3 h-8">Launch activities to see your progress here&hellip;</span>';
                }
                //console.log(json);
            })
            .catch((err) => console.error("error:", err));
    }
</script>
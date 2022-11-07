<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Action[]|\Cake\Collection\CollectionInterface $activitys
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>

<header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/1200w/flickr-james-wheeler-49993278088_08ea00ed09_k_1200w.jpg);">
    <div class="bg-sagedark/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Activities</h1>
    </div>
</header>
<div class="p-8 text-lg" id="mainContent">
    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">Recent Activities</h2>

        <p class="mb-3 text-xl">Explore recently added activities in all categories.</p>

        

    </div>
    <div class="max-w-full flex flex-col lg:flex-row lg:gap-4 sticky bg-white -top-[2px] z-50 py-2">
        <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
        <div class="text-sm text-sky-700">
            <!-- TODO Allan update pagination and styling -->
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?php $this->Paginator->numbers()
            ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
            <div class="mb-3 text-slate-700">
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}} | {{count}} total activities')) ?>
            </div>


        </div>
        </div>
        <!-- sort options appear to the side on larger screens, but on top on smaller screens -->
        <div class="lg:basis-1/5">
            <div class="flex justify-end lg:justify-start gap-4">
                <!-- TODO Allan add working sort and filter options -->
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
        </div>
    </div>
    <div class="lg:columns-2 gap-4">
                <?php foreach ($activities as $activity) : ?>
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

                    <div class="w-full inline-block mb-4 p-0.5 rounded-md bg-sagedark hover:bg-sagedark/80 ">
                        <div class="flex flex-row justify-between">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-journal-text mx-3 my-4 flex-none" viewBox="0 0 16 16">
                                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                            </svg>
                            <!-- TODO Allan Change icon for activity based on activity type -->
                            <div class="bg-white inset-1 rounded-r-sm flex-1">
                                <div x-data="{ count: <?= $completed ?>, liked: <?= $activity->recommended ?> }">
                                    <div class="p-3 text-lg">
                                        <a href="/profile/launches" class="inline-block p-0.5 px-2 bg-sky-700 text-white text-xs text-center uppercase rounded-lg hover:no-underline hover:bg-sky-700/80" :class="[count > '0' ? 'show' : 'hidden']">
                                            Launched
                                        </a>
                                        <h4 class="mb-2 mt-1 text-xl font-semibold">
                                            <?= $activity->name ?>
                                        </h4>
                                        <?php if (!empty($activity->description)) : ?>
                                            <?= $activity->description ?>
                                        <?php else : ?>
                                            <p><em>No description provided&hellip;</em></p>
                                        <?php endif ?>
                                        <?php if (!empty($activity->_joinData->stepcontext)) : ?>
                                            <em>Curator says:</em><br>
                                            <?= $activity->_joinData->stepcontext ?>
                                        <?php endif ?>
                                        <?php if (!empty($activity->isbn)) : ?>
                                            ISBN: <?= $activity->isbn ?>
                                        <?php endif ?>
                                        <!-- <form action="/activities/like/<?= $activity->id ?>"
                        x-on:click="liked++"
                        @submit.prevent="submitData">
                    <button><span x-text="liked"></span> likes</button>
                    </form> -->
                    <!-- TODO Allan to update video preview embed functionality -->
                                        <?php
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $activity->hyperlink, $youtube);
                                        if (!empty($youtube[1])) :
                                        ?>
                                            <img src="https://i.ytimg.com/vi/<?= $youtube[1] ?>/hqdefault.jpg" x-on:click="count++; fetch('/activities-users/launch?activity_id=<?= $activity->id ?>')">
                                            <div class="hidden w-full z-50 h-auto bg-black/50" x-on:click="count++; fetch('/activities-users/launch?activity_id=<?= $activity->id ?>')">
                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $youtube[1] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                        <?php endif ?>
                                        <a target="_blank" x-on:click="count++;" onclick="loadStatus();" rel="noopener" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $activity->id ?>" class="inline-block my-2 p-2 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-lg hover:no-underline">
                                            Launch
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                                <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                            </svg>
                                        </a>
                                        <!-- TODO Nori different launch icon? -->
                                        <!-- TODO Allan Long hyperlinks breaking cards on more info. Add to site js, see https://css-tricks.com/better-line-breaks-for-long-urls/ -->
                                        <div x-data="{ open: false }">
                                            <button @click="open = !open" class="text-sm text-sky-700 text-right">
                                                <span>More info</span>
                                                <svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="w-full">
                                                <p><strong>Hyperlink:</strong> <?= $activity->hyperlink ?></p>
                                                <!-- <div class="mb-3 p-3bg-white dark:bg-slate-800 rounded-lg">
                    <strong>Activity type:</strong> <?= $activity->activity_type->name ?>
                    </div> -->
                                                <p>
                                                    <a class="text-lg text-sky-700 hover:underline" href="/activities/view/<?= $activity->id ?>">
                                                        View Activity Record
                                                    </a>
                                                </p>
                                                <div class="bg-gray-200 p-3 rounded-md">
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
                                                    <p class="font-semibold">Report an issue with this activity</p>
                                                    <?php
                                                    echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                                                    echo $this->Form->hidden('user_id', ['value' => $uid]);
                                                    ?>
                                                    <label>
                                                        <?php
                                                        echo $this->Form->textarea(
                                                            'issue',
                                                            [
                                                                'class' => 'w-full h-20 p-3 bg-white rounded-lg',
                                                                'x-model' => 'form' . $activity->id . 'Data.issue',
                                                                'placeholder' => 'Type here ...',
                                                                'required' => 'required'
                                                            ]
                                                        );
                                                        ?>
                                                    </label>
                                                    <input type="submit" class="inline-block px-4 py-2 text-white text-md bg-slate-700 focus:text-slate-900 hover:bg-slate-700/80 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg cursor-pointer my-2" value="Submit Report">
                                                    <span x-text="message" class="ml-1 text-sm text-sky-700"></span>
                                                    <p class="text-sm hover:underline "><a href="/profile/reports">See all your reports</a></p>
                                                    <?= $this->Form->end() ?>
                                                </div>
                                            </div> <!-- end hidden more info -->
                                        </div><!-- end more info dropdown -->
                                    </div>
                                </div> <!-- click count increment container -->
                            </div> <!-- end white inner box -->
                        </div>
                    </div>








                <?php endforeach; // end of activities loop for this step 
                ?>
            </div>
</div>
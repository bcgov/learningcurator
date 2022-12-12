<?php
$this->assign('title', 'Activities you\'ve claimed');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType[]|\Cake\Collection\CollectionInterface $activityTypes
 */
?>
<header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/1200w/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed_1200w.jpg);">
    <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">My Curator</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://flic.kr/p/JULZFP" target="_blank">Paradise Meadows Boardwalk</a> by <a href="https://flic.kr/ps/3bxUBu" target="_blank">Fyre Mael on Flickr</a> (<a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">CC BY 2.0</a>)</p>
</header>

<div class="p-8 text-lg" id="mainContent">

    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">Launched Activities</h2>
        <?php if (!empty($alllaunches)) : ?>
            <p class="mb-3 text-xl">
                As you launch activities on a pathway, they will be recorded here,
                along with the date and time when you clicked the launch button.</p>
    </div>
    <!-- TODO Allan show pagination/sort options here for 10+ items? -->
    <div class="max-w-full flex flex-col lg:flex-row lg:gap-4 sticky bg-white -top-[2px] z-50 py-2">
        <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
            <div class="text-sm text-sky-700">

                Pagination placeholder

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
        <?php foreach ($alllaunches as $a) : ?>

            <div class="w-full inline-block mb-4 rounded-md bg-sagedark p-0.5">
                <div class="flex flex-row justify-between">
                    <!-- TODO fix the path to get to the right data for activity types. Couldn't figure it out -->
                    <div class="mx-3 my-4 flex-none"></div>
                    <!-- <i class="<?= h($a->image_path) ?> mx-3 my-4 flex-none" style="color:white; font-size: 2rem;" aria-label="<?= h($a->activity_type->name) ?>"></i> -->
                    <div class="bg-white inset-1 rounded-r-sm flex-1">
                        <div class="p-3 text-lg">
                            <h4 class="mb-2 mt-1 text-xl font-semibold">
                                <?= $a['name'] ?>
                            </h4>


                            <ul class="list-disc pl-8 mt-2 text-lg ">
                                <li>
                                    <a class="hover:underline hover:text-sky-700" href="/activities/view/<?= $a['id'] ?>">
                                        View Activity Record
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" rel="noopener" data-toggle="tooltip" data-placement="bottom" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $a['id'] ?>" class="hover:underline hover:text-sky-700">
                                        Launch Activity
                                    </a>
                                </li>
                            </ul>
                            <div class="mt-3 text-sm">
                                <p class="mb-0">
                                    <span class="font-semibold">Launched: </span><?= count($a['launches']) ?> times
                                </p>
                                <p class="mt-0 mb-0">
                                    <span class="font-semibold">Last launched: </span><?php ?>
                                    <span class="inline-block">
                                        <?= $this->Time->format($a['launches'][0]['date'], \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                                    </span>
                                    <?php ?>
                                </p>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <h3 class="mb-3 text-xl font-semibold">You haven't launched any activities yet</h3>
        <p>As you launch activities on a pathway, they will be recorded here
            along with the date and time that you clicked the launch button.</p>
        <p>Pathway modules have one or more required activities. When you launch
            a required activity, that action counts towards your pathway progress,
            indicated by the progress bar.</p>

        <a href="/categories" class="inline-block p-3 mt-4 mr-4 bg-sagedark text-white text-xl hover:no-underline rounded-lg">
            Explore Categories
        </a>
        <a href="/pathways" class="inline-block p-3 mt-4 bg-darkblue text-white text-xl hover:no-underline rounded-lg">
            Explore Pathways
        </a>
    <?php endif ?>
    </div>
</div>
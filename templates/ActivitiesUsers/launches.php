<?php
$this->assign('title', 'Activities you\'ve claimed');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed.jpg);">
    <div class="bg-bluegreen/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">My Curator</h1>
    </div>
</header>
<!-- TODO Q should the title be followed pathways? My Curator? -->
<div class="p-8 text-lg">
    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">Launched Activites</h2>

        <p class="mb-3">
            As you launch activities on a pathway, they will be recorded here,
            along with the date and time when you clicked the launch button.</p>
    </div>
    <!-- TODO Q do we need pagination/sorth options here? -->
    <div class="max-w-full flex flex-col lg:flex-row lg:gap-4 sticky bg-white -top-[2px] z-50 py-2">
        <div class="lg:basis-4/5 max-w-prose order-last lg:order-first">
            <div class="text-sm text-sky-700">
                <!-- TODO Allan add in pagination? -->

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

    <?php if (!empty($alllaunches)) : ?>
        <div class="grid lg:grid-cols-2 gap-4 items-start">
            <?php foreach ($alllaunches as $a) : ?>
                <!-- TODO Q - does this look weird with the different sized cards? Masonry type layout may be better if possible  -->

                <div class="align-self-start rounded-md bg-sagedark hover:bg-sagedark/80 p-0.5">
                    <div class="flex flex-row justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-journal-text mx-3 my-4 flex-none" viewBox="0 0 16 16">
                            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                        </svg>
                        <!-- TODO Allan Change icon for activity based on activity type -->
                        <div class="bg-white inset-1 rounded-r-sm flex-1">
                            <div class="p-3 text-lg">
                                <h4 class="mb-3 mt-1 text-2xl">
                                    <a href="/activities/view/<?= $a['id'] ?>">
                                        <?= $a['name'] ?>
                                    </a>
                                </h4>
                                <div class="mt-3">
                                    <p class="text-sm">
                                        <span class="font-semibold">Launched: </span><?php foreach ($a['launches'] as $ls) : ?>
                                            <span class="inline-block">
                                                <?= $this->Time->format($ls['date'], \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                                            </span>
                                        <?php endforeach ?>
                                    </p>

                                </div>
                                <!-- TODO Q do we want description/objective here, more info? or just abbreviated? -->

                                <?php if (!empty($a->description)) : ?>
                                    <?= $a->description ?>
                                <?php else : ?>
                                    <p><em>No description provided&hellip;</em></p>
                                <?php endif ?>

                                <a target="_blank" rel="noopener" data-toggle="tooltip" data-placement="bottom" title="Launch this activity" href="/activities-users/launch?activity_id=<?= $a['id'] ?>" class="inline-block my-2 p-2 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-lg hover:no-underline">
                                    Launch
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <!-- TODO Nori compare this to getting started page for pathways -->
            <!-- TODO Nori figure out why this short page isn't showing the footer within the screen height but the pathways page is -->
        <?php else : ?>
            <div class="p-8 text-xl max-w-prose">
                <h2 class="mb-3 text-2xl text-darkblue font-semibold">You haven't launched any activities yet</h2>
                <div class="p-4 text-xl">
                    <p>As you launch activities on a pathway, they will be recorded here
                        along with the date and time that you clicked the launch button.</p>
                    <p>Pathway modules have one or more required activities. When you launch
                        a required activity, that action counts towards your pathway progress,
                        indicated by the progress bar.</p>
                </div>

                <a href="/categories" class="inline-block p-3 mt-4 mr-4 bg-sagedark text-white text-xl hover:no-underline rounded-lg">
                    Explore Categories
                </a>
                <a href="/pathways" class="inline-block p-3 mt-4 bg-darkblue text-white text-xl hover:no-underline rounded-lg">
                    Explore Pathways
                </a>

            </div>
        <?php endif ?>
        </div>
</div>
</div>
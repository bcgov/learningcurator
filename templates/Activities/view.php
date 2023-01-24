<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = '';
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>
<header class="w-full h-52 bg-cover bg-center pb-2 px-2" style="background-image: url(/img/categories/1200w/flickr-james-wheeler-49993278088_08ea00ed09_k_1200w.jpg);">
    <div class="bg-sagedark/90 h-44 w-72 drop-shadow-lg mb-6 mx-6 p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Activities</h1>
    </div>
    <p class="text-xs text-white float-right -mt-3 mb-0 bg-black/20 p-0.5">Photo: <a href="https://www.pexels.com/photo/brown-wooden-pathway-in-the-middle-of-green-grass-and-trees-3988366/" target="_blank">Tofino Pathway</a> by <a href="https://www.pexels.com/@souvenirpixels/" target="_blank">James Wheeler on Pexels</a></p>
</header>
<div class="p-8 text-lg" id="mainContent">
    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">Activity Record: <span class="text-slate-900"><?= $activity->name ?></span></h2>


        <div class="w-full inline-block mb-4 p-0.5 rounded-md bg-sagedark">
            <div class="flex flex-row justify-between">
            <i class="<?= h($activity->activity_type->image_path) ?> mx-3 my-4 flex-none" style="color:white; font-size: 2rem;" aria-label="<?= h($activity->activity_type->name) ?>"></i>
                <div class="bg-white inset-1 rounded-r-sm flex-1">
                    <div class="p-3 text-lg">
                        <?php 
                        $show = 'hidden'; 
                        if($claimid > 0) $show = 'inline-block';
                        ?>
                        <a href="/profile/launches" id="launchbadge" class="<?= $show ?> p-0.5 px-2 bg-sky-700 text-white text-xs text-center uppercase rounded-lg hover:no-underline hover:bg-sky-700/80">
                            Launched
                        </a>
                        
                        <h4 class="mb-2 mt-1 text-xl font-semibold">
                            <?= $activity->name ?>
                        </h4>
                        <div class="">
                            <?php if (!empty($activity->description)) : ?>
                                <div class="autop"><?= $this->Text->autoParagraph(h($activity->description)); ?></div>
                            <?php else : ?>
                                <p><em>No description provided&hellip;</em></p>
                            <?php endif ?>
                        </div>
                        <?php if (!empty($activity->_joinData->stepcontext)) : ?>
                            <div class="text-sm italic mt-2">
                                Curator says:
                                <blockquote class="border-l-2 p-2 m-2"><?= $activity->_joinData->stepcontext ?></blockquote>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($activity->isbn)) : ?>
                            <p class="mt-2">ISBN: <?= $activity->isbn ?></p>
                        <?php endif ?>
                        <!-- <form action="/activities/like/<?= $activity->id ?>"
                        x-on:click="liked++"
                        @submit.prevent="submitData">
                    <button><span x-text="liked"></span> likes</button>
                    </form> -->
                        <!-- <a href="/activities/like/<?= $activity->id ?>" class="inline-block ml-6" title="Like this activity">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                                    </svg>
                                    <span class="lcount"><?= h($activity->recommended) ?> likes</span>
                                </a> -->
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
                        <?php if ($activity->status_id == 2) : ?>

                            <div class="">
                                <a target="_blank" 
                                    rel="noopener" 
                                    title="Launch this activity" 
                                    href="/activities-users/launch?activity_id=<?= $activity->id ?>" 
                                    onclick="showBadge()"
                                    class="inline-block my-2 p-2 bg-darkblue hover:bg-darkblue/80 rounded-lg text-white text-lg hover:no-underline">
                                        Launch
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                            <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                        </svg>
                                </a>
                                <script>
                                    function showBadge() {
                                        document.querySelector('#launchbadge').classList.remove('hidden');
                                    }
                                </script>
                            </div>
                        <?php elseif ($activity->status_id == 3) : ?>
                            <h4 class="font-semibold mb-1">Archived Activity</h4>
                            <p class="mb-1">This activity has been archived, so its link will not be shown. If you are a curator you can still access the hyperlink by editing this activity.</p>
                        <?php endif ?>
                    </div>
                    <!-- click count increment container -->
                </div> <!-- end white inner box -->
            </div>
        </div>
        <?php if ($role == 'curator' || $role == 'superuser') : ?>
            <div class="my-3">
                <?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'inline-block px-3 py-1 text-white text-base bg-slate-700 focus:bg-slate-700/80 hover:no-underline rounded-lg']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activity->id], ['confirm' => __('Really delete?'), 'class' => 'inline-block px-3 py-1 text-base hover:bg-red-700/80 text-white bg-red-700 hover:no-underline rounded-lg']) ?>
            </div>
<!-- TODO maybe change this from a label to a different format. Looks out of place here. -->
            <?php if ($activity->status_id == 3) : ?>
                <span class="bg-red-400 text-slate-900 mt-3 py-1 px-2 rounded-full mr-3 text-base uppercase inline-block">Archived</span>
            <?php endif ?>
            <?php if ($activity->moderation_flag == 1) : ?>
                <!-- <span class="bg-orange-400 text-slate-900 py-1 px-2 rounded-full mr-2 text-sm">INVESTIGATE</span> -->
            <?php endif ?>
        <?php endif; // role check 
        ?>
        <?php foreach ($activity->tags as $tag) : ?>
            <a href="/tags/view/<?= h($tag->id) ?>" class="bg-slate-200 py-1 px-2 rounded-full mr-3"><?= $tag->name ?></a>
        <?php endforeach ?>

        <h4 class="font-semibold  text-xl mt-5">Activity Details</h4>

        <ul class="list-disc pl-8 mt-2">
            <li class="px-2"><strong>Activity added:</strong> <?= $this->Time->format($activity->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?> </li>
            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                <li class="px-2"><strong>Added by:</strong> <a href="/users/view/<?= $activity->createdby_id ?>"><?= $curator[0]->username ?></a></li>
            <?php endif ?>
            <li class="px-2"><strong>Last Automatic Audit:</strong> <?= $this->Time->format($activity->audited, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></li>
            <li class="px-2" x-data="{ input: '<?= $activity->hyperlink ?>', tooltip: 'Click to copy link', showMsg: false }"><strong>Hyperlink: </strong>
                <?= $activity->hyperlink ?> <button @click="$clipboard(input), showMsg = true" class="bg-sky-700 text-white rounded-lg py-1 px-2 ml-1 text-base hover:cursor-pointer hover:bg-sky-700/80"><i class="" :class="{'bi bi-clipboard2 ': !showMsg, 'bi bi-clipboard2-check': showMsg }" alt="Copy link"></i> <span x-show="!showMsg">Copy link</span><span x-cloak x-show="showMsg">Copied!</span></button></li>
        </ul>

        <?php if (count($activitylaunches) > 0) : ?>
            <h4 class="font-semibold  text-xl mt-5">Activity Launches</h4>
            <p class="mb-2">You launched this activity on the following dates:</p>
            <ul class="list-disc pl-8">
                <?php foreach ($activitylaunches as $u) : ?>
                    <li class="px-2">
                        <?= $this->Time->format($u[1], \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?>
                        <?= $this->Form->postLink(__('Delete record'), ['controller' => 'ActivitiesUsers', 'action' => 'delete/' . $u[0]], ['class' => 'inline-block mt-3 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base ml-2', 'confirm' => __('Delete?')]) ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <?php if ($role == 'curator' || $role == 'superuser') : ?>
            <?php if (!empty($activity->moderator_notes)) : ?>
                <h4 class="font-semibold text-xl mt-5"><?= __('Curator Notes') ?></h4>
                <blockquote class="border-l-2 p-2 m-2">
                    <?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
                </blockquote>
            <?php endif ?>
        <?php endif; ?>

        <?php if (!empty($activity->steps)) : ?>
            <h4 class="font-semibold text-xl mt-5">Related Pathways</h4>
            <p class="mb-2">This activity is included in the following pathways:</p>
            <ul class="list-disc pl-8">
                <?php foreach ($activity->steps as $step) : ?>
                    <?php foreach ($step->pathways as $path) : ?>
                        <?php if ($path->status_id == 2) : ?>
                            <li class="px-2">
                                <a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a>
                            </li>

                        <?php else : ?>
                            <li class="px-2">
                                <span class="bg-orange-400 text-slate-900 py-1 px-2 rounded-full mr-2 text-sm">DRAFT</span>
                                <a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a>
                            </li>

                        <?php endif ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
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
                            'required' => 'required'
                        ]
                    );
                    ?>
                </label>
                <input type="submit" class="inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg cursor-pointer my-3" value="Submit Report">
                <span x-text="message" class="ml-1 text-sm text-sky-700"></span>
                <p class="text-sm hover:underline mb-1"><a href="/profile/reports">See all your reports</a></p>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
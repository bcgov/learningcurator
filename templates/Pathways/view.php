<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}

$this->assign('title', h($pathway->name));

?>
<header class="w-full h-52 bg-cover bg-center pb-8 px-8" style="background-image: url(/img/categories/Paradise_Meadows_Boardwalk-strathcona_Provincial-park-compressed.jpg);">
    <div class="bg-sky-700/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">Pathways</h1>
    </div>
</header>
<div class="p-8 pt-4 w-full text-lg">

    <nav class="mb-4 text-slate-500 text-sm" aria-label="breadcrumb">
        <a href="/category/<?= h($pathway->topic->categories[0]->id) ?>/<?= h($pathway->topic->categories[0]->slug) ?>" class="hover:underline"><?= h($pathway->topic->categories[0]->name) ?></a> >
        <a href="/category/<?= h($pathway->topic->categories[0]->id) ?>/<?= h($pathway->topic->categories[0]->slug) ?>/topic/<?= h($pathway->topic->id) ?>/<?= h($pathway->topic->slug) ?>" class="hover:underline"><?= h($pathway->topic->name) ?></a> >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost-2 mr-1 inline-block" viewBox="0 0 16 16">
            <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
        </svg><?= h($pathway->name) ?>
    </nav>



    <div class="max-w-prose">
        <div class="p-3 mb-3 mt-8 bg-bluegreen text-white rounded-l-full  flex justify-start items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-signpost-2 mx-3 grow-0" viewBox="0 0 16 16">
                <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z" />
            </svg>
            <h2 class="text-2xl flex-1">
                <?= h($pathway->name) ?>
                <?php if ($pathway->status_id == 1) : ?>
                    <span class="bg-orange-400 text-white rounded-full px-2 py-1 text-sm align-middle" title="Edit to set to publish">DRAFT</span>
                <?php endif ?>
            </h2>
            <span class="text-sm ml-3 justify-self-end flex-none"><?= $stepcount ?> steps | <?= $requiredacts ?> activities</span>
        </div>

        <div class="pl-8 text-xl">

            <p><span class="font-bold">Objective: </span>
                <?= $pathway->objective ?></p>
            <?php if (empty($followid)) : ?>
                <div class="my-3">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-users', 'action' => 'follow']]) ?>
                    <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $pathway->id]) ?>
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

            <h3 class="mt-4 mb-1 text-darkblue font-semibold text-lg">Activity Progress</h3>
            <div class="flex pbarcontainer mb-3 w-full bg-slate-200 rounded-lg outline-slate-500 outline outline-1 outline-offset-2 content-center justify-between">
                <span class="py-2 px-3 bg-darkblue text-white rounded-lg text-base pbar pro flex-none"></span>
                <span class="py-2 px-3 text-base total"></span>
            </div>
            <!-- TODO Nori adjust progress bar text when percentage is small and doesn't fit text -->
            <script>
                fetch('/pathways/status/<?= $pathway->id ?>', {
                        method: 'GET'
                    })
                    .then((res) => res.json())
                    .then((json) => {
                        if (json.percentage > 0) {
                            let launched = json.completed + ' launched';
                            let remaining = (json.requiredacts - json.completed) + ' remaining';

                            document.querySelector('.pbar').style.width = json.percentage + '%';

                            if (json.percentage == 100) {
                                document.querySelector('.pro').innerHTML = 'Pathway completed!';
                            } else {
                                document.querySelector('.pro').innerHTML = launched;
                                document.querySelector('.total').innerHTML = remaining;
                            }

                        } else {
                            document.querySelector('.pbarcontainer').innerHTML = '<span class="py-2 px-3 text-base text-right flex-1">' + json.requiredacts + ' activities remaining</span>';
                        }
                        //console.log(json);
                    })
                    .catch((err) => console.error("error:", err));
            </script>



            <?php if ($role == 'curator' || $role == 'superuser') : ?>
                <div x-data="{ open: false }" class="mb-8">
                    <div class="flex justify-start gap-4">
                        <?= $this->Html->link(__('Edit Pathway'), ['action' => 'edit', $pathway->id], ['class' => 'px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg flex-none justify-self-start']) ?>
                        <button @click="open = ! open" class=" px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">
                            Add a Step
                        </button>
                    </div>

                    <div xcloak x-show="open" class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
                        <?= $this->Form->create(null, ['url' => [
                            'controller' => 'Steps',
                            'action' => 'add'
                        ]]) ?>
                        <?php
                        echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
                        echo $this->Form->control('description', ['class' => ' block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg', 'type' => 'textarea', 'label' => 'Objective']);
                        echo $this->Form->hidden('createdby', ['value' => $uid]);
                        echo $this->Form->hidden('modifiedby', ['value' => $uid]);
                        echo $this->Form->hidden('pathways.0.id', ['value' => $pathway->id]);
                        ?>
                        <?= $this->Form->button(__('Add Step'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>


            <?php endif ?>
<!-- TODO Nori sometimes objective has added line breaks? -->
<!-- TODO Nori change to simple numbers in blue, then add subtitle and title in box -->
            <?php if (!empty($pathway->steps)) : ?>

                <?php foreach ($pathway->steps as $steps) : ?>
                    <?php $requiredacts = 0; ?>
                    <?php foreach ($steps->activities as $act) : ?>
                        <?php if ($act->_joinData->required == 1) $requiredacts++; ?>
                    <?php endforeach ?>
                    <?php //echo '<pre>'; print_r($steps); continue; 
                    ?>
                    <!-- count required activities -->
                    <?php if ($steps->status->name == 'Published') : ?>
                        <div class="mt-4 text-lg border-2 border-bluegreen rounded-lg flex justify-start">
                            <h3 class="text-xl flex-none bg-bluegreen text-white basis-1/7 p-3"><?= h($steps->name) ?></h3>
                            <div class="flex-1 basis-6/7 p-3">
                                <p class="text-bluegreen font-semibold text-base">
                                    <?= $requiredacts ?> required activities</p>
                                <p class="mb-2"><span class="font-semibold">Objective: </span><?= $steps->description ?></p>
                                <p class="mb-2"> <a href="/<?= h($pathway->topic->categories[0]->slug) ?>/<?= $pathway->topic->slug ?>/pathway/<?= $pathway->slug ?>/s/<?= $steps->id ?>/<?= $steps->slug ?>" class="text-sky-700 underline">
                                        View <strong><?= h($steps->name) ?></strong>
                                    </a> </p>
                                <!-- <?php if ($role == 'curator' || $role == 'superuser') : ?>
                                    <span class="text-xs px-4 bg-slate-100/80 dark:bg-emerald-700 rounded-lg"><?= $steps->status->name ?></span>
                                <?php endif ?> -->
                            </div>
                        </div>


                    <?php endif; // if published 
                    ?>
                <?php endforeach ?>
                </nav>
        </div>


    </div>
</div>




<?php else : ?>
    <div>There don't appear to be any steps assigned to this pathway yet.</div>
<?php endif; // are there any steps at all? 
?>

</div>
</div>
</div>
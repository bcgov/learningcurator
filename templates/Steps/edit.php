<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */

$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<!-- TODO collapse step edit info - highlight activities stuff -->
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Step: <span class="text-slate-900"><a href="/pathways/<?= $step->pathways[0]->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
                <?= $step->pathways[0]->name ?>, <?= $step->name ?>
            </a></span></h2>
    <div x-data="{openTab: 0}">
        <div class="flex justify-start gap-4 my-5">
            <button @click="openTab = 1" :class="{ 'bg-slate-200 text-slate-900' : openTab === 1 }" class="px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">
                Add Existing Activity
            </button>

            <button @click="openTab = 2" :class="{ 'bg-slate-200 text-slate-900' : openTab === 2 }" class=" px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">
                Add New Activity
            </button>
            <button @click="openTab = 3" :class="{ 'bg-slate-200 text-slate-900' : openTab === 3 }" class=" px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">
                Edit Current Step
            </button>
            <button @click="openTab = 4" :class="{ 'bg-slate-200 text-slate-900' : openTab === 4 }" class=" px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">
                Add New Step
            </button>
        </div>
        <div class="max-w-prose">
            <div xcloak x-show="openTab === 1" class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
                <h3 class="font-semibold">Add Existing Activity to this Step</h3>
                <form method="get" id="actfind" action="/activities/stepfind" class="my-2 flex justify-between gap-2">
                    <input class="form-field" type="search" placeholder="Activity Search" aria-label="Search" name="q">
                    <input type="hidden" name="step_id" value="<?= $step->id ?>">
                    <button class="px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg" type="submit">Search</button>
                </form>
                <ul class="list-group list-group-flush" id="results">
                </ul>
            </div>
            <div xcloak x-show="openTab === 2" class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
                <h3 class="font-semibold">Add New Activity to this Step</h3>
                <?= $this->Form->create(null, ['url' => ['controller' => 'Activities', 'action' => 'addtostep']]) ?>
                <?php
                echo $this->Form->hidden('createdby_id', ['value' => $this->Identity->get('id')]);
                echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id')]);
                echo $this->Form->hidden('step_id', ['value' => $step->id]);
                ?>
                <div class="mt-2"> <?php echo $this->Form->control('hyperlink', ['class' => 'form-field']); ?></div>
                <div class="mt-2"><?php echo $this->Form->control('name', ['class' => 'form-field']); ?></div>
                <div class="mt-2"><label for="description">Description</label>
                    <?php echo $this->Form->textarea('description', ['class' => 'form-field']) ?></div>
                <?= $this->Form->button(__('Save Activity'), ['class' => 'px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mt-3']) ?>
                <?= $this->Form->end() ?>
            </div>
            <div xcloak x-show="openTab === 3" class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block max">
                <h3 class="font-semibold">Edit Current Step</h3>

                <?= $this->Form->create($step) ?>
                <?= $this->Form->hidden('image_path', ['class' => 'form-field']) ?>
                <?= $this->Form->hidden('featured', ['class' => 'form-field']) ?>
                <?= $this->Form->hidden('modifiedby') ?>
                <?= $this->Form->hidden('pathway_id', ['value' => $step->pathway_id]) ?>
                <?= $this->Form->control('status_id', ['options' => $statuses, 'class' => 'form-field']) ?>
                <div class="mt-2"><?= $this->Form->control('name', ['class' => 'form-field']) ?></div>
                <?php  //$this->Form->control('slug', ['class' => 'p-3 bg-slate-300 dark:bg-slate-800 rounded-lg']);
                ?>
                <div class="mt-2"><?= $this->Form->control('description', ['class' => 'form-field', 'label' => 'Objective']) ?></div>
                <?= $this->Form->button(__('Save Step Details'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
                <?= $this->Form->end() ?>
                <?= $this->Form->postLink(
                    __('Delete Step'),
                    ['action' => 'delete', $step->id],
                    [
                        'class' => 'inline-block mt-3 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base',
                        'confirm' => __('Are you sure you want to delete # {0}?', $step->name)
                    ]
                );
                ?>
            </div>
            <div xcloak x-show="openTab === 4" class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
                <h3 class="font-semibold">Add New Step to Pathway</h3>
                <?= $this->Form->create(null, ['url' => [
                    'controller' => 'Steps',
                    'action' => 'add'
                ]]) ?>
                <div class="mt-2">
                    <?php
                    echo $this->Form->control('name', ['class' => 'form-field']); ?></div>
                <div class="mt-2"><?php echo $this->Form->control('description', ['class' => 'form-field', 'type' => 'textarea', 'label' => 'Objective']);
                                    echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
                                    echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);
                                    echo $this->Form->hidden('pathways.0.id', ['value' => $step->pathways[0]->id]);
                                    ?></div>
                <?= $this->Form->button(__('Add Step'), ['class' => 'px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mt-3']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>


    <?php  //$this->Form->control('activities._ids', ['options' => $activities]) 
    $reqtmp = array();
    $supptmp = array();
    $requiredacts = array();
    $supplementalacts = array();
    // Loop through the whole list, add steporder to tmp array
    foreach ($step->activities as $line) {
        if ($line->_joinData->required == 1) {
            array_push($requiredacts, $line);
        } else {
            array_push($supplementalacts, $line);
        }
    }
    foreach ($requiredacts as $line) {
        $reqtmp[] = $line->_joinData->steporder;
    }
    foreach ($supplementalacts as $line) {
        $supptmp[] = $line->_joinData->steporder;
    }
    // Use the tmp array to sort acts list
    array_multisort($reqtmp, SORT_DESC, $requiredacts);
    array_multisort($supptmp, SORT_DESC, $supplementalacts);
    ?>

    <?php if (count($requiredacts) === 1) : ?>
        <h4 class="font-semibold mt-8 mb-3 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-2">1</span>Required Activity </h4>
    <?php else : ?>
        <h4 class="font-semibold mt-8 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-2"><?= count($requiredacts) ?></span>Required Activities </h4>
    <?php endif ?>
    <?php foreach ($requiredacts as $a) : ?>
        <div class="my-3" id="exac-<?= $a->id ?>" data-stepid="<?= $a->_joinData->id ?>">
            <div class="flex justify-start gap-4 items-center">
                <div class="basis-1/7 flex-none flex flex-col justify-center items-end text-sm">
                    <div class="">
                        <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
                        <?= $this->Form->control('sortorder', ['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
                        <?= $this->Form->control('direction', ['type' => 'hidden', 'value' => 'up']) ?>
                        <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
                        <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => $step->id]) ?>
                        <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => $a->id]) ?>
                        <button class="px-3 py-1 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">Up <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill inline-block" viewBox="0 0 16 16">
                                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                            </svg></button>
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="">
                        <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
                        <?= $this->Form->control('sortorder', ['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
                        <?= $this->Form->control('direction', ['type' => 'hidden', 'value' => 'down']) ?>
                        <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
                        <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => $step->id]) ?>
                        <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => $a->id]) ?>
                        <button class="px-3 py-1 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mt-1">Down <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill inline-block" viewBox="0 0 16 16">
                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                            </svg></button>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                <div class="basis-4/7 flex-1">
                    <div class="w-full inline-block mb-4 rounded-md bg-sagedark p-0.5">
                        <div class="flex flex-row justify-between">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-journal-text mx-3 my-4 flex-none" viewBox="0 0 16 16">
                                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                            </svg>
                            <!-- TODO Allan Change icon for activity based on activity type -->
                            <div class="bg-white inset-1 rounded-r-sm flex-1">

                                <div class="p-3 text-lg">
                                    <?php if ($a->status->name == 'Draft') : ?>
                                        <span class="bg-orange-400 text-slate-900 rounded-full px-2 py-0.5 text-sm inline-block align-top" title="Edit to set to publish">DRAFT</span>
                                    <?php else : ?>
                                        <span class="px-2 py-0.5 bg-sky-700 text-xs text-white rounded-lg inline-block align-top"><?= $a->status->name ?></span>
                                    <?php endif ?>
                                    <h4 class="mb-1 mt-1 text-xl font-semibold">
                                        <a class="hover:underline" href="/activities/view/<?= $a['id'] ?>"><?= $a['name'] ?></a>
                                    </h4>
                                    <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'edit/' . $a->_joinData->id], 'class' => '']) ?>
                                    <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $a->_joinData->id,]) ?>
                                    <label><span class="text-sm italic">Curator Context: Why is this activity on this step?</span><br>
                                        <?= $this->Form->textarea('stepcontext', [
                                            'value' => $a->_joinData->stepcontext,
                                            'class' => 'form-field',
                                            'rows' => 2
                                        ]) ?>
                                    </label>
                                    <button class="px-3 py-1 text-white text-sm bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mt-3">Save Context</button>
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="basis-2/7 flex-none flex flex-col justify-center items-start text-sm">

                    <div>
                        <?= $this->Form->create(null, ['action' => '/activities-steps/required-toggle/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
                        <?= $this->Form->hidden('id', ['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
                        <?php if ($a->_joinData->required == 0) : ?>
                            <?= $this->Form->hidden('required', ['type' => 'hidden', 'value' => 1]) ?>
                        <?php else : ?>
                            <?= $this->Form->hidden('required', ['type' => 'hidden', 'value' => 0]) ?>
                        <?php endif ?>
                        <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => $step->id]) ?>
                        <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => $a->id]) ?>
                        <?= $this->Form->button(__('Make Supplemental'), ['class' => 'px-3 py-1 text-white text-sm bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg ']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <div>
                        <?= $this->Form->create(null, ['action' => '/activities-steps/delete/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
                        <?= $this->Form->hidden('id', ['value' => $a->_joinData->id]) ?>
                        <?= $this->Form->button(__('Remove Activity'), ['class' => 'px-3 py-1 text-white text-md bg-red-700 hover:text-slate-900 hover:bg-red-200 hover:no-underline rounded-lg mt-1']) ?>
                        <?= $this->Form->end() ?>

                    </div>

                </div>
            </div>
        </div>
    <?php endforeach ?>

    <?php if (count($supplementalacts) === 1) : ?>
        <h4 class="font-semibold mt-8 mb-3 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-2">1</span>Supplemental Activity </h4>
    <?php else : ?>
        <h4 class="font-semibold mt-8 text-xl text-sagedark"><span class="bg-sagedark text-white rounded-lg text-lg inline-block px-2 mr-2"><?= count($supplementalacts) ?></span>Supplemental Activities </h4>
    <?php endif ?>
    <?php foreach ($supplementalacts as $a) : ?>
        <div class="my-3" id="exac-<?= $a->id ?>" data-stepid="<?= $a->_joinData->id ?>">
            <div class="flex justify-start gap-4 items-center">
                <div class="basis-1/7 flex-none flex flex-col justify-center items-end text-sm">
                    <div class="">
                        <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
                        <?= $this->Form->control('sortorder', ['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
                        <?= $this->Form->control('direction', ['type' => 'hidden', 'value' => 'up']) ?>
                        <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
                        <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => $step->id]) ?>
                        <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => $a->id]) ?>
                        <button class="px-3 py-1 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg">Up <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill inline-block" viewBox="0 0 16 16">
                                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                            </svg></button>
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="">
                        <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'sort/' . $a->_joinData->id], 'class' => 'inline-block']) ?>
                        <?= $this->Form->control('sortorder', ['type' => 'hidden', 'value' => $a->_joinData->steporder]) ?>
                        <?= $this->Form->control('direction', ['type' => 'hidden', 'value' => 'down']) ?>
                        <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
                        <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => $step->id]) ?>
                        <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => $a->id]) ?>
                        <button class="px-3 py-1 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mt-1">Down <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill inline-block" viewBox="0 0 16 16">
                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                            </svg></button>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                <div class="basis-4/7 flex-1">
                    <div class="w-full inline-block mb-4 rounded-md bg-sagedark p-0.5">
                        <div class="flex flex-row justify-between">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-journal-text mx-3 my-4 flex-none" viewBox="0 0 16 16">
                                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                            </svg>
                            <!-- TODO Allan Change icon for activity based on activity type -->
                            <div class="bg-white inset-1 rounded-r-sm flex-1">

                                <div class="p-3 text-lg">
                                    <span class="px-2 py-0.5 bg-sky-700 text-xs text-white rounded-lg inline-block align-top"><?= $a->status->name ?></span>
                                    <h4 class="mb-1 mt-1 text-xl font-semibold">
                                        <a class="hover:underline" href="/activities/view/<?= $a->id ?>"><?= $a->name ?></a>
                                    </h4>
                                    <?= $this->Form->create(null, ['url' => ['controller' => 'activities-steps', 'action' => 'edit/' . $a->_joinData->id], 'class' => '']) ?>
                                    <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $a->_joinData->id,]) ?>
                                    <label><span class="text-sm italic">Curator Context: Why is this activity on this step?</span><br>
                                        <?= $this->Form->textarea('stepcontext', [
                                            'value' => $a->_joinData->stepcontext,
                                            'class' => 'form-field',
                                            'rows' => 2
                                        ]) ?>
                                    </label>
                                    <button class="px-3 py-1 text-white text-sm bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mt-3">Save Context</button>
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="basis-2/7 flex-none flex flex-col justify-center items-start text-sm">
                    <div>
                        <?= $this->Form->create(null, ['action' => '/activities-steps/required-toggle/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
                        <?= $this->Form->hidden('id', ['type' => 'hidden', 'value' => $a->_joinData->id]) ?>
                        <?php if ($a->_joinData->required == 0) : ?>
                            <?= $this->Form->hidden('required', ['type' => 'hidden', 'value' => 1]) ?>
                        <?php else : ?>
                            <?= $this->Form->hidden('required', ['type' => 'hidden', 'value' => 0]) ?>
                        <?php endif ?>
                        <?= $this->Form->control('step_id', ['type' => 'hidden', 'value' => $step->id]) ?>
                        <?= $this->Form->control('activity_id', ['type' => 'hidden', 'value' => $a->id]) ?>
                        <?= $this->Form->button(__('Make Required'), ['class' => 'px-3 py-1 text-white text-sm bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg ']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <div>
                        <?= $this->Form->create(null, ['action' => '/activities-steps/delete/' . $a->_joinData->id, 'class' => 'inline-block']) ?>
                        <?= $this->Form->hidden('id', ['value' => $a->_joinData->id]) ?>
                        <?= $this->Form->button(__('Remove Activity'), ['class' => 'px-3 py-1 text-white text-md bg-red-700 hover:text-slate-900 hover:bg-red-200 hover:no-underline rounded-lg mt-1']) ?>
                        <?= $this->Form->end() ?>

                    </div>

                </div>
            </div>
        </div>
    <?php endforeach ?>
</div><!-- /.main wrap -->



<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<!-- Note: activity step find is formatted in activities/stepfind.php -->

<script>
    $(function() {
        $('#actfind').on('submit', function(e) {

            e.preventDefault();

            let form = $(this);

            let url = $(this).attr('action');

            $.ajax({
                type: "GET",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    $('#results').html(data);
                },
                statusCode: {
                    403: function() {
                        form.after('<div class="alert alert-warning">You must be logged in.</div>');
                    }
                }
            });
        });

        $('#hyperlink').on('change', function(e) {

            e.preventDefault();

            let urltoscrape = this.value;
            let url = '/activities/getinfo?url=' + urltoscrape;

            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    let foo = $.parseJSON(data);
                    $('.newname').val(foo.title);
                    $('.note-editable').html(foo.description);
                    console.log(foo.title);
                },
                statusCode: {
                    403: function() {
                        // oh no
                    }
                }
            });
        });

    });
</script>
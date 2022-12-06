<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */

$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Activity: <span class="text-slate-900"><a href="/activities/view/<?= $activity->id ?>"><?= $activity->name ?></a></span></h2>
    <div class="max-w-prose">
        <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
            <?= $this->Form->create($activity) ?>
            <?php
            // echo $this->Form->control('ministry_id', ['class' => 'form-field mb-3', 'options' => $ministries, 'empty' => true]);
            // echo $this->Form->control('category_id', ['class' => 'form-field mb-3', 'options' => $categories, 'empty' => true]);
            // echo $this->Form->control('approvedby_id', ['class' => 'form-field mb-3']);
            echo $this->Form->hidden('createdby_id', ['value' => $activity->createdby_id, 'class' => 'form-field mb-3']);
            echo $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id'), 'class' => 'form-field mb-3']);
            ?>
            <?php echo $this->Form->control('name', ['class' => 'form-field mb-3']); ?>
            <?php echo $this->Form->control('description', ['class' => 'form-field mb-3']); ?>
            <?php echo $this->Form->control('hyperlink', ['class' => 'form-field mb-3']); ?>
            <div id="linkcheck"></div>
            <?php
            if ($this->Form->isFieldError('hyperlink')) {
                echo $this->Form->error('hyperlink', 'This link may already exist in the system.');
            }
            ?>
            <?php //echo $this->Form->control('steps._ids', ['class' => 'form-field mb-3', 'options' => $steps]); 
            ?>
            <?php //echo $this->Form->control('licensing', ['class' => 'form-field mb-3']); 
            ?>
            <?php //echo $this->Form->control('moderator_notes', ['class' => 'form-field mb-3']); 
            ?>
            <?php echo $this->Form->control('isbn', ['class' => 'form-field mb-3', 'label' => 'ISBN']); ?>
            <?php echo $this->Form->control('activity_types_id', ['class' => 'form-field mb-3 text-base', 'options' => $activityTypes]); ?>
            <?php echo $this->Form->control('status_id', ['class' => 'form-field mb-3 text-base', 'options' => $statuses, 'empty' => true]); ?>
            <?php //echo $this->Form->control('estimated_time', ['type' => 'text', 'label' => 'Estimated Time', 'class' => 'form-field mb-3']); 
            ?>
            <label>Estimated Time
                <select name="estimated_time" id="estimated_time_id" class="form-field text-base">
                    <option>Under 5 mins</option>
                    <option>Under 10 mins</option>
                    <option>Under 15 mins </option>
                    <option>Under 20 mins</option>
                    <option>Under 30 mins</option>
                    <option>Under 1 hour</option>
                    <option>Half day or less</option>
                    <option>1 day </option>
                    <option>More than 1 day </option>
                    <option>Variable</option>
                </select>
            </label>
            <?php //echo $this->Form->control('tag_string', ['class' => 'form-field mb-3', 'type' => 'text', 'label' => 'Tags']); 
            ?>
            <?php //echo $this->Form->control('users._ids', ['class' => 'form-field mb-3', 'options' => $users]); 
            ?>
            <?php //echo $this->Form->control('competencies._ids', ['class' => 'form-field mb-3', 'options' => $competencies]); 
            ?>
            <?= $this->Form->button(__('Save Activity'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>

        </div>
    </div> <?php if (!empty($activity->steps)) : ?>
        <h3 class="font-semibold text-xl mt-5">Related Pathways</h3>
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
                            <span class="bg-orange-400 text-slate-900 py-1 px-2 rounded-full mr-3">DRAFT</span>
                            <a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a>
                        </li>

                    <?php endif ?>
                <?php endforeach ?>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

</div>
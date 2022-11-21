<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType $activityType
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Activity Type <a href="/activity-types/" class="inline-block ml-2 text-sky-700 hover:underline text-base font-normal">View all Activity Types</a></h2>
    <div class="max-w-prose">
        <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">

            <?= $this->Form->create($activityType) ?>
            <fieldset>
                <?php
                echo $this->Form->control('name', ['class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('slug', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('description', ['class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('color', ['class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('delivery_method', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('image_path', ['class' => 'form-field text-base mb-3']);
                echo $this->Form->control('featured', ['class' => 'form-field text-base mb-3']);
               // echo $this->Form->control('createdby', ['label' => 'Created By', 'class' => 'form-field text-base mb-3']);
                // echo $this->Form->control('modifiedby', ['label' => 'Modified By', 'class' => 'form-field text-base mb-3']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Save Activity Type'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>
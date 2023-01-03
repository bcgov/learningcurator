<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Pathway</h2>
    <div class="max-w-prose outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
        <?= $this->Form->create($pathway) ?>
        <fieldset>
            <div>
                <label>Topic
                    <?php echo $this->Form->select(
                        'topic_id',
                        $areas,
                        ['class' => 'form-field mb-3 text-base'],
                    );
                    ?></label>
            </div>
            <?php
            echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
            echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);
            //echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true,'class'=>'form-control']);
            //echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true,'class'=>'form-control']);
            ?>
            <?php
            echo $this->Form->control('name', ['class' => 'form-field mb-3', 'type' => 'text', 'label' => 'Pathway Title']);
            ?>

            <label for="description">Pathway Description</label>
            <span class="text-slate-600 block mb-1 text-sm" id="descriptionHelp"><i class="bi bi-info-circle"></i> A brief description of your pathway. This appears on the pathway overview page. (1&nbsp;to&nbsp;2&nbsp;sentences).</span>
            <?php echo $this->Form->textarea('description', ['class' => 'form-field mb-3', 'aria-describedby' => 'descriptionHelp']); ?>

            <label for="objective">Pathway Goal</label>
            <span class="text-slate-600 block mb-1 text-sm" id="goalHelp"><i class="bi bi-info-circle"></i> What learning goal will your learners work toward over the course of the whole pathway? (1&nbsp;sentence).</span>
            <?php echo $this->Form->textarea('objective', ['class' => 'form-field mb-3', 'aria-describedby' => 'goalHelp']);
            echo $this->Form->hidden('status_id', ['value' => 1]);
            //echo $this->Form->control('color');
            //echo $this->Form->control('file_path');
            //echo $this->Form->control('image_path');
            //echo $this->Form->control('featured');
            //echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
            //echo $this->Form->control('competencies._ids', ['options' => $competencies]);
            //echo $this->Form->control('steps._ids', ['options' => $steps]);
            //echo $this->Form->control('users._ids', ['options' => $users]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Add new pathway'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>
<header class="w-full h-52 bg-darkblue px-8 flex items-center">
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
                        ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3 border text-base'],
                    );
                    ?></label>
            </div>
            <?php
            echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
            echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);
            //echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true,'class'=>'form-control']);
            //echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true,'class'=>'form-control']);
            echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
            echo $this->Form->control('description', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
            echo $this->Form->control('objective', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
            echo $this->Form->control('estimated_time', ['class' => 'block w-full px-3 py-2 m-0 bg-slate-100/80 rounded-lg']);
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
        <?= $this->Form->button(__('Add new pathway'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
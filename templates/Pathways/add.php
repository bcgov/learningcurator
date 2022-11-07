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
                <label>Topic:
                    <?php echo $this->Form->select(
                        'topic_id',
                        $areas,
                        ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg'],
                    );
                    ?></label>
            </div>
            <?php
            echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
            echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);
            //echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true,'class'=>'form-control']);
            //echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true,'class'=>'form-control']);
            echo $this->Form->control('name', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
            echo $this->Form->control('description', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
            echo $this->Form->control('objective', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
            echo $this->Form->control('estimated_time', ['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
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
        <?= $this->Form->button(__('Add new pathway'), ['class' => 'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
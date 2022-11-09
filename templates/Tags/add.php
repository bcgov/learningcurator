<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Add Tag <?= $this->Html->link(__('View All Tags'), ['action' => 'index'], ['class' => 'inline-block ml-2 text-sky-700 hover:underline text-base font-normal']) ?></h2>
    <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
<!-- TODO Nori/Allan the classes aren't obeying the card width -->
<!-- TODO Q Allan should the created by fill in automatically? -->
            <?= $this->Form->create($tag) ?>
            <fieldset>
                <?php
                    echo $this->Form->control('name', ['class' => 'block w-full max-w-prose px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
                    echo $this->Form->control('slug', ['class' => 'block w-full max-w-prose px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
                    echo $this->Form->control('description', ['class' => 'block w-full max-w-prose px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
                    echo $this->Form->control('createdby', ['class' => 'block w-full max-w-prose px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
                    // echo $this->Form->control('modifiedby', ['class' => 'block w-full max-w-prose px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3']);
                    echo $this->Form->control('activities._ids', ['options' => $activities], ['class' => 'overflow-hidden block w-full max-w-prose px-3 py-2 m-0 bg-slate-100/80 rounded-lg mb-3 text-base']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>

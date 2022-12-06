<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <div class="max-w-prose">
        <h2 class="text-2xl text-darkblue font-semibold mb-3">View Question <span><?= $this->Html->link(__('View All Questions'), ['action' => 'index'], ['class' => 'inline-block ml-2 text-sky-700 hover:underline text-base font-normal']) ?></span></h2>


        <h3 class="font-semibold text-xl mt-5">Question</h3>
        <p><?= h($question->title) ?></p>
        <h3 class="font-semibold text-xl mt-5">Answer</h3>
        <div><?= $question->content ?></div>
        <h3 class="font-semibold text-xl mt-5">Details</h3>
        <ul class="list-disc pl-8 mt-2">
            <li class="px-2">
                <strong>Title: </strong><?= h($question->title) ?>
            </li>
            <li class="px-2">
                <strong>Slug: </strong><?= h($question->slug) ?>
            </li>
            <li class="px-2">
                <strong>Status: </strong><?= h($question->status->name) ?>
            </li>
            <li class="px-2">
                <strong>Created By: </strong><?= h($question->createdby_id) ?>
            </li>
            <li class="px-2">
                <strong>User: </strong><?= $question->has('user') ? $this->Html->link($question->user->id, ['controller' => 'Users', 'action' => 'view', $question->user->id]) : '' ?>
            </li>
            <!-- TODO display the user name instead of ID ? -->

            <li class="px-2">
                <strong>Number: </strong><?= $this->Number->format($question->id) ?>
            </li>

            <li class="px-2">
                <strong>Created: </strong><?= h($question->created) ?>
            </li>

            <li class="px-2">
                <strong>Modified: </strong><?= h($question->modified) ?>
            </li>

        </ul>

        <div class="mt-4">
            <?= $this->Html->link(__('Edit Question'), ['action' => 'edit', $question->id], ['class' => 'inline-block px-3 py-1 text-white text-base bg-slate-700 hover:bg-slate-700/80 hover:no-underline rounded-lg']) ?>
            <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'inline-block px-3 py-1 text-base hover:bg-red-700/80 text-white bg-red-700 hover:no-underline rounded-lg']) ?>
            <?= $this->Html->link(__('Add New Question'), ['action' => 'add'], ['class' => 'inline-block px-3 py-1 text-white text-base bg-slate-700 hover:bg-slate-700/80 hover:no-underline rounded-lg']) ?>
        </div>
    </div>
</div>
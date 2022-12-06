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
        <h2 class="text-2xl text-darkblue font-semibold mb-3">Add new question <span><?= $this->Html->link(__('View All Questions'), ['action' => 'index'], ['class' => 'inline-block ml-2 text-sky-700 hover:underline text-base font-normal']) ?></span></h2>
        <p class="text-xl">People keep asking questions, and we keep providing answers.</p>
        <div class="outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">

            <?= $this->Form->create($question) ?>
            <?php
            echo $this->Form->control('title', ['class' => 'form-field mb-3 text-base', 'label' => 'Question']); 
             echo $this->Form->control('content', ['class' => 'form-field mb-3 text-base',  'label' => 'Answer']); 
        echo $this->Form->control('status_id', ['options' => $statuses, 'empty' => true, 'class' => 'form-field mb-3 text-base']);
                                ?>
            <div class="mt-4">
                <?= $this->Form->button(__('Add question'), ['class' => 'px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 hover:no-underline rounded-lg']) ?>
                <?= $this->Form->end() ?></div>
        </div>
    </div>
</div>
<!-- TODO Allan add back summernote wysiwyg? -->

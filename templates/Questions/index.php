<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
$this->loadHelper('Authentication.Identity');
$uid = '';
$role = '';
if ($this->Identity->isLoggedIn()) {
    $role = $this->Identity->get('role');
    $uid = $this->Identity->get('id');
}
?>

<header class="w-full h-52 bg-cover bg-[center_top_65%] pb-8 px-8" style="background-image: url(/img/categories/cape-scott-trail-n-r-t-on-flckr.jpg);">
    <div class="bg-darkblue/90 h-44 w-72 drop-shadow-lg p-4 flex">
        <h1 class="text-white text-3xl font-bold m-auto tracking-wide">About</h1>
    </div>
</header>
<div class="p-8 text-lg">


    <div class="max-w-prose">
        <h2 class="mb-3 text-2xl text-darkblue font-semibold">What is Learning Curator?</h2>

        <p class="mb-3">
            A web site where BC Public Service curators collect readings, courses,
            activities and media, and shape pathways to learning goals. Where public
            service employees learn on their own time, at their own pace.</p>
        <p class="mb-3">
            Curator pathways are organized into
            <a href="/categories" class="underline font-semibold">categories</a> and then topics.
            You can explore
            <a href="/pathways" class="underline font-semibold">all the pathways</a>
            we have to offer and when you see one you like, you can
            follow it.
        </p>
        <!-- <p>Not just a big repository of important bookmarks, Curator rejects blind tagging in
    favor of a pedagogical approach where resources are structured into pathways
    which have specific objectives, and are further organized into logic steps, revealing
    a progression of concepts that blends formal and informal learning resources into a 
    single stream.</p> -->
        <?php if ($role == 'curator' || $role == 'superuser') : ?>
            <?= $this->Html->link(__('Add New Question'), ['action' => 'add'], ['class' => 'inline-block px-4 py-2 text-white text-md bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg mb-5']) ?>
        <?php endif ?>





        <h3 class="text-xl text-darkblue">Frequently Asked Questions</h3>
        <?php foreach ($questions as $question) : ?>
            <?php if ($question->status_id == 2) : ?>
                <div class="p-3 my-3 border border-sky-700 rounded-lg">
                    <details>
                        <summary id="<?= h($question->slug) ?>"><?= h($question->title) ?></summary>

                        <div class="text-base">
                            <?= $question->content ?>
                        </div>

                        <?php if ($role == 'curator' || $role == 'superuser') : ?>
                            <div class="mt-3 text-right">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id], ['class' => 'inline-block px-3 py-1 text-white text-base bg-slate-700 hover:text-slate-900 hover:bg-slate-200 hover:no-underline rounded-lg']) ?>
                                <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'inline-block px-3 py-1 text-base hover:bg-red-700/80 text-white bg-red-700 hover:no-underline rounded-lg']) ?>
                            </div>
                        <?php endif ?>

                    </details>
                </div>
            <?php else : ?>
                <?php if ($role == 'curator' || $role == 'superuser') : ?>
                    <div class="p-3 my-3 bg-white dark:bg-slate-900/80 rounded-lg">
                        <div><span class="badge badge-warning"><?= h($question->status->name) ?></span></div>
                        <h2 class="text-2xl" id="<?= h($question->slug) ?>"><?= h($question->title) ?></h2>
                        <div><?= $question->content ?></div>
                        <div class="btn-group mt-3">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id], ['class' => 'btn btn-primary']) ?>
                            <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'btn btn-danger']) ?>
                        </div>
                    </div>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach; ?>

    </div>
</div>
</div>
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

<div class="p-6 dark:text-white">
<?php if($role == 'curator' || $role == 'superuser'): ?>
<?= $this->Html->link(__('New Question'), ['action' => 'add'], ['class' => 'btn btn-success float-right']) ?>
<?php endif ?>
<h1 class="text-4xl">Learning Curator</h1>
<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900/80 dark:text-white">
<div class="mb-6 text-2xl">
    A web site where BC Public Service curators collect readings, courses, 
    activities and media, and shape pathways to learning goals. Where public 
    service employees learn on their own time, at their own pace.
</div>
<p class="mb-3 text-xl">
    Curator pathways are organized into 
    <a href="/categories" class="underline">categories</a> and then topics.
    You can explore 
    <a href="/pathways" class="underline">all the pathways</a>
    we have to offer and when you see one you like, you can 
    follow it. When you follow a pathway, it will be listed 
    here, so the next time you login, you can jump right to it.
</p>
<!-- <p>Not just a big repository of important bookmarks, Curator rejects blind tagging in
    favor of a pedagogical approach where resources are structured into pathways
    which have specific objectives, and are further organized into logic steps, revealing
    a progression of concepts that blends formal and informal learning resources into a 
    single stream.</p> -->
<div class="w-1/2">
    <h2 class="text-lg">Frequently Asked Questions</h2>
<?php foreach ($questions as $question): ?>
<?php if($question->status_id == 2): ?>
<div class="p-3 my-3 bg-white dark:bg-slate-800 rounded-lg">
<details>
    <summary id="<?= h($question->slug) ?>"><?= h($question->title) ?></summary>
    
    <div class="p-3 bg-slate-200 dark:bg-slate-700 rounded-lg">
        <?= $question->content ?>
    </div>

    <?php if($role == 'curator' || $role == 'superuser'): ?>
        <div class="btn-group mt-3">
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id],['class'=>'btn btn-primary']) ?>
        <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'btn btn-danger']) ?>
    </div>
    <?php endif ?>

</details>
</div>
<?php else: ?>
<?php if($role == 'curator' || $role == 'superuser'): ?>
<div class="p-3 my-3 bg-white dark:bg-slate-900/80 rounded-lg">
    <div><span class="badge badge-warning"><?= h($question->status->name) ?></span></div>
    <h2 class="text-2xl" id="<?= h($question->slug) ?>"><?= h($question->title) ?></h2>
    <div><?= $question->content ?></div>
    <div class="btn-group mt-3">
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id],['class'=>'btn btn-primary']) ?>
    <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id), 'class' => 'btn btn-danger']) ?>
</div>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach; ?>

</div>
</div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic[]|\Cake\Collection\CollectionInterface $topics
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="py-5">
<h1>All Topics</h1>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-6">
<?php foreach ($topics as $topic): ?>
<div class="p-3 bg-white rounded-lg my-3">
<!-- <div class=""><?= $this->Number->format($topic->id) ?></div> -->
<?php $toptit = $topic->categories[0]->name . ' ' . $topic->name ?>
<div><?= $this->Html->link(h($topic->categories[0]->name), ['controller' => 'Categories', 'action' => 'view', $topic->categories[0]->id]) ?></div>
<h2><?= $this->Html->link(h($toptit), ['action' => 'view', $topic->id],['class'=>'topictitle']) ?></h2>

<div class=""><?= h($topic->description) ?></div>
<!-- <div class=""><?= h($topic->image_path) ?></div> -->
<!-- <div class=""><?= h($topic->color) ?></div> -->
<!-- <div class=""><?= h($topic->featured) ?></div> -->
<!-- <div class=""><?= h($topic->created) ?></div> -->
<!-- <div class=""><?= $topic->has('user') ? $this->Html->link($topic->user->name, ['controller' => 'Users', 'action' => 'view', $topic->user->id]) : '' ?></div> -->
<!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $topic->id]) ?> -->
<!-- <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $topic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $topic->id)]) ?> -->
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
?>

<div class="container-fluid">
<div class="row justify-content-md-center align-items-center"  id="colorful">
<div class="col-md-4">
    <h1 class="my-5">Tags</h1>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center align-items-center bg-light">
<div class="col-md-4">
<?php foreach ($tags as $tag): ?>
<div class="bg-white p-3 my-2">
    <?= $this->Html->link(h($tag->name), ['action' => 'view', $tag->id]) ?>
</div>
<?php endforeach ?>
</div>
</div>
</div>
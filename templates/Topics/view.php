<?php $this->layout = 'public'; ?>
<div class="container-fluid">
<div class="row justify-content-lg-center" id="">
<div class="col-12">
<div class="p-3 my-3 bg-white rounded-lg">
<h1 class="display-2"><?= h($topic->categories[0]->name) ?> <?= h($topic->name) ?></h1>
<div class="display-5">
<?= h($topic->description) ?>
</div>
</div>
</div>
<div class="col-md-12 col-lg-6">
<?php foreach($topic->pathways as $pathway): ?>
<div class="p-3 my-3 bg-white rounded-lg">
    <h2>
        <?php //$this->Html->link(h($pathway->name), ['controller' => 'Pathways', 'action' => 'view', $pathway->id],['class' => '']) ?>
        <a href="https://learningcurator.ca/<?= str_replace(' ','-',strtolower($topic->categories[0]->name)) ?>/<?= str_replace(' ','-',strtolower($topic->name)) ?>/<?= h($pathway->slug) ?>.html"><?= h($pathway->name) ?></a>
    </h2>
    <div><?= h($pathway->description) ?></div>
</div>
<?php endforeach ?>
</div>
</div>
</div>
</div>

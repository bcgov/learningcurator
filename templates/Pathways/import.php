<div class="p-6">
<h1><?= h($path->name) ?></h1>
<?= h($path->description) ?><br>
<?= h($path->objective) ?><br>
<?php foreach($path->steps as $step): ?>
<h2><?= $step->name ?></h2>
<?= $step->description ?>
<?php foreach($step->activities as $activity): ?>
<div class="hidden">
    <h3><?= $activity->name ?></h3>
    <?= $activity->hyperlink ?><br>
    <?= $activity->description ?>
</div>
<?php endforeach?>

<?php endforeach?>
</div>
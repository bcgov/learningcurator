<?php foreach($activities as $act): ?>

<a href="/activities/view/<?= $act->id ?>"><?= $act->name ?></a><br>

<?php endforeach ?>

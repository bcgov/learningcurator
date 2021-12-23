<?php  
$this->assign('title', 'Activities you\'ve claimed');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
$role = $this->Identity->get('role');
$uid = $this->Identity->get('id');
}
?>

<h1 class="mt-6 text-2xl dark:text-white">
Welcome <?= $this->Identity->get('first_name') ?>
</h1>

<div class="systemrole">
<?php if($role == 'curator'): ?>
<span class="dark:text-white">Curator</span>
<?php elseif($role == 'superuser'): ?>
<span class="dark:text-white">Super User</span>
<?php endif ?>
</div>

<div class="dark:text-white">
<a class=" active" href="/profile/pathways">My Pathways</a> 
<a class="" href="/profile/claims">My Activities</a> 
<a class="" href="/profile/reports">My Issues</a> 
</div>

<?php if(!$activities->isEmpty()): ?>
<?php foreach($activities as $a): ?>

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-gray-900 dark:text-white">
<h2 class="text-2xl">
<?= $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $a['id']], ['class' => 'btn btn-light float-right', 'confirm' => __('Unclaim?')]) ?>
<a href="/activities/view/<?= $a['activity']['id'] ?>" class="font-weight-bold">
<i class="bi <?= $a['activity']['activity_type']['image_path'] ?>"></i>
<?= $a['activity']['name'] ?>
</a>
</h2>
<div class="">
<div>Claimed on: <?= $this->Time->format($a['created'],\IntlDateFormatter::MEDIUM,null,'GMT-8') ?></div>

<?php foreach($a['activity']['steps'] as $s): ?>
<?php if(!empty($s->pathways[0]->slug)): ?>
<?php if($s->pathways[0]->status_id == 2): ?>
<div class="my-1">Included in 
<a href="/pathways/<?= $s->pathways[0]->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>" class="font-weight-bold">
<i class="bi bi-pin-map-fill"></i>
<?= $s->pathways[0]->name ?> - <?= $s->name ?>
</a>
</div>
<?php endif ?>
<?php endif ?>
<?php endforeach ?>
</div>

</div>
<?php endforeach ?>
<?php else: ?>

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-gray-900 dark:text-white">
<p><strong>You've not yet claimed any activities.</strong></p>
<p>You can claim activities along a pathway. Doing so allows you to see how much of the path you have completed.</p>
</div>
<?php endif ?>

<h3 class="mt-5">Featured Pathways</h3>

<?php foreach($published as $p): ?>
<!-- <pre><?php print_r($p) ?></pre> -->
<div class="p-3 mb-2 bg-white">
<a href="/pathways/<?= $p->slug ?>">
<i class="bi bi-pin-map-fill"></i> 
<?= h($p->name) ?>
</a> 
<a href="/topics/view/<?= $p->topic->id ?>" class="badge badge-light">
<?= h($p->topic->categories[0]->name) ?> <?= h($p->topic->name) ?>
</a>
</div>
<?php endforeach ?>


</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

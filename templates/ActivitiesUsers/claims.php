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
<a class=" active" href="/profile">My Pathways</a> 
<a class="" href="/profile/claims">My Activities</a> 
<a class="" href="/profile/reports">My Issues</a> 
</div>

<?php if(!$activities->isEmpty()): ?>
<?php foreach($activities as $a): ?>

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">
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

<div class="p-3 my-3 rounded-lg activity bg-white dark:bg-slate-900 dark:text-white">
<p><strong>You've not yet claimed any activities.</strong></p>
<p>You can claim activities along a pathway. Doing so allows you to see how much of the path you have completed.</p>
</div>
<?php endif ?>

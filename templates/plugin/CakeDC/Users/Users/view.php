<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$Users = ${$tableAlias};
$usenam = $Users->first_name . ' ' . $Users->last_name . ' profile';
$this->assign('title', $usenam);
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>

<div class="p-6 dark:text-white">


<?php if($role == 'superuser'): ?>
<div class="btn-group float-right mt-5">
<?= $this->Html->link(__d('cake_d_c/users', 'Edit User'), ['action' => 'edit', $Users->id],['class'=>'btn btn-primary']) ?> 
<?= $this->Form->postLink(
                __d('cake_d_c/users', 'Delete User'),
                ['action' => 'delete', $Users->id],
                ['confirm' => __d('cake_d_c/users', 'Are you sure you want to delete # {0}?', $Users->id),
                'class' => 'btn btn-light']
            ) ?> 
</div>
<?php endif ?>

<div class="mt-5"><a href="/users/index">All Users</a></div>
<h1 class="display-4 mt-0">
    <?= h($Users->first_name) ?> <?= h($Users->last_name) ?>
</h1>
<div class="mb-3">
    <?php if($this->Number->format($Users->active) == 1): ?>
    <span class="badge badge-success">Active</span>
    <?php endif ?>
    <span class="badge badge-dark"><?= h($Users->role) ?></span>
    <span class="badge badge-primary">
    <?php if($Users->ministry_id == 2): ?>
        Public Service Agency
    <?php elseif($Users->ministry_id == 3): ?>
        Citizen Services
    <?php endif ?>
    </span>
</div>
<!-- <div><?= h($Users->username) ?></div> -->

<div>
    <a href="mailto:<?= h($Users->email) ?>" class="font-weight-bold"><?= h($Users->email) ?></a>
</div>
<div class="mt-3">
    <?= __d('cake_d_c/users', 'Created') ?> 
    <?= h($Users->created) ?>
    <?= __d('cake_d_c/users', 'Modified') ?> <?= h($Users->modified) ?>
</div>




<h3 class="mt-4">Activities Claimed</h3>
<?php if(!empty($Users->activities_users)): ?>
<div class="overflow-auto" style="height: 20em">
<?php foreach($Users->activities_users as $act): ?>
<div class="dark:bg-slate-900/80 px-3 py-2 rounded-lg">
    <a href="/activities/view/<?= $act->activity->id ?>">
    <i class="<?= $act->activity->activity_type->image_path ?>"></i>
        <?= $act->activity->name ?>
    </a>
</div>
<?php endforeach ?>
</div>
<?php else: ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">This person hasn't claimed any activites yet.</div>
<?php endif ?>
</div>

<div class="col-md-4 col-xl-3">
<h3 class="mt-4">Activities Contributed</h3>
<?php if(!$actsadded->isEmpty()): ?>
<div class="overflow-auto" style="height: 20em">
<?php foreach($actsadded as $act): ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">
    <a href="/activities/view/<?= $act->id ?>">
        <i class="<?= $act->activity_type->image_path ?>"></i>
        <?= $act->name ?>
    </a>
</div>
<?php endforeach ?>
</div>
<?php else: ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">This person hasn't contributed any activities yet.</div>
<?php endif ?>
</div>


<div class="col-md-4 col-xl-3">
<h3 class="mt-4">Paths Following</h3>
<?php if(!empty($Users->pathways_users)): ?>
<?php foreach($Users->pathways_users as $path): ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">
    <a href="/pathways/<?= $path->pathway->slug ?>">
        <i class="bi bi-pin-map-fill"></i>
        <?= $path->pathway->name ?>
    </a>
</div>
<?php endforeach ?>
<?php else: ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">This person hasn't followed any pathways yet.</div>
<?php endif ?>
</div>

<div class="col-md-4 col-xl-3">
<h3 class="mt-4">Pathways Contributed</h3>
<?php if(!$pathsadded->isEmpty()): ?>
<?php foreach($pathsadded as $path): ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">
    <a href="/pathways/<?= $path->slug ?>">
    <i class="bi bi-pin-map-fill"></i>
        <?= $path->name ?>
    </a>
</div>
<?php endforeach ?>
<?php else: ?>
<div class="dark:bg-slate-900/80 p-3 rounded-lg">This person hasn't contributed any pathways yet.</div>
<?php endif ?>
</div>





</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
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
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-6">

<div class="bg-white p-5 my-5">

<div class="row justify-content-end text-right">
<div class="col-5">
<div class="btn-group">
<?= $this->Html->link(__d('cake_d_c/users', 'Edit User'), ['action' => 'edit', $Users->id],['class'=>'btn btn-primary']) ?> 
<?= $this->Form->postLink(
                __d('cake_d_c/users', 'Delete User'),
                ['action' => 'delete', $Users->id],
                ['confirm' => __d('cake_d_c/users', 'Are you sure you want to delete # {0}?', $Users->id),
                'class' => 'btn btn-light']
            ) ?> 
</div>
</div>
</div>
<?php if($this->Number->format($Users->active) == 1): ?>
<div>
    <span class="badge badge-success">Active</span>
</div>
<?php endif ?>

<h2><?= h($Users->username) ?></h2>

<div><?= __d('cake_d_c/users', 'Role') ?>: <?= h($Users->role) ?></p>

<div class="row">
<div class="col-md-6">
    <div><?= __d('cake_d_c/users', 'Id') ?></div>
    <p><?= h($Users->id) ?></p>
    <div><?= __d('cake_d_c/users', 'Username') ?></div>
    <p><?= h($Users->username) ?></p>
    <div><?= __d('cake_d_c/users', 'Email') ?></div>
    <p><?= h($Users->email) ?></p>
    <div><?= __d('cake_d_c/users', 'First Name') ?></div>
    <p><?= h($Users->first_name) ?></p>
    <div><?= __d('cake_d_c/users', 'Last Name') ?></div>
    <p><?= h($Users->last_name) ?></p>
</div>
<div class="col-md-6">
    <div><?= __d('cake_d_c/users', 'Activation Date') ?></div>
    <p><?= h($Users->activation_date) ?></p>
    <div><?= __d('cake_d_c/users', 'Created') ?></div>
    <p><?= h($Users->created) ?></p>
    <div><?= __d('cake_d_c/users', 'Modified') ?></div>
    <p><?= h($Users->modified) ?></p>
</div>
</div>



</div>
</div>
</div>
</div>

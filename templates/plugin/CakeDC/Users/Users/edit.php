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

use Cake\Core\Configure;
$this->loadHelper('Authentication.Identity');
$Users = ${$tableAlias};
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="container-fluid" id="colorful">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="m-5 p-5 bg-white rounded-lg shadow-sm">
            <?php
            echo $this->Form->postLink(
                __d('cake_d_c/users', 'Delete'),
                ['action' => 'delete', $Users->id],
                ['confirm' => __d('cake_d_c/users', 'Are you sure you want to delete # {0}?', $Users->id),
                'class' => 'btn btn-danger float-right']
            );
            ?>

    <?= $this->Form->create($Users); ?>
    <fieldset>
        <legend><?= __d('cake_d_c/users', 'Edit User') ?></legend>
        <?php
        echo $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username')]);
        echo $this->Form->control('email', ['label' => __d('cake_d_c/users', 'Email')]);
        echo $this->Form->control('first_name', ['label' => __d('cake_d_c/users', 'First name')]);
        echo $this->Form->control('last_name', ['label' => __d('cake_d_c/users', 'Last name')]);
        $mins = [
                    ['text' => 'Not Specified', 'value' => 1],
                    ['text' => 'Public Service Agency', 'value' => 2],
                    ['text' => 'Citizen Services', 'value' => 3],
                ];
        echo $this->Form->control('ministry_id',['options' => $mins]);
        
        echo $this->Form->control('additional_data', ['label' => __d('cake_d_c/users', 'Additonal Data')]);
        if($role == 'superuser') {
            echo $this->Form->control('role', ['label' => __d('cake_d_c/users', 'Role')]);
            //echo $this->Form->control('is_superuser', ['label' => __d('cake_d_c/users', 'Is Superuser?')]);
        }
        echo $this->Form->control('token', ['label' => __d('cake_d_c/users', 'Token')]);
        echo $this->Form->control('token_expires', [
            'label' => __d('cake_d_c/users', 'Token expires')
        ]);
        echo $this->Form->control('api_token', [
            'label' => __d('cake_d_c/users', 'API token')
        ]);
        echo $this->Form->control('activation_date', [
            'label' => __d('cake_d_c/users', 'Activation date')
        ]);
        echo $this->Form->control('tos_date', [
            'label' => __d('cake_d_c/users', 'TOS date')
        ]);
        echo $this->Form->control('active', [
            'label' => __d('cake_d_c/users', 'Active')
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__d('cake_d_c/users', 'Submit'),['class' => 'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <?php if (Configure::read('OneTimePasswordAuthenticator.login')) : ?>
        <fieldset>
            <legend>Reset Google Authenticator</legend>
            <?= $this->Form->postLink(
                __d('cake_d_c/users', 'Reset Google Authenticator Token'), [
                'plugin' => 'CakeDC/Users',
                'controller' => 'Users',
                'action' => 'resetOneTimePasswordAuthenticator', $Users->id
            ], [
                'class' => 'btn btn-danger',
                'confirm' => __d(
                    'cake_d_c/users',
                    'Are you sure you want to reset token for user "{0}"?', $Users->username
                )
            ]);
            ?>
        </fieldset>
    <?php endif; ?>
</div>
</div>
</div>
</div>

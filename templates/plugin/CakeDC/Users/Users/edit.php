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


$this->loadHelper('Authentication.Identity');
$Users = ${$tableAlias};
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="p-6">

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
        <legend class="text-4xl"><?= __d('cake_d_c/users', 'Edit') . ' ' . $Users->first_name ?></legend>
        <div class="mt-3 p-6 bg-slate-200 rounded-lg">
            Activated on <?= $Users->activation_date ?>
        <?php
        if($role == 'superuser') {
            $roles = [
                ['text' => 'Regular User', 'value' => 'user'],
                ['text' => 'Curator', 'value' => 'curator'],
                ['text' => 'Super User', 'value' => 'superuser'],
            ];
            echo $this->Form->control('role', ['label' => __d('cake_d_c/users', 'Role'), 'options' => $roles, 'class' => 'p-2 m-1']);
            //echo $this->Form->control('is_superuser', ['label' => __d('cake_d_c/users', 'Is Superuser?')]);
        }
        echo $this->Form->control('first_name', ['label' => __d('cake_d_c/users', 'First name'), 'class' => 'p-2 m-1']);
        echo $this->Form->control('last_name', ['label' => __d('cake_d_c/users', 'Last name'), 'class' => 'p-2 m-1']);


        echo $this->Form->control('email', ['label' => __d('cake_d_c/users', 'Email'), 'class' => 'p-2 m-1']);
        echo $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'class' => 'p-2 m-1']);
        echo $this->Form->control('ministry_id',['options' => $ministries, 'class' => 'p-2 m-1']);
    
        
        // echo $this->Form->control('activation_date', [
        //     'label' => __d('cake_d_c/users', 'Activation date'), 'class' => 'p-2 m-1'
        // ]);

        // echo $this->Form->control('additional_data', ['label' => __d('cake_d_c/users', 'BC Gov GUID'), 'class' => 'p-2 m-1']);
        // echo $this->Form->control('token', ['label' => __d('cake_d_c/users', 'Token'), 'class' => 'p-2 m-1']);
        // echo $this->Form->control('token_expires', [
        //     'label' => __d('cake_d_c/users', 'Token expires'), 'class' => 'p-2 m-1'
        // ]);
        // echo $this->Form->control('api_token', [
        //     'label' => __d('cake_d_c/users', 'API token'), 'class' => 'p-2 m-1'
        // ]);

        // echo $this->Form->control('tos_date', [
        //     'label' => __d('cake_d_c/users', 'TOS date'), 'class' => 'p-2 m-1'
        // ]);
        // echo $this->Form->control('active', [
        //     'label' => __d('cake_d_c/users', 'Active'), 'class' => 'p-2 m-1'
        // ]);
        ?>
        <?= $this->Form->button(__d('cake_d_c/users', 'Save User Info'),['class' => 'p-3 my-1 text-xl rounded-lg']) ?>
        </div>
        
    </fieldset>
    
    <?= $this->Form->end() ?>
    
</div>

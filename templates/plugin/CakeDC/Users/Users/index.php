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
?>
<div class="p-6 dark:text-white">

<h1 class="mt-5">Users</h1>
<form method="get" action="/users/search" class="mb-5">
<label>Search
		<input class="form-control" 
                type="search" 
                placeholder="User Search" 
                aria-label="Search" 
                name="q">
</label>
		<button class="btn btn-outline-dark" type="submit">Search</button>
	</form>

    
<div class="my-5 p-3 bg-white dark:bg-slate-900">

<?php foreach (${$tableAlias} as $user) : ?>
<div class="bg-light mb-3 p-3">
    <div class="">
    <?= $this->Html->link(__d('cake_d_c/users', h($user->username)), ['action' => 'view', $user->id],['class' => 'font-weight-bold']) ?> 
    <?= h($user->first_name) ?> <?= h($user->last_name) ?> <?= h($user->email) ?>
    </div>
</div>

<?php endforeach; ?>

<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __d('cake_d_c/users', 'previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__d('cake_d_c/users', 'next') . ' >') ?>
</ul>
<p><?= $this->Paginator->counter() ?></p>
</div>


</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
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

<div class="p-6">
<div class="mt-5"><a href="/users/index">All Users</a></div>
<h1 class="mt-0">Search Users</h1>
<form method="get" action="/users/search" class="mb-5">
<label>Search
		<input class="form-control" 
                type="search" 
                placeholder="Activity Search" 
                aria-label="Search" 
                name="q"
                value="<?= h($q) ?>">
</label>
		<button class="btn btn-outline-dark" type="submit">Search</button>
	</form>


<?php foreach (${$tableAlias} as $user) : ?>
<div class="bg-white dark:bg-slate-900 my-5 p-3">
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

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="row justify-content-md-center">
<div class="col-md-8">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'btn btn-dark float-right']) ?>
    <h3><?= __('Users') ?></h3>
	<div class="card-columns">
	   <?php foreach ($users as $user): ?>
		<div class="card card-body">
			<?= $this->Html->link($user->name, ['action' => 'view', $user->id]) ?>
		</div>
		<?php endforeach; ?>
	</div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
</div>

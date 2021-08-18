<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry[]|\Cake\Collection\CollectionInterface $ministries
 */
?>
<div class="container-fluid" id="colorful">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="m-5 p-5 bg-white rounded-lg shadow-sm">
    <h1>Ministries</h1>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-6">

    <?php foreach ($ministries as $ministry): ?>
    <div class="my-3 p-3 bg-white rounded-lg shadow-sm">
    <?= $this->Html->link(h($ministry->name), ['action' => 'view', $ministry->id]) ?>
    </div>
    <?php endforeach; ?>
     
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
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>

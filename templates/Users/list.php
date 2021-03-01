<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-4">
    
    <h3 class="mt-5"><?= __('Users') ?></h3>

    <div class="p-3 my-5 shadow-sm rounded-lg bg-white"><?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'btn btn-success']) ?></div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-4">

    <div class="my-5" id="users">
        <input type="text" name="activityfilter" id="activityfilter" placeholder="Filter" class="search form-control mb-3">
        <?php foreach ($users as $user): ?>
        <div class="my-2 p-3 bg-white shadow-sm rounded-lg ">
            <div><span class="name"><?= $this->Html->link($user->name, ['action' => 'view', $user->id],['class' => 'font-weight-bold']) ?></span></div>
            <div>IDIR: <span class="idir"><?= $user->idir ?></span> Created: <span class="created"><?= $user->created ?></span></div>
        </div>
        <?php endforeach; ?>
    </div> <!-- /#userlist -->

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
	
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
var options = {
    valueNames: [ 'name','idir','created' ]
};

var hackerList = new List('users', options);
</script>
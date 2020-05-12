<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType[]|\Cake\Collection\CollectionInterface $activityTypes
 */
?>
<h1>Activity Types</h1>
<table class="table">
<?php foreach ($activityTypes as $activityType): ?>
<tr>
    <td><?= $this->Html->link(h($activityType->name), ['action' => 'view', $activityType->id]) ?></td>
    <td><?= h($activityType->color) ?></td>
    <td><?= h($activityType->image_path) ?></td>
    <td><?= $this->Html->link(__('Edit'), ['action' => 'edit', $activityType->id]) ?></td>
</tr>
<?php endforeach ?>
</table>
<!-- pagination code removed. If we have more than 20 activity types we're needing to re-write anyhow -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>
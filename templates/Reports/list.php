<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<h3 class="my-3"><?= __('Reports') ?></h3>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center linear">
<div class="col-md-6">
<?php foreach ($reports as $report): ?>
<div class="my-3 p-3 bg-white rounded-lg shadow-sm">

    <!-- <div><?= $this->Html->link(__('View'), ['action' => 'view', $report->id]) ?></div> -->
    <div><?= $report->has('activity') ? $this->Html->link($report->activity->name, ['controller' => 'Activities', 'action' => 'view', $report->activity->id]) : '' ?></div>
    <div><?php $link = $report->user->name . ' on ' . $report->created . ' said:' ?></div>
    <div><?= $report->has('user') ? $this->Html->link($link, ['controller' => 'Users', 'action' => 'view', $report->user->id],['class'=>'font-weight-bold']) : '' ?></div>
    
    <blockquote class="p-3 bg-light rounded-3 shadow-sm"><?= $report->issue ?></blockquote>
    <?php if(empty($report->response)): ?>
    <div class="my-2 alert alert-warning">No reply yet</div>
    <?php else: ?>
    <div class="mt-3">
        <a href="/users/view/<?= $report->curator_id ?>">Curator</a> repsonse:
        <div class="my-2 alert alert-success"><?= $report->response ?></div>
    </div>
    <?php endif ?>
    <a href="#curatorresponse<?= $report->id ?>"  
        class="btn btn-dark" 
        data-toggle="collapse" 
        title="Respond to this report" 
        data-target="#curatorresponse<?= $report->id ?>" 
        aria-expanded="false" 
        aria-controls="curatorresponse<?= $report->id ?>">
            Respond
    </a>	
    <div class="collapse" id="curatorresponse<?= $report->id ?>">
    <?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'edit', $report->id]]) ?>
    <fieldset>
    <legend><?= __('Respond') ?></legend>
    <?php
    echo $this->Form->hidden('id', ['value' => $report->id]);
    echo $this->Form->hidden('curator_id', ['value' => $uid]);
    echo $this->Form->textarea('response',['class' => 'form-control', 'placeholder' => 'Type here ...']);
    ?>
    </fieldset>
    <input type="submit" class="btn btn-dark" value="Submit Response">
    <?= $this->Form->end() ?>
    </div> <!-- curatorresponse -->
</div>
<?php endforeach; ?>


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
<?php 
$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">
<h1><?= h($path->name) ?></h1>
<?= h($path->description) ?><br>
<?= h($path->objective) ?><br>
<?php foreach($path->steps as $step): ?>
<div class="mb-3 p-3 bg-slate-100 dark:bg-slate-900 rounded-lg">
<?php 
echo $this->Form->create(null, ['url' => [
                                'controller' => 'Steps',
                                'action' => 'add']
                            ]);
echo $this->Form->control('name', ['value' => $step->name, 
                                    'class'=>'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->control('description', ['value' => $step->description, 
                                    'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 
                                    'type' => 'textarea',
                                    'label'=>'Objective'
                            ]);
echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);
echo $this->Form->hidden('pathways.0.id', ['value' => $pathid]);
?>
<?= $this->Form->button(__('Add Step'), ['class'=>'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>



<div class="mb-3 p-3 bg-slate-200 dark:bg-slate-900 hidden">



<?php foreach($step->activities as $activity): ?>
<div class="p-3 ">
    <?php 
    echo $this->Form->create(null, ['url' => [
                                    'controller' => 'Activities',
                                    'action' => 'addtostep']
                                ]);
    echo $this->Form->control('name', ['value' => $activity->name, 
                                        'class'=>'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
    echo $this->Form->control('hyperlink', ['value' => $activity->hyperlink, 
                                        'class'=>'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
    echo $this->Form->control('description', ['value' => $activity->description, 
                                        'class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg', 
                                        'type' => 'textarea',
                                        'label'=>'Objective'
                                ]);
    echo $this->Form->hidden('createdby', ['value' => $this->Identity->get('id')]);
    echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);
    echo $this->Form->hidden('step_id', ['value' => '']);
    ?>
    <?= $this->Form->button(__('Add Activity'), ['class'=>'inline-block my-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
    <?= $this->Form->end() ?>

</div>
<?php endforeach?>



</div>
</div>
<?php endforeach?>
</div>
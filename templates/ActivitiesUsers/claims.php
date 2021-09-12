<?php  
$this->loadHelper('Authentication.Identity'); 
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="py-5">
<h1>Welcome <?php echo $this->Identity->get('first_name') ?></h1>

</div>
<div class="nav nav-pills justify-content-center">
    <a class="nav-link" href="/profile/pathways">Pathways</a> 
    <a class="nav-link active" href="/profile/claims">Claims</a> 
    <a class="nav-link" href="/profile/reports">Reports</a> 
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-8 col-lg-6">

<?php foreach($activities as $a): ?>
    
<div class="bg-white">
    <div class="p-3 my-2 rounded-lg"
        style="background-color: rgba(<?= $a['activity']['activity_type']['color'] ?>,.2);">
            <div>
            <?= $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $a['id']], ['class' => 'btn btn-light float-right', 'confirm' => __('Unclaim?')]) ?>
            <a href="/activities/view/<?= $a['activity']['id'] ?>" class="font-weight-bold">
                <i class="bi <?= $a['activity']['activity_type']['image_path'] ?>"></i>
                <?= $a['activity']['name'] ?>
            </a>
                
            </div>
            <div>
            <?php foreach($a['activity']['steps'] as $s): ?>
                <div>
                    <a href="/pathways/<?= $s->pathways[0]->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
                        <?= $s->pathways[0]->name ?> - <?= $s->name ?>
                    </a>
                </div>
            <?php endforeach ?>
            </div>
    </div>
</div>
<?php endforeach ?>

</div>
</div>
</div>
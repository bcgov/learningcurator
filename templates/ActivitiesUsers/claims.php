<?php  
$this->assign('title', 'Activities you\'ve claimed');
$this->loadHelper('Authentication.Identity');
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="py-5">
<?php echo $this->User->logout('Logout',['class'=>'btn btn-warning float-right']) ?>
<div class="systemrole">
	<?php if($role == 'curator'): ?>
		 <span class="badge badge-success">Curator</span>
	<?php elseif($role == 'superuser'): ?>
		<span class="badge badge-success">Super User</span>
	<?php endif ?>
</div>
<h1 class="display-4">Welcome <?php echo $this->Identity->get('first_name') ?></h1>

</div>
<div class="nav nav-pills justify-content-center">
    <a class="nav-link" href="/profile">Pathways</a> 
    <a class="nav-link active" href="/profile/claims">Claims</a> 
    <a class="nav-link" href="/profile/reports">Reports</a> 
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3">
<div class="row justify-content-md-center">
<div class="col-md-8 col-lg-6">
<h2><?= __('Your Claims') ?></h2>
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
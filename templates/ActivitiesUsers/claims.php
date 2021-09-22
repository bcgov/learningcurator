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
<div class="col-md-10 col-lg-8 col-xl-6">
<div class="py-5">

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
    <a class="nav-link" href="/profile/pathways">Pathways</a> 
    <a class="nav-link active" href="/profile/claims">Claims</a> 
    <a class="nav-link" href="/profile/reports">Reports</a> 
    <a class="nav-link" href="/profile/contributions">Contributions</a> 
</div>
</div>
</div>
</div>
<div class="container-fluid pt-3">
<div class="row justify-content-md-center">
<div class="col-md-8 col-lg-6">
<h2><?= __('Your Claims') ?></h2>
<?php if(!$activities->isEmpty()): ?>
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
            <div class="p-3" style="background-color: rgba(255,255,255,.3)">
            <div>Claimed on: <?= $this->Time->format($a['created'],\IntlDateFormatter::MEDIUM,null,'GMT-8') ?></div>
            <?php foreach($a['activity']['steps'] as $s): ?>
                <div>Included in 
                    <a href="/pathways/<?= $s->pathways[0]->slug ?>/s/<?= $s->id ?>/<?= $s->slug ?>">
                        <?= $s->pathways[0]->name ?> - <?= $s->name ?>
                    </a>
                </div>
            <?php endforeach ?>
            </div>
    </div>
</div>
<?php endforeach ?>
<?php else: ?>

<div class="p-3 mb-2 bg-white rounded-lg shadow-lg">
    <p><strong>You've not yet claimed any activities.</strong></p>
    <p>You can claim activities along a pathway. Doing so allows you to see how much of the path you have completed.</p>
</div>
<?php endif ?>

<h3 class="mt-5">Recent Pathways</h3>

<?php foreach($published as $p): ?>
	<!-- <pre><?php print_r($p) ?></pre> -->
	<div class="p-3 mb-2 bg-white">
		<a href="/pathways/<?= $p->slug ?>">
			<i class="bi bi-pin-map-fill"></i> 
			<?= h($p->name) ?>
		</a> 
		<a href="/topics/view/<?= $p->topic->id ?>" class="badge badge-light">
		<?= h($p->topic->categories[0]->name) ?> <?= h($p->topic->name) ?>
		</a>
	</div>
<?php endforeach ?>


</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

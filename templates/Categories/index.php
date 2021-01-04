<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = 0;
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role_id');
	$uid = $this->Identity->get('id');
}
?>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-12">
<div class="my-3 p-5 bg-dark text-white rounded-3">

	<h1 class="display-1">Curator CMS</h1>
	<div class="fs-3 fw-light">
		Helping subject matter experts create learning pathways for self-guided learners
	</div>
	<a class="btn btn-success btn-lg mt-3" 
		href="https://learningcurator.ca" 
		rel="noopener" 
		target="_blank">Visit LearningCurator.ca</a>

</div> <!-- /.p5 -->
</div>
<?php if($role == 2 || $role == 5): ?>
<div class="col-md-6">
<?php foreach ($categories as $category): ?>
<div class="my-2 p-5 bg-dark text-white rounded-3">
	<h2><?= $this->Html->link($category->name, ['action' => 'view', $category->id]) ?></h2>
	<div>
	<?= $category->description ?>
	</div>
</div>
<?php endforeach; ?>
</div>
<?php endif ?>
</div>
</div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/

?>
<style>
.badge {
	border-radius: 50%;
	color:#FFF; 
	display: inline-block;
	font-size: 24px;
	height: 50px;
	padding-top: 12px;
	width: 60px;
}
</style>
<div class="container-fluid">
<div class="row justify-content-md-center" id="colorful">
<div class="col-md-6">
<div class="pad-sm">
	<h1>
		Welcome <?= h($user->name) ?> 	
		<a class="" data-toggle="collapse" href="#editname" role="button" aria-expanded="false" aria-controls="editname">
			<i class="fas fa-edit"></i>
		</a>
	</h1>

	<div class="collapse" id="editname">
	<div class="row">
	<div class="col-sm-12 col-md-7 col-lg-5">
	<div class="p-3" style="background-color: rgba(255,255,255,.5)">	
		<p>Update your display name here. This is the name that will be used on 
		any completion certificates that you might earn.</p>
		<?= $this->Form->create(null, ['url' => [
			'controller' => 'Users',
			'action' => 'edit/' . $user->id
		]]) ?>
		<?= $this->Form->control('name',['class'=>'form-control','value' => $user->name, 'label' => false]) ?>
		<?= $this->Form->hidden('id', ['value' => $user->id]) ?>
		<?= $this->Form->button(__('Update name'), ['class'=>'btn btn-light']) ?>
		<?= $this->Form->end() ?>
	</div>
	</div>
	</div>
	</div>

</div>
</div>
</div>
</div>
<div class="container-fluid pt-3 linear">
<div class="row justify-content-md-center">

<div class="col-md-8 col-lg-6">
<ul class="nav nav-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link active" href="#">Pathways</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/learning-curator/users/bookmarks">Bookmarks</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/learning-curator/users/claimed">Claimed</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/learning-curator/users/reports">Reports</a>
  </li>
</ul>
</div>

<div class="w-100"></div>
<div class="col-md-8 col-lg-6">

<?php if (!empty($user->pathways)) : ?>
	<h2><i class="fas fa-sitemap"></i> <?= __('Your Pathways') ?></h2>
	<?php foreach ($user->pathways as $pathways) : ?>
	<div class="p-3 mb-2 bg-white rounded-lg">
	<div class="row">
	<div class="col-3 ">
	
		<canvas class="bg-white rounded-lg" id="chart<?= $pathways->id ?>" width="400" height="400"></canvas>
		<script>
			var request<?= $pathways->id ?> = new XMLHttpRequest();

			request<?= $pathways->id ?>.open('GET', '/learning-curator/pathways/status/<?= $pathways->id ?>', true);

			request<?= $pathways->id ?>.onload = function() {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var data<?= $pathways->id ?> = JSON.parse(this.response);
				document.querySelector('.status<?= $pathways->id ?>').innerHTML = data<?= $pathways->id ?>.status;
				var ctx<?= $pathways->id ?> = document.getElementById('chart<?= $pathways->id ?>').getContext('2d');
				var myDoughnutChart = new Chart(ctx<?= $pathways->id ?>, {
					type: 'doughnut',
					data: JSON.parse(data<?= $pathways->id ?>.chartjs),
					options: { 
						legend: { 
							display: false 
						},
					}
				});
			} else {
				// We reached our target server, but it returned an error

			}
			};

			request<?= $pathways->id ?>.onerror = function() {
				// There was a connection error of some sort
				document.querySelector('.status<?= $pathways->id ?>').innerHTML = 'Could not get status';
			};
			request<?= $pathways->id ?>.send();
		</script>
	</div>
	<div class="col">
	
		<?= $this->Form->postLink(__('Unfollow'), ['controller' => 'PathwaysUsers','action' => 'delete/'. $pathways->_joinData->id], ['class' => 'btn btn-dark float-right', 'confirm' => __('Really unfollow?')]) ?>
		<div>
			<?= $pathways->has('category') ? $this->Html->link($pathways->category->name, ['controller' => 'Categories', 'action' => 'view', $pathways->category->id]) : '' ?>
		</div>
		
		<h3>
		<?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->slug]) ?>
		</h3>

		<div><?= h($pathways->description) ?></div>
		<div class="p-3 mt-3 bg-light">Overall Progress: <span class="status<?= $pathways->id ?>"></span>%</div>
		
	</div>
	</div>
	</div>
	<?php endforeach; ?>
<?php else: ?>
<h2><?= _('You\'re not following any pathways yet.') ?></h2>
<p><?= _('Pathways are organized into topics. Here some topics for you to explore:') ?></p>
<?php foreach ($allcats as $cat) : ?>
<div class="p-3 mb-2 bg-white rounded-lg">
<h3>
	<?= $this->Html->link($cat->name, ['controller' => 'Categories', 'action' => 'view', $cat->id]) ?>
</h3>
<div><?= h($cat->description) ?></div>
</div>
<?php endforeach; ?>

<?php endif; ?>

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
	
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
var options = {
    valueNames: [ 'name' ]
};

var hackerList = new List('activitylist', options);
</script>
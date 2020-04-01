<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
*/
?>
<div class="btn-group float-right">
<?= $this->Html->link(__('Logout'), ['action' => 'logout', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?php //$this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'btn btn-dark btn-sm']) ?>
<?php //$this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-dark btn-sm']) ?>
</div>
<h1><?= h($user->name) ?></h1>
<?php if (!empty($user->pathways)) : ?>
<h2><?= __('You\'re following these pathways') ?></h2>
<div class="card-columns">
	<?php foreach ($user->pathways as $pathways) : ?>
	<div class="card p-3">
		<div><?= $pathways->has('category') ? $this->Html->link($pathways->category->name, ['controller' => 'Categories', 'action' => 'view', $pathways->category->id]) : '' ?></div>
		<h2><?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?></h2>
		<div><?= h($pathways->description) ?></div>
		<div class="status<?= $pathways->id ?>"></div>

		<script>
			var request<?= $pathways->id ?> = new XMLHttpRequest();

			request<?= $pathways->id ?>.open('GET', '/pathways/status/<?= $pathways->id ?>', true);

			request<?= $pathways->id ?>.onload = function() {
			if (this.status >= 200 && this.status < 400) {
				// Success!
				var data<?= $pathways->id ?> = JSON.parse(this.response);
				document.querySelector('.status<?= $pathways->id ?>').innerHTML = data<?= $pathways->id ?>.status;
				console.log(data<?= $pathways->id ?>);
			} else {
				// We reached our target server, but it returned an error

			}
			};

			request<?= $pathways->id ?>.onerror = function() {
			// There was a connection error of some sort
			};
			request<?= $pathways->id ?>.send();
		</script>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if (!empty($user->activities)) : ?>
<h2><?= __('You\'ve claimed these activities') ?></h2>
<div class="card">
<div class="card-body">
<input type="text" name="activityfilter" id="activityfilter" placeholder="Filter" class="form-control mb-3">
<div class="mb-1">
<span class="badge badge-dark" style="background-color: rgba(240,203,86,1)">Read</span>
<span class="badge badge-dark" style="background-color: rgba(71,189,182,1)">Watch</span>
<span class="badge badge-dark" style="background-color: rgba(229,76,59,1)">Listen</span>
<span class="badge badge-dark" style="background-color: rgba(134, 33, 206,1)">Participate</span>
</div>
<div class="card-columns">
	<?php foreach ($user->activities as $activity) : ?>
	<div class="card p-3" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border: 0">
		<?php if($activity->status_id == 2): ?>
		<span class="badge badge-warning" title="This link has been deemed to be non-functional or no longer relevant to the pathway">DEFUNCT</span>
		<div><strong><?= h($activity->name) ?></strong></div>
		<?php else: ?>
		<h3><?= h($activity->name) ?></h3>
		<?php endif ?>
		<div><?= h($activity->description) ?></div>
	<a target="_blank" 
		href="<?= $activity->hyperlink ?>" 
		style="background-color: rgba(<?= $activity->activity_type->color ?>,1); border: 3px solid #FFF; color: #FFF; font-weight: bold;" 
		class="btn btn-block my-2 text-uppercase btn-lg">

			<i class="fas <?= $activity->activity_type->image_path ?>"></i>
			
			<?= $activity->activity_type->name ?>
	</a>

	</div>
	<?php endforeach; ?>
</div>
</div>
</div>

<?php endif; ?>
<?php if (!empty($user->competencies)) : ?>
<div class="card">
<div class="card-body">
	<h2><?= __('Competencies developing') ?></h2>
	<?php foreach ($user->competencies as $competencies) : ?>
	<div>
		<?= $this->Html->link($competencies->name, ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>
	</div>
	<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

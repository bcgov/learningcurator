<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */

$this->loadHelper('Authentication.Identity');
$uid = 0;
$role = '';
if ($this->Identity->isLoggedIn()) {
	$role = $this->Identity->get('role');
	$uid = $this->Identity->get('id');
}
?>

<div class="p-6 dark:text-white">

	<?php if($role == 'curator' || $role == 'superuser'): ?>
	<div class="btn-group float-right">
	<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activity->id], ['confirm' => __('Really delete?'), 'class' => 'btn btn-sm btn-light']) ?>
	<?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activity->id], ['class' => 'btn btn-light btn-sm']) ?>
	</div>

	<?php if($activity->status_id == 3): ?>
	<span class="badge badge-danger">DEFUNCT</span>
	<?php endif ?>
	<?php if($activity->moderation_flag == 1): ?>
	<span class="badge badge-warning">INVESTIGATE</span>
	<?php endif ?>
	<?php endif; // role check ?>	

	<h1 class="text-4xl mb-3">
		<?= $activity->name ?>
	</h1>

	<div class="p-3 bg-white dark:bg-slate-900 rounded-lg">
		
		<div class="mb-2">
			<?php foreach($activity->tags as $tag): ?>
			<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
			<?php endforeach ?>
		</div>

		<div class="p-2 lg:p-4 text-lg bg-slate-100 dark:bg-[#002850] rounded-lg">
		<?php if(!empty($activity->description)): ?>
			<?= $activity->description ?>
		<?php else: ?>
			<em>No description provided&hellip;</em>
		<?php endif ?>
			<div class="mt-3 italic text-sm" >
				This activity was added on <?= $this->Time->format($activity->created,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
				<?php if($role == 'curator' || $role == 'superuser'): ?>
					by <a href="/users/view/<?= $activity->createdby_id ?>"><?= $curator[0]->username ?></a>
				<?php endif ?>
			</div>
		</div>

		<?php if(!empty($activity->isbn)): ?>
		<div class="p-2 isbn bg-white dark:bg-slate-800">
		<strong>ISBN:</strong> <?= $activity->isbn ?>
		</div>
		<?php endif ?>

		<?php if($activity->status_id == 2): ?>
		<div>
			<a target="_blank" 
				rel="noopener" 
				data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
				href="/activities-users/launch?activity_id=<?= $activity->id ?>" 
				class="inline-block my-2 p-3 bg-sky-700 rounded-lg text-white text-2xl hover:no-underline">
					Launch Activity
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
						<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
					</svg>
			</a>
			
			<a href="/activities/like/<?= $activity->id ?>" class="inline-block ml-6" title="Like this activity">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
					<path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
				</svg>
				<span class="lcount"><?= h($activity->recommended) ?> likes</span>
			</a>

		</div>
		<?php elseif($activity->status_id == 3): ?>
		<div class="p-6 text-xl dark:bg-slate-900" >
			<div><strong>Archived</strong></div>
			<p>This activity has been archived, so it's link will not be shown. If you are a curator you
				can still access the hyperlink by editing this activity.
			</p>
		</div>
		<?php endif ?>

		</div>

		<div class="my-3 p-3 bg-white dark:bg-slate-900 rounded-lg">
			<strong>Hyperlink:</strong>
			<div class="p-2 bg-white dark:bg-black text-xl">
				<?= $activity->hyperlink ?>
			</div>
		</div>



		
		<?php if(count($activitylaunches) > 0): ?>
		<div class="mb-3 p-3 bg-white dark:bg-slate-900 rounded-lg">
		<h2 class="text-lg">You launched this activity:</h2>
		<?php foreach($activitylaunches as $u): ?>
		<div class="p-2 my-2 bg-slate-100 dark:bg-slate-800 dark:text-yellow-500 rounded-lg">
			<?= $this->Time->format($u[1],\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
			<?= $this->Form->postLink(__('Remove'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $u[0]], ['class' => 'px-2 bg-white text-black dark:bg-black dark:text-white hover:no-underline rounded-lg', 'confirm' => __('Remove?')]) ?>
		</div>
		<?php endforeach ?>
		</div>
		<?php endif ?>




		<?php if($role == 'curator' || $role == 'superuser'): ?>
		<?php if (!empty($activity->moderator_notes)) : ?>
		<div class="my-3 p-3 bg-white dark:bg-slate-900 rounded-lg">
		<h3 class="text-lg"><?= __('Moderator Notes') ?></h3>
		<blockquote>
		<?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
		</blockquote>
		</div>
		<?php endif ?>
		<?php endif; ?>
		
		<?php if(!empty($activity->steps)): ?>
		<div class="my-3 p-3 bg-white dark:bg-slate-900 rounded-lg">
		<h3 class="text-lg">
			This activity is included in the following pathways:
		</h3>

		<?php foreach($activity->steps as $step): ?>
		<?php foreach($step->pathways as $path): ?>
		<?php if($path->status_id == 2): ?>

		<div class="my-3 p-3 bg-white dark:bg-slate-800 rounded-lg">
			<h4 class="text-xl">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-compass" viewBox="0 0 16 16">
					<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
					<path d="m6.94 7.44 4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
				</svg>
				<a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a></h4>
		
		</div>

		<?php else: ?>

		<div class="my-3 p-3" >
		<span class="badge badge-warning">DRAFT</span>
		<h4><a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a></h4>
			<div><?= $step->description ?></div>
		</div>

		<?php endif ?>
		<?php endforeach ?>
		<?php endforeach ?>
		</div>
		<?php endif ?>


	<div class="p-3 bg-white dark:bg-slate-900 rounded-lg">
		<p class="mb-1 text-lg">Is there something wrong with this activity? Report it!</p>
		<script>

		var message = '';

		function report<?= $activity->id ?>Form() {
			return {
				form<?= $activity->id ?>Data: {
					activity_id: '<?= $activity->id ?>',
					user_id: '<?= $uid ?>',
					issue: '',
					csrfToken: <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>,
				},
				message: '',

				submitData() {
					this.message = ''

					fetch('/reports/add', {
						method: 'POST',
						headers: { 
							'Content-Type': 'application/json', 
							'X-CSRF-Token': <?php echo json_encode($this->request->getAttribute('csrfToken')); ?> 
						},
						body: JSON.stringify(this.form<?= $activity->id ?>Data)
					})
					.then(() => {
						this.message = 'Report sucessfully submitted!';
						this.form<?= $activity->id ?>Data.issue = '';

					})
					.catch(() => {
						this.message = 'Ooops! Something went wrong!';
					})
				}
		}
		}
		</script>
		<?= $this->Form->create(null,
								[
									'url' => [
										'controller' => 'reports',
										'action' => 'add'
									],
									'class' => 'block w-full lg:w-1/2 p-3 bg-white dark:bg-black rounded-lg',
									'x-data' => 'report' . $activity->id . 'Form()',
									'@submit.prevent' => 'submitData'
								]) ?>

			
			<?php
			echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
			echo $this->Form->hidden('user_id', ['value' => $uid]);
			echo $this->Form->textarea('issue',
							['class' => 'block w-full h-20 p-6 bg-slate-200 dark:bg-slate-700 text-white rounded-lg', 
							'x-model' => 'form'.$activity->id.'Data.issue', 
							'placeholder' => 'Type your issue here ...',
							'required' => 'required']);
			?>
			
			<input type="submit" class="mt-1 px-4 py-2 text-white bg-sky-700 hover:bg-sky-800 rounded-lg" value="Report Issue">
			<span x-text="message"></span> 
			<a class="inline-block ml-6" href="/profile/reports">See all your reports</a>

		<?= $this->Form->end() ?>



		</div>






</div>
</div>
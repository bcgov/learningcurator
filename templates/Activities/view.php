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
	

		<?php if(in_array($activity->id,$useractivitylist)): // if the user hasn't claimed this, then show them claim form ?>

		<!-- <div class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="You have completed this activity. Great work!">CLAIMED <i class="fas fa-check-circle"></i></div> -->
		
		<?php echo $this->Form->postLink(__('Unclaim'), ['controller' => 'ActivitiesUsers','action' => 'delete/'. $claimid], ['class' => 'btn btn-primary', 'confirm' => __('Unclaim?')]) ?>
		
		<?php endif ?>
	

	<h1 class="text-4xl">
		<?= $activity->name ?>
	</h1>
	<div class="p-3 bg-slate-200 dark:bg-slate-900 rounded-lg">
		<div class="mb-2">

			<?php foreach($activity->tags as $tag): ?>
			<a href="/tags/view/<?= h($tag->id) ?>" class="badge badge-light"><?= $tag->name ?></a> 
			<?php endforeach ?>
		</div>
		<?= $activity->description ?>
		<?php if(!empty($activity->isbn)): ?>
		<div class="p-2 my-2 isbn">
			ISBN: <?= $activity->isbn ?>
		</div>
		<?php endif ?>
		<div class="py-3 text-muted" >
			<?= $this->Time->format($activity->created,\IntlDateFormatter::MEDIUM,null,'GMT-8') ?>
			<?php if($role == 'curator' || $role == 'superuser'): ?>
				by <a href="/users/view/<?= $activity->createdby_id ?>"><?= $curator[0]->username ?></a>
			<?php endif ?>
		</div>
		<div class="py-3">
			<a href="/activities/like/<?= $activity->id ?>" class="likingit btn btn-light float-left mr-1" data-toggle="tooltip" data-placement="bottom" title="Like this activity">
				<i class="fas fa-thumbs-up"></i> <span class="lcount"><?= h($activity->recommended) ?> likes</span>
			</a>
		</div>

		
	<?php if($activity->status_id == 2): ?>




	<div @click.away="open = false" class="relative" x-data="{ open: false }">
	<button @click="open = !open" class="px-4 py-2 text-lg font-semibold text-right bg-sky-600 text-white rounded-lg dark:bg-sky-600 dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-slate-900 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
		<span>Launch</span>
		<svg fill="currentColor" viewBox="0 0 8 18" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-8 h-4 transition-transform duration-200 transform md:-mt-1">
			<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
	<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 right-0 w-full origin-top-right shadow-lg">
		<div class="p-4 bg-white rounded-md shadow dark:bg-slate-900">

		<div>
			<a target="_blank" 
				rel="noopener" 
				data-toggle="tooltip" data-placement="bottom" title="Launch this activity"
				href="<?= $activity->hyperlink ?>" 
				class="inline-block mb-3 p-3 bg-sky-600 rounded-lg text-white text-2xl">
					Open Activity in new window
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
						<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
					</svg>
			</a>
		</div>

		<div class="my-4">
			<?= $activity->hyperlink ?>
		</div>
		
	</div>
	</div>








	<?php endif; ?>


	<?php if($activity->status_id == 3): ?>
		<div class="p-6 text-xl dark:bg-slate-900" >
			<div><strong>Archived</strong></div>
			<p>This activity has been archived.</p>
		</div>
	<?php endif ?>

	</div>





	<div x-data="{ open: false }">
    <!-- Button -->
    <button x-on:click="open = true" type="button" class="px-4 py-2 focus:outline-none focus:ring-4 focus:ring-aqua-400">
        Report an issue
    </button>

    <!-- Modal -->
    <div
        x-show="open"
        x-on:keydown.escape.prevent.stop="open = false"
        role="dialog"
        aria-modal="true"
        x-id="['modal-title']"
        :aria-labelledby="$id('modal-title')"
        class="fixed inset-0 overflow-y-auto"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Panel -->
        <div
            x-show="open" x-transition
            x-on:click="open = false"
            class="relative min-h-screen flex items-center justify-center p-4"
        >
            <div
                x-on:click.stop
                x-trap.noscroll.inert="open"
                class="relative max-w-2xl w-full bg-white dark:bg-slate-900 border border-black p-8 overflow-y-auto"
            >

			

			<?= $this->Form->create(null,['url' => ['controller' => 'reports','action' => 'add'],'class'=>'reportform']) ?>
            <fieldset>
                <legend><?= __('Report this activity') ?></legend>
				<p>Is there something wrong with this activity? Tell us about it!</p>
                <?php
                    echo $this->Form->hidden('activity_id', ['value' => $activity->id]);
                    echo $this->Form->hidden('user_id', ['value' => $uid]);
                    echo $this->Form->textarea('issue',['class' => 'dark:bg-slate-900', 'placeholder' => 'Type here ...']);
                ?>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Submit Report">
            <?= $this->Form->end() ?>

            </div>
        </div>
    </div>
</div>







	


		<?php if($role == 'curator' || $role == 'superuser'): ?>
		<?php if (!empty($activity->moderator_notes)) : ?>
		<div class="my-3 p-3 ">
		<h4><?= __('Moderator Notes') ?></h4>
		<blockquote>
		<?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
		</blockquote>
		</div>
		<?php endif ?>
		<?php endif; ?>

		<?php if(!empty($activity->steps)): ?>
		<div class="dark:bg-slate-900 dark:text-white">
		<h3 class="mt-3"><i class="fas fa-sitemap"></i> Pathways</h3>

		<?php foreach($activity->steps as $step): ?>
		<?php foreach($step->pathways as $path): ?>
		<?php if($path->status_id == 2): ?>

		<div class="my-3 p-3" >
			<h4><a href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $path->name ?> - <?= $step->name ?></a></h4>
			<div><?= $step->description ?></div>
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






</div>
</div>
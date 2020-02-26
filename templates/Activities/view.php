<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
?>
<div class="row">
<div class="col">
<div class="card" style="background-color: rgba(<?= $activity->activity_type->color ?>,.2); border:0">
<div class="card-body">
<div><?= $activity->has('category') ? $this->Html->link($activity->category->name, ['controller' => 'Categories', 'action' => 'view', $activity->category->id]) : '' ?></div>
<div><?= $activity->has('activity_type') ? $this->Html->link($activity->activity_type->name, ['controller' => 'ActivityTypes', 'action' => 'view', $activity->activity_type->id]) : '' ?></div>
<h3><?= h($activity->name) ?></h3>
<div><?= h($activity->hyperlink) ?></div>
<div><?= __('Isbn') ?></div>
<div><?= h($activity->isbn) ?></div>
<div><?= h($activity->image_path) ?></div>
<div><?= __('Hours') ?></div>
<div><?= $this->Number->format($activity->hours) ?></div>
<div class="text">
<strong><?= __('Description') ?></strong>
<blockquote>
<?= $this->Text->autoParagraph(h($activity->description)); ?>
</blockquote>
</div>
<div class="text">
<strong><?= __('Licensing') ?></strong>
<blockquote>
<?= $this->Text->autoParagraph(h($activity->licensing)); ?>
</blockquote>
</div>
<div class="text">
<strong><?= __('Moderator Notes') ?></strong>
<blockquote>
<?= $this->Text->autoParagraph(h($activity->moderator_notes)); ?>
</blockquote>
</div>
<div class="related">
<h4><?= __('Related Users') ?></h4>
<?php if (!empty($activity->users)) : ?>
<?php foreach ($activity->users as $users) : ?>
<div>
    <?= $this->Html->link($users->name, ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="related">
<h4><?= __('Related Competencies') ?></h4>
<?php if (!empty($activity->competencies)) : ?>
<?php foreach ($activity->competencies as $competencies) : ?>
<div>
<?= $this->Html->link($compentencies->name, ['controller' => 'Competencies', 'action' => 'view', $competencies->id]) ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="related">
<h4><?= __('Related Steps') ?></h4>
<?php if (!empty($activity->steps)) : ?>
<?php foreach ($activity->steps as $steps) : ?>
<div>
   <?= $this->Html->link($steps->name, ['controller' => 'Steps', 'action' => 'view', $steps->id]) ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="related">
<h4><?= __('Related Tags') ?></h4>
<?php if (!empty($activity->tags)) : ?>
<?php foreach ($activity->tags as $tags) : ?>
<div>
	<?= $this->Html->link($tags->name, ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>

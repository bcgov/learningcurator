<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */

$this->loadHelper('Authentication.Identity');
?>
<div class="p-6">
<div class="p-3 bg-slate-100/80 dark:bg-slate-900/80 rounded-lg">
<h1 class="text-lg">Manual Review</h1>
<p>These activities, usually because they are behind authentication, 
    (e.g. most of our intranet sites) cannot be automatically audited 
    and need to be periodically checked to ensure that the link still 
    goes to where it should.</p>
<p>If you find a broken link or something amiss, you can fix it by updating the 
    link here, or file a report so that some other curator might know of the 
    issue and be able to rectify it.</p>
<p>These are links which have not been audited in the past 2 weeks.</p>
<?php foreach($activities as $a): ?>
<div class="p-3 mb-3 bg-slate-100/80 dark:bg-slate-800 rounded-lg">
<div><a href="/activities/view/<?= h($a->id) ?>" target="_blank"><?= h($a->name) ?></a></div>
<div>
    <a href="<?= h($a->hyperlink) ?>" target="_blank">Visit website to verify</a> 
    <?= $this->Form->create(null, ['url' => ['controller' => 'Activities','action' => 'edit/' . $a->id], 'class' => 'inline']) ?>
    <?= $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id')]); ?>
    <?= $this->Form->hidden('audited', ['value' => '2022-04-25 10:30:00']); ?>
    <?= $this->Form->button(__('Succesfully Audited'), ['class' => '']) ?>
    <?= $this->Form->end() ?>
</div>
<!--
<?= $this->Form->create(null, ['url' => ['controller' => 'Activities','action' => 'edit/' . $a->id], 'class' => 'inline']) ?>
<?= $this->Form->hidden('modifiedby_id', ['value' => $this->Identity->get('id')]); ?>
<?= $this->Form->control('hyperlink', ['value' => $a->hyperlink, 'label' => '', 'class' => 'inline-block px-3 py-2 m-0 dark:text-white dark:bg-slate-900/80 rounded-lg']); ?>
<?= $this->Form->button(__('Update Link'), ['class' => 'inline-block']) ?>
<?= $this->Form->end() ?>
-->

</div>
<?php endforeach ?>
</div>
</div>
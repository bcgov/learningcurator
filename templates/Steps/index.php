<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step[]|\Cake\Collection\CollectionInterface $steps
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3"><?= __('All Steps') ?><?= $this->Html->link(__('Add Step'), ['action' => 'add'], ['class' => 'inline-block ml-2 text-sky-700 hover:underline text-base font-normal']) ?></h2>


    <p class="mt-5 mb-1 text-base"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    <table class="border-collapse border border-slate-400">
        <thead>
            <tr>
            <tr>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('id') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('name') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('slug') ?></th>
                <!-- <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('image_path') ?></th> -->
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('featured', ['label' => 'Feat']) ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('created') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('createdby', ['label' => 'Created by']) ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('modified') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('modifiedby', ['label' => 'Modified by']) ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody class="text-base">

            <?php foreach ($steps as $step) : ?>
                <tr>
                    <td class="px-2 py-1 border border-slate-300"><?= $this->Number->format($step->id) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($step->name) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($step->slug) ?></td>
                    <!-- <td class="px-2 py-1 border border-slate-300"><?= h($step->image_path) ?></td> -->
                    <td class="px-2 py-1 border border-slate-300"><?= $this->Number->format($step->featured) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($step->created) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($step->createdby) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($step->modified) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($step->modifiedby) ?></td>
                    <td class="px-2 py-1 border border-slate-300 text-sm">
                        <span class="inline-block text-sky-700 hover:underline  hover:cursor-pointer"><?= $this->Html->link(__('View'), ['action' => 'view', $step->id]) ?></span>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $step->id]) ?>
                        <span class="inline-block text-red-500 hover:underline hover:cursor-pointer"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $step->id], ['confirm' => __('Are you sure you want to delete # {0}?', $step->id)]) ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="flex items-center gap-2">
            <li><?= $this->Paginator->first('<< ' . __('first')) ?></li>
            <li><?= $this->Paginator->prev('< ' . __('previous')) ?></li>
            <li><?= $this->Paginator->numbers() ?></li>
            <li><?= $this->Paginator->next(__('next') . ' >') ?></li>
            <li><?= $this->Paginator->last(__('last') . ' >>') ?></li>
        </ul>

    </div>
</div>
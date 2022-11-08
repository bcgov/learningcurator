<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic[]|\Cake\Collection\CollectionInterface $topics
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">All Topics <?= $this->Html->link(__('Add Topic'), ['action' => 'add'], ['class' => 'inline-block ml-2 text-sky-700 hover:underline text-base font-normal']) ?></h2>

    <p class="mt-3 text-base"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    <table class="border-collapse border border-slate-400">
        <thead>
            <tr>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('id') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('name') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('slug') ?></th>
                <!-- <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('image_path') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('color') ?></th> -->
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('feat') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('created') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= $this->Paginator->sort('user_id') ?></th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left"><?= __('Actions') ?></th>

            </tr>
        </thead>
        <tbody class="text-base">
            <?php foreach ($topics as $topic) : ?>
                <tr>
                    <td class="px-2 py-1 border border-slate-300"><?= $this->Number->format($topic->id) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($topic->name) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($topic->slug) ?></td>
                    <!-- <td class="px-2 py-1 border border-slate-300"><?= h($topic->image_path) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= h($topic->color) ?></td> -->
                    <td class="px-2 py-1 border border-slate-300"><?= h($topic->featured) ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= $this->Time->format($topic->created, \IntlDateFormatter::MEDIUM, null, 'GMT-8') ?></td>
                    <td class="px-2 py-1 border border-slate-300"><?= $topic->has('user') ? $this->Html->link($topic->user->username, ['controller' => 'Users', 'action' => 'view', $topic->user->id]) : '' ?></td>
                    <td class="px-2 py-1 border border-slate-300 text-sm">
                        <span class="inline-block text-sky-700 hover:underline  hover:cursor-pointer"><?= $this->Html->link(__('View'), ['action' => 'view', $topic->id]) ?> </span>
                        <span class="inline-block hover:underline hover:cursor-pointer"><?= $this->Html->link(__('Edit'), ['action' => 'edit', $topic->id]) ?> </span>
                        <span class="inline-block text-red-500 hover:underline hover:cursor-pointer"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $topic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $topic->id)]) ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
    <!-- TODO Nori/Allan update pagination to match others -->
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
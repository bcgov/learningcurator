<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Tagged Activities: <span class="font-normal text-slate-900"><?= h($tag->name) ?></span>  </h2>

    <div class="text-xl">
        <!-- TODO Nori/Allan auto Paragraph formatting function here? -->
       <?= $this->Text->autoParagraph(h($tag->description)); ?>
    </div>

    <ul class="list-disc pl-8 mt-2">
        <?php if (!empty($tag->activities)) : ?>
            <?php foreach ($tag->activities as $activities) : ?>
                <li class="px-2">
                    <?= $this->Html->link($activities->name, ['controller' => 'Activities', 'action' => 'view', $activities->id]) ?>
                </li>
            <?php endforeach; ?>
    </ul>
<?php endif; ?>
</div>
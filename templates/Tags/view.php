<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Tagged Activities: <span class="text-slate-900"><?= h($tag->name) ?></span>  </h2>

    <div class="text-xl">
        <!-- TODO Nori/Allan auto Paragraph formatting function here? -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill inline align-text-top mr-1" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
        </svg> <?= h($tag->description) ?>
    </div>

    <!-- <?= $this->Text->autoParagraph(h($tag->description)); ?> -->
    <ul class="list-disc pl-8 mt-2">
        <!-- TODO Nori/Allan why arent' the activities being listed here? Working in tag edit view -->
        <?php if (!empty($tag->activities)) : ?>
            <?php foreach ($tag->activities as $activities) : ?>
                <li class="px-2">
                    <?= $this->Html->link($activities->name, ['controller' => 'Activities', 'action' => 'view', $activities->id]) ?>
                </li>
            <?php endforeach; ?>
    </ul>
<?php endif; ?>
</div>
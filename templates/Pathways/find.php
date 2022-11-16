<!-- TODO Q is there supposed to be php code here app view/entity? -->
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>

<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold">Pathway Step Directory</h2>

    <table class="border-collapse border border-slate-400 mt-3">
        <thead>
            <tr>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left">Pathway</th>
                <th class="border border-slate-300 px-2 py-1 bg-slate-200 text-left">Steps</th>
            </tr>
        </thead>
        <!-- TODO this shows all the step names nicely... -->
        <tbody class="text-base">
            <?php if (!empty($pathways)) : ?>
                <?php foreach ($pathways as $path) : ?>
                    <tr>
                        <td class="px-2 py-1 border border-slate-300"> <a href="/pathways/<?= $path->slug ?>" target="_blank" rel="noopener">
                                <?= $path->name ?>
                            </a></td>
                        <td class="px-2 py-1 border border-slate-300">
                            <ol class="list-decimal pl-4">
                                <?php foreach ($path->steps as $step) : ?>
                                    <li class="px-2"> <a class="inline" data-stepid="<?= $step->id ?>" data-steptit="<?= $path->name ?> - <?= $step->name ?>" title="<?= strip_tags($step->description) ?>" href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
                                            <?= $step->name ?>
                                        </a> </li>
                                <?php endforeach ?>
                            </ol>
                        </td>
                    </tr>


                <?php endforeach; ?>

        </tbody>
    </table>
<?php else : ?>
    <div class="mt-3">
        <p>No results found.</p>
    </div>
<?php endif ?>

</div>
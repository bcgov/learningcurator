<?php if (!empty($pathways)) : ?>
    <?php foreach ($pathways as $path) : ?>
        <div class="p-3 mb-1">
            <div class="text-bluegreen text-xl">
                <i class="bi bi-signpost-2"></i> <a href="/pathways/<?= $path->slug ?>" target="_blank" rel="noopener" class="font-semibold"><?= $path->name ?>
                </a>
            </div>
            
            <div class="ml-6"><em>Choose a step:&nbsp;</em>
                <?php foreach ($path->steps as $step) : ?>
                    &bull;<a class="stepid px-1" data-stepid="<?= $step->id ?>" data-steptit="<?= $path->name ?> - <?= $step->name ?>" title="<?= strip_tags($step->description) ?>" href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>"><?= $step->name ?></a>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
    <script>
        $(function() {
            $('.stepid').on('click', function(e) {
                e.preventDefault();
                let stepid = $(this).data('stepid');
                let savetext = 'Save this activity to ';
                savetext += $(this).data('steptit');
                $('.stepid').removeClass('chosenstep');
                $('.addform').removeClass('opacity-25');
                $('.savebut').removeClass('d-none').html(savetext);
                $('#step_id').val(stepid);
                $(this).addClass('chosenstep');
            });
        });
    </script>
<?php else : ?>
    <div class="p-3">
        <p class="text-xl font-semibold">No results found.</p>
    </div>
<?php endif ?>
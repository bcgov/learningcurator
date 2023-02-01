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
    <style>
        .chosenstep {
            background-color: #333;
            border-radius: 3px;
            color: #FFF;
        }
    </style>
    <script>
        let steplinks = document.getElementsByClassName('stepid');
        Array.from(steplinks).forEach(function(element) {
            element.addEventListener('click', (e) => { 
                e.preventDefault();
                let sid = e.target.getAttribute('data-stepid');
                document.querySelector('#step_id').value = sid;
                // #TODO This doesn't quite work yet as it doesn't remove the 
                // chosenstep class from all of them first so the highlight
                // remains even after you select another option
                // Might just make this a select box?
                e.target.classList.toggle('chosenstep');
                document.querySelector('.addform').classList.remove('opacity-25');
                
            });
        });
    </script>
<?php else : ?>
    <div class="p-3">
        <p class="text-xl font-semibold">No results found.</p>
    </div>
<?php endif ?>
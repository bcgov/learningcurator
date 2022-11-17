<?php if(!empty($pathways)): ?>
<?php foreach($pathways as $path): ?>
<div class="bg-light p-3 mb-1">
<div>
    <a href="/pathways/<?= $path->slug ?>"
        target="_blank"
        rel="noopener" 
        class="font-weight-bold">
            <i class="bi bi-pin-map-fill"></i>
            <?= $path->name ?>
    </a>
</div>
<em>Chose a step:</em>
<div>
<?php foreach($path->steps as $step): ?>
<a class="stepid" 
    data-stepid="<?= $step->id ?>" 
    data-steptit="<?= $path->name ?> - <?= $step->name ?>" 
    title="<?= strip_tags($step->description) ?>"
    href="/pathways/<?= $path->slug ?>/s/<?= $step->id ?>/<?= $step->slug ?>">
        <?= $step->name ?>
</a>, 
<?php endforeach ?>
</div>
</div>
<?php endforeach ?>
<script>
$(function () {
    $('.stepid').on('click', function(e){
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
<?php else: ?>
<div class="bg-light p-3">
    <p>No results found.</p>
</div>
<?php endif ?>
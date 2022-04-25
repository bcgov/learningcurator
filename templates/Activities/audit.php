<div class="p-6">
<div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-lg">
<h1 class="text-lg"><?= $actcount ?> activities checked.</h1>
<?php if($actcount > 0): ?>
<div><?= $count200 ?> activities OK.</div>
<div><?= $excludedcount ?> activities excluded for manual review.</div>
<div><?= $reportcount ?> reports filed.</div>
<?php endif ?>
</div>
</div>
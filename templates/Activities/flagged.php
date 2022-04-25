<div class="p-6">
<div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-lg">
<h1 class="text-lg">Manual Review</h1>
<?php foreach($activities as $a): ?>
    <?= $a->hyperlink ?><br>
<?php endforeach ?>
</div>
</div>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">"Auto" Link Audit</h2>
    <h3><?= $actcount ?> activities checked.</h3>
    <?php if ($actcount > 0) : ?>
        <div><?= $count200 ?> activities OK.</div>
        <div><?= $excludedcount ?> activities excluded for manual review.</div>
        <div><?= $reportcount ?> reports filed.</div>
    <?php endif ?>
</div>

<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway[]|\Cake\Collection\CollectionInterface $pathways
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>

<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold">Pathway Search</h2>
    <h3 class="text-xl mt-4 font-semibold">Search for a Pathway</h3>
    <form method="get" action="/pathways/search" class="mt-2 w-2/3">
       <input class="px-3 py-2 m-0 border rounded-l-lg w-3/4" type="search" placeholder="title or keyword ..." aria-label="Search" name="q" value="<?= h($q) ?>"><button class="px-3 py-2 m-0 bg-slate-400 hover:bg-slate-300 rounded-r-lg" type="submit">Search</button>
    </form> 
   
    <?= $this->Html->link(__('New Pathway'), ['action' => 'add'], ['class' => 'inline-block px-4 py-2 text-md text-white bg-slate-700 hover:text-slate-900 focus:text-slate-900 hover:bg-slate-200 focus:bg-slate-200 focus:outline-none focus:shadow-outline hover:no-underline rounded-lg my-4']) ?>
    <h3 class="text-xl mt-4 font-semibold">All Pathways</h3>

    <?php foreach ($pathways as $pathway) : ?>
        <div class="bg-white p-3 my-2 rounded-lg">

            <div>
                <a href="/pathways/<?= h($pathway->slug) ?>">
                    <i class="bi bi-pin-map-fill"></i>
                    <?= h($pathway->name) ?>
                </a>
                <span class=""><?= $pathway->status->name ?></span> in

                <?= $this->Html->link($pathway->topic->name, ['controller' => 'Topics', 'action' => 'view', $pathway->topic->id], ['class' => '']) ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
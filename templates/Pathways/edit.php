<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pathway $pathway
 */
$this->loadHelper('Authentication.Identity');
?>

<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Pathway: <span class="text-slate-900"><a href="/pathways/<?= $pathway->slug ?>">
                <?= $pathway->name ?>
            </a></span></h2>
    <div class="max-w-prose">
        <div class="border border-slate-500 p-6 my-3 rounded-md block">


            <!-- <a href="/pathways/<?= $pathway->slug ?>/export" class="float-right ml-3 p-3 bg-slate-100/80 hover:no-underline rounded-lg">Export Pathway</a> -->

            <?= $this->Form->create($pathway) ?>
            <label><?php echo $this->Form->checkbox('featured'); ?> Featured?</label>

            <?php echo $this->Form->hidden('modifiedby', ['value' => $this->Identity->get('id')]);

            echo $this->Form->control('status_id', ['type' => 'select', 'options' => $statuses, 'class' => 'form-field mb-3']);
            echo $this->Form->control('createdby', ['type' => 'select', 'options' => $users, 'class' => 'form-field mb-3', 'label' => 'Created By']) ?>
            <?php echo $this->Form->control('topic_id', ['type' => 'select', 'options' => $topics, 'class' => 'form-field mb-3', 'label' => 'Topic']); ?>
            <?php
            echo $this->Form->control('version', ['class' => 'form-field mb-3', 'type' => 'text', 'label' => 'Version']);
            
            echo $this->Form->control('name', ['class' => 'form-field mb-3', 'type' => 'text', 'label' => 'Pathway Title']);
            
            //echo $this->Form->control('slug', ['class' => 'form-field mb-3']); ?>
            
             <!-- <label for="description">Pathway Description</label> -->
             <!-- <span class="text-slate-600 block mb-1 text-sm" id="descriptionHelp"><i class="bi bi-info-circle"></i> A brief description of your pathway. This appears on the pathway overview page. (1&nbsp;to&nbsp;2&nbsp;sentences).</span> -->
           <?php //echo $this->Form->textarea('description', ['class' => 'form-field mb-3', 'aria-describedby' => 'descriptionHelp']); ?>
            <label for="objective">Pathway Goal</label>
             <span class="text-slate-600 block mb-1 text-sm" id="goalHelp"><i class="bi bi-info-circle"></i> What learning goal will your learners work toward over the course of the whole pathway? (1&nbsp;sentence).</span>
             <?php echo $this->Form->textarea('objective', ['class' => 'form-field mb-3', 'aria-describedby' => 'goalHelp']); ?>

             <label for="acknowledgments">Acknowledgments</label>
             <span class="text-slate-600 block mb-1 text-sm" id="acknowledgments"><i class="bi bi-info-circle"></i> Provide any acknowledgments you wish to make to contributors. Will be included in the footer of each path.</span>
             <?php echo $this->Form->textarea('acknowledgments', ['class' => 'form-field mb-3', 'aria-describedby' => 'acknowledgments']); ?>

             <label for="content_warning">Content Warning</label>
             <span class="text-slate-600 block mb-1 text-sm" id="content_warning"><i class="bi bi-info-circle"></i> Provide a content warning for pathways which may require it.</span>
            <?php echo $this->Form->textarea('content_warning', ['class' => 'form-field mb-3', 'aria-describedby' => 'content_warning']); 
             
            //echo $this->Form->control('topics._ids', ['options' => $topics, 'empty' => true, 'class' => 'form-field mb-3']);
            //echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true, 'class' => 'form-field mb-3']);
            //echo $this->Form->control('color');
            //echo $this->Form->control('file_path', ['class' => 'form-field mb-3','label' => 'Import history']);
            //echo $this->Form->control('image_path');
            //echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => true]);
            //echo $this->Form->control('competencies._ids', ['options' => $competencies]);
            ?>
            <?php if (!empty($pathway->file_path)) : ?>
                <!-- <div class="form-field mb-3"><?= $pathway->file_path ?></div> -->
            <?php endif ?>
            <?= $this->Form->control('keywords', ['class' => 'form-field mb-3', 'type' => 'text', 'label' => 'Keywords']); ?>
            <span class="text-slate-600 block mb-1 text-sm" id="keywordsHelp">
                <i class="bi bi-info-circle"></i> 
                A comma-separated list of keywords that don't appear in the title 
                or goal that you wish this pathway to be found by in a search.
            </span>
            <?= $this->Form->button(__('Save Pathway'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>
            <?= $this->Form->postLink(__('Delete Pathway'), ['action' => 'delete', $pathway->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pathway->id), 'class' => 'inline-block mt-3 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base']) ?>






            <h3 class="mt-4 text-xl">Re-order Steps</h3>
            <?= $this->Form->create(null, ['url' => ['controller' => 'pathways-steps', 'action' => 'reorder']]) ?>
            <?= $this->Form->control('pathway_id', ['type' => 'hidden', 'value' => $pathway->id]) ?>
            <?php $count = 0 ?>
            <div id="items">
            <?php foreach($sortedsteps as $s): ?>
            <div class="flex mb-2 p-2 bg-slate-100 rounded-lg" data-id="<?= $s->id ?>">
            <?php $count++ ?>
            <div class="handle hover:cursor-pointer" style="height: 2em; width: 3em;">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="10" style="margin: .5em 0 0 1em" viewBox="0 0 320 512">
                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z"/>
                </svg>
            </div>
            <?= $this->Form->control('steporder[]', ['type' => 'hidden', 'class' => 'stepcount step' . $s->id, 'value' => $count]) ?>
            <div><?= $s->name ?></div>
            <?= $this->Form->control('steps[]', ['type' => 'hidden', 'value' => $s->_joinData->id]) ?>
            </div>
            <?php endforeach ?>
            <?= $this->Form->button(__('Update Step Order'), ['class' => 'mt-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
            <?= $this->Form->end() ?>







        </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
var el = document.getElementById('items');
var sortable = Sortable.create(el, {
  animation: 150,
  handle: ".handle",
  onEnd: function (/**Event*/evt) {
        resort();
	},
});
function resort () {
    let stepcount = document.getElementsByClassName('stepcount');
    let count = 1;
    Array.from(stepcount).forEach(function(element) {
        element.setAttribute('value', count);
        count++;
    });
}
</script>
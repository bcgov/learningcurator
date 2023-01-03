<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
?>
<header class="w-full h-32 md:h-52 bg-darkblue px-8 flex items-center">
    <h1 class="text-white text-3xl font-bold tracking-wide">Curator Dashboard</h1>
</header>
<div class="p-8 text-lg" id="mainContent">
    <h2 class="text-2xl text-darkblue font-semibold mb-3">Edit Topic: <span class="text-slate-900"><?= h($topic->name) ?></span> </h2>
    <div class="max-w-prose outline outline-1 outline-offset-2 outline-slate-500 p-6 my-3 rounded-md block">
        <?= $this->Form->create($topic) ?>
        <fieldset>
            <div class="mb-5">
                <label>Published?
                    <?= $this->Form->checkbox('featured', ['class' => 'inline-block']) ?>
                </label>
            </div>
            <label>Category
                <select name="categories[_ids][]" id="categories" class="form-field mb-3 text-base">
                    <?php foreach ($categories as $c) : ?>
                        <?php if ($topic->categories[0]->id == $c['value']) : ?>
                            <option selected value="<?= $c['value'] ?>"><?= $c['text'] ?></option>
                        <?php else : ?>
                            <option value="<?= $c['value'] ?>"><?= $c['text'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </label>

            <?php
            // echo $this->Form->radio('categories._ids', $categories);
            //echo $this->Form->control('categories._ids', ['options' => $categories]);
            //echo $this->Form->control('featured');
            //echo $this->Form->control('image_path');
            //echo $this->Form->control('color');
            //echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('name', ['class' => 'form-field mb-3', 'label' => 'Topic Name']);
            echo $this->Form->hidden('slug');    ?>
          <label for="description">Topic Description</label>
            <small class="text-slate-600 block mt-0" id="descriptionHelp"><i class="bi bi-info-circle"></i> A brief description of the topic within the category (1&nbsp;to&nbsp;2&nbsp;sentences).</small>
           <?php echo $this->Form->textarea('description', ['class' => 'form-field', 'aria-describedby' => 'descriptionHelp']); ?>
         
        </fieldset>
        <?= $this->Form->button(__('Save Topic'), ['class' => 'my-3 inline-block px-4 py-2 text-white text-md bg-slate-700 hover:bg-slate-700/80 focus:bg-slate-700/80  hover:no-underline rounded-lg']) ?>
        <?= $this->Form->end() ?>
        <?= $this->Form->postLink(
            __('Delete Topic'),
            ['action' => 'delete', $topic->id],
            [
                'confirm' => __('Are you sure you want to delete # {0}?', $topic->id),
                'class' => 'inline-block my-2 text-red-500 underline hover:text-red-700 hover:cursor-pointer text-base'
            ]
        );
        ?>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
?>
<div class="p-6">
<h1 class="display-4 my-5">
    Editing <?= h($topic->name) ?>
</h1>
<div class="p-3 my-5 bg-white dark:bg-slate-900">
<div class="float-right">
<?= $this->Form->postLink(__('Delete'),
                    ['action' => 'delete', $topic->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $topic->id), 
                        'class' => 'btn btn-danger']
                ); 
?>
</div>
<?= $this->Form->create($topic) ?>
<fieldset>
<div>
<label>Published?
<?= $this->Form->checkbox('featured') ?>
</label>
</div>
<label>Topic Area
<select name="categories[_ids][]" id="categories" class="block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg">
<?php foreach($categories as $c): ?>
    <?php if($topic->categories[0]->id == $c['value']): ?>
        <option selected value="<?= $c['value'] ?>"><?= $c['text'] ?></option>
    <?php else: ?>
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
echo $this->Form->control('name',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
echo $this->Form->hidden('slug');
echo $this->Form->control('description',['class' => 'block w-full px-3 py-2 m-0 dark:text-white dark:bg-slate-800 rounded-lg']);
?>
</fieldset>
<?= $this->Form->button(__('Save Topic'),['class' => 'inline-block my-2 p-3 bg-sky-600 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline']) ?>
<?= $this->Form->end() ?>
</div>
</div>
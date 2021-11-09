<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry $ministry
 */
?>
<div class="container-fluid" id="colorful">
<div class="row justify-content-md-center">
<div class="col-md-6">
<div class="m-5 p-5 bg-white rounded-lg shadow-sm">
<?= $this->Html->link(__('All Ministries'), ['action' => 'index'], ['class' => '']) ?><br>
EDITING
    <h1>
        <?= h($ministry->name) ?> - 
        <span class="text-uppercase"><?= h($ministry->slug) ?></span>
    </h1>
    
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-md-center">
<div class="col-md-4">
<div class="bg-white rounded-lg p-3 my-5">
            <?= $this->Form->create($ministry) ?>
            <fieldset>
                <legend><?= __('Edit Ministry') ?></legend>
                <?php
                    echo $this->Form->control('name',['class' => 'form-control']);
                    echo $this->Form->control('slug',['class' => 'form-control']);
                    echo $this->Form->control('elm_learner_group',['class' => 'form-control']);
                    echo $this->Form->control('description',['class' => 'form-control']);
                    //echo $this->Form->control('hyperlink',['class' => 'form-control']);
                    //echo $this->Form->control('image_path',['class' => 'form-control']);
                    //echo $this->Form->control('color',['class' => 'form-control']);
                    //echo $this->Form->control('featured');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Edit Ministry'),['class' => 'btn btn-success mt-3']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

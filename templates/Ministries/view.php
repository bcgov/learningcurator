<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ministry $ministry
 */
?>
<div class="row justify-content-md-center">
<div class="col-md-6">
    <h1><?= h($ministry->name) ?></h1>
	<div class="text">
                <blockquote>
                    <?= $this->Text->autoParagraph(h($ministry->description)); ?>
                </blockquote>
            </div>
                 <div class="related">
                <h2><?= __('Related Pathways') ?></h2>
                <?php if (!empty($ministry->pathways)) : ?>
		<?php foreach ($ministry->pathways as $pathways) : ?>
                        <div class="card mb-3">
                        <div class="card-body">
                            <h3><?= $this->Html->link($pathways->name, ['controller' => 'Pathways', 'action' => 'view', $pathways->id]) ?></h3>
                            <div><?= h($pathways->description) ?></div>
                            <div><?= h($pathways->objective) ?></div>
                        </div>
                        </div>
                        <?php endforeach; ?>
                <?php endif; ?>
            </div>
    </div>
</div>

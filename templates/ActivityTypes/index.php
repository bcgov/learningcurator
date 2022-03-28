<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityType[]|\Cake\Collection\CollectionInterface $activityTypes
 */
$count = 0;
?>
<script>
function componentToHex(c) {
  var hex = c.toString(16);
  return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
  return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

//alert(rgbToHex(0, 51, 255)); // #0033ff
</script>

<div class="p-6">
<h1 class="mb-6 text-3xl">Activity Types</h1>
<div class="grid grid-cols-2 gap-4">

<?php foreach($activityTypes as $type): ?>
	<div class="p-4 bg-white dark:bg-slate-900 rounded-lg">
	<div class="mb-3">
    <div class="float-right"><?= $this->Html->link(__('Edit'), ['action' => 'edit', $type->id],['class' => 'btn btn-light mt-3']) ?></div>

		<a href="/activity-types/view/<?= $type->id ?>" class="text-2xl">
			<?= h($type->name) ?>
		</a>
	</div>
		<div class="p-3 bg-slate-200 dark:bg-slate-800 text-lg rounded-lg">
		<?= $type->description ?>
		</div>
    <a title="View this activity type"
			href="/activity-types/view/<?= $type->id ?>"  
			class="inline-block mt-2 p-3 bg-sky-700 hover:bg-sky-800 rounded-lg text-white text-xl hover:no-underline">
				View Activities
		</a>
    <!-- <div>
        RGB: <?= h($type->color) ?><br>
    </div>
    <div>
        Icon: <?= h($type->image_path) ?>
    </div> -->

	</div>
<?php endforeach ?>
</div>
</div>


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

<div class="container-fluid">
<div class="row justify-content-md-center bg-white" id="activitytypes">
<?php foreach($activityTypes as $type): ?>
<?php $count++ ?>
	<div class="col-md-6" style="background-color: rgba(<?= $type->color ?>,.2)">
	<div class="pad-md">
	<div class="pad-sm bg-white rounded-lg mb-2">
	<div class="mb-3">
    <div class="float-right"><?= $this->Html->link(__('Edit'), ['action' => 'edit', $type->id],['class' => 'btn btn-light mt-3']) ?></div>
		<a href="/activity-types/view/<?= $type->id ?>" class="activity-icon activity-icon-lg" style="background-color: rgba(<?= $type->color ?>,1)">
			<i class="activity-icon activity-icon-lg fas <?= $type->image_path ?>"></i>
		</a>
		<a href="/activity-types/view/<?= $type->id ?>" class="" style="color: #333; font-size: 230%">
			<?= h($type->name) ?>
		</a>
	</div>
		<div class="mb-3" style="font-size: 120%;">
		<?= $type->description ?>
		</div>
        <div>
        RGB: <?= h($type->color) ?><br>
        Hex: <span class="text-uppercase hexx<?= $count ?>"></span>
        <script> 
        var hoo<?= $count ?> = rgbToHex(<?= h($type->color) ?>);
        console.log(hoo<?= $count ?>);
        document.querySelector('.hexx<?= $count ?>').innerHTML = hoo<?= $count ?>;
        </script>
        
    </div>
    <div>
    <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" rel="noopener">
        FontAwesome Icon</a>: <?= h($type->image_path) ?>
    </div>

    
	</div>
	</div>
	</div>
<?php endforeach ?>
</div>
</div>


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>


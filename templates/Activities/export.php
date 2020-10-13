<?php $this->layout = 'ajax' ?>
<?xml version="1.0" encoding="UTF-8"?>
<document>
<?php foreach ($activities as $activity): ?>
<page>
	<title><?= $activity->name ?></title>
	<estimated_time><?= $activity->estimated_time ?></estimated_time>
	<description><?= $activity->description ?></description>
	<hyperlink><?= $activity->hyperlink ?></hyperlink>
</page>
<?php endforeach; ?>
</document>
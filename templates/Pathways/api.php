<?php 
$this->layout = 'ajax';
?>
<pre>
{
"version": "https://jsonfeed.org/version/1",
"title": "Learning Curator individual pathway listing all steps and contained activities.",
"home_page_url": "https://learningcentre.gww.bc.ca",
"feed_url": "https://learningcentre.gww.bc.ca",
"items": 
<?= json_encode($pathway) ?>
}
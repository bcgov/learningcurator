<?php 
$this->layout = 'ajax';
?>

{
"version": "https://jsonfeed.org/version/1",
"title": "Learning Curator topics and pathways list",
"home_page_url": "https://learningcentre.gww.bc.ca",
"feed_url": "https://learningcentre.gww.bc.ca",
"items": 
<?= json_encode($categories) ?>
}
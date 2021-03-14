<?php 
$this->layout = 'ajax';
?>
<pre>
{
"version": "https://jsonfeed.org/version/1",
"title": "Learning Curator topics and pathways list",
"home_page_url": "https://learningcentre.gww.bc.ca",
"feed_url": "https://learningcentre.gww.bc.ca",
"items": [
<?php foreach ($categories as $category): ?>
    {
		"id": "<?= h($category->id) ?>",
		"name": "<?= h($category->name) ?>",
        "description": "<?= strip_tags($category->description) ?>",
        "topics":[
        <?php foreach ($category->topics as $topic): ?>
        {
            "id": "<?= h($topic->id) ?>",
            "name": "<?= h($topic->name) ?>",
            "description": "<?= h($topic->description) ?>",
            "pathways": [
            <?php foreach ($topic->pathways as $path): ?>
            <?php if($path->status_id === 2): ?>
                {
                    "id": "<?= h($path->id) ?>",
                    "name": "<?= h($path->name) ?>",
                    "description": "<?= h($path->description) ?>"
                }
                <?php if(end($topic->pathways) !== $name) echo ',' ?>
            <?php endif ?>
            <?php endforeach; ?>
            ],
        },
        <?php endforeach; ?>
        ],
    },
<?php endforeach; ?>
]
}
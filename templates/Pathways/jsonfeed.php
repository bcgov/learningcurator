{
  "version": "https://jsonfeed.org/version/1",
  "title": "Learning Curator Pathways",
  "home_page_url": "https://learningcurator.gww.gov.bc.ca/",
  "feed_url": "https://learningcurator.gww.gov.bc.ca/pathways/jsonfeed",
  "items": [
  <?php foreach($pathways as $p): ?>
    {
      "id":"<?= $p->version ?>",
      "title":"<?= $p->name ?>",
      "summary":"",
      "content_text":"<?= $p->name ?>",
      "content_html":"<h1><?= $p->name ?></h1>",
      "_pathway_id":"<?= $p->id ?>",
      "_learning_partner":"Learning Centre",
      "author":"Allan Haggett",
      "date_published":"<?= date('r', strtotime($p->created)) ?>",
      "date_modified":"<?= date('r', strtotime($p->modified)) ?>",
      "tags":"<?= $p->topic->name ?>",
      "url":"https://learningcurator.gww.gov.bc.ca/p/<?= $p->slug ?>"
    },
  <?php endforeach ?>
  ]
}

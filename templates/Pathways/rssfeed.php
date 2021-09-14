<?php 
$this->layout = 'ajax';
?>
<?php echo '<?'; ?>xml version="1.0" encoding="utf-8"<?php echo '?>' ?>
<feed xmlns="http://www.w3.org/2005/Atom">

  <title>Learning Curator Pathways</title>
  <link href="https://learningcurator.ca/"/>
  <updated>2003-12-13T18:30:02Z</updated>
  <author>
    <name>Curator</name>
  </author>
  <id>urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6</id>
<?php foreach($pathways as $p): ?>
  <entry>
    <title><?= $p->name ?></title>
    <link href="https://learningcurator.ca/pathways/<?= $p->slug ?>"/>
    <id><?= $p->id ?></id>
    <updated><?= $p->created ?></updated>
    <summary><?= $p->description ?></summary>
  </entry>
<?php endforeach ?>
</feed>
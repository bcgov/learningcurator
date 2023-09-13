<?php echo '<?'; ?>xml version="1.0" encoding="utf-8"<?php echo '?>' ?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	
	xmlns:georss="http://www.georss.org/georss"
	xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
	>

  <channel>
	<title>Learning Curator Pathways</title>
	<link>https://learningcurator.gww.gov.bc.ca</link>
  <atom:link href="https://learningcurator.ca/pathways/rssfeed" rel="self" type="application/rss+xml" />
	<description>Curated pathways of learning.</description>
	<lastBuildDate>Sun, 10 Sep 2023 13:19:30 +0000</lastBuildDate>
	<language>en-US</language>
  <sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
  <?php foreach($pathways as $p): ?>
  <item>
    <title><?= $p->name ?></title>
    <link>https://learningcurator.ca/pathways/<?= $p->slug ?></link>
    <guid isPermaLink="false">https://learningcurator.ca/pathways/<?= $p->slug ?></guid>
    <description><![CDATA[<?= $p->description ?>]]></description>
    <dc:creator><![CDATA[Curator]]></dc:creator>
		<pubDate><?= date('r', strtotime($p->created)) ?></pubDate>
    <category><![CDATA[curator]]></category>
    <content:encoded>
    <![CDATA[
      <?= $p->description ?>
    ]]>
    </content:encoded>
  </item>

  <?php endforeach ?>
</channel>
</rss>

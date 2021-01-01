<?php
$category = strtolower($pathway->category->name);
$topic = strtolower($pathway->topics[0]->name);
// #TODO don't hardcode this path
$homefolder = '/home/curator/learning-curator/static/' . $category . '/' . $topic;
if(!is_dir($homefolder)) {
	if (!mkdir($homefolder, 0777, true)) {
		die('Failed to create folders...');
	}
}
$pathwaypath = $homefolder . '/' . $pathway->slug . '.html';
// #TODO don't hardcode this path
$pathsource = 'https://cms.learningcurator.ca/pathways/view/' . $pathway->id;
$pagehtml = file_get_contents($pathsource);
$fh=fopen($pathwaypath,'w'); 
fwrite($fh,$pagehtml);
fclose($fh);
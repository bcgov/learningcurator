<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Topic $topic
 */
//$this->loadHelper('Authentication.Identity');
//echo json_encode($topics);

echo json_encode(compact(['topics']));
?>


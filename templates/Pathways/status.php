<?php 

foreach ($percentages as &$p) {
    unset($p);
}
echo json_encode(compact(['percentages','status']));
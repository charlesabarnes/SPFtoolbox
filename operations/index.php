<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");


$object = new Ip;
$object->getDNS($_GET['domain']);

print_r($object->getOutput)
?>
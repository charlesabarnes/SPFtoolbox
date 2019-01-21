<?php

include_once('./phpwhois/whois.main.php');
include_once('./phpwhois/whois.utils.php');

$whois = new Whois();
$query = $_GET['domain'];
$result = $whois->lookup($query);
echo "[\n";
echo json_encode($result['rawdata'], JSON_PRETTY_PRINT);
echo "\n]";
?>
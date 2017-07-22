<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');

class Ipv6{
    public function getDNS($hostname){
    $response = dns_get_record ($hostname , DNS_AAAA);
        print_r(json_encode($response, JSON_PRETTY_PRINT));
    }
}
$object = new Ipv6;
$object->getDNS($_GET['domain']);


?>
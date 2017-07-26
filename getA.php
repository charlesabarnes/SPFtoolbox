<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");


class Ip{
    public function getDNS($hostname){
    $response = dns_get_record ($hostname , DNS_A);
        print_r(json_encode($response, JSON_PRETTY_PRINT));
    }
}
$object = new Ip;
$object->getDNS($_GET['domain']);


?>
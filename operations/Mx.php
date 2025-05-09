<?php
include_once('./OperationInterface.php');

class Mx implements OperationInterface{
    public function getOutput($hostname){
        $response = dns_get_record ($hostname , DNS_MX);
        return json_encode($response, JSON_PRETTY_PRINT);
    }
}
?>
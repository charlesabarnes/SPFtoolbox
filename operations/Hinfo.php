<?php
include_once('./OperationInterface.php');

class Hinfo implements OperationInterface{
    public function getOutput($hostname){
        $response = dns_get_record ($hostname , DNS_HINFO);
        return json_encode($response, JSON_PRETTY_PRINT);
    }
}
?>
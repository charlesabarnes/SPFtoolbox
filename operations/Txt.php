<?php
include_once('./OperationInterface.php');

class Txt implements OperationInterface{
    public function getOutput($hostname){
        $response = dns_get_record ($hostname , DNS_TXT);  
        return json_encode($response, JSON_PRETTY_PRINT);     
    }
}
?>
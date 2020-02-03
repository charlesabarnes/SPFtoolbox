<?php
include_once('./OperationInterface.php');

class Txt implements OperationInterface{
    public function getOutput(_dmarc.$hostname){
        $response = dns_get_record (_dmarc.$hostname , DNS_TXT);  
        return json_encode($response, JSON_PRETTY_PRINT);     
    }
}
?>
<?php
include_once('./OperationInterface.php');

class AAAA implements OperationInterface{
    public function getOutput($hostname){
        $response = dns_get_record ($hostname , DNS_AAAA);
        return json_encode($response, JSON_PRETTY_PRINT);
    }
}

?>
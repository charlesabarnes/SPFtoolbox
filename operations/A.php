<?php

include_once('./OperationInterface.php');
class A implements OperationInterface{
    public function getOutput($hostname){
        $response = dns_get_record ($hostname , DNS_A);
        return json_encode($response, JSON_PRETTY_PRINT);
    }
}

?>
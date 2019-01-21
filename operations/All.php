<?php

class All implements OperationInterface{
    public function getOutput($hostname){
        $response = dns_get_record ($hostname , DNS_ALL);
        return json_encode($response, JSON_PRETTY_PRINT);
    }
}
?>
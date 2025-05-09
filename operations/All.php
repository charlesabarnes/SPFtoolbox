<?php
include_once('./OperationInterface.php');

class All implements OperationInterface{
    public function getOutput($hostname){
        $response = @dns_get_record($hostname , DNS_ALL);
        if($response == false) {
            $response = @dns_get_record($hostname , DNS_ANY);
        }
        return json_encode($response, JSON_PRETTY_PRINT);
    }
}
?>
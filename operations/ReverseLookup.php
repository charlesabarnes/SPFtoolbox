<?php
include_once('./OperationInterface.php');

class ReverseLookup implements OperationInterface{
    public function getOutput($ip){
        if((bool)ip2long($ip)){
            $response = gethostbyaddr($ip);  
            return '[{"'.$ip.'": "'.$response.'"}]';
        } else {
            return '[{"error": "Please enter a valid IP"}]';
        }

    }
}
?>
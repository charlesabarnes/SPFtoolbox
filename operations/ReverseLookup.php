<?php
include_once('./OperationInterface.php');

class ReverseLookup implements OperationInterface{
    public function getOutput($ip){
        $response = gethostbyaddr($ip);  
        return '[{"'.$ip.'": "'.$response.'"}]';
    }
}
?>
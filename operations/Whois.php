<?php

include_once('./phpwhois/whois.main.php');
include_once('./phpwhois/whois.utils.php');
include_once('./OperationInterface.php');

class WhoisOutput implements OperationInterface{
  public function getOutput($hostname){
    $whois = new Whois();
    $query = $_GET['domain'];
    $result = $whois->lookup($query);
    $output = "[\n";
    $output .= json_encode($result['rawdata'], JSON_PRETTY_PRINT);
    $output .= "\n]";
    return $output;
  }
}
?>
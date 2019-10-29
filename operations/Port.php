<?php

include_once('./OperationInterface.php');


class Port implements OperationInterface{
  private $port;
  private $ports = [25, 53, 80 , 443, 465, 587, 993]; // Default ports
  
  function __construct($port = 80) {
    if ($port == ""){
      $this->port = $this->ports;
    } else {
      $this->port = [$port];
    }
  }
  
  function getOutput($hostname) {
    $port =  $this->port;
    $portArray = "";
    for ($i = 0; $i < count($port); $i++) {
      $fp = fsockopen($hostname, $port[$i], $errno, $errstr, 5);

      if ($fp) {
        $result = 'open';
        fclose($fp);
      } else {
        $result = 'closed';;
      }
      $portArray .= "\"$port[$i]\": \"Is $result\",\n";
    }
    $result = "[{\n";
    $result .= rtrim($portArray, ",\n");
    $result .= "\n}]";
    return $result;
  }
    
}
  
  
  ?>
  
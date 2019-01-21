<?php
include_once('./OperationInterface.php');
class Port implements OperationInterface{
  private $port = '80';

  function __construct($port) {
    $this->port = $port;
  }
  
  function getOutput($hostname) {
      $fp = fsockopen($hostname, $this->port, $errno, $errstr, 5);
      if ($fp) {
        $result = 'open';
        fclose($fp);
      } else {
        $result=$protocole.'closed';;
      }
      return '[{"Port '.$this->port.'": "Is '.$result.'"}]';
  }
}

?>

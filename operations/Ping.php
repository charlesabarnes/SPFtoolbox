<?php
include_once('./OperationInterface.php');

class Ping implements OperationInterface{
    public function getOutput($hostname){
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        exec("ping -n 4 " . $host, $output, $status);
      } else {
        exec("ping -c 4 " . $host, $output, $status);
      }
        return json_encode($output, JSON_PRETTY_PRINT);
    }
}
?>
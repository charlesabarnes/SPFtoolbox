<?php
include_once('./OperationInterface.php');

class Ping implements OperationInterface{

    public function getOutput($hostname) {
      error_log(strtoupper(substr(PHP_OS, 0, 3)));
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        exec("ping -n 4 " . $hostname, $output, $status);
      } else {
        exec("ping -c 4 " . $hostname, $output, $status);
      }
      error_log($output);
      error_log($hostname);
      return json_encode($output, JSON_PRETTY_PRINT);
    }
}
?>
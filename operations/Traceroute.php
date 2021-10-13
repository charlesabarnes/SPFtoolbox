<?php
include_once('./OperationInterface.php');

class Traceroute implements OperationInterface{

    public function getOutput($hostname) {
      return json_encode($this->getTraceroute($hostname), JSON_PRETTY_PRINT);
    }

    private function getTraceroute($host) {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec('tracert '.$host, $out, $code);
        } else {
            exec('traceroute '.$host.' 2>&1', $out, $code);
        }
        if ($code) {
            error_log(print_r($out, true));
            return [];
        }
        return $out;
    }

}
?>
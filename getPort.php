<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");        
        
class Port {
    function getPort($hostname) {
      $i = 0;
      $ports = array(22, 25, 53, 80, 443, 465, 587, 993, 5222, 5269);
        foreach ($ports as $port) {
            $fp = @fsockopen($hostname, $port, $errno, $errstr, 5);
            if (!$fp) {
                echo "Port ", $port, " is open";
            } else {
                echo "Port ", $port, " is closed";
                if ($fp)
                {
                    @fclose($x); //close connection
                }
            }
            $i++;
        }
    }
}

$object = new Port;
$object->getDNS($_GET['domain']);

echo json_encode($result['rawdata'], JSON_PRETTY_PRINT);
?>

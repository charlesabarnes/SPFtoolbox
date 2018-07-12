<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

function getPorts($hostname) {
      $ports = array(22 => "SSH", 25 => "SMTP", 53 => "DNS", 80 => "HTTP", 443 => "HTTPS", 465 => "SMTPS", 587 => "IMAP", 993 => "IMAPS", 5222 => "XMPP Jabber", 5269 => "Server Jabber");
       foreach ($ports as $port => $protocole) {
        $fp = @fsockopen($hostname, $port, $errno, $errstr, 5);
        if ($fp) {
          $result.=$protocole."\": \" Port is open\",\"";
          @fclose($fp);
        } else {
          $result.=$protocole."\": \" Port is closed\",\"";
          }
        }
        echo "[{\"";
        echo $hostname."\": \"\",\"";
        echo $result;
        echo "end of list\": \"end of list\"}]";
}

$domain=$_GET['domain'];
if(isset($domain) && $domain!=null){
   if(filter_var($domain,FILTER_VALIDATE_DOMAIN) or filter_var($domain,FILTER_VALIDATE_IP)){
        echo getPorts($domain);
   }else{
        echo "Please enter a valid domain/IP";
   }
}
?>

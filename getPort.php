<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");        
        
function getPort($hostname) {
      $i = 0;
      $ports = array(22 => "SSH", 25 => "SMTP", 53 => "DNS", 80 => "HTTP", 443 => "HTTPS", 465 => "SMTPS", 587 => "IMAP", 993 => "IMAPS", 5222 => "XMPP Jabber", 5269 => "Server to server Jabber");
       foreach ($ports as $port => $protocole) {
       $fp = @fsockopen($hostname, $port, $errno, $errstr, 5);
       if (!$fp) {
           echo $protocole, " : Port ", $port, " is closed" . "\n";
      } else {
          echo $protocole, " : Port ", $port, " is open" . "\n";
          if ($fp)
          {
              @fclose($x); //close connection
          }
      }
      $i++;
   }
}

$domain = $_GET['domain']
if(isset($_GET['domain']) && $_GET['domain']!=null){
   if(filter_var($domain,FILTER_VALIDATE_DOMAIN) or filter_var($domain,FILTER_VALIDATE_IP)){
        getPort($domain);
   }else{
        echo "Please enter a valid domain/IP";
   }
}
?>

<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

function dnsbllookup($ip){
$dnsbl_lookup=array("dnsbl-1.uceprotect.net","dnsbl-2.uceprotect.net","dnsbl-3.uceprotect.net","dnsbl.dronebl.org","dnsbl.sorbs.net","zen.spamhaus.org","bsb.spamlookup.net","spam.dnsbl.sorbs.net","virus.dnsbl.sorbs.net "); 
if($ip){
    $reverse_ip=implode(".",array_reverse(explode(".",$ip)));
    foreach($dnsbl_lookup as $host){
        if(checkdnsrr($reverse_ip.".".$host.".","A")){
            $listed.=$reverse_ip.'.'.$host."\": \"&#10006;\",\"";
        }
        else {
            $listed.=$reverse_ip.'.'.$host."\": \"&#10004;\",\"";
        }
    }
}
if($listed){
    echo "[{\"";
    echo $listed;
    echo "end of list\": \"end of list\"}]";
}
else{
    echo '"A" record was not found';
}
}
$ip=$_GET['domain'];
if(isset($_GET['domain']) && $_GET['domain']!=null){
    if((bool)ip2long($ip)){
        if(filter_var($ip,FILTER_VALIDATE_IP)){
            echo dnsbllookup($ip);
        }else{
            echo "Please enter a valid domain/IP";
        }
    }
    else{
        $ip = gethostbyname($ip);
        if(filter_var($ip,FILTER_VALIDATE_IP)){
            echo dnsbllookup($ip);
        }else{
            echo "Please enter a valid domain/IP";
        }
    }
}
?>
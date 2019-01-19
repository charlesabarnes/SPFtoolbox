<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

function dnsbllookup($ip){
$dnsbl_lookup = array("babl.rbl.webiron.net","cabl.rbl.webiron.net","stabl.rbl.webiron.net","all.rbl.webiron.net","crawler.rbl.webiron.net","truncate.gbudb.net","dnsbl.sorbs.net","safe.dnsbl.sorbs.net","http.dnsbl.sorbs.net","socks.dnsbl.sorbs.net","misc.dnsbl.sorbs.net","smtp.dnsbl.sorbs.net","web.dnsbl.sorbs.net","new.spam.dnsbl.sorbs.net","recent.spam.dnsbl.sorbs.net","old.spam.dnsbl.sorbs.net","spam.dnsbl.sorbs.net","escalations.dnsbl.sorbs.net","block.dnsbl.sorbs.net","zombie.dnsbl.sorbs.net","dul.dnsbl.sorbs.net","noservers.dnsbl.sorbs.net","rhsbl.sorbs.net","badconf.rhsbl.sorbs.net","nomail.rhsbl.sorbs.net","sbl.spamhaus.org","xbl.spamhaus.org","pbl.spamhaus.org","sbl-xbl.spamhaus.org","zen.spamhaus.org","rbl.orbitrbl.com","dnsrbl.org","db.wpbl.info","bad.psky.me","bl.spamcop.net","noptr.spamrats.com","dyna.spamrats.com","spam.spamrats.com","auth.spamrats.com","bl.spamcannibal.org","spamtrap.drbl.drand.net","hostkarma.junkemailfilter.com","blacklist.hostkarma.com","ix.dnsbl.manitu.net","dnsbl.inps.de","bl.blocklist.de","srnblack.surgate.net","all.s5h.net","rbl.megarbl.net","rbl.realtimeblacklist.com","b.barracudacentral.org","virbl.dnsbl.bit.nl"); 
if($ip){
    $reverse_ip=implode(".",array_reverse(explode(".",$ip)));
    $listed = '';
    foreach($dnsbl_lookup as $host){
        if(checkdnsrr($reverse_ip.".".$host.".","A")){
            $listed.=$host."\": \"&#10006;&#10006;&#10006;&#10006;&#10006;&#10006;&#10006;&#10006;\",\"";
        }
        else {
            $listed.=$host."\": \"&#10004;\",\"";
        }
    }
}
if($listed != ''){
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
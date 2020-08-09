<?php
include_once('./OperationInterface.php');

class Blacklist implements OperationInterface{
    const LOOKUP_HOSTS = [
        "babl.rbl.webiron.net",
        "cabl.rbl.webiron.net",
        "stabl.rbl.webiron.net",
        "all.rbl.webiron.net",
        "crawler.rbl.webiron.net",
        "truncate.gbudb.net",
        "dnsbl.sorbs.net",
        "safe.dnsbl.sorbs.net",
        "http.dnsbl.sorbs.net",
        "socks.dnsbl.sorbs.net",
        "misc.dnsbl.sorbs.net",
        "smtp.dnsbl.sorbs.net",
        "web.dnsbl.sorbs.net",
        "new.spam.dnsbl.sorbs.net",
        "recent.spam.dnsbl.sorbs.net",
        "old.spam.dnsbl.sorbs.net",
        "spam.dnsbl.sorbs.net",
        "escalations.dnsbl.sorbs.net",
        "block.dnsbl.sorbs.net",
        "zombie.dnsbl.sorbs.net",
        "dul.dnsbl.sorbs.net",
        "noservers.dnsbl.sorbs.net",
        "rhsbl.sorbs.net",
        "badconf.rhsbl.sorbs.net",
        "nomail.rhsbl.sorbs.net",
        "sbl.spamhaus.org",
        "xbl.spamhaus.org",
        "pbl.spamhaus.org",
        "sbl-xbl.spamhaus.org",
        "zen.spamhaus.org",
        "rbl.orbitrbl.com",
        "dnsrbl.org",
        "db.wpbl.info","bad.psky.me",
        "bl.spamcop.net",
        "noptr.spamrats.com",
        "dyna.spamrats.com",
        "spam.spamrats.com",
        "auth.spamrats.com",
        "spamtrap.drbl.drand.net",
        "hostkarma.junkemailfilter.com",
        "blacklist.hostkarma.com",
        "ix.dnsbl.manitu.net",
        "dnsbl.inps.de","bl.blocklist.de",
        "srnblack.surgate.net",
        "all.s5h.net",
        "rbl.realtimeblacklist.com",
        "b.barracudacentral.org",
        "virbl.dnsbl.bit.nl"
    ]; 

    const ERROR_OBJECT = '[{"error": "Please enter a valid domain/IP"}]';

    function dnsbllookup($ip){
        $data = '';
        if($ip){
            $reverse_ip=implode(".",array_reverse(explode(".",$ip)));
            $listed = '';
            foreach(self::LOOKUP_HOSTS as $host){
                if(checkdnsrr($reverse_ip.".".$host.".","A")){
                    $listed.=$host."\": \"FAIL. The domain is listed on a blacklist\",\"";
                }
                else {
                    $listed.=$host."\": \"OK\",\"";
                }
            }
        }
        if($listed != ''){
            $data .= "[{\"";
            $data .= $listed;
            $data .= "end of list\": \"end of list\"}]";
        }
        else{
            $data .= '"A" record was not found';
        }
        return $data;
        }

        
    public function getOutput($hostname){
        if(!(bool)ip2long($hostname)){
            $hostname = gethostbyname($hostname);
        } 
        if(filter_var($hostname,FILTER_VALIDATE_IP)) {
            return $this->dnsbllookup($hostname);
        } else{
            return self::ERROR_OBJECT;
        }
    }
}
?>

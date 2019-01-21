<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$domain = $_GET['domain'];
if(isset($domain) && $domain!=null){

  if(filter_var($domain,FILTER_VALIDATE_DOMAIN) or filter_var($domain,FILTER_VALIDATE_IP)){
    switch ($_GET['request']) {
      case 'a':
        include_once('./A.php');
        $object = new A;
        break;
      case 'aaaa':
        include_once('./AAAA.php');
        $object = new AAAA;
        break;
      case 'all':
        include_once('./All.php');
        $object = new All;
        break;
      case 'blacklist':
        include_once('./Blacklist.php');
        $object = new Blacklist;
        break;
      case 'port':
        include_once('./Port.php');
        $object = new Port('80');
        break;
      case 'whois':
        include_once('./AAAA.php');
        $object = new AAAA;
        break;
      case 'hinfo':
        include_once('./AAAA.php');
        $object = new AAAA;
        break;
      case 'mx':
        include_once('./AAAA.php');
        $object = new AAAA;
        break;
      case 'txt':
        include_once('./AAAA.php');
        $object = new AAAA;
        break;
      default:
        # code...
        break;
    }
    print_r($object->getOutput($domain));
  } else{
  echo '[{"error": "Please enter a valid domain/IP"}]';
  }
}
?>
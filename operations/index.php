<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$domain = $_GET['domain'];
if(isset($domain) && $domain !=null){

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
    case 'hinfo':
      include_once('./Hinfo.php');
      $object = new Hinfo;
      break;
    case 'mx':
      include_once('./Mx.php');
      $object = new Mx;
      break;
    case 'port':
      include_once('./Port.php');
      $object = new Port($_GET['port']);
      break;
    case 'reverseLookup':
      include_once('./ReverseLookup.php');
      $object = new ReverseLookup;
      break;
    case 'txt':
      include_once('./Txt.php');
      $object = new Txt;
      break;
    case 'dmarc':
      include_once('./Dmarc.php');
      $object = new Dmarc;
      break;
    case 'whois':
      include_once('./Whois.php');
      $object = new WhoisOutput;
      break;
    default:
      echo '[{"error": "Please check a valid DNS type"}]';
      break;
  }
  print_r($object->getOutput($domain));

}
?>
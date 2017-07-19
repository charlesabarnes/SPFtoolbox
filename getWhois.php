<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');

$out = str_replace('{self}', $_SERVER['PHP_SELF'], $out);

$resout = extract_block($out, 'results');

if (isSet($_GET['domain']))
	{
	$query = $_GET['domain'];

	if (!empty($_GET['output']))
		$output = $_GET['output'];
	else
		$output = '';

	include_once('phpwhois/whois.main.php');
	include_once('phpwhois/whois.utils.php');

	$whois = new Whois();

	// Set to true if you want to allow proxy requests
	$allowproxy = false;

 	// get faster but less acurate results
 	$whois->deep_whois = empty($_GET['fast']);
 	
 	// To use special whois servers (see README)
	//$whois->UseServer('uk','whois.nic.uk:1043?{hname} {ip} {query}');
	//$whois->UseServer('au','whois-check.ausregistry.net.au');

	// Comment the following line to disable support for non ICANN tld's
	$whois->non_icann = true;

	$result = $whois->Lookup($query);
	$resout = str_replace('{query}', $query, $resout);
	$winfo = '';
			if (!empty($result['rawdata']))
				{
					$myResult = json_encode($result, JSON_PRETTY_PRINT);
					echo json_encode($result, JSON_PRETTY_PRINT);
				}
			else
				{
				if (isset($whois->Query['errstr']))
					$winfo = implode($whois->Query['errstr'],"\n<br></br>");
				else
					$winfo = 'Unexpected error';
				}


	$resout = str_replace('{result}', $winfo, $resout);
	}
else
	$resout = '';

$out = str_replace('{ver}',$whois->CODE_VERSION,$out);
exit(str_replace('{results}', $resout, $out));

//-------------------------------------------------------------------------

function extract_block (&$plantilla,$mark,$retmark='')
{
$start = strpos($plantilla,'<!--'.$mark.'-->');
$final = strpos($plantilla,'<!--/'.$mark.'-->');

if ($start === false || $final === false) return;

$ini = $start+7+strlen($mark);

$ret=substr($plantilla,$ini,$final-$ini);

$final+=8+strlen($mark);

if ($retmark===false)
	$plantilla=substr($plantilla,0,$start).substr($plantilla,$final);
else	
	{
	if ($retmark=='') $retmark=$mark;
	$plantilla=substr($plantilla,0,$start).'{'.$retmark.'}'.substr($plantilla,$final);
	}
	
return $ret;
}
?>
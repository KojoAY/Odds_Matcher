<?php
require_once("./inc/config.php");
set_time_limit(0);
ignore_user_abort(true);


// function to make GET request using cURL
function curlGet($url) {
	$headers = Array(
                "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
                "Cache-Control: max-age=0",
                "Connection: keep-alive",
                "Keep-Alive: 300",
                "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
                "Accept-Language: en-us,en;q=0.5",
                "Pragma: "
            );
    $config = Array(
	            CURLOPT_SSL_VERIFYPEER => true,
	            CURLOPT_SSL_VERIFYHOST => 2,
	            CURLOPT_RETURNTRANSFER => TRUE ,
	            CURLOPT_FOLLOWLOCATION => TRUE ,
	            CURLOPT_AUTOREFERER => TRUE ,
	            CURLOPT_CONNECTTIMEOUT => 120 ,
	            CURLOPT_TIMEOUT => 120 ,
	            CURLOPT_MAXREDIRS => 10 ,
	            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8" ,
	            CURLOPT_URL => $url
	        );

    $handle = curl_init() ;
    curl_setopt_array($handle, $config) ;
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers) ;

    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);

	curl_setopt($handle, CURLOPT_CAINFO, getcwd() . '\GoDaddyRootCertificateAuthority-G2.crt');
    
    //@$output->data = curl_exec($handle);
    @$output = curl_exec($handle);

    curl_close($handle) ;
    return $output;
}

$webPageData = array();	// declaring array to store scraped book data

// function to return XPath object
function returnXPathObject($item) {
	// instantiating a new DomDocument
	$xmlPageDom = new DomDocument();	

	// load the HTML from the downloaded page
	@$xmlPageDom->loadHTML($item);	
	
	// instantiating new XPath Dom object
	$xmlPageXPath = new DOMXPath($xmlPageDom);	

	// returning XPath object
	return $xmlPageXPath;	
}


$rec_cnt = 0;

$totalData = 'https://api.matchbook.com/edge/rest/events?per-page=1&sport-ids=15';
$getTotal = curlGet($totalData);

// instantiating new XPath Dom object
$webPageXpath = returnXPathObject($getTotal);
$totalList = $webPageXpath->query("//events-response/total");

$webPageData["totalList"] = $totalList->item(0)->nodeValue;
$getTotalList = $webPageData["totalList"];


#$data = "https://api.matchbook.com/edge/rest/events?per-page=5&sport-ids=15";
$data = "https://api.matchbook.com/edge/rest/events?per-page={$getTotalList}&sport-ids=15";

$webPage = curlGet($data);
$xml = simplexml_load_string($webPage);
#print_r($xml);

$total = $xml->total;

$availableAmount = 'available-amount';

for ($i = 0; $i < $total; $i++){
	$event = $xml->events->event[$i];

	$teams = $event->name;

	$teams = explode(' vs ', $teams);
	
	$homeTeam 		= (!empty($teams[0])) ? $teams[0] : '';
	$awayTeam 		= (!empty($teams[1])) ? $teams[1] : '';
	
	
	echo $homeTeam.'<br>';
	echo $awayTeam.'<br>';

	
}



?>
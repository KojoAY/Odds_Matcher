<?php
$_CON = new PDO("mysql:host=localhost:3306;dbname=admin_odds", "oddsuser", "rVr4g0_4");
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
	
	$getNoOfPrices_home = count($event->markets->market->runners[0]->prices);
	$getNoOfPrices_away = count($event->markets->market->runners[1]->prices);
	$getNoOfPrices_draw = count($event->markets->market->runners[2]->prices);

	$teams = $event->name;
	$dateTime = $event->start;

	$t_home = ($getNoOfPrices_home/2); 
	$t_away = ($getNoOfPrices_away/2); 
	$t_draw = ($getNoOfPrices_draw/2);


	// home availables
	$homeBackAvAm = $event->markets->market->runners[0]->prices[0]->$availableAmount;
	$homeLayAvAm = $event->markets->market->runners[0]->prices[$t_home]->$availableAmount;
	// home odds
	$homeBackOdds = $event->markets->market->runners[0]->prices[0]->odds;
	$homeLayOdds = $event->markets->market->runners[0]->prices[$t_home]->odds;


	// away availables
	$awayBackAvAm = $event->markets->market->runners[1]->prices[0]->$availableAmount;
	$awayLayAvAm = $event->markets->market->runners[1]->prices[$t_away]->$availableAmount;
	// away odds
	$awayBackOdds = $event->markets->market->runners[1]->prices[0]->odds;
	$awayLayOdds = $event->markets->market->runners[1]->prices[$t_away]->odds;


	// draw availables
	$drawBackAvAm = $event->markets->market->runners[2]->prices[0]->$availableAmount;
	$drawLayAvAm = $event->markets->market->runners[2]->prices[$t_draw]->$availableAmount;
	// draw odds
	$drawBackOdds = $event->markets->market->runners[2]->prices[0]->odds;
	$drawLayOdds = $event->markets->market->runners[2]->prices[$t_draw]->odds;
	

	// competition
	$metaTags = 'meta-tags';
	$metaTag = 'meta-tag';
	$sportType = $event->$metaTags->$metaTag[0]->name;
	$country = $event->$metaTags->$metaTag[1]->name;
	$competition = $event->$metaTags->$metaTag[2]->name;


	$teams = explode(' vs ', $teams);
	
	
	$sportsType 	= 1;
	$dateTime 		= strtotime($dateTime);
	$competition 	= $competition;
	$homeTeam 		= (!empty($teams[0])) ? $teams[0] : '';
	$awayTeam 		= (!empty($teams[1])) ? $teams[1] : '';
	
	
	$homeLayOdds = (!empty($homeLayOdds)) ? $homeLayOdds : 0; 
	$awayLayOdds = (!empty($awayLayOdds)) ? $awayLayOdds : 0; 
	$drawLayOdds = (!empty($drawLayOdds)) ? $drawLayOdds : 0; 
	$homeLayAvAm = (!empty($homeLayAvAm)) ? $homeLayAvAm : 0;  
	$awayLayAvAm = (!empty($awayLayAvAm)) ? $awayLayAvAm : 0; 
	$drawLayAvAm = (!empty($drawLayAvAm)) ? $drawLayAvAm : 0; 
	

	if (isset($homeLayOdds)) {
		$outcome_team	= $homeTeam;
		$outcome_layOdd	= $homeLayOdds;
		$outcome_avAm	= $homeLayAvAm;
		$unique_code 	= md5('1');

		saveData($unique_code, $sportsType, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $homeLayOdds, $awayLayOdds, $drawLayOdds, $outcome_layOdd, $homeLayAvAm, $awayLayAvAm, $drawLayAvAm, $outcome_avAm, $_CON);
		
	} 

	if (isset($drawLayOdds)) {
		$outcome_team	= 'Draw';
		$outcome_layOdd	= $drawLayOdds;
		$outcome_avAm	= $drawLayAvAm;
		$unique_code 	= md5('X');
		
		saveData($unique_code, $sportsType, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $homeLayOdds, $awayLayOdds, $drawLayOdds, $outcome_layOdd, $homeLayAvAm, $awayLayAvAm, $drawLayAvAm, $outcome_avAm, $_CON);
	} 

	if (isset($awayLayOdds)) {
		$outcome_team	= $awayTeam;
		$outcome_layOdd	= $awayLayOdds;
		$outcome_avAm	= $awayLayAvAm;
		$unique_code 	= md5('2');
		
		saveData($unique_code, $sportsType, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $homeLayOdds, $awayLayOdds, $drawLayOdds, $outcome_layOdd, $homeLayAvAm, $awayLayAvAm, $drawLayAvAm, $outcome_avAm, $_CON);
	}
}

function saveData($unique_code, $sportsType, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $homeLayOdds, $awayLayOdds, $drawLayOdds, $outcome_layOdd, $homeLayAvAm, $awayLayAvAm, $drawLayAvAm, $outcome_avAm, $_CON){

	$SQL_INSERT = "INSERT INTO `exchange_odds` SET
			`ex_unique_code`		= '$unique_code',
			`ex_exchange_id`		= '1',
			`ex_sports_type_id`		= '$sportsType',
			`ex_date_time`			= '$dateTime',
			`ex_competition`		= '$competition',
			`ex_home_team`			= '$homeTeam',
			`ex_away_team`			= '$awayTeam',
			`ex_outcome_team`		= '$outcome_team',
			`ex_home_layodds`		= '$homeLayOdds',
			`ex_away_layodds`		= '$awayLayOdds',
			`ex_draw_layodds`		= '$drawLayOdds',
			`ex_outcome_layodds`	= '$outcome_layOdd',
			`ex_home_available`		= '$homeLayAvAm',
			`ex_away_available`		= '$awayLayAvAm',
			`ex_draw_available`		= '$drawLayAvAm',
			`ex_outcome_available`	= '$outcome_avAm'";
	$_CON->query($SQL_INSERT);

}

?>
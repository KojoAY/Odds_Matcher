<?php
#require_once("../../inc/config.php");
$_CON = new PDO("mysql:host=localhost:3306;dbname=admin_odds", "oddsuser", "rVr4g0_4");
set_time_limit(0);
ignore_user_abort(true);

function multiRequest($data) {
	
	// array of curl handles
	$curly = array();
	// data to be returned
	$result = array();

	// multi handle
	$mh = curl_multi_init();
	
	// loop through $data and create curl handles
	// then add them to the multi-handle
	foreach ($data as $id => $d) {
		$headers = Array(
                "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
                "Cache-Control: max-age=0",
                "Connection: keep-alive",
                "Keep-Alive: 300",
                "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
                "Accept-Language: en-us,en;q=0.5",
                "Pragma: "
            );
    	$options = Array();
		
		
		$curly[$id] = curl_init();
		
		$url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
		curl_setopt($curly[$id], CURLOPT_URL,            $url);
		curl_setopt($curly[$id], CURLOPT_HEADER,         0);
		curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
		
		curl_setopt($curly[$id], CURLOPT_HTTPHEADER, $headers) ;
		
		#curl_setopt($curly[$id], CURLOPT_SSL_VERIFYHOST, 0);
		#curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curly[$id], CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curly[$id], CURLOPT_CAINFO, getcwd() . '\COMODORSACertificationAuthority.crt');

        curl_setopt($curly[$id], CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curly[$id], CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curly[$id], CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curly[$id], CURLOPT_TIMEOUT, 120);
        curl_setopt($curly[$id], CURLOPT_MAXREDIRS, 10);
        curl_setopt($curly[$id], CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");


		#curl_setopt_array($curly[$id], $options);
		
		// post?
		if (is_array($d)) {
			if (!empty($d['post'])) {
				curl_setopt($curly[$id], CURLOPT_POST,       1);
				curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
			}
		}
		
		// extra options?
		//if (!empty($options)) {
			#curl_setopt_array($curly[$id], $options);
		//}
		
		curl_multi_add_handle($mh, $curly[$id]);
	}
 
	// execute the handles
	$running = null;
	do {
		curl_multi_exec($mh, $running);
	} while($running > 0);
	
	
	// get content and remove handles
	foreach($curly as $id => $c) {
		$result[$id] = curl_multi_getcontent($c);
		curl_multi_remove_handle($mh, $c);
	}
	
	// all done
	curl_multi_close($mh);
	
	return $result;
}



$webPageData = array();	// declaring array to store scraped book data

// function to return XPath object
function returnXPathObject($webPage) {
	// instantiating a new DomDocument
	$xmlPageDom = new DomDocument();	

	// load the HTML from the downloaded page
	@$xmlPageDom->loadHTML($webPage);	
	
	// instantiating new XPath Dom object
	$xmlPageXPath = new DOMXPath($xmlPageDom);	

	// returning XPath object
	return $xmlPageXPath;	
}



/**/
$data = array(
			// Champions League
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2152950&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",

			// Europa League
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2152996&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",

			// Bundesliga, Germany
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2152330&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2152324&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",

			// Premier League, England
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2152196&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",

			// Serie A, Italy
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2153452&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",

			// La Liga, Spain
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2154128&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6",

			// Ligue 1, France
			"https://ws.mybet.com/sportsbook/v1/api/getCompetitionEvents?competitionId=2152298&marketTypes=MRES%2COVUN%2CEHCP&includeOutrights=true&maxResults=9&channelId=6"
			
		);


$webPages = multiRequest($data);

foreach($webPages as $obj){
	
	// instantiating new XPath Dom object
	#$webPageXpath = returnXPathObject($webPage);	

	$webPage = json_decode($obj);

	for($i = 0; $i < 9; $i++){

		@$Odds1 = $webPage->Competition->event[$i]->markets[0]->selection[0]->odds->dec;
		@$Odds2 = $webPage->Competition->event[$i]->markets[0]->selection[1]->odds->dec;
		@$Odds3 = $webPage->Competition->event[$i]->markets[0]->selection[2]->odds->dec;

		@$type1 = $webPage->Competition->event[$i]->markets[0]->selection[0]->type;
		@$type2 = $webPage->Competition->event[$i]->markets[0]->selection[1]->type;
		@$type3 = $webPage->Competition->event[$i]->markets[0]->selection[2]->type;
		
		@$team1 = $webPage->Competition->event[$i]->markets[0]->selection[0]->names->longName;
		@$team2 = $webPage->Competition->event[$i]->markets[0]->selection[1]->names->longName;
		@$team3 = $webPage->Competition->event[$i]->markets[0]->selection[2]->names->longName;

		@$competition = $webPage->Competition->event[$i]->compNames->longName;
		@$dateTime = $webPage->Competition->event[$i]->eventTime/1000;


		if(@$type1 == "1"){
			@$homeOdds = $Odds1;
			@$homeTeam = $team1;
		} elseif(@$type2 == "1"){
			@$homeOdds = $Odds2;
			@$homeTeam = $team2;
		} elseif(@$type3 == "1"){
			@$homeOdds = $Odds3;
			@$homeTeam = $team3;
		}

		if(@$type1 == "2"){
			@$awayOdds = $Odds1;
			@$awayTeam = $team1;
		} elseif(@$type2 == "2"){
			@$awayOdds = $Odds2;
			@$awayTeam = $team2;
		} elseif(@$type3 == "2"){
			@$awayOdds = $Odds3;
			@$awayTeam = $team3;
		}

		if(@$type1 == "X"){
			@$drawOdds = $Odds1;
			@$drawTeam = $team1;
		} elseif(@$type2 == "X"){
			@$drawOdds = $Odds2;
			@$drawTeam = $team2;
		} elseif(@$type3 == "X"){
			@$drawOdds = $Odds3;
			@$drawTeam = $team3;
		}


		if (isset($homeOdds)) {
			$outcome_team = $homeTeam;
			$outcome_backOdd = $homeOdds;
			$unique_code = md5('1');

			saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON);
		}

		if (isset($drawOdds)) {
			$outcome_team = 'Draw';
			$outcome_backOdd = $drawOdds;
			$unique_code = md5('X');

			saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON);
		} 

		if (isset($awayOdds)) {
			$outcome_team = $awayTeam;
			$outcome_backOdd = $awayOdds;
			$unique_code = md5('2');

			saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON);
		} 
	}
}


function saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON){
$SQL_INSERT = "INSERT INTO `bookie_odds` SET
			`bk_unique_code`		= '$unique_code',
			`bk_bookie_id`			= '9',
			`bk_sports_type_id`		= '1',
			`bk_date_time`			= '$dateTime',
			`bk_competition`		= '$competition',
			`bk_home_team`			= '$homeTeam',
			`bk_away_team`			= '$awayTeam',
			`bk_outcome_team`		= '$outcome_team',
			`bk_outcome_backodds`	= '$outcome_backOdd',
			`bk_home_backodds`		= '$homeOdds',
			`bk_away_backodds`		= '$awayOdds',
			`bk_draw_backodds`		= '$drawOdds'";
	$_CON->query($SQL_INSERT);
}
?>




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

		curl_setopt($curly[$id], CURLOPT_CAINFO, getcwd() . '\GeoTrustPrimaryCertificationAuthority.crt');

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


$rec_cnt = 0;

/**/

$data = array(
		// Premier League, England
		#"",

		// Bungesliga, Germany
		"https://www.xtip.de/de/bets/bets.html?group=399017&sportid=1&filter="

		// La Liga, Spain
		#"",

		// Serie A, Italy
		#"",

		// Ligue 1, France
		#"",

		// Champions League
		#"",

		// Europa League
		#""
	);

$webPages = multiRequest($data);


foreach($webPages as $webPage){
	
	// instantiating new XPath Dom object
	$webPageXpath = returnXPathObject($webPage);
	//echo  $webPage;	

	$countData = $webPageXpath->query('//div[@class="live_row"]/div[@class="live_row_container clearfix"]');	

	// If eventDate date exists
	if ($countData->length > 0) {
		for ($i=0; $i < $countData->length; $i++) { 
			
			$homeOdds = $webPageXpath->query('//div[@class="live_td live_odds_container"]/div[@data-test-id="mc-oddbutton-'.$i.'_odd1"]');	
			// If eventDate date exists
			if ($homeOdds->length > 0) {
				// Add eventDate date to array
				echo $webPageData['$homeOdds'] = $homeOdds->item($i)->nodeValue; 
			}

			$drawOdds = $webPageXpath->query('//div[@class="live_td live_odds_container"]/div[@data-test-id="mc-oddbutton-'.$i.'_oddx"]');	
			// If eventDate date exists
			if ($drawOdds->length > 0) {
				// Add eventDate date to array
				echo $webPageData['$drawOdds'] = $drawOdds->item($i)->nodeValue; 
			}

			$awayOdds = $webPageXpath->query('//div[@class="live_td live_odds_container"]/div[@data-test-id="mc-oddbutton-'.$i.'_odd2"]');	
			// If eventDate date exists
			if ($awayOdds->length > 0) {
				// Add eventDate date to array
				echo $webPageData['$awayOdds'] = $awayOdds->item($i)->nodeValue; 
			}
			
			
/*

			echo '<br>';
			echo $webPageData['$homeOdds'];
			echo $webPageData['$drawOdds'];
			echo $webPageData['$awayOdds'];
			echo '<p>';


			
			$teamNames = $webPageData['name'];
			$homeAwayTeams = explode('-', $teamNames);
			
			# home team
			$homeTeam = trim($homeAwayTeams[0]);
			# away team
			$awayTeam = trim($homeAwayTeams[1]);
			
			
			$gameDesc = explode(' - ', $webPageData['desc']);
			
			# date and time
			$dateTime = strtotime($webPageData['date']);
			
			
			# assigning unique code
			//$unique_code_source = $homeTeam.$awayTeam.date('d-m-Y   H:i', $dateTime);
			//$unique_code = md5($unique_code_source);
			
			# sports types array
			$sportsTypeArray = array(
									"Football"=>"1", 
									"Fußball"=>"1",
									"Tennis"=>"2", 
									"Basketball"=>"3", 
									"Amarican Football"=>"4", 
									"Horse Racing"=>"5", 
									"Boxing"=>"6", 
									"Ice Hockey"=>"7"
								);
								
			# sports type assignment
			$sportsType = $sportsTypeArray[trim($gameDesc[0])];
			# the competition type
			$competition = trim($gameDesc[1]) . ' - ' . trim($gameDesc[2]);
			
								
			#echo '<br>';
			$backOdds = trim($webPageData['odds']);
			$backOdds = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $backOdds);
			$backOdds = explode(' ', $backOdds);
			# home odds
			$homeOdds = $backOdds[0];
			# draw odds
			$drawOdds = $backOdds[1];
			# away odds
			$awayOdds = $backOdds[2];
			
			
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
			
			
			
			
			/*

			echo $unique_code;
			echo '<br><b>Sports Type: </b>' . $sportsType;
			echo '<br><b>Date/Time: </b>' . $dateTime;
			echo '<br><b>Competition: </b>' . $competition;
			echo '<br><b>Home Team: </b>' . $homeTeam;
			echo '<br><b>Away Team: </b>' . $awayTeam;
			echo '<br><b>Outcome Team: </b>' . $outcome_team;
			echo '<br><b>Outcome Odds: </b>' . $outcome_backOdd;
			echo '<br><b>Home Odds: </b>' . $homeOdds;
			echo '<br><b>Draw Odds: </b>' . $drawOdds;
			echo '<br><b>Away Odds: </b>' . $awayOdds;
			echo '<p>=======</p>';
			
			
			#   /httpdocs/bookies/tipico/index.php
			#   /usr/local/bin/php /httpdocs/bookies/tipico/index.php > /dev/null 2>&1
			#   /var/www/vhosts/h2718034.stratoserver.net/httpdocs/bookies/tipico/index.php
			*/
			
		}
	}
}


function saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON){
	$SQL_INSERT = "INSERT INTO `bookie_odds` SET
			`bk_unique_code`		= '$unique_code',
			`bk_bookie_id`			= '1',
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

/*
	echo $unique_code;
			echo '<br><b>Sports Type: </b>' . $sportsType;
			echo '<br><b>Date/Time: </b>' . $dateTime;
			echo '<br><b>Competition: </b>' . $competition;
			echo '<br><b>Home Team: </b>' . $homeTeam;
			echo '<br><b>Away Team: </b>' . $awayTeam;
			echo '<br><b>Outcome Team: </b>' . $outcome_team;
			echo '<br><b>Outcome Odds: </b>' . $outcome_backOdd;
			echo '<br><b>Home Odds: </b>' . $homeOdds;
			echo '<br><b>Draw Odds: </b>' . $drawOdds;
			echo '<br><b>Away Odds: </b>' . $awayOdds;
			echo '<p>=======</p>';*/
}
?>




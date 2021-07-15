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


$rec_cnt = 0;

/**/
$data = array(
			// Champions League
			"https://www.bet3000.com/de/events/2008-uefa-champions-league",

			// Europa League
			"https://www.bet3000.com/de/events/4058-uefa-europa-league",


			// Bundesliga, Germany
			"https://www.bet3000.com/de/events/1876-1-bundesliga",

			// La Liga, Spain
			"https://www.bet3000.com/de/events/1945-la-liga",

			// Serie A
			"https://www.bet3000.com/de/events/1946-serie-a",

			// Premier League, England
			"https://www.bet3000.com/de/events/1948-premier-league",

			// Ligue 1, France
			"https://www.bet3000.com/de/events/1957-ligue-1"
		);


$webPages = multiRequest($data);

foreach($webPages as $webPage){
	$cnt = 0;
	// instantiating new XPath Dom object
	$webPageXpath = returnXPathObject($webPage);	

	$getGameDesc = $webPageXpath->query('//h3[@class="breadcrumbs-holder"]');


	if ($getGameDesc->length > 0) {
		$webPageData['getGameDesc'] = $getGameDesc->item(0)->nodeValue;
	}

	$teamsData = trim($webPageData['getGameDesc']);
	$teamsData = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' | ', $teamsData);
	$teamsData = explode(' | ', $teamsData);

	$gameDesc = $teamsData[1];
	//$gameDesc .= (!empty($teamsData[2])) ? ' - ' . $teamsData[2] : '';



	$dateTime = $webPageXpath->query('//div[@class="expires"]/span[@class="time"]/@content');


	if ($dateTime->length > 0) {
		for ($i=0; $i < $dateTime->length; $i++) { 

			// Add eventDate date to array
			$webPageData['dateTime'] = strtotime($dateTime->item($i)->nodeValue);
			#echo "<br>";
			

			$homeTeam = $webPageXpath->query('//div[@class="team-home"]/span[@itemprop="name"]');
			if ($homeTeam->length > 0){
				$webPageData['homeTeam'] = $homeTeam->item($i)->nodeValue;
			}

			$awayTeam = $webPageXpath->query('//div[@class="team-away"]/span[@itemprop="name"]');
			if ($awayTeam->length > 0){
				$webPageData['awayTeam'] = $awayTeam->item($i)->nodeValue;
			}

			$odds = $webPageXpath->query('//div[@class="predictions"]/button[@class="prediction triple"]/span[@class="odds"]');
			if ($odds->length > 0){
				$webPageData['homeOdds'] = $odds->item($cnt)->nodeValue;
				$webPageData['drawOdds'] = $odds->item($cnt+1)->nodeValue;
				$webPageData['awayOdds'] = $odds->item($cnt+2)->nodeValue;
			}

			$cnt+=3;



			# home team
			$homeTeam = trim($webPageData['homeTeam']);
			# away team
			$awayTeam = trim($webPageData['awayTeam']);
			
			
			
			# date and time
			/*$dateTime = $webPageData['dateTime'];
			*/
			
			# assigning unique code
			$unique_code_source = $homeTeam.$awayTeam.date('d-m-Y   H:i', $webPageData['dateTime']);
			$unique_code = md5($unique_code_source);
			
			# sports types array
			$sportsTypeArray = array(
									"Football"=>"1", 
									"Tennis"=>"2", 
									"Basketball"=>"3", 
									"Amarican Football"=>"4", 
									"Horse Racing"=>"5", 
									"Boxing"=>"6", 
									"Ice Hockey"=>"7"
								);
								
			# sports type assignment
			$sportsType = 1;
			# the competition type
			$competition = trim($gameDesc);
			
			
			# home odds
			@$homeOdds = $webPageData['homeOdds'];
			# draw odds
			@$drawOdds = $webPageData['drawOdds'];
			# away odds
			@$awayOdds = $webPageData['awayOdds'];
			
			if (isset($homeOdds)) {
				$outcome_team = $homeTeam;
				$outcome_backOdd = $homeOdds;
				$unique_code = md5('1');

				saveData($unique_code, $webPageData['dateTime'], $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON);
			}

			if (isset($drawOdds)) {
				$outcome_team = 'Draw';
				$outcome_backOdd = $drawOdds;
				$unique_code = md5('X');

				saveData($unique_code, $webPageData['dateTime'], $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON);
			} 

			if (isset($awayOdds)) {
				$outcome_team = $awayTeam;
				$outcome_backOdd = $awayOdds;
				$unique_code = md5('2');

				saveData($unique_code, $webPageData['dateTime'], $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON);
			} 
			
			/*
			echo $unique_code;
			echo '<br>' . $sportsType;
			echo '<br>' . $webPageData['dateTime'];
			echo '<br>' . $competition;
			echo '<br>' . $homeTeam;
			echo '<br>' . $awayTeam;
			echo '<br>' . $outcome_team;
			echo '<br>' . $outcome_backOdd;
			echo '<br>' . $homeOdds;
			echo '<br>' . $awayOdds;
			echo '<br>' . $drawOdds;
			echo '<p>=======</p>';
			*/
			
		}
	}
	#sleep(2);
}


function saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON){
	$SQL_INSERT = "INSERT INTO `bookie_odds` SET
			`bk_unique_code`		= '$unique_code',
			`bk_bookie_id`			= '7',
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




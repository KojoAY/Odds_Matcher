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

		curl_setopt($curly[$id], CURLOPT_CAINFO, getcwd() . '\thawtePrimaryRootCA.crt');

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
			"https://sports.bwin.com/de/sports/4/13914/wetten/champions-league-gruppe-a",
			"https://sports.bwin.com/de/sports/4/13915/wetten/champions-league-gruppe-b",
			"https://sports.bwin.com/de/sports/4/13916/wetten/champions-league-gruppe-c",
			"https://sports.bwin.com/de/sports/4/13917/wetten/champions-league-gruppe-d",
			"https://sports.bwin.com/de/sports/4/13918/wetten/champions-league-gruppe-e",
			"https://sports.bwin.com/de/sports/4/13922/wetten/champions-league-gruppe-f",
			"https://sports.bwin.com/de/sports/4/13920/wetten/champions-league-gruppe-g",
			"https://sports.bwin.com/de/sports/4/13921/wetten/champions-league-gruppe-h",

			// Europa League
			"https://sports.bwin.com/de/sports/4/18254/wetten/uefa-europa-league-gruppe-a",
			"https://sports.bwin.com/de/sports/4/18256/wetten/uefa-europa-league-gruppe-b",
			"https://sports.bwin.com/de/sports/4/18258/wetten/uefa-europa-league-gruppe-c",
			"https://sports.bwin.com/de/sports/4/18260/wetten/uefa-europa-league-gruppe-d",
			"https://sports.bwin.com/de/sports/4/18262/wetten/uefa-europa-league-gruppe-e",
			"https://sports.bwin.com/de/sports/4/18264/wetten/uefa-europa-league-gruppe-f",
			"https://sports.bwin.com/de/sports/4/18266/wetten/uefa-europa-league-gruppe-g",
			"https://sports.bwin.com/de/sports/4/18268/wetten/uefa-europa-league-gruppe-h",
			"https://sports.bwin.com/de/sports/4/18723/wetten/uefa-europa-league-gruppe-i",
			"https://sports.bwin.com/de/sports/4/18724/wetten/uefa-europa-league-gruppe-j",
			"https://sports.bwin.com/de/sports/4/18725/wetten/uefa-europa-league-gruppe-k",
			"https://sports.bwin.com/de/sports/4/18726/wetten/uefa-europa-league-gruppe-l",

			// Bundesliga, Germany
			"https://sports.bwin.com/de/sports/4/43/wetten/bundesliga",
			"https://sports.bwin.com/de/sports/4/79/wetten/2-bundesliga",

			// Premier League, England
			"https://sports.bwin.com/de/sports/4/46/wetten/premier-league",

			// La Liga, Spain
			"https://sports.bwin.com/de/sports/4/16108/wetten/laliga",

			// Serie A, Italy
			"https://sports.bwin.com/de/sports/4/42/wetten/serie-a",

			// Ligue 1, France
			"https://sports.bwin.com/de/sports/4/4131/wetten/ligue-1"
			
		);


$webPages = multiRequest($data);


foreach($webPages as $webPage){
	
	// instantiating new XPath Dom object
	$webPageXpath = returnXPathObject($webPage);

	
	$gameDesc = $webPageXpath->query('//li[@itemprop="itemListElement"]/a[@class="last-breadcrumbs-item"]/span');
	if($gameDesc->length > 0){
		$webPageData['gameDesc'] = $gameDesc->item(0)->nodeValue;
	}
		
	$eventDate = $webPageXpath->query('//div[@class="marketboard-event-group__item--sub-group"]/h2[@class="marketboard-event-group__header marketboard-event-group__header--level-3"]/span[@class="marketboard-event-group__header-content marketboard-event-group__header-content--level-3"]');	
	// If event description exists
	if ($eventDate->length > 0) {
		for($d = 0; $d < $eventDate->length; $d++){
			// Add event description to array
			$webPageData['eventDate'] = $eventDate->item($d)->nodeValue; 
		}
	}


	$eventTime = $webPageXpath->query('//div[@class="marketboard-event-group__item--sub-group"]/div[@class="marketboard-event-group__item-container marketboard-event-group__item-container--level-3"]/div[@class="marketboard-event-group__item--event"]/div[@class="marketboard-event-without-header"]/div/div[@class="marketboard-event-without-header__market-time"]');
	
	for($i = 0; $i < $eventTime->length; $i++){
		
		$dayOff = explode(' - ', $webPageData['eventDate']);
		$getDate = explode('.', $dayOff[1]);
		$dateRearranged = trim($getDate[2]) . '-' . trim($getDate[1]) . '-' . trim($getDate[0]);
		#$getDate = implode('/', $getDate);

		if ($eventTime->length > 0) {
			// Add event description to array
			$webPageData['eventTime'] = $eventTime->item($i)->nodeValue;
		}


		$getTeamData = $webPageXpath->query('//div[@class="marketboard-event-group__item--sub-group"]/div[@class="marketboard-event-group__item-container marketboard-event-group__item-container--level-3"]/div[@class="marketboard-event-group__item--event"]/div[@class="marketboard-event-without-header"]/div/div[@class="marketboard-event-without-header__markets-container"]/table[@class="marketboard-event-without-header__markets-list"]');
		
		if ($getTeamData->length > 0) {
			// Add event description to array
			$webPageData['getTeamData'] = $getTeamData->item($i)->nodeValue;
		}


		$teamsData = trim($webPageData['getTeamData']);
		$teamsData = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' | ', $teamsData);
		$teamsData = explode(' | ', $teamsData);
/*
		echo '<strong>Home Team: </strong>' . $teamsData[0] . '<br>';
		echo '<strong>Home Odds: </strong>' . $teamsData[1] . '<br>';
		echo '<strong>Draw Odds: </strong>' . $teamsData[3] . '<br>';
		echo '<strong>Away Team: </strong>' . $teamsData[4] . '<br>';
		echo '<strong>Away Odds: </strong>' . $teamsData[5] . '<br>';

		echo '<strong>Desc: </strong>' . $webPageData['gameDesc'];


		echo '<p>';
*/
				
		# home team
		$homeTeam = trim($teamsData[0]);
		# away team
		$awayTeam = trim($teamsData[4]);
		
		
		# date and time
		$getDateTime = $dateRearranged . 'T' . $webPageData['eventTime'] . '+02:00';
		$dateTime = strtotime($getDateTime);
		
		
		# assigning unique code
		$unique_code_source = $homeTeam.$awayTeam.date('d-m-Y   H:i', $dateTime);
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
							
		# sports type assignment  2017-11-21T17:00+02:00
		#$sportsType = $sportsTypeArray[trim($gameDesc[1])];
		# the competition type
		$competition = $webPageData['gameDesc'];
		
		

		# home odds
		$homeOdds = $teamsData[1];
		# away odds
		$drawOdds = $teamsData[3];
		# draw odds
		$awayOdds = $teamsData[5];
		

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
		#echo '<br>' . $sportsType;
		echo '<br>' . $dateTime;
		echo '<br>' . $competition;
		echo '<br>' . $homeTeam;
		echo '<br>' . $awayTeam;
		echo '<br>' . $outcome_team;
		echo '<br>' . $outcome_backOdd;
		echo '<br>' . $homeOdds;
		echo '<br>' . $awayOdds;
		echo '<br>' . $drawOdds;
		echo '<p>=======</p>';
		
		
		
		$SQL_INSERT = "INSERT INTO `bookie_odds` SET
					`bk_unique_code`		= '$unique_code',
					`bk_bookie_id`			= '12',
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
		if ($_CON->query($SQL_INSERT)) {
			echo 'Success!';
		}*/
	}
}


function saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON){
	$SQL_INSERT = "INSERT INTO `bookie_odds` SET
			`bk_unique_code`		= '$unique_code',
			`bk_bookie_id`			= '12',
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




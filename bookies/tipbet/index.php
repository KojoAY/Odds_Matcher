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

		curl_setopt($curly[$id], CURLOPT_CAINFO, getcwd() . '\GeoTrustGlobalCA.crt');

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
			// Bundesliga, Germany
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/deutschland/bundesliga/t42",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/deutschland/2-bundesliga/t41",

			// Premier League, England
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/england/premier-league/t1",

			// La Liga, Spain
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/spanien/laliga/t36",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/spanien/laliga-2/t37",

			// Serie A
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/italien/serie-a/t33",

			// Ligue 1, France
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/frankreich/ligue-1/t4",

			// Champions League
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-a/t1462",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-b/t1463",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-c/t1464",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-d/t1465",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-e/t1466",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-f/t1467",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-g/t1468",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-champions-league-gruppe-h/t1469",

			// Europa League
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-a/t10908",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-b/t10911",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-c/t10912",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-d/t10913",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-e/t10914",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-f/t10915",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-g/t10916",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-h/t10917",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-i/t10918",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-j/t10919",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-k/t10920",
			"https://tipbet.com/de/online-sportwetten/sportarten/fussball/internationalbrclubs/uefa-europa-league-gruppe-l/t10921"
		);


$webPages = multiRequest($data);

foreach($webPages as $webPage){
	$cnt = 0;
	// instantiating new XPath Dom object
	$webPageXpath = returnXPathObject($webPage);
	
	$tr_mainline = $webPageXpath->query('//tr[@class="main-line"]');	

	// If eventDate date exists
	if ($tr_mainline->length > 0) {
		for ($i=0; $i < $tr_mainline->length; $i++) { 
			
			$awayTeam = $webPageXpath->query('//span[@itemprop="awayTeam"]/meta[@itemprop="name"]/@content');
			if($awayTeam->length > 0){
				$webPageData['awayTeam'] = $awayTeam->item($i)->nodeValue;
			}
			
			
			$homeTeam = $webPageXpath->query('//span[@itemprop="homeTeam"]/meta[@itemprop="name"]/@content');
			if($homeTeam->length > 0){
				$webPageData['homeTeam'] = $homeTeam->item($i)->nodeValue;
			}
			
			
			$comp = $webPageXpath->query('//meta[@itemprop="description"]/@content');
			if($comp->length > 0){
				$webPageData['comp'] = $comp->item($i)->nodeValue;
			}
			
			
			$dateTime = $webPageXpath->query('//meta[@itemprop="startDate"]/@content');
			if($dateTime->length > 0){
				$webPageData['dateTime'] = $dateTime->item($i)->nodeValue;
			}
			
			
			$odds = $webPageXpath->query('//span[@data-oty="10"]');
			if($odds->length > 0){
				$webPageData['homeOdds'] = $odds->item($cnt)->nodeValue;
				$webPageData['drawOdds'] = $odds->item($cnt+1)->nodeValue;
				$webPageData['awayOdds'] = $odds->item($cnt+2)->nodeValue;
			}
			$cnt += 3;
			
			# home team
			$homeTeam = trim($webPageData['homeTeam']);
			# away team
			$awayTeam = trim($webPageData['awayTeam']);
			
			
			#$gameDesc = explode(' - ', $webPageData['desc']);
			
			# date and time
			$dateTime = strtotime($webPageData['dateTime']);
			
			
			
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
			#$sportsType = $sportsTypeArray[trim($gameDesc[0])];
			# the competition type
			$gameDesc = explode(" - ", trim($webPageData['comp']));
			$competition = $gameDesc[2] . ' - ' . $gameDesc[3];
			
			
			# home odds
			$homeOdds = explode(',', $webPageData['homeOdds']);
			$homeOdds = implode('.', $homeOdds);
			# draw odds
			$drawOdds = explode(',', $webPageData['drawOdds']);
			$drawOdds = implode('.', $drawOdds);
			# away odds
			$awayOdds = explode(',', $webPageData['awayOdds']);
			$awayOdds = implode('.', $awayOdds);
			

			$homeOdds = (!empty($homeOdds)) ? $homeOdds : 0; 
			$awayOdds = (!empty($awayOdds)) ? $awayOdds : 0; 
			$drawOdds = (!empty($drawOdds)) ? $drawOdds : 0; 
			

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
			#echo '<br>**' . $sportsType;
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
			*/
			
			
		} 
	}
}


function saveData($unique_code, $dateTime, $competition, $homeTeam, $awayTeam, $outcome_team, $outcome_backOdd, $homeOdds, $awayOdds, $drawOdds, $_CON){
	$SQL_INSERT = "INSERT INTO `bookie_odds` SET
			`bk_unique_code`		= '$unique_code',
			`bk_bookie_id`			= '21',
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
	if($_CON->query($SQL_INSERT)){
		echo 'ok';
	}
}
?>




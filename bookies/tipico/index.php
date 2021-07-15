<?php
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
		
        curl_setopt($curly[$id], CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curly[$id], CURLOPT_CAINFO, getcwd() . '\VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt');

        curl_setopt($curly[$id], CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curly[$id], CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curly[$id], CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curly[$id], CURLOPT_TIMEOUT, 120);
        curl_setopt($curly[$id], CURLOPT_MAXREDIRS, 10);
        curl_setopt($curly[$id], CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8");

		
		// post?
		if (is_array($d)) {
			if (!empty($d['post'])) {
				curl_setopt($curly[$id], CURLOPT_POST,       1);
				curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
			}
		}
		
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


$data = array(
		// Premier League, England
		"https://www.tipico.com/de/online-sportwetten/fussball/england/premier-league/g1301/",

		// Bungesliga, Germany
		"https://www.tipico.com/de/online-sportwetten/fussball/deutschland/1-bundesliga/g42301/",
		"https://www.tipico.com/de/online-sportwetten/fussball/deutschland/2-bundesliga/g41301/",

		// La Liga, Spain
		"https://www.tipico.com/de/online-sportwetten/fussball/spanien/la-liga/g36301/",
		"https://www.tipico.com/de/online-sportwetten/fussball/spanien/la-liga-2/g37301/",

		// Serie A, Italy
		"https://www.tipico.com/de/online-sportwetten/fussball/italien/serie-a/g33301/",

		// Ligue 1, France
		"https://www.tipico.com/de/online-sportwetten/fussball/frankreich/ligue-1/g4301/",

		// Champions League
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-a/g681110/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-b/g681210/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-c/g681310/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-d/g681410/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-e/g681510/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-f/g681610/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-g/g681710/",
		"https://www.tipico.com/de/online-sportwetten/fussball/champions-league/gruppe-h/g681810/",

		// Europa League
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-a/g681910/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-b/g682010/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-c/g682110/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-d/g682210/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-e/g682310/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-f/g682410/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-g/g682510/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-h/g682610/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-i/g682710/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-j/g682810/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-k/g682910/",
		"https://www.tipico.com/de/online-sportwetten/fussball/europa-league/gruppe-l/g683010/"
	);

$webPages = multiRequest($data);

foreach($webPages as $webPage){
	
	// instantiating new XPath Dom object
	$webPageXpath = returnXPathObject($webPage);	

	$name = $webPageXpath->query('//div[@itemscope=""]/meta[@itemprop="name"]/@content');	

	// If eventDate date exists
	if ($name->length > 0) {
		for ($i=0; $i < $name->length; $i++) { 
			// Add eventDate date to array
			$webPageData['name'] = $name->item($i)->nodeValue; 
			
			
			$desc = $webPageXpath->query('//div[@itemscope=""]/meta[@itemprop="description"]/@content');	
			// If eventDate date exists
			if ($desc->length > 0) {
				// Add eventDate date to array
				$webPageData['desc'] = $desc->item($i)->nodeValue; 
			}
			
			
			$date = $webPageXpath->query('//div[@itemscope=""]/meta[@itemprop="startDate"]/@content');	
			// If eventDate date exists
			if ($date->length > 0) {
				// Add eventDate date to array
				$webPageData['date'] = $date->item($i)->nodeValue; 
			}
			
			
			
			$odds = $webPageXpath->query('//div[@class="bl br left cf"]');	
			// If eventDate date exists
			if ($odds->length > 0) {
				$exp_odds = explode(',', $odds->item($i)->nodeValue);
				$exp_odds = implode('.', $exp_odds);
				$webPageData['odds'] = ' ' . $exp_odds; 
			}
			
			
			$teamNames = $webPageData['name'];
			$homeAwayTeams = explode('-', $teamNames);
			
			# home team
			$homeTeam = trim($homeAwayTeams[0]);
			# away team
			$awayTeam = trim($homeAwayTeams[1]);
			
			
			$gameDesc = explode(' - ', $webPageData['desc']);
			
			# date and time
			$dateTime = strtotime($webPageData['date']);
			
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
}
?>




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
			// Champions League
			"https://www.bigbetworld.com/en/sportsbook#sport=66&country=I16&league=37948"

			// Europa League
			#"",

			// Bundesliga, Germany
			#"",

			// Premier League, England
			#"",

			// Serie A, Italy
			#"",

			// La Liga, Spain
			

			// Ligue 1, France
			#""
			
		);


$webPages = multiRequest($data);

foreach($webPages as $webPage){
	
	// instantiating new XPath Dom object
		$webPageXpath = returnXPathObject($webPage);	

		$obj = json_decode($webPage);
		print_r($obj);
		
		//echo $webPage;

		/*
		$desc = $webPageXpath->query('//head/title/@content');	
		// If event description exists
		if ($desc->length > 0) {
			// Add event description to array
			$webPageData['desc'] = $desc->item(0)->nodeValue; 
		}
		

		$name = $webPageXpath->query('//tr[@itemscope=""]/meta[@itemprop="name"]/@content');	

		// If eventDate date exists
		if ($name->length > 0) {
			for ($i=0; $i < $name->length; $i++) { 
				// Add eventDate date to array
				echo $webPageData['name'] = $name->item($i)->nodeValue; 
				
				
				$date = $webPageXpath->query('//tr[@itemscope=""]/meta[@itemprop="startDate"]/@content');	
				// If eventDate date exists
				if ($date->length > 0) {
					// Add eventDate date to array
					$webPageData['date'] = $date->item($i)->nodeValue; 
				}
				
				
				
				$homeOdds = $webPageXpath->query('//td[@class="bets"]/table/tbody/tr/td/p[@itemprop="homeTeam"]/strong');	
				// If eventDate date exists
				if ($homeOdds->length > 0) {
					$webPageData['homeOdds'] = $homeOdds->item($i)->nodeValue;
				}

				$awayOdds = $webPageXpath->query('//td[@class="bets"]/table/tbody/tr/td/p[@itemprop="awayTeam"]/strong');	
				// If eventDate date exists
				if ($awayOdds->length > 0) {
					$webPageData['awayOdds'] = $awayOdds->item($i)->nodeValue;
				}

				$drawOdds = $webPageXpath->query('//td[@class="bets"]/table/tbody/tr/td/p/strong');	
				// If eventDate date exists
				if ($drawOdds->length > 0) {
					$webPageData['drawOdds'] = $drawOdds->item($i)->nodeValue;
				}
				
				
				$teamNames = $webPageData['name'];
				$homeAwayTeams = explode(' - ', $teamNames);
				
				# home team
				$homeTeam = trim($homeAwayTeams[0]);
				# away team
				$awayTeam = trim($homeAwayTeams[1]);
				
				
				$gameDesc = explode(' - ', $webPageData['desc']);
				
				# date and time
				$dateTime = strtotime($webPageData['date']);
				
				
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
									
				# sports type assignment
				$sportsType = $sportsTypeArray[trim($gameDesc[1])];
				# the competition type
				$competition = trim($gameDesc[0]);
				
									
				echo '<br>';

				# home odds
				$homeOdds = $webPageData['homeOdds'];
				# away odds
				$drawOdds = $webPageData['awayOdds'];
				# draw odds
				$awayOdds = $webPageData['drawOdds'];
				
				
				if (max(@$backOdds[0], @$backOdds[1], @$backOdds[2]) == @$homeOdds) {
					$outcome_team = $homeTeam;
					@$outcome_backOdd = $backOdds[0];
				} elseif (@max(@$backOdds[0], @$backOdds[1], @$backOdds[2]) == $drawOdds) {
					$outcome_team = 'Draw';
					@$outcome_backOdd = $backOdds[1];
				} elseif (@max(@$backOdds[0], @$backOdds[1], @$backOdds[2]) == $awayOdds) {
					$outcome_team = $awayTeam;
					@$outcome_backOdd = $backOdds[2];
				}
				
				
				
				
				
				echo $unique_code;
							echo '<br>' . $sportsType;
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
				
				
				/*
				$SQL_INSERT = "INSERT INTO `bookie_odds` SET
							`unique_code`		= '$unique_code',
							`bookie_id`			= '1',
							`sports_type_id`	= '$sportsType',
							`datetime`			= '$dateTime',
							`competition`		= '$competition',
							`home_team`			= '$homeTeam',
							`away_team`			= '$awayTeam',
							`outcome_team`		= '$outcome_team',
							`outcome_backodds`	= '$outcome_backOdd',
							`home_backodds`		= '$homeOdds',
							`away_backodds`		= '$awayOdds',
							`draw_backodds`		= '$drawOdds'";
				if ($_CON->query($SQL_INSERT)) {
					echo 'Success!';
				}
			}
		}*/
	
}

?>




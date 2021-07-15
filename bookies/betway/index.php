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
			"https://sports.betway.com/de/sports/grp/soccer/germany/bundesliga"

			// Europa League
			#"",

			// Bundesliga, Germany
			#"",

			// Premier League, England
			#"",

			// Serie A, Italy
			#"",

			// La Liga, Spain
			#"",

			// Ligue 1, France
			#""
			
		);


$webPages = multiRequest($data);

foreach($webPages as $webPage){
	
	// instantiating new XPath Dom object
	$webPageXpath = returnXPathObject($webPage);	
	echo $webPage;
	/*
				
				
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




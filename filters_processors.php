<?php
    session_start();
    require_once("./inc/config.php");
    set_time_limit(0);
    ignore_user_abort(true);
    
    $bookie_arr = array(
            "", 
            "<a href=\"https://www.tipico.com/\" target=\"_blank\"><img src=\"images/Tipico_Logo.png\" alt=\"Tipico\" height=\"20\"></a>"
        );

    $now_date = strtotime('now');
    $past_time = ($now_date-(5*60));

    
        
    
    $_SESSION['SET_FILTERS'] = "";


    // collect data for the sports types
    if(!empty($_POST['SPORTS'])){
        $CNT_LOOP = 0;

        $_SESSION['SET_FILTERS'] .=  " AND (";
        foreach ($_POST['SPORTS'] as $sports_types => $sports) {
            if ($CNT_LOOP > 0){
                $_SESSION['SET_FILTERS'] .= " OR b.bk_sports_type_id =  '$sports'";
            } else {
                $_SESSION['SET_FILTERS'] .= "b.bk_sports_type_id =  '$sports'";
            } $CNT_LOOP++;
        }
        $_SESSION['SET_FILTERS'] .= ")";
    }
    

    // collect data for the bookies
    if(!empty($_POST['BOOKIES'])){
        $CNT_LOOP = 0;

        $_SESSION['SET_FILTERS'] .= " AND (";
        foreach ($_POST['BOOKIES'] as $bookies => $bookie) {
            if ($CNT_LOOP > 0){
                $_SESSION['SET_FILTERS'] .= " OR b.bk_bookie_id =  '$bookie'";
            } else {
                $_SESSION['SET_FILTERS'] .= "b.bk_bookie_id =  '$bookie'";
            } $CNT_LOOP++;
        }
        $_SESSION['SET_FILTERS'] .= ")";
    }


    // collect data for the bookies
    /*$_POST['EXCHANGE'][] = '1';
    if(!empty($_POST['EXCHANGE'])){
        $CNT_LOOP = 0;

        $_SESSION['SET_FILTERS'] .= " AND (";
        foreach ($_POST['EXCHANGE'] as $exchanges => $exchg) {
            if ($CNT_LOOP > 0){
                $_SESSION['SET_FILTERS'] .= "b.bk_exchange_id =  '$exchg'";
            } else {
                $_SESSION['SET_FILTERS'] .= "e.ex_exchange_id =  '$exchg'";
            } $CNT_LOOP++;
        }
        $_SESSION['SET_FILTERS'] .= "))";
    }


    // collect data for the rates
    if(!empty($_POST['RATE'])){
        $CNT_LOOP = 0;

        $_SESSION['SET_FILTERS'] .= " AND (";
        foreach ($_POST['RATE'] as $rates_data => $rate) {
            if ($CNT_LOOP > 0){
                $_SESSION['SET_FILTERS'] .= " AND (b.bk_outcome_backodds*100)/e.ex_outcome_layodds <=  '$rate'";
            } else {
                $_SESSION['SET_FILTERS'] .= "(b.bk_outcome_backodds*100)/e.ex_outcome_layodds >=  '$rate'";
            } $CNT_LOOP++;
        }
        $_SESSION['SET_FILTERS'] .= "))";
    }*/


    // collect data for the odds
    if(!empty($_POST['MIN_ODDS']) || $_POST['MAX_ODDS'] != ''){
        
        $MIN_ODDS = $_POST['MIN_ODDS'];
        $MAX_ODDS = $_POST['MAX_ODDS'];

        $_SESSION['SET_FILTERS'] .= " AND (b.bk_outcome_backodds >= '$MIN_ODDS' AND b.bk_outcome_backodds <= '$MAX_ODDS')";
    }
    



    $SQLEX = "SELECT b.*, e.* 
        FROM exchange_odds AS e
        INNER JOIN dict_filter AS d ON d.matchbook_list = e.ex_home_team
        INNER JOIN bookie_odds AS b ON b.bk_home_team LIKE CONCAT('%',d.bookie_list,'%') 
        AND b.bk_date_time = e.ex_date_time 
        AND b.bk_date_time > $now_date 
        WHERE (b.bk_add_timestamp >= NOW() - INTERVAL 5 MINUTE AND e.ex_add_timestamp >= NOW() - INTERVAL 5 MINUTE) " . $SET_FILTERS . "
        GROUP BY b.bk_home_team, b.bk_away_team ORDER BY b.bk_id ASC LIMIT 50";

    $RESEX = $_CON->query($SQLEX);
    while($ROWEX = $RESEX->fetch(PDO::FETCH_ASSOC)){
        echo '<ul>
            <li id="tb-competition">
                <strong>' . $ROWEX['bk_home_team'] . ' vs ' . $ROWEX['bk_away_team'] . '</strong>
                Soccer > ' . $ROWEX['bk_competition'] . '
            </li>
            <li id="tb-datetime">
                ' . @date("d/m | H:i", $ROWEX['bk_date_time']+(60*60)) . '
            </li>
            <li id="tb-outcome">
                ' . $ROWEX['bk_outcome_team'] . '
            </li>
            <li id="tb-bookie">
                ' . $bookie_arr[$ROWEX['bk_bookie_id']] . '
            </li>
            <li id="tb-back">';
                echo (!empty($ROWEX['bk_outcome_backodds'])) ? @number_format($ROWEX['bk_outcome_backodds'], 2) : '0.00';
            echo '
            </li>
            <li id="tb-exchange">
                <a href="https://www.matchbook.com/" target="_blank"><img src="images/logo-mobile.png" alt="Matchbook" height="10"></a>
            </li>
            <li id="tb-lay">';
            
                if($ROWEX['bk_outcome_team'] == $ROWEX['bk_home_team']){
                    echo $layOdds = number_format(@$ROWEX['ex_home_layodds'], 2);
                    $avail = number_format(@$ROWEX['ex_home_available'], 2);
                }
                elseif($ROWEX['bk_outcome_team'] == $ROWEX['bk_away_team']){
                    echo $layOdds = number_format(@$ROWEX['ex_away_layodds'], 2);
                    $avail = number_format(@$ROWEX['ex_away_available'], 2);
                }
                elseif($ROWEX['bk_outcome_team'] == 'Draw'){
                    echo $layOdds = number_format(@$ROWEX['ex_draw_layodds'], 2);
                    $avail = number_format(@$ROWEX['ex_draw_available'], 2);
                }
                else{
                    echo '-';
                }
                
                echo '
                <span>&euro;' . $avail . '</span>
            </li>
            <li id="tb-rating">';
                $rating = (@$ROWEX['bk_outcome_backodds']*100)/@$layOdds;
                echo number_format($rating, 2);
        echo '
            </li>
            <li id="tb-calc">
                <a class="fa fa-calculator"></a>
            </li>
        </ul>';
    }
?>
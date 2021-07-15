<?php

    /*
    $f = fopen('lock', 'w') or die ('Cannot create lock file');
    if (flock($f, LOCK_EX | LOCK_NB)) {
        // yay
    }
    */

    session_start();
    require_once("./inc/config.php");
    set_time_limit(0);
    ignore_user_abort(true);
    


    $now_date = strtotime('now');
    $past_time = ($now_date-(5*60));


    
    // how many rows to show per page
    $rowsPerPage = 20;
    
    // by default we show first page
    $pageNum = 1;
    
    // if $_REQUEST['page'] defined, use it as page number
    if(isset($_SESSION['offest']))
    {
        $pageNum = $_SESSION['offest'];
    }
    
    // counting the offset
    @$offset = ($pageNum - 1) * $rowsPerPage;
    
    

   

if(!empty($_POST['SPORTS']) || !empty($_POST['BOOKIES'])){

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


    // collect data for the rates
    if(!empty($_POST['MIN_RATE']) && !empty($_POST['MAX_RATE'])){
        $MIN_RATE = $_POST['MIN_RATE'];
        $MAX_RATE = $_POST['MAX_RATE'];
        
        $_SESSION['SET_FILTERS'] .= " AND ((b.bk_outcome_backodds*100)/e.ex_outcome_layodds >=  '$MIN_RATE' AND (b.bk_outcome_backodds*100)/e.ex_outcome_layodds <=  '$MAX_RATE')";
    }


    // collect data for the odds
    if(!empty($_POST['MIN_ODDS']) && $_POST['MAX_ODDS'] != ''){
        
        $MIN_ODDS = $_POST['MIN_ODDS'];
        $MAX_ODDS = $_POST['MAX_ODDS'];

        $_SESSION['SET_FILTERS'] .= " AND (b.bk_outcome_backodds >= '$MIN_ODDS' AND b.bk_outcome_backodds <= '$MAX_ODDS')";
    }
    
}
    $SET_FILTERS = @$_SESSION['SET_FILTERS'];


    // how many rows we have in database
    $SQL_REC_COUNT = "SELECT COUNT(b.bk_id) AS bk_id, COUNT(e.ex_id) AS ex_id 
                    FROM exchange_odds AS e
                    INNER JOIN dict_filter AS d ON d.matchbook_list = e.ex_home_team
                    INNER JOIN bookie_odds AS b ON b.bk_home_team LIKE CONCAT('%',d.bookie_list,'%') 
                    
                    AND b.bk_date_time > $now_date AND b.bk_unique_code = e.ex_unique_code
                    WHERE (b.bk_add_timestamp >= NOW() - INTERVAL 5 MINUTE AND e.ex_add_timestamp >= NOW() - INTERVAL 5 MINUTE) " . $SET_FILTERS . "";


                    #AND (b.bk_date_time = e.ex_date_time OR b.bk_date_time = DATE(DATE_ADD(e.ex_date_time, INTERVAL 1 DAY)))


    $RES_REC_COUNT      = $_CON->query($SQL_REC_COUNT);
    $ROW_REC_COUNT      = $RES_REC_COUNT->fetch(PDO::FETCH_ASSOC);
    $TOTAL_REC_COUNT    = number_format(($ROW_REC_COUNT['bk_id']/2), 0);
    

    // how many pages we have when using paging?
    $maxPage = ceil($TOTAL_REC_COUNT/$rowsPerPage);
    
    
    $nav  = '';
    
    for($page = 1; $page <= $maxPage; $page++)
    {
       if ($page == $pageNum)
       {
          $nav .= "  [<strong>$page</strong>] "; // no need to create a link to current page
       }
       else
       {
          @$nav .= " <a href=\"?res=$page\">$page</a> ";
       } 
    }

    if ($pageNum > 1)
    {
       $page  = $pageNum - 1;
       $prev  = "<a href=\"?res=$page\" id=\"prev-1\" class=\"fa fa-chevron-left\"></a> ";
    } 
    else
    {
       $prev  = '<i id="prev-0" class=\"fa fa-chevron-right\"></i>'; // we're on page one, don't print previous link
    }
    
    if ($pageNum < $maxPage)
    {
       $page = $pageNum + 1;
       @$next = " <a href=\"?res=$page\" id=\"next-1\" class=\"fa fa-chevron-right\"></a>";
    } 
    else
    {
       $next = '<i id="next-0" class=\"fa fa-chevron-right\"></i>'; // we're on the last page, don't print next link
    }
    

    $SQL_GETBOOKIES = "SELECT * FROM bookies WHERE active_stat = '1'";
    $RES_GETBOOKIES = $_CON->query($SQL_GETBOOKIES);
    while($ROW_RETBOOKIES = $RES_GETBOOKIES->fetch(PDO::FETCH_ASSOC)){
        $id = $ROW_RETBOOKIES['id'];
        $bookie_arr[$id] = "<a href=\"{$ROW_RETBOOKIES['b_url']}\" target=\"_blank\"><img src=\"{$ROW_RETBOOKIES['b_image']}\" alt=\"{$ROW_RETBOOKIES['b_name']}\" height=\"\"></a>";
    }

    

    $SQLEX = "SELECT b.*, e.* 
        FROM exchange_odds AS e
        INNER JOIN dict_filter AS d ON d.matchbook_list = e.ex_home_team
        INNER JOIN bookie_odds AS b ON b.bk_home_team LIKE CONCAT('%',d.bookie_list,'%') 
        
        AND b.bk_date_time > $now_date AND b.bk_unique_code = e.ex_unique_code
        WHERE (b.bk_add_timestamp >= NOW() - INTERVAL 5 MINUTE AND e.ex_add_timestamp >= NOW() - INTERVAL 5 MINUTE) " . $SET_FILTERS . "
        GROUP BY b.bk_outcome_backodds, e.ex_outcome_layodds ORDER BY b.bk_home_team ASC LIMIT $offset, $rowsPerPage";
        

    $RESEX = $_CON->query($SQLEX);
    while($ROWEX = $RESEX->fetch(PDO::FETCH_ASSOC)){
        $bookie_id = $ROWEX['bk_bookie_id'];
        
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
                ' . $bookie_arr[$bookie_id] . '
            </li>
            <li id="tb-back">';
                echo (!empty($ROWEX['bk_outcome_backodds'])) ? @number_format($ROWEX['bk_outcome_backodds'], 2) : '0.00';
                echo '<!--a>1 <span>X</span> 2</a>';

                echo '
                <nav>
                    <strong>' . $ROWEX['bk_home_team'] . ' vs ' . $ROWEX['bk_away_team'] . '</strong>
                    <span>Soccer > ' . $ROWEX['bk_competition'] . '</span>
                    <article>
                        <div><span>1</span>' . number_format($ROWEX['bk_home_backodds'], 2) . '</div>
                        <div id="mid"><span>X</span>' . number_format($ROWEX['bk_draw_backodds'], 2) . '</div>
                        <div><span>2</span>' . number_format($ROWEX['bk_away_backodds'], 2) . '</div>
                    </article>
                </nav-->
            
            </li>
            <li id="tb-exchange">
                <a href="https://www.matchbook.com/" target="_blank"><img src="images/matchbook-logo.png" alt="Matchbook" height=""></a>
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
                <span>&euro;' . $avail . '</span>';

                echo '<!--a>1 <span>X</span> 2</a>';

                echo '
                <nav>
                    <strong>' . $ROWEX['bk_home_team'] . ' vs ' . $ROWEX['bk_away_team'] . '</strong>
                    <span>Soccer > ' . $ROWEX['bk_competition'] . '</span>
                    <article>
                        <div><span>1</span>' . number_format($ROWEX['ex_home_layodds'], 2) . '</div>
                        <div id="mid"><span>X</span>' . number_format($ROWEX['ex_draw_layodds'], 2) . '</div>
                        <div><span>2</span>' . number_format($ROWEX['ex_away_layodds'], 2) . '</div>
                    </article>
                </nav-->

            </li>
            <li id="tb-rating">';
                $rating = (@$ROWEX['bk_outcome_backodds']*100)/@$layOdds;
                echo ($rating <= 100) ? number_format($rating, 2) : '<span style="color:#f00;">' . number_format($rating, 2) . '</span>';
        echo '
            </li>
            <li id="tb-calc">
                <a class="fa fa-calculator"></a>
            </li>
        </ul>';  

    }

        echo '<div id="pg-nav">';
            
            $PG_COUNT = ($TOTAL_REC_COUNT == 0) ? '' : '<span id="pofp">Page ' . $pageNum . ' of ' . $maxPage . ' Pages</span>';
            echo '<div id="pg-results"><strong>' . $TOTAL_REC_COUNT . '</strong> Results </div>';
            echo '<div>' . $prev . ' ' . $PG_COUNT . ' ' . $next . '</div>';
        
        echo '</div>';

    ?>
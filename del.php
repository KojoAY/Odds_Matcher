<?php
#require_once("./inc/config.php");
$_CON = new PDO("mysql:host=localhost:3306;dbname=admin_odds", "oddsuser", "rVr4g0_4");

set_time_limit(0);
ignore_user_abort(true);

$SQLDELEX = "DELETE FROM exchange_odds WHERE ex_add_timestamp < NOW() - INTERVAL 10 MINUTE";
$_CON->query($SQLDELEX);

$SQLDELBK = "DELETE FROM bookie_odds WHERE bk_add_timestamp < NOW() - INTERVAL 10 MINUTE";
$_CON->query($SQLDELBK);
?>
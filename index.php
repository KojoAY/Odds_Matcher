<?php 
session_start();
//include("inc/config.php"); 
?>
<!DOCTYPE html>
<html>
<head>
<title>Oddsmatcher</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="css/form-style.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/genScript.js"></script>
<script type="text/javascript" src="js/get_list.js"></script>
</head>
<body>
<section class="main-container">
    <article class="topbtn">
        <a id="openFilters"><i class="fa fa-filter"></i> Filters</a>
    </article>
    
	<header class="list-caption">
    	
    	<ul>
        	<li id="tb-competition">
            	Competition <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-datetime">
            	Date/Time <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-outcome">
            	Outcome <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-bookie">
            	Bookie <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-back">
            	Back <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-exchange">
            	Exchange <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-lay">
            	Lay <a class="fa fa-exchange fa-rotate-90"></a>
            </li>
            <li id="tb-rating">
            	Rating <a class="fa fa-sort-amount-desc"></a>
            </li>
            <li id="tb-calc">
            	
            </li>
    	</ul>
    </header>

    <?php $_SESSION['offest'] = @$_GET['res']; ?>

    <section class="event-list-rows">
    	<?php include('list_event.php'); ?>
    </section>
</section>

<section id="bookieResponseArea"></section>
<section id="ExResponseArea"></section>

<?php
include('filters_form.php');
?>

</body>
</html>
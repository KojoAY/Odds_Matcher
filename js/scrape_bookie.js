// JavaScript Document

$(document).ready(function(){ 

    var auto= $('#bookieResponseArea'), refreshed_content;	
		refreshed_content = setInterval(function(){
		auto.load("bookies/tipico/soccer.php").fadeIn("slow");}, 
		60000); 										
		console.log(refreshed_content);										 
		return false; 
});
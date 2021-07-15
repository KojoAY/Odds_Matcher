// JavaScript Document

$(document).ready(function(){ 

    var auto= $('#ExResponseArea'), refreshed_content;	
		refreshed_content = setInterval(function(){
		auto.load("exchange/matchbook/index.php").fadeIn("slow");}, 
		60000); 										
		console.log(refreshed_content);										 
		return false; 
});
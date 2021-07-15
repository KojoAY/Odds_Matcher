// JavaScript Document

$(document).ready(function(){ 

    var auto= $('.event-list-rows'), refreshed_content;	
	refreshed_content = setInterval(function(){
		auto.load("list_event.php").fadeIn("slow");
	}, 5000); 										
	console.log(refreshed_content);										 
	return false; 
	
	
	
	/*
	$('#applyFilters').submit(function(e) {
        //e.preventDefault();
		//$('.event-list-rows').html();
		var form_data = $(this).serialize();
		$.ajax({
			url: "list_event.php",
			type: "post",
			data: "form_data",
			success: function (data){
				$('.event-list-rows').html(data);
			}
		});
		return false;
    });*/
});
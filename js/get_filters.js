// JavaScript Document

$(document).ready(function(e) {
    $('.oddsFilter').submit(function(e) {
        e.preventDefault();
		$('.event-list-rows').html('');
		var form_data = $(this).serialize();
		$.ajax({
			url: "filters_processors.php",
			type: "post",
			data: form_data,
			success: function (data){
				$('.event-list-rows').html(data);
			}
		});
		return false;
    });
});
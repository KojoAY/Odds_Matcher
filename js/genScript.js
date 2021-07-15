// JavaScript Document

$(document).ready(function() {
	$('#openFilters').click(function(e) {
        $('.oddsFilter-darkHover').css({'display':'block'});
    	$('.oddsFilter-container').css({'display':'block', 'position':'relative'});
    });
	
	$('a.fa-times').click(function(e) {
        $('.oddsFilter-darkHover').css({'display':'none'});
        $('.oddsFilter-container').css({'display':'none', 'position':'absolute'});
    });

});
$(document).ready(function($) {

	$('.simple-ajax-popup-align-top').magnificPopup({
		type: 'ajax',
		alignTop: true,
		overflowY: 'scroll' 
	});

	$('.simple-ajax-popup').magnificPopup({
		type: 'ajax'
	});
	
});
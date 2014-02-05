// Make the ribbon stick to the bottom of the responsive admin-bar
jQuery( document ).ready( function( $ ) {

	 function ribbonPosition(){
	 	var adminBarHeight = $('#wpadminbar').height() ;
	 	$('#rad-corner-ribbon').css({
	 		'top': adminBarHeight + 'px'
	 	}); 	

	 }
	 ribbonPosition();
	 $( window ).resize(function(){
	 	ribbonPosition();
	 });
});
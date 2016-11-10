// bb-build-bracket.js
// JavaScript for the edit tournament screen (mstw-bb-bracket-builder-class.php)
//

jQuery(document).ready( function( $ ) {
	// alert( "Doc is ready" );
	//
	// when the tourney control is changed, update the current_tourney (WP option) 
	//

	$( '#bb-current-tourney' ).change( function( event ) {
		//alert( 'bb-build-bracket.js tourney changed ... id= ' + event.target.id );
		//alert( 'tourney: ' + this.value );
		
		var data = {
			  'action'        : 'bracket_builder', //same for all
			  'real_action'   : 'change_tournament',
			  'page'          : 'edit_tournaments',
			  'tournament'    : event.target.value
			  };
			  
		jQuery.post( ajaxurl, data, function( response ) {
			//alert( 'Got this from the server: ' + response );
			var object = jQuery.parseJSON( response );
			
			if ( '' != object.error ) {
				alert( object.error );
			}
			else {
				//alert( "tournament updated" );
			}
			
		});
	
	});

	
	//$( '.game-date' ).focus( function( event ) {
		//alert( "focus to cell= " + event.target.id );
		//currentDateCell = event.target.id;
	//});
	
	//
	// Set up the date and time pickers
	//
	$('.game-date').datepicker({
		dateFormat : 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: false,
		showNowButton: false
	});
	
	$('.game-time').timepicker({
		'timeFormat': 'H:i',
		'step'      : '5',
		//hourText: 'Hour',
		//minuteText: 'Minute',
		amPmText: ['am', 'pm'],
		//showPeriodLabels: true,
		//timeSeparator: ':',
		showPeriod: true,
		showLeadingZero: true,
		//nowButtonText: 'Maintenant',
		//showNowButton: true,
		//closeButtonText: 'Done',
		//showCloseButton: true,
		//deselectButtonText: 'Désélectionner',
		//showDeselectButton: true
	});
	
});
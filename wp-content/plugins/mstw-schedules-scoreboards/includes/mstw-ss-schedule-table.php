<?php
 /*---------------------------------------------------------------------------
 *	mstw-ss-schedule-table.php
 *	Contains the code for the MSTW Schedules & Scoreboards schedule table
 *		shortcode [mstw_ss_table]
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2014-15 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.

 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program. If not, see <http://www.gnu.org/licenses/>.
 *-------------------------------------------------------------------------*/

//---------------------------------------------------------------------------
// Add the shortcode handler, which will create the Game Schedule table on the 
// user side. Handles the shortcode parameters, if there were any, then calls 
// mstw_ss_build_schedule_table( ) to create the output
// 

add_shortcode( 'mstw_schedule_table', 'mstw_ss_schedule_table_shortcode_handler' );

function mstw_ss_schedule_table_shortcode_handler( $atts ){
	//mstw_log_msg( 'in mstw_ss_schedule_table_shortcode_handler( ) ...' );
	//mstw_log_msg( $atts );
	
	// the team comes from the shortcode args, and must be provided
	if ( !is_array( $atts ) or !array_key_exists( 'sched', $atts ) ) {
		return '<h3>' . __( 'No schedule specified in shortcode.', 'mstw-schedules-scoreboards' ) . '</h3>';
	}
	
	// get the options set in the admin settings screen
	$base_options = get_option( 'mstw_ss_options' );
	$dtg_options = get_option( 'mstw_ss_dtg_options' );
	
	$options = array_merge( (array)$base_options, (array)$dtg_options );
	
	// and merge them with the defaults
	$defaults = array_merge( mstw_ss_get_defaults( ), mstw_ss_get_dtg_defaults( ) );
	$args = wp_parse_args( $options, $defaults );
		
	// then merge the parameters passed to the shortcode with the result									
	$attribs = shortcode_atts( $args, $atts );
	
	return mstw_ss_build_schedule_table( $attribs );
	
} //End: mstw_ss_schedule_table_shortcode_handler( )

//--------------------------------------------------------------------------------------
// MSTW_SS_BUILD_SCHEDULE_TABLE
// 	Called by mstw_ss_schedule_table_shortcode_handler( )
// 	Builds the schedule table as a string (to replace the [shortcode] in a page or post.
// ARGUMENTS:
// 	$atts - the display settings and shortcode arguments, properly combined by
//	mstw_ss_schedule_table_shortcode_handler()
// RETURNS
//	HTML for schedule table as a string
//
function mstw_ss_build_schedule_table( $atts ) {
	//mstw_log_msg( " In mstw_ss_build_schedule_table ... " );
	//mstw_log_msg( $atts );

	$output = ''; //This is the return string
	
	$sched_slugs = explode( ',', $atts['sched'] );
	
	if ( !empty( $sched_slugs[0] ) ) {
		//CSS tag will be the FIRST schedule slug specified
		$css_tag = '_' . $sched_slugs[0];
	}
	else {
		//Have to have at least one schedule slug
		return '<h3>' . __( 'No schedule specified.', 'mstw-schedules-scoreboards' ) . '</h3>';
	}
	
	//This changes if and only if last_dtg == now
	$sort_order = 'ASC';
	
	//full date format 
	$dtg_format = ( $atts['table_date_format'] == 'custom' ? $atts['custom_table_date_format'] : $atts['table_date_format'] ); 
	
	//time format
	$time_format = ( $atts['table_time_format'] == 'custom' ? $atts['custom_table_time_format'] : $atts['table_time_format'] );
	
	//mstw_log_msg( '$dtg_format = ' . $dtg_format );
	//mstw_log_msg( '$time_format = ' . $time_format );
	
	// Need to set $first_dtg and $last_dtg by converting strings
	// OR convert $first_dtg='now' to current php DTG stamp
	if ( $atts['first_dtg'] == 'now' ) {
		$first_dtg = current_time( 'timestamp' );
	}
	else { 
		$first_dtg = strtotime( $atts['first_dtg'] );
	}		
	$first_dtg = ( $first_dtg <= 0 ? 1 : $first_dtg );
	
	if ( $atts['last_dtg'] == 'now' ) {
		$sort_order = 'DESC'; //WHY DOES THIS HAVE TO BE THE CASE?
		$last_dtg = current_time( );
	}
	else { 
		$last_dtg = strtotime( $atts['last_dtg'] );
	}
	$last_dtg = ( $last_dtg <= 0 ? PHP_INT_MAX : $last_dtg );

	//return( "first_dtg = $first_dtg last_dtg = $last_dtg ");		
	
	// Get the games posts
	$games = get_posts( 
				array( 'numberposts' => $atts['games_to_show'],
					   'post_type' => 'mstw_ss_game',
					   'meta_query' => array(
										   'relation' => 'AND',
										    array(
											   'key'     => 'game_sched_id',
											   'value'   => $sched_slugs,
											   'compare' => 'IN',
										       ),
										    array(
											   'key'     => 'game_unix_dtg',
											   'value'   => array( $first_dtg,
																   $last_dtg ),
											   'type'    => 'NUMERIC',
											   'compare' => 'BETWEEN'
										       )
									        ),
							'orderby' => 'meta_value', 
							'meta_key' => 'game_unix_dtg',
							'order' => $sort_order 
							) 
				);						
	
	if ( $games ) {
		// Make table of games
		// Start with the table header
		$output .= "<table class='mstw-ss-table mstw-ss-table_$sched_slugs[0]'>"; 
		$output .= "<thead><tr>";

		if( $atts['show_date'] ) { 
			$label = sanitize_title( $atts['date_label'] );
			$output .= '<th>' . __( $atts['date_label'], 'mstw-schedules-scoreboards' ) . '</th>';
		}
		
		$output .= '<th>'. __( $atts['opponent_label'], 'mstw-schedules-scoreboards' ) . '</th>';
		
		if( $atts['show_location'] ) {
			$output .= '<th>'. __( $atts['location_label'], 'mstw-schedules-scoreboards' ) . '</th>';
		}
		
		if( $atts['show_time'] ) {
			$output .= '<th>'. __( $atts['time_label'], 'mstw-schedules-scoreboards' ) . '</th>';
		}
		
		if ( $atts['show_media'] > 0 ) { 
			$output .= '<th>'.  __( $atts['media_label'], 'mstw-schedules-scoreboards' ) . '</th>';
		}
		//mstw_log_msg( 'show_media= ' . $atts['show_media'] );
		
		$output .= '</tr></thead>';
		
		// Loop through the posts and make the rows
		foreach( $games as $game ) {
			// set up some housekeeping to make styling in the loop easier
			
			$row_class = '';
			
			$is_home_game = get_post_meta($game->ID, 'game_is_home_game', true );
			$row_class = ( $is_home_game ) ? 'mstw-ss-home' : 'mstw-ss-away' ;
			
			$row_tr = "<tr class='$row_class'>";
			$td = '<td>';
			
			// create the row
			$row_string = $row_tr;			
			
			// column 1: Build the game date in a specified format
			if ( $atts['show_date'] ) {
				$new_date_string = mstw_date_loc( $dtg_format, (int)get_post_meta( $game->ID, 'game_unix_dtg', true ) );

				$row_string .= "$td $new_date_string </td>";	
			}
			
			// column 2: create the opponent entry ALWAYS SHOWN
			$opponent_entry = mstw_ss_build_opponent_entry( $game, $atts, "table" );
			
			// handle the show_sport option
			if ( $atts['show_sport'] ) {
				//$opponent_entry = "$sport $vs_or_at $opponent_entry";
				$opponent_entry = mstw_ss_build_game_sport( $game ) . ' ' . $opponent_entry;	
			} //End: if ( show_sport )
			
			$row_string .=  $td . $opponent_entry . '</td>';
			
			// column 3: create the location entry
			if ( $atts['show_location'] ) {
				$location_entry = mstw_ss_build_location_entry( $game, $atts );
				$row_string .= $td . $location_entry . '</td>';
			}
			
			// column 4: create the time/results entry
			// 20120221-MAO: Rewritten to handle new game time entry logic
			//		and to use time format settings
			
			if ( $atts['show_time'] ) {
				$result_str = mstw_ss_build_game_time_results( $game, $time_format );
				$row_string .=  $td . $result_str . '</td>';	
			}
			
			// column 5: create the media listings in a pretty format 
			
			if( $atts['show_media'] > 0 ) { //if ( $show_media ) {
				$media_links = mstw_ss_build_media_links( $game, $atts );
				$row_string .= $td . $media_links . '</td>';
			}
			
			//$output = $output . $row_string;
			$output .= $row_string . '</tr>';
			
		} // end of foreach game
		
		$output = $output . '</table>';
	}
	else { // No posts were found
		$output =  '<h3>' . __( 'No games found for ', 'mstw-schedules-scoreboards' ) .$sched_slugs[0] . '.</h3>';	
	}
	
	return $output;

} //End function mstw_ss_build_schedule_table
?>
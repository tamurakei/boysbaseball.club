<?php
/*---------------------------------------------------------------------------
 *	mstw-ss-schedule-slider.php
 *	Contains the code for the MSTW Schedules & Scoreboards schedule slider
 *		shortcode [mstw_ss_slider]
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
// Add the shortcode handler, which will create the Schedule Slider on the 
// user side. Handles the shortcode parameters, if there were any, then 
// calls mstw_ss_build_slider( ) to create the output
// 

add_shortcode( 'mstw_schedule_slider', 'mstw_ss_slider_handler' );

function mstw_ss_slider_handler( $atts ) {	
	//mstw_log_msg( 'in mstw_ss_schedule_table_shortcode_handler( ) ...' );
	//mstw_log_msg( $atts );

	// the team comes from the shortcode args, and must be provided
	if ( !is_array( $atts ) or !array_key_exists( 'sched', $atts ) ) {
		return '<h3>' . __( 'No schedule specified.', 'mstw-schedules-scoreboards' ) . '</h3>';
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
	
	return mstw_ss_build_slider( $attribs );
	
} //End: mstw_ss_slider_handler( )
	
//-----------------------------------------------------------------------------
// MSTW_SS_BUILD_SLIDER
//  Called by mstw_ss_slider_handler( )
//	Builds the schedule slider as a string (to replace the [shortcode] in a page or post.
// ARGUMENTS:
//  $atts - the display settings and shortcode arguments, properly combined by
//	mstw_ss_shortcode_handler()
// RETURN:
//	 HTML for schedule slider as a atring
//
function mstw_ss_build_slider( $atts ) {
	//mstw_log_msg( " In mstw_ss_build_schedule_slider ... " );
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
	
	// Get the games posts
	$games = get_posts( 
				array( 	'numberposts' => -1,
						'post_type' => 'mstw_ss_game',
						'meta_query' => array(
											array(
												'key'     => 'game_sched_id',
												'value'   => $sched_slugs,
												'compare' => 'IN'
												)
											),
						'orderby' => 'meta_value', 
						'meta_key' => 'game_unix_dtg',
						'order' => 'ASC' 
						)
				);	
				
	if( $games ) {
		// total games in the specfied schedule(s)
		$nbr_of_games = count( $games );
			
		// # games to show comes from the shortcode atts
		// show 3 games by default
		$games_to_show = $atts['games_to_show'];
		
		if ( '' == $games_to_show or -1 == $games_to_show ) {
			$games_to_show = 3;
		}
		
		// find the next game
		$next_game = mstw_ss_get_next_game( $games, current_time( 'timestamp' ) );
		
		$next_game_number = $next_game['next_game_number'];
		$next_game_id     = $next_game['next_game_id'];
		
		if ( -2 == $next_game_id ) {
			return "<h3>" . __( 'No games found on schedule ', 'mstw-schedules-scoreboards' ) . $sched_slug . "</h3>\n";
		} 
		else if ( -1 == $next_game_id ) {
			$next_game_number = $nbr_of_games - $games_to_show;
		}
		
		//Ya never know when there's only 2 games on a schedule
		$next_game_number = max( 0, min( $next_game_number, $nbr_of_games - $games_to_show ) );
	
		$game_number = $next_game_number + 1;
		
		$slider_title = $atts['title'];
		$show_slider_title = ( '' == $slider_title ) ? 0 : 1;

		if ( '' == $atts['link'] or '' == $atts['link_label'] ) {
			$show_slider_schedule_link = 0;
		}
		else {
			$show_slider_schedule_link = 1;
			$slider_link = $atts['link'];
			$slider_link_label = $atts['link_label'];
		}

		$game_block_width = 187;
		$schedule_view_width = 584; //DEFAULT. CALCULATED BELOW BASED ON GAMES_TO_SHOW

		$nbr_of_games = sizeof( $games );

		$games_to_show = $atts['games_to_show'];
		$games_to_show = ( '' == $games_to_show or -1 == $games_to_show ) ? 3 : $games_to_show;
		
		$slider_view_width = $games_to_show*$game_block_width+10 . 'px';
		
		$slider_view_height = ( $atts['show_slider_logos'] == 'name-only' ? '197px' : '250px' );
		
		// this is the entire width the 10 accounts for the size of the right arrow bar
		$schedule_slider_width = $nbr_of_games * $game_block_width + 10 . 'px';
		// postions the next game on the left
		$game_number = min( $game_number, $nbr_of_games - $games_to_show + 1 );
		$schedule_slider_offset = ( $game_number > 0 ? (-1) * ( $game_number - 1 ) * $game_block_width : 0) . 'px';

		$output .= "<div class='ss-slider-area ss-slider-area$css_tag' style='width:$slider_view_width;'>\n"; //height:$slider_view_height;'>\n";
		$output .= "<div class='ss-slider ss-one-edge-shadow ss-one-edge-shadow" . $css_tag . "'>\n";
		$output .= "<div class='border border" . $css_tag . "'>\n";
		$output .= "<div class='box box" . $css_tag . "'>\n";
			if ( $show_slider_title ) {
				$output .= "<div class='title title" . $css_tag . "'>\n";
					$output .= $slider_title;
				$output .= "</div> <!--end .title-->\n";
			
				if ( $show_slider_schedule_link ) {
					$output .= "<div class='full-schedule-link full-schedule-link" . $css_tag . "'>\n";
						$output .= "<a href='" . $slider_link . "' target='_blank' >" . $slider_link_label . "</a>\n";
					$output .= "</div> <!--end .full-schedule-link-->\n";
				}	
				$output .= "<div class='ss-clear'></div>\n";
				$output .= "<div class='ss-divider ss-divider" . $css_tag . "'></div>\n";
			}
		$output .= "<div class='content content$css_tag'>\n"; 
		$output .= "<div class='schedule-slider schedule-slider$css_tag' style='width:$schedule_slider_width; left: $schedule_slider_offset; position:absolute;'>\n"; 

		foreach ( $games as $game ) {
			$output .= mstw_ss_build_game_block( $game, $atts, $css_tag );
		}
		$output .= "</div> <!--end .schedule-slider-->\n";
		
		// Add the scroll controls - right and left arrows
		$output .= "<div class='ss-clear'></div>\n";
		$output .= "<div class='ss-slider-right-arrow' id='ss-slider-right-arrow{$css_tag}' style='height:$slider_view_height; line-height:$slider_view_height;'>&rsaquo;</div>\n";
		$output .= "<div class='ss-slider-left-arrow' id='ss-slider-left-arrow{$css_tag}'  style='height:$slider_view_height; line-height:$slider_view_height;'>&lsaquo;</div>\n";
		
		$output .= "</div> <!--end .content-->\n";
		
		$output .= "</div> <!--end .box-->\n";
		$output .= "</div> <!--end .border-->\n";
		$output .= "</div> <!--end .ss-slider-->\n";
		$output .= "</div> <!--end .ss-slider-area-->\n";
		
	} 
	else {
		$output = "<h3>" . __( 'No games found on schedule ', 'mstw-schedules-scoreboards' ) . $sched_slug . "</h3>\n";
	}
	
	return $output;
} //End: mstw_ss_build_slider()

//================================================================================
// MSTW_SS_BUILD_GAME_BLOCK
//	Called by mstw_ss_build_slider() to build the html for ONE game block
//	Returns an HTML string
// 	
	function mstw_ss_build_game_block( $game, $options, $css_tag ) {
		
		//$options should be the display settings merged with the shortcode args
		extract( $options );
		
		//full date format 
		$date_format = ( $options['slider_date_format'] == 'custom' ? $options['custom_slider_date_format'] : $options['slider_date_format'] );
		
		//time format
		$time_format = ( $options['slider_time_format'] == 'custom' ? $options['custom_slider_time_format'] : $options['slider_time_format'] );
	
		$ret = '';
		
		$home_css_tag = ( get_post_meta( $game->ID, 'game_is_home_game', true ) ) ? 'mstw-ss-home' : '';
		
		$ret .= "<div class='game-block $home_css_tag'>\n";
		
		//game date block
		$ret .= "<div class='date date" . $css_tag . " pad'>\n";
			$ret .= mstw_date_loc( $date_format, (int)get_post_meta( $game->ID, 'game_unix_dtg', true ) );
		$ret .= "</div> <!--end .date-->\n";
		
		//game sport or schedule block
		//sport overrides schedule
		if ( $options['show_sport'] ) {
			$ret .= "<div class='game-schedule game-schedule" . $css_tag . " pad'>\n";	
				$ret .= mstw_ss_build_game_sport( $game );				
			$ret .= "</div> <!--end .game-schedule -->\n";
		}
		else if ( $options['show_schedule_name'] ) {
			$ret .= "<div class='game-schedule game-schedule" . $css_tag . " pad'>\n";
				$sched_slug = get_post_meta( $game->ID, 'game_sched_id', true );
				$sched_obj = get_page_by_path( $sched_slug, OBJECT, 'mstw_ss_schedule' );	
				$ret .= get_the_title( $sched_obj->ID );
			$ret .= "</div> <!--end .game-schedule -->\n";
		}
		
		$ret .= "<div class='opponent opponent" . $css_tag . " pad'>\n";
			$ret .= mstw_ss_build_opponent_entry( $game, $options, "slider" );
		$ret .= "</div> <!--end .opponent-->\n";
		
		$location_entry = mstw_ss_build_location_entry( $game, $options );
		
		if( trim( $location_entry ) != '' and !empty( $location_entry ) ) {
			$ret .= "<div class='location location" . $css_tag . " pad'>\n";
			if( $location_entry[0] != '&' ) {  //huh?
				$ret .= "@ ";
			}
				
			$ret .= $location_entry;
				
			$ret .= "</div> <!--end .location-->\n";
		}
		
		$ret .= "<div class='time-result time-result" . $css_tag . " pad'>\n";
		
			$ret .= mstw_ss_build_game_time_results( $game, $time_format );
		$ret .= "</div> <!--end .time-result-->\n";
		
		if ( $options['show_media'] > 0 ) {
			$ret .= "<div class='links pad'>\n";
				$ret .= mstw_ss_build_media_links( $game, $options );
			$ret .= "</div> <!--end .links-->\n";
		}
			
		$ret .= "</div> <!--end .game-block-->\n";
		return $ret;
	}
	
//================================================================================
// MSTW_SS_GET_NEXT_GAME
//	Finds the next game AFTER a specified date time group
// Args:
//	$games = an array of game posts
//	dtg => a php time stamp
// Return:
//	An array of information:
//	next_game_id 
//		WP ID for next game if found, otherwise
//		-1 if no game was found with a start DTG after the dtg argument
//		-2 if $games is empty
//	next_game_number
//		number of next game [ 0 to sizeof($games)-1 ] 
//		(if found, otherwise see next_game_id)
//	next_game_dtg
//		PHP time stamp (date-time-group) for next game 
//		(if found, otherwise see next_game_id)
//	next_game_opponent
//		PHP time stamp for next game 
//		(if found, otherwise see next_game_id)
//================================================================================
	function mstw_ss_get_next_game( $games, $dtg ) {
		//mstw_log_msg( "in mstw_ss_get_next_game..." );
		//mstw_log_msg( $games );
		
		// No game has been found (yet)
		$retval = array( 'next_game_id' 	=> -1,
						 'next_game_number'	=> -1,
						 'next_game_dtg'	=> -1,
						 'next_game_opponent'	=> '-1',
						 ); 

		// loop thru the game posts to find the first game in the future
		$next_game_number = 0;
		if ( $games ) {
			foreach( $games as $game ) {
				// Find first game time after the current time, and (just to be sure) has no result
				if ( get_post_meta( $game->ID, 'game_unix_dtg', true ) > $dtg ) {
					// Ding, ding, ding, we have a winner
					// Grab the data needed and stop looping through the games
					$retval['next_game_id'] = $game->ID;
					$retval['next_game_number'] = $next_game_number;
					$retval['next_game_dtg'] = get_post_meta( $game->ID, 'game_unix_dtg', true );
					$retval['next_game_opponent'] = get_post_meta( $game->ID, 'game_opponent_team', true );
					break;
				}
				$next_game_number++;
			}
		} else {  
			$retval['next_game_id'] =  -2; 
		}
		
		return $retval;

	}

?>
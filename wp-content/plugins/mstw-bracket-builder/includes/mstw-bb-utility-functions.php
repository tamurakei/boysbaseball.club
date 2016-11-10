<?php
/*-----------------------------------------------------------------------
 * mstw-bb-utility-functions.php
 * 	'Helper functions' used in the MSTW Bracket Builder plugin
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed AS IS in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *---------------------------------------------------------------------*/
 
/*----------------------------------------------------------------------
 * MSTW BB UTLITY FUNCTIONS
 *	'Helper functions' used in the MSTW Bracket Builder plugin
 *
 * 1. mstw_bb_log_msg - writes debug messages to /wp-content/debug.log
 *
 * 2. mstw_bb_requires_wordpress_version - checks for the right WordPress 
 *		version
 *
 * 3. mstw_bb_admin_notice - Displays admin notices
 *
 * 4. mstw_bb_add_admin_notice - Adds admin notices to transient for display
 *
 * 5. mstw_bb_get_current_tourney - gets the current tourney from the 
 *		options DB
 *
 * 6. mstw_bb_set_current_tourney - sets the current tourney (slug) in the
 *		options DB
 *
 * 7. mstw_bb_table_defaults - returns the defaults for the tournament tables
 *
 * 8. mstw_bb_bracket_defaults - returns the default arguments for 
 *		tournament brackets
 *
 * 9. mstw_bb_build_location_string - returns the html for a location_format
 *		based on the specified format
 *
 * 10. mstw_bb_build_team_name - builds the team name from the team object (slug)
 *		and the format arguments
 *----------------------------------------------------------------------------*/
 
//------------------------------------------------------------------------------
//	1. mstw_bb_log_msg - logs messages to /wp-content/debug IF WP_DEBUG is true
//		ARGUMENTS:
//			$msg - string, array, or object to log
//					note: if $msg == 'divider' a divider is output to the log
//		RETURNS:
//			None. Outputs to WP error_log
//
if ( !function_exists( 'mstw_bb_log_msg' ) ) {
	function mstw_bb_log_msg( $msg ) {
		if ( WP_DEBUG === true ) {
			if ( $msg == 'divider' ) {
				error_log( '------------------------------------------------------' );
			}
			else if( is_array( $msg ) || is_object( $msg ) ) {
				error_log( print_r( $msg, true ) );
			} 
			else {
				error_log( $msg );
			}
		}
	} //End: mstw_bb_log_msg( )
}

//------------------------------------------------------------------------------
//	2. mstw_bb_requires_wordpress_version - checks for the right WordPress version
//		Arguments:
//			$msg - string, array, or object to log
//		Returns:
//			none - prints message to upgrade and exits
//	THIS FUNCTION ONLY WORKS IN ADMIN (because it calls get_plugin_data()
//
if ( !function_exists( 'mstw_bb_requires_wordpress_version' ) ) {
	function mstw_bb_requires_wordpress_version( $version = '3.9.2' ) {
		global $wp_version;
		
		$plugin = MSTW_SS_PLUGIN_NAME;
		//$plugin_data = get_plugin_data( __FILE__, false );
		$plugin_data = get_plugin_data( MSTW_SS_PLUGIN_DIR . '/mstw-schedules-scoreboards.php', 
										false );

		if ( version_compare( $wp_version, $version, "<" ) ) {
			if( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
				$die_msg = $plugin_data['Name'] . " requires WordPress $version or higher, and has been deactivated! <br/> Please upgrade WordPress and try again.<br /><br /><a href='".admin_url()."'>Back to admin dashboard</a>.";
				die( $die_msg );
			}
		}
	} //end mstw_bb_requires_wordpress_version()
}

//----------------------------------------------------------------
// 3. mstw_bb_admin_notice - Displays all admin notices; 
//		callback for admin_notices action
//		ARGUMENTS: 	$transient - transient where messages are stored
//		RETURNS:	None. Displays all messages in the $transient transient
//					(then deletes it)
//
if ( !function_exists ( 'mstw_bb_admin_notice' ) ) {
	function mstw_bb_admin_notice( ) {
		//mstw_bb_log_msg( "mstw_bb_admin_notice:" );
		
		$transient = 'mstw_bb_admin_notices';
		
		if ( get_transient( $transient ) !== false ) {
			// get the types and messages
			$messages = get_transient( $transient );
			// display the messages
			foreach ( $messages as $message ) {
				$msg_type = $message['type'];
				$msg_notice = $message['notice'];
				
				// Kludge to get warning messages to appear after page title
				$msg_type = ( $msg_type == 'warning' ) ? $msg_type . ' updated' : $msg_type ;
			?>
				<div class="<?php echo $msg_type; ?>">
					<p><?php echo $msg_notice; ?></p>
				</div>
			
			<?php
			}

			delete_transient( $transient );
			
		} //End: if ( get_transient( $transient ) )
	} //End: function mstw_bb_admin_notice( )
}

//----------------------------------------------------------------
// 4. mstw_bb_add_admin_notice - Adds admin notices to transient 
//		for display on admin_notices hook
//
//	ARGUMENTS: 	$type - type of notice [updated|error|update-nag|warning]
//				$notice - notice text
//
//	RETURNS:	None. Stores notice and type in transient for later display on admin_notices hook
//
if ( !function_exists ( 'mstw_bb_add_admin_notice' ) ) {
	function mstw_bb_add_admin_notice( $type = 'updated', $notice ) {
		//mstw_bb_log_msg( "mstw_bb_add_admin_notice:" );
		
		$transient = 'mstw_bb_admin_notices';
		
		//default type to 'updated'
		if ( !( $type == 'updated' or $type == 'error' or $type =='update-nag' or $type == 'warning' ) ) $type = 'updated';
		
		//mstw_bb_log_msg( "type: $type, notice: $notice " );
		
		//set the admin message
		$new_msg = array( array(
							'type'	=> $type,
							'notice'	=> $notice
							)
						);

		//either create or add to the sss_admin transient
		$existing_msgs = get_transient( $transient );
		
		if ( $existing_msgs === false ) {
			// no transient exists, create it with the current message
			set_transient( $transient, $new_msg, HOUR_IN_SECONDS );
		} 
		else {
			// transient exists, append current message to it
			$new_msgs = array_merge( $existing_msgs, $new_msg );
			set_transient ( $transient, $new_msgs, HOUR_IN_SECONDS );
		}
		
		$new_transient = get_transient( $transient );
		//mstw_bb_log_msg( $transient );
	} //End: function mstw_bb_add_admin_notice( )
}



//-------------------------------------------------------------------------
// 5. mstw_bb_get_current_tourney - gets the current tourney from the options DB 
//
//	ARGUMENTS: 
//		None
//
//	RETURNS:
//		The current tourney (slug) or '' if a current tourney has not been set
//
function mstw_bb_get_current_tourney( ) {
	//mstw_bb_log_msg( "mstw_bb_get_current_tourney" );
	
	//for testing only
	//$this -> set_current_tourney( '' );
	
	$current_tourney = get_option( 'bb-current-tourney', '' );
	
	// We should get a current tourney, but in case we don't we'll take the
	// first one find and set it as current
	
	if ( '' == $current_tourney or -1 == $current_tourney ) {
		// This should only happen the first time the plugin is run
		//mstw_bb_log_msg( "current tourney not found" );
		
		$args = array(
			'posts_per_page' => -1, 
			'post_type'      => 'mstw_bb_tourney',
			'order_by'       => 'title',
			);
		$tourneys = get_posts( $args );
		
		if ( $tourneys ) {
			//mstw_bb_log_msg( 'tourneys: ' );
			//mstw_bb_log_msg( $tourneys );
			$current_tourney = $tourneys[0]->post_name;
			//mstw_bb_log_msg( "setting current tourney to $current_tourney" );
			//$this -> set_current_tourney( $current_tourney );
			mstw_bb_set_current_tourney( $current_tourney );
		}
	}
	
	//mstw_bb_log_msg( "returning current tourney: $current_tourney " );
	
	return $current_tourney;
	
} //End: mstw_bb_get_current_tourney( )

//-------------------------------------------------------------------------
// 6. mstw_bb_set_current_tourney - sets the current tourney (slug) in the options DB 
//
//	ARGUMENTS: 
//		None
//
//	RETURNS:
//		True of current tourney is updated, false if update fails
//
function mstw_bb_set_current_tourney( $tourney_slug = '' ) {
	//mstw_bb_log_msg( "mstw_bb_set_current_tourney" );	
	//mstw_bb_log_msg( "Setting current tourney to: $tourney_slug " );
	
	return update_option( 'bb-current-tourney', $tourney_slug );
		
} //End: mstw_bb_set_current_tourney( )
	
// ----------------------------------------------------------------
// 6. mstw_bb_count_league_teams - returns the number of teams in a league 
//		Arguments:
//			$league_slug - the league to count
//		Returns:
//			Number of teams in the league
//
if( !function_exists( 'mstw_bb_count_league_teams' ) ) {
	function mstw_bb_count_league_teams( $league_slug = null ) {
		//mstw_bb_log_msg( "mstw_bb_count_league_teams:" );
		
		if ( null === $league_slug ) {
			$count =0;
			
		} else {
			$args = array( 
						'numberposts' => -1,
						'post_type' => 'mstw_lm_team',
						'tax_query' => array(
										array( 'taxonomy' => 'mstw_lm_league',
											   'field'    => 'slug',
											   'terms'    => $league_slug
											)
										   ),
						  );
						  
			$teams = get_posts( $args ); 
			
			$count = count( $teams );
			
		}
		
		return $count;
	}
} //End: mstw_bb_count_league_teams( )


// ----------------------------------------------------------------
// 7. mstw_bb_table_defaults - returns the default arguments for 
//		tournament tables
//	Arguments:
//		None
//	Returns:
//		Defaults as an array
//
if( !function_exists( 'mstw_bb_table_defaults' ) ) {
	function mstw_bb_table_defaults( ) {
		
		return array(
			'tourney'     => '',
			
			'date_format' => 'j M Y',
			
			'time_format' => 'H:i',
			
			'tba'         => __( 'TBA', 'mstw-bracket-builder' ),
			
			// location_format: 'stadium' or 'city-state'
			'location_format' => 'city-state',
			
			// team_format: 'title', 'name', 'mascot', 'name-mascot',
			//	'logo', 'logo-name', logo-name-mascot', 'logo-mascot'
			'team_format'     => 'logo-name',
		
		);
		
	} //End: mstw_bb_table_defaults( )
}

// ----------------------------------------------------------------
// 8. mstw_bb_bracket_defaults - returns the default arguments for 
//		tournament brackets
//	Arguments:
//		None
//	Returns:
//		Defaults as an array
//
if( !function_exists( 'mstw_bb_bracket_defaults' ) ) {
	function mstw_bb_bracket_defaults( ) {
		
		return array(
			'tourney'     => '',
			
			'date_format' => 'D, j M Y',
			
			'time_format' => 'H:i',
			
			'tba'         => __( 'TBD', 'mstw-bracket-builder' ),
			
			// location_format: 'stadium' or 'city-state'
			'location_format' => 'city-state',
			
			// team_format: 'title', 'name', 'short-name', 'mascot', 'name-mascot',
			//	'logo', 'logo-name', logo-name-mascot', 'logo-mascot'
			'team_format'     => 'logo-name',
			
		);
		
	} //End: mstw_bb_bracket_defaults( )
}

// ----------------------------------------------------------------
// 9. mstw_bb_build_location_string - returns the html for a location_format
//		based on the specified format
//	Arguments:
//		$game: a game object (CPT)
//		$format: location format
//	Returns:
//		If there is a location slug, return either the stadium (CPT title)
//		or 'stadium(city, state)'
//		Else, return the location_text field
//
if( !function_exists( 'mstw_bb_build_location_string' ) ) {
	function mstw_bb_build_location_string( $game, $format = 'stadium' ) {
		//mstw_bb_log_msg( "mstw_bb_build_location_string" );
		//mstw_bb_log_msg( $format );
		$location = get_post_meta( $game -> ID, 'location', true );
		//mstw_bb_log_msg( "location slug:" . $location );
		
		// the location text is the fallback
		$loc_str = get_post_meta( $game->ID, 'location_text', true );
		
		// See if there's a location slug for the game
		$loc_slug = get_post_meta( $game->ID, 'location', true );
		//mstw_bb_log_msg( "game: " . $game -> ID . " location slug:" . $loc_slug );
		
		if ( '' != $loc_slug && -1 != $loc_slug ) {
			$loc_obj = get_page_by_path( $loc_slug, OBJECT, 'mstw_lm_venue' );
			
			if ( null !== $loc_obj ) {
				$stadium = get_the_title( $loc_obj );
				
				switch ( $format ) {
					case 'city-state':
						$city = get_post_meta( $loc_obj -> ID, 'venue_city', true );
						$state = get_post_meta( $loc_obj -> ID, 'venue_state', true );
						$loc_str = "$stadium ($city, $state)";
						break;
						
					case 'stadium':
					default: //'stadium'
						//default to the venue title
						$loc_str = $stadium;
						break;
					
				}
			}
		}
		
		return $loc_str;
		
	} //End: mstw_bb_build_location_string( )
}
	
//-----------------------------------------------------------------------------
// 10. mstw_bb_build_team_name - builds the team name from the team object (slug)
//	and the format arguments
//
// ARGUMENTS
//	$slug:   slug of team (mstw_lm_team) CPT
//	$format: team name format - title | name | short-name | mascot | name-mascot
//				| logo | logo-name | logo-name-mascot | logo-mascot
//	$reverse: displays team logo AFTER the name (text)
//
// RETURNS
//	The team name HTML, or null if team object does not exist
//
if( !function_exists( 'mstw_bb_build_team_name' ) ) {
	function mstw_bb_build_team_name ( $slug, $format = 'title', $reverse = false ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.mstw_bb_build_team_name:' );
		
		$team_obj = get_page_by_path( $slug, OBJECT, 'mstw_lm_team' );
		
		if ( null !== $team_obj ) {
			$name = get_post_meta( $team_obj -> ID, 'team_name', true );
			$short_name = get_post_meta( $team_obj -> ID, 'team_short_name', true );
			$mascot = get_post_meta( $team_obj -> ID, 'team_mascot', true );
			$logo = get_post_meta( $team_obj -> ID, 'team_logo', true );
			
			// $team_name is return variable
			$team_name = '';
			
			// for any logo format, add logo first 
			if ( !$reverse && false !== strpos( $format, 'logo' ) ) {
				$team_name .= "<img class='team-logo' src='$logo' />";
			}
			
			switch ( $format ) {
				case 'name':
				case 'logo-name':
					$team_name .= $name;
					break;
					
				case 'short-name':
					$team_name .= $short_name;
					break;
					
				case 'mascot':
				case 'logo-mascot':
					$team_name .= $mascot;
					break;
					
				case 'name-mascot':
				case 'logo-name-mascot':
					$team_name .= "$name $mascot";
					break;
				
				case 'logo':
					// handled before select
					break;
					
				case 'title':
				default:
					$team_name .= get_the_title( $team_obj );
					break;
			}
			
			// for any logo format, add logo first 
			if ( $reverse && false !== strpos( $format, 'logo' ) ) {
				$team_name .= "<img class='team-logo-right' src='$logo' />";
			}
			
		} else {
			$team_name = null;
		}
		
		return $team_name;
		
	} // mstw_bb_build_team_name( )
}
?>
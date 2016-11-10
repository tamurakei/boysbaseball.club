<?php
 /*---------------------------------------------------------------------------
 *	mstw-bb-tourney-bracket-class.php
 *	Contains the class for the MSTW Bracket Builder tournament
 *	bracket table shortcode [mstw_tourney_bracket]
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. All rights 
 * 	reserved.
 *-------------------------------------------------------------------------*/

//---------------------------------------------------------------------------
// Add the shortcode handler, which will create the Tournament Bracket display
// table on the user side. Handles the shortcode parameters, if there were 
// any, then calls mstw_bb_build_tourney_bracket( ) to create the output
// 

class MSTW_TOURNEY_BRACKET {
	
	public function __construct( ) {
		add_filter( 'get_tourney_bracket_builder_instance', [$this, 'get_instance'] );
	}
	
	public function get_instance( ) {
		return $this; //return the object
	}
	
	//
	// Handles the shortcode inline arguments and merges them with options DB
	//
	public function tourney_bracket_handler( $atts, $content = null, $shortcode ) {
		//mstw_bb_log_msg( "MSTW_TOURNEY_BRACKET:tourney_bracket_handler: shortcode= $shortcode " );
		//mstw_bb_log_msg( 'shortcode: ' . $shortcode );
		//mstw_bb_log_msg( 'plugin slug 1: ' . plugin_dir_path( __FILE__ ) );
		
		//$plugin_dir = dirname( plugin_dir_path( __FILE__ ) );
		//$last_slash = strrchr( $plugin_dir, '/' );
		
		//mstw_bb_log_msg( 'last slash position: ' . $last_slash );
		
		// MUST have a tournament to proceed
		if( !is_array( $atts ) or !array_key_exists( 'tourney', $atts ) ) {	
			return '<h3 class="mstw-bb-user-msg">' . __( 'No TOURNAMENT specified in shortcode.', 'mstw-bracket-builder' ) . '</h3>';
		}
		
		$tourney_slug = $atts['tourney'];
		//mstw_bb_log_msg( "Tournament (slug): $tourney_slug" );
		
		// get the default options
		$args = mstw_bb_bracket_defaults( );
			
		// then merge the parameters passed to the shortcode 								
		$attribs = shortcode_atts( $args, $atts );
		//$attribs = $atts;
		
		return $this -> build_tourney_bracket( $attribs );
		
	} //End: mstw_bb_tourney_bracket_handler( )
	
	//-----------------------------------------------------------------------------
	// build_tourney_bracket
	// 	Builds the bracket for the specified tournament 
	// 	Called from mstw_bb_tourney_bracket_handler( ) after it has processed 
	//	the arguments & settings
	//
	// ARGUMENTS
	// 	$atts  - the plugin settings and shortcode arguments; the critical att is 
	//				tourney
	//
	// RETURNS
	//	HTML for tournament bracket (a table) as a string
	//
	function build_tourney_bracket( $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_tourney_bracket:' );
		
		//mstw_bb_log_msg( 'attributes passed to function' );
		//mstw_bb_log_msg( $atts );
		
		// This is the return string
		$html = "";
		
		if ( !array_key_exists( 'tourney', $atts ) ) {
			$html .= "Error: TOURNEY not specified in shortcode.";
			return $html;
		}
		
		$tourney_slug = $atts['tourney'];
		
		$tourney_obj = get_page_by_path( $tourney_slug, OBJECT, 'mstw_bb_tourney' );
		
		if ( null === $tourney_obj ){
			$html .= "Error occured with tourney: $tourney_slug";
			return $html;
		}
		
		//
		// Gather the tournament's meta data 
		//
		$tourney_id = $tourney_obj -> ID;
			
		$rounds = get_post_meta( $tourney_id, 'rounds', true );
		
		$round_names = get_post_meta( $tourney_id, 'round_names', true );
		
		$games = $this -> get_tourney_games( $tourney_id );
		
		$html .= '<div class="mstw_tournament_bracket mstw_tournament_bracket_' . $tourney_slug . '">';
		
		if ( $rounds > 0 ) {
			for ( $i =0; $i < $rounds; $i++ ) {
				$html .= $this -> build_round( $tourney_id, $games, $i, $round_names[ $i ], $atts );
			}
		}
		
		$html .= '</div> <!-- End: .mstw_tournament_bracket"-->';
			
		return $html;
		
	} //End: build_tourney bracket;
	
	//-----------------------------------------------------------------------------
	// build_round( ) - Builds the HTML for the specified tournament round 
	// 	Called from build_tourny_bracket( )
	//
	// ARGUMENTS
	// 	$tourney_id  - the tourney CPT ID (NOT the tourney slug)
	//	$games - a list of the tourney's game CPTs (objects) IN NUMERICAL ORDER
	//	$round_nbr - the round number STARTING AT ZERO
	//	$round_name - the round title
	//	$atts - shortcode arguments (merged with defaults)
	//
	// RETURNS
	//	HTML for the tournament round's bracket (wrapped in a div) as a string
	//
	function build_round( $tourney_id, $games, $round_nbr, $round_name, $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_round:' );
		//return "<p>Tourney (ID): $tourney_id, Round #: " . strval($round_nbr + 1) . ", Round Name: $round_name</p>"; 
		$ret_html = '<div class="round round_' . strval( $round_nbr + 1 ) . '">';
		
		$ret_html .= $this -> build_round_header( $round_nbr, $round_name );
		
		$rounds = get_post_meta( $tourney_id, 'rounds', true );
		
		$games = $this -> get_games_in_round( $games, $rounds, $round_nbr );
		
		$last_game_in_tourney = pow( 2, $rounds ) - 2;
		
		$base = pow( 2 , $rounds );
		
		$games_in_round = pow( 2 , $rounds ) / pow( 2, $round_nbr + 1 );
		
		$round_start = pow( 2, $rounds - $round_nbr ) * ( pow ( 2, $round_nbr ) - 1 );
		
		$round_end = $round_start + $games_in_round - 1;
		
		//mstw_bb_log_msg( "Round: $round_nbr, Games in Round: $games_in_round, Round start: $round_start, Round End: $round_end ");
		
		$ret_html .= '<ul class="round_games round_' . ( $round_nbr + 1 ) . '">';
		
		//if ( 0 == ( $round_nbr + 1 ) % 2 ) {
			//$ret_html .= '<div class="test-divider"></div>';
		//}
		
		foreach ( $games as $key => $value ) {
			if ( $round_nbr < ( $rounds - 1 ) ) {
				if ( 0 == $key % 2 ) {
					$ret_html .= '<div class="relative">';
					$ret_html .= '<div class="bracket-lines-' . ($round_nbr + 1) . '"></div>';
					$ret_html .= '</div>';
				}
			}
			
			$last_game_in_round = ( $key == $round_end ) ? " last_game" : "" ;
			
			$ret_html .= '<li class="game game_' . $key . $last_game_in_round . '">';
			
			$ret_html .= $this -> build_game_block( $key, $value, $round_end, $atts );
			
			$ret_html .= '</li>';
			
		}
		
		$ret_html .= '</ul>';

		//mstw_bb_log_msg( "Games in Round $round_nbr" );
		//mstw_bb_log_msg( $games );
		
		
		$ret_html .= '</div> <!-- .round round_rnd_nbr -->';
		
		return $ret_html;
		
	} //End: build_round( )
	
	function build_round_header ( $round_nbr, $round_name ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_round_header:' );
		
		$ret_html = '<h2 class="round_header">' . $round_name . '</h2>';
		
		//$ret_html .= '<div class="test-divider"></div>';
		
		
		return $ret_html;
		
	} //End: build_round_header( )
	
	function get_tourney_games( $tourney_id ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.get_tourney_games:' );
		
		$tourney_slug = get_post( $tourney_id ) -> post_name;
		
		$meta_query = array(
						array( 'key' => 'tournament',
							   'value' => $tourney_slug,
							 ),
					    );
		
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'mstw_bb_game',
			'meta_query'       => $meta_query,
			'order_by'         => 'meta_value_num',
			'meta_key'         => 'game_nbr',
			'order'            => 'ASC',
			// pull the right tournament
			// order the games by game #
			);
			
		return get_posts( $args );
		
	} //End: get_tourney_games( )
	
	//-----------------------------------------------------------------------------
	// get_games_in_round( ) - Builds the HTML for the specified tournament round 
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$games - a list of ALL the tourney's games (CPTs/objects) IN NUMERICAL ORDER
	//	$round_nbr - the round number STARTING AT ZERO
	//
	// RETURNS
	//	A list of games in the round IN NUMERICAL ORDER
	//
	function get_games_in_round( $games, $rounds, $round_nbr ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.get_games_in_round:' );
		
		// $base is for convenience, so we aren't exponentiating all over
		$base = pow( 2 , $rounds );
		
		$games_in_round = $base / pow( 2, $round_nbr + 1 );
		
		$round_start = pow( 2, $rounds - $round_nbr ) * ( pow ( 2, $round_nbr ) - 1 );

		//mstw_bb_log_msg( "Rounds: $rounds, Round start: $round_start, Games in Round: $games_in_round");
		
		$games = array_slice( $games, $round_start, $games_in_round, true );
		
		//mstw_bb_log_msg( $games );
		//foreach ( $games as $key => $value ) {
		//	mstw_bb_log_msg( "Key: $key Value:" );
		//	mstw_bb_log_msg( $value );
		//}
		
		return $games;
		
		
	} //End: get_games_in_round( )
	
	//-----------------------------------------------------------------------------
	// build_game_block( ) - Builds the HTML a bracket game block ( list / <ul> ) 
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//  $round_end - # of last game in round
	//	$atts - shortcode arguments (merged with defaults)
	//
	// RETURNS
	//	A list of games in the round IN NUMERICAL ORDER
	//
	function build_game_block( $game_nbr, $game, $round_end, $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_game_block:' );
		
		
		
		$last_round = ( $game_nbr == $round_end ) ? " last_game" : "";
			
		$ret_html = '<ul class="game game_' . $game_nbr . '">';
		
		$ret_html .= '<li class="game_status">' . $this -> build_status_row( $game_nbr, $game, $atts ) . '</li>';
		$ret_html .= $this -> build_team_rows( $game_nbr, $game, $atts );
		
		$loc_format = ( array_key_exists( 'location_format', $atts ) ) ? $atts['location_format'] : 'stadium';
		$ret_html .= '<li class="game_location">' . mstw_bb_build_location_string( $game, $loc_format ) . '</li>';
		
		$ret_html .= '</ul>';
		
		return $ret_html;
		
	} //End: build_game_block( )
	
	
	//-----------------------------------------------------------------------------
	// build_status_row( ) - Builds the HTML for a game block's status line 
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//	$atts - shortcode arguments (merged with defaults)
	//
	// RETURNS
	//	HTML for a status line
	//
	function build_status_row( $game_nbr, $game, $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_status_row:' );
		
		$ret_html = '';
		
		// if game is final, just show FINAL
		if ( get_post_meta( $game -> ID, 'is_final', true ) ) {
			$ret_html .= __( 'FINAL', 'mstw-bracket-builder' );
		
		// else if game is in progress, show period and time remaining
		} else if ( '' != ( $period = get_post_meta( $game -> ID, 'period', true ) ) ) {
			$ret_html .= __( 'Period', 'mstw-bracket-builder' ) . ": $period ";
			$ret_html .= __( 'Time', 'mstw-bracket-builder' ) . ": " . get_post_meta( $game -> ID, 'time_remaining', true );
		
		// else show the game time (or TBA)		
		} else {
			$dtg = get_post_meta( $game -> ID, 'dtg', true );
			// Check for TBA
			$date_ja = array('月','火','水','木','金','土','日');
			$date_en = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
			if ( get_post_meta( $game -> ID, 'time_is_tba', true ) ) {
				$game_date = str_replace($date_en,$date_ja,date( 'Y年n月j日(D)', $dtg ));
				$ret_html .= $game_date;
                                //$ret_html .= date( 'D, j M Y', $dtg );
				$ret_html .= ' ' . __( 'Time', 'mstw-bracket-builder' ) . ": " . __( 'TBA', 'mstw-bracket-builder' );
			
			// Otherwise show the game date and time			
			} else {
                                $game_date = str_replace($date_en,$date_ja,date( 'Y年n月j日(D) H:i', $dtg ));
                                $ret_html .= $game_date;
				//$ret_html .= date( 'Y年n月j日(d)', $dtg );
				//$ret_html .= date( 'D, j M Y H:i', $dtg );
				
			}
			
		}
		
		return $ret_html;
		
	} //End: build_status_row( )
	 
	//-----------------------------------------------------------------------------
	// build_team_rows( ) - Builds the HTML for a game block's team rows 
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//	$atts - shortcode arguments (merged with defaults)
	//
	// RETURNS
	//	HTML for a team line
	//
	function build_team_rows( $game_nbr, $game, $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_team_row:' );
		
		$ret_html = '';
		$home_html = '<li class="game_home">';
		$away_html = '<li class="game_away">';
		//return get_post_meta( $game -> ID, $home_away . '_text', true );
		
		//$home_row = '';
		$home_row = $this -> build_team_name( $game, 'home', $atts );
		
		
		if ( '' != ( $home_score = get_post_meta( $game -> ID, 'home_score', true ) ) ) {
			$home_row .= " <span class='game_score'>$home_score</span>";
			
		}
		
		//$away_row = '';
		// Use the specified team name if available
		$away_row = $this -> build_team_name( $game, 'away', $atts );
		
		if ( '' != ( $away_score = get_post_meta( $game -> ID, 'away_score', true ) ) ) {
			$away_row .= " <span class='game_score'>$away_score</span>";
			
		}
		
		//
		// Add winner tag if game is final and scores are available
		//
		//mstw_bb_log_msg( "is final: " . get_post_meta( $game -> ID, 'is_final', true ) );
		//mstw_bb_log_msg( "home: " . intval( $home_score ) );
		//mstw_bb_log_msg( "away: " . intval( $away_score ) );
		
		if ( get_post_meta( $game -> ID, 'is_final', true ) && '' != $home_score && '' != $away_score ) {
			if ( intval( $home_score ) > intval( $away_score ) ) {
				$home_html = '<li class="game_home winner">';
			}
			else { //if ( intval( $away_score ) > intval( $home_score ) ) {
				//mstw_bb_log_msg( "away score is greater than home score" );
				$away_html = '<li class="game_away winner">';
				//mstw_bb_log_msg( "setting away html to be: $away_html");
			}
		} 
		
		$ret_html .= $home_html . $home_row . "</li>";
		
		$ret_html .= $away_html . $away_row . "</li>";
		
		//mstw_bb_log_msg( "returning $ret_html" );
		
		return $ret_html;
		
	} //End: build_team_rows( )
	
	//-----------------------------------------------------------------------------
	// build_team_name( ) - Builds the team name for the game block's team rows
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$game: the game CPT/object
	//	$team: 'home' or 'away' team
	//	$atts: arguments passed to shortcode (merged w/ defaults)
	//
	//	Uses the name from the team slug (LM team object) if it's available, and
	//	builds name based on the shorcode 'team_format', 
	//	otherwise uses the team text field
	//
	// RETURNS
	//	HTML for a team's name, formatted based on the team_format attribute
	//
	function build_team_name( $game, $team = 'home', $atts ) {
		//mstw_bb_log_msg( "build_team_name:" );
		
		$team_name = ''; 
		// Use the specified team name if available
		$team_slug = get_post_meta( $game -> ID, $team, true );  
		if ( -1 !=  $team_slug && '' != $team_slug  ) {
			$format = ( array_key_exists( 'team_format', $atts ) ) ? $atts['team_format'] : 'title';
			$team_name = mstw_bb_build_team_name( $team_slug, $format );
			$team_name = ( null !== $team_name ) ? $team_name : get_post_meta( $game -> ID, 'home_text', true );
			//$home_row .= $team_name;
			
		} else if ( '' != ( $home_text = get_post_meta( $game -> ID, 'home_text', true ) ) ) {
			// Else use the team text
			$team_name .= get_post_meta( $game -> ID, $team . '_text', true );
			
		}
		
		return $team_name;
		
	} //End: build_team_name( )
	
	//-----------------------------------------------------------------------------
	// get_team_name_from_slug( ) - gets the team name from the team object 
	//
	// ARGUMENTS
	//	$slug:   slug of team (mstw_lm_team) CPT
	//	$format: team name format - title | name | short-name | mascot | name-mascot
	//	| logo | logo-name | logo-name-mascot | logo-mascot
	//
	// RETURNS
	//	the team name, or null if team object does not exist
	//
	function get_team_name_from_slug ( $slug, $format = 'title' ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.get_team_name_from_slug:' );
		
		$team_obj = get_page_by_path( $slug, OBJECT, 'mstw_lm_team' );
		
		if ( null !== $team_obj ) {
			$name = get_post_meta( $team_obj -> ID, 'team_name', true );
			$short_name = get_post_meta( $team_obj -> ID, 'team_short_name', true );
			$mascot = get_post_meta( $team_obj -> ID, 'team_mascot', true );
			$logo = get_post_meta( $team_obj -> ID, 'team_logo', true );
			
			// $team_name is return variable
			$team_name = '';
			
			// for any logo format, add logo first 
			if ( false !== strpos( $format, 'logo' ) ) {
				$team_name = "<img class='team-logo' src='$logo' />";
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
			
		} else {
			$team_name = null;
		}
		
		return $team_name;
		
	} // get_team_name_from_slug( )
	

	
} //End: class MSTW_TOURNEY_BRACKET

$bracket_builder = new MSTW_TOURNEY_BRACKET;

add_shortcode( 'mstw_tourney_bracket', array( $bracket_builder, 'tourney_bracket_handler' ) );

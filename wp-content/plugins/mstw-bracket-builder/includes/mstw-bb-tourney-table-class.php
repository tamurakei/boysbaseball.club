<?php
 /*---------------------------------------------------------------------------
 *	mstw-bb-tourney-table-class.php
 *	Contains the class for the MSTW Bracket Builder tournament
 *  table shortcode [mstw_tourney_table]
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

class MSTW_TOURNEY_TABLE {
	
	public function __construct( ) {
		add_filter( 'get_tourney_bracket_builder_instance', [$this, 'get_instance'] );
	}
	
	public function get_instance( ) {
		return $this; //return the object
	}
	
	//
	// Handles the shortcode inline arguments and merges them with options DB
	//
	public function tourney_table_handler( $atts, $content = null, $shortcode ) {
		mstw_bb_log_msg( "MSTW_TOURNEY_TABLE:tourney_table_handler: shortcode= $shortcode " );
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
		mstw_bb_log_msg( "Tournament (slug): $tourney_slug" );
		
		
		// get the default options
		$args = mstw_bb_table_defaults( );
		
		// then merge the parameters passed to the shortcode 								
		$attribs = shortcode_atts( $args, $atts );
	
		//mstw_bb_log_msg( "attribs:" );
		//mstw_bb_log_msg( $attribs );
		
		return $this -> build_tourney_table( $attribs );
		
	} //End: tourney_table_handler( )
	
	//-----------------------------------------------------------------------------
	// build_tourney_table
	// 	Builds the table for the specified tournament 
	// 	Called from tourney_table_handler( ) after it has processed 
	//	the arguments & settings
	//
	// ARGUMENTS
	// 	$atts  - the plugin settings and shortcode arguments; the critical att is 
	//				tourney
	//
	// RETURNS
	//	HTML for tournament bracket (a table) as a string
	//
	function build_tourney_table( $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_tourney_table:' );
		
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
		
		$html .= '<table class="mstw_tournament_table mstw_tournament_table_' . $tourney_slug . '">';
		
		if ( $rounds > 0 ) {
			for ( $i =0; $i < $rounds; $i++ ) {
				$html .= $this -> build_round( $tourney_id, $games, $i, $round_names[ $i ], $atts );
			}
		}
		
		$html .= '</table> <!-- End: .mstw_tournament_table"-->';
			
		return $html;
		
	} //End: build_tourney_table( );
	
	//-----------------------------------------------------------------------------
	// build_round( ) - Builds the HTML for the specified tournament round 
	// 	Called from build_tourney_bracket( )
	//
	// ARGUMENTS
	// 	$tourney_id  - the tourney CPT ID (NOT the tourney slug)
	//	$games - a list of the tourney's game CPTs (objects) IN NUMERICAL ORDER
	//	$round_nbr - the round number STARTING AT ZERO
	//	$round_name - the round title
	//
	// RETURNS
	//	HTML for the tournament round's bracket (wrapped in a div) as a string
	//
	function build_round( $tourney_id, $games, $round_nbr, $round_name, $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_TABLE.build_round:' );
		//return "<p>Tourney (ID): $tourney_id, Round #: " . strval($round_nbr + 1) . ", Round Name: $round_name</p>"; 
		
		$ret_html = $this -> build_round_header( $round_nbr, $round_name );
		
		$rounds = get_post_meta( $tourney_id, 'rounds', true );
		
		$games = $this -> get_games_in_round( $games, $rounds, $round_nbr );
		
		//$ret_html .= '<ul class="round_games round_' . ( $round_nbr + 1 ) . '">';
		
		//if ( 0 == ( $round_nbr + 1 ) % 2 ) {
			//$ret_html .= '<div class="test-divider"></div>';
		//}
		
		foreach ( $games as $key => $value ) {
		
			$ret_html .= $this -> build_game_table_row( $key, $value, $atts );
	
			
		}
		
		return $ret_html;
		
	} //End: build_round( )
	
	//-----------------------------------------------------------------------------
	// build_round_header( ) - Builds a round header row in a tourney table 
	// 	Called from build_round( )
	//
	function build_round_header ( $round_nbr, $round_name ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_round_header:' );
		
		// Need to adjust colspan 
		$ret_html = '<thead><tr class="round_header"><td colspan=5>' . $round_name . '</td></tr>';
		
		//if ( 0 == $round_nbr ) {
		/*
			$ret_html .= '<tr class="table_headers">';
			$ret_html .= '<td class="nbr_title">' . __('#', 'mstw-bracket-builder') . '</td>';
			$ret_html .= '<td class="date_title">' . __('Date', 'mstw-bracket-builder') . '</td>';
			$ret_html .= '<td class="time_title">' . __('Time', 'mstw-bracket-builder') . '</td>';
			$ret_html .= '<td class="matchup_title">' . __('Matchup', 'mstw-bracket-builder') . '</td>';
			$ret_html .= '<td class="location_title">' . __('Location', 'mstw-bracket-builder') . '</td>';
		*/
		//}

                        $ret_html .= '<tr class="table_headers">';
                        $ret_html .= '<td class="nbr_title">' . __('試合番号', 'mstw-bracket-builder') . '</td>';
                        $ret_html .= '<td class="date_title">' . __('日付', 'mstw-bracket-builder') . '</td>';
                        $ret_html .= '<td class="time_title">' . __('時間', 'mstw-bracket-builder') . '</td>';
                        $ret_html .= '<td class="matchup_title">' . __('対戦カード', 'mstw-bracket-builder') . '</td>';
                        $ret_html .= '<td class="location_title">' . __('試合会場', 'mstw-bracket-builder') . '</td>';

			
		return $ret_html . '</thead>';
		
	} //End: build_round_header( )
	
	//-----------------------------------------------------------------------------
	// get_tourney_games( ) - Gets all the games in a tourney
	// 	Called from build_tourney_table( )
	//
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
	// get_games_in_round( ) - Get the games in a tournament round
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$games: a list of ALL the tourney's games (CPTs/objects) IN NUMERICAL ORDER
	//	$rounds: number of rounds in tourney
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
	// build_game_table_row( ) - Builds HTML for a row for the tournament 
	//	games table 
	// 	Called from build_round( )
	//
	// ARGUMENTS
	//	$game_nbr: game number 0 through 2**$nbr_rounds - 1
	//	$game:     the game CPT/object
	//
	// RETURNS
	//	HTML for a row in the table
	//
	function build_game_table_row( $game_nbr, $game, $atts ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_BRACKET.build_game_table_row:' );
		if ( $game_nbr == 1 ) 
			mstw_bb_log_msg( $atts );
		$ret_html = '<tr class="game game_' . $game_nbr . '">';
		
		$ret_html .= $this -> build_number_cell( $game_nbr, $game );
		$ret_html .= $this -> build_date_cell( $game_nbr, $game, $atts['date_format'] );
		$ret_html .= $this -> build_time_cell( $game_nbr, $game, $atts['time_format'], $atts['tba'] );
		$ret_html .= $this -> build_matchup_cell( $game_nbr, $game, $atts['team_format'] );
		$ret_html .= $this -> build_location_cell( $game_nbr, $game, $atts['location_format'] );
		
		$ret_html .= '</tr>';
		
		
		return $ret_html;
		
	} //End: build_game_table_row( )
	
	//-----------------------------------------------------------------------------
	// build_number_cell( ) - Builds the HTML for the game number cell 
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//
	// RETURNS
	//	HTML for the game number cell
	//
	function build_number_cell( $game_nbr, $game ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_TABLE.build_number_cell:' );
		
		return '<td class="game_nbr">' . ( $game_nbr + 1 ) . '</td>';
		
	} //End: build_number_cell( )
	
	//-----------------------------------------------------------------------------
	// build_date_cell( ) - Builds the HTML for the game date cell 
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//
	// RETURNS
	//	HTML for the game number cell
	//
	function build_date_cell( $game_nbr, $game, $date_format = 'D, j M Y' ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_TABLE.build_date_cell:' );
		
		$ret_html = '<td class="game_date">';
		$date_format = 'Y年n月j日(D)';
		$date_ja = array('月','火','水','木','金','土','日');
		$date_en = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
		$timestamp = get_post_meta( $game -> ID, 'dtg', true );
		$game_date = date($date_format, $timestamp);
		$game_date = str_replace($date_en,$date_ja,$game_date);
		$ret_html .= $game_date;
		
		return $ret_html . '</td>';
		
	} //End: build_date_cell( )
	
	//-----------------------------------------------------------------------------
	// build_time_cell( ) - Builds the HTML for the game time cell 
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//
	// RETURNS
	//	HTML for the game number cell
	//
	function build_time_cell( $game_nbr, $game, $time_format = 'H:i', $tba_string = 'TBA' ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_TABLE.build_time_cell:' );
		
		$ret_html = '<td class="game_time">';
		
		$time_is_tba = get_post_meta( $game->ID, 'time_is_tba', true );
		
		if ( $time_is_tba ) {
			$ret_html .= $tba_string;
			
		} else {
			$timestamp = get_post_meta( $game -> ID, 'dtg', true );
			$time_str = date( $time_format, $timestamp );
			$ret_html .= $time_str;
			
		}
		
		return $ret_html . '</td>';
		
	} //End: build_time_cell( )
	
	//-----------------------------------------------------------------------------
	// build_matchup_cell( ) - Builds the HTML for the matchup (teams) cell 
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//	$team_format: format for the team name
	//
	// RETURNS
	//	HTML for the game number cell
	//
	function build_matchup_cell( $game_nbr, $game, $team_format ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_TABLE.build_matchup_cell:' );
		
		$ret_html = '<td class="game_matchup">';
		
		// Use the specified team name if available
		$team_slug = get_post_meta( $game -> ID, 'home', true ); 
		if ( -1 != $team_slug && '' != $team_slug ) {
			$ret_html .= mstw_bb_build_team_name( $team_slug, $team_format );
			
		} else {
			// Else use the team text
			$ret_html .= get_post_meta( $game -> ID, 'home_text', true );
			
		}
		
		if ( get_post_meta( $game -> ID, 'is_final', true ) ) {
			$home_score = get_post_meta( $game -> ID, 'home_score', true );
			$away_score = get_post_meta( $game -> ID, 'away_score', true );
			
			$ret_html .= " $home_score - $away_score ";
			
		} else {
			$ret_html .= " vs ";
			
		}
		
		// Use the specified team name if available
		$team_slug = get_post_meta( $game -> ID, 'away', true );
		
		if ( -1 != $team_slug && '' != $team_slug ) {
			//true argument moves logo to the end of the string
			$ret_html .= mstw_bb_build_team_name( $team_slug, $team_format, true );
			
		} else {
			// Else use the team text
			$ret_html .= get_post_meta( $game -> ID, 'away_text', true );
			
		}
		
		return $ret_html;
		
	} //End: build_matchup_cell( )
	
	//-----------------------------------------------------------------------------
	// build_location_cell( ) - Builds the HTML for the location cell 
	//
	// ARGUMENTS
	//	$game_nbr - game number 0 through 2**$nbr_rounds - 1
	//	$game - the game CPT/object
	//
	// RETURNS
	//	HTML for the location cell
	//
	function build_location_cell( $game_nbr, $game, $location_format ) {
		//mstw_bb_log_msg( 'MSTW_TOURNEY_TABLE.build_location_cell:' );
		
		$ret_html = '<td class="game_date">';
		
		$ret_html .= mstw_bb_build_location_string( $game, $location_format );
		
		$ret_html .= '</td>';
		
		return $ret_html;
		
	} //End: build_location_cell( )
	
} //End: class MSTW_TOURNEY_TABLE

$tourney_table = new MSTW_TOURNEY_TABLE;

add_shortcode( 'mstw_tourney_table', array( $tourney_table, 'tourney_table_handler' ) );

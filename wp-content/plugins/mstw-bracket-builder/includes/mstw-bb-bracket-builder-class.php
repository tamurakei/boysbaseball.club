<?php
/* ------------------------------------------------------------------------
 * 	MSTW Bracket Builder Class
 *	UI for the MSTW Bracket Builder Plugin
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed AS IS in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *--------------------------------------------------------------------------*/
 
class MSTW_BB_BRACKET_BUILDER {
	
	//-------------------------------------------------------------
	//	edit_bracket_screen - builds the user interface for the 
	//		Edit Tournament admin screen
	//-------------------------------------------------------------
	function edit_bracket_screen( ) {
		//mstw_bb_log_msg( "MSTW_BB_BRACKET_BUILDER.edit_bracket_screen:" );
		?>
		
		<!-- For busy indicator
		<div class="progress-indicator">
			<img src="res/images/icon_loading_75x75.gif" alt="" />
		</div>
		-->
		<!-- begin main wrapper for page content -->
		<div class="wrap">
		
		<h1><?php _e( 'Edit Tournament', 'mstw-bracket-builder' )?></h1>
		
		<!--<p class='mstw-bb-admin-instructions'>
		 <?php //_e( 'Read the contextual help tab on the top right of this screen.', 'mstw-bracket-builder' ) ?> 
		</p>-->
		
		<?php
		// Check & cleanup the returned $_POST values
		$submit_value = $this->process_option( 'submit', 0, $_POST, false );
		
		//mstw_bb_log_msg( 'request method: ' . $_SERVER['REQUEST_METHOD'] );
		//mstw_bb_log_msg( '$_POST =' );
		//mstw_bb_log_msg( $_POST );
		
		//
		// We do the heavy lifting in the post( ) method
		//
		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$this->post( compact( 'submit_value' ) );
		}

		//
		// Heavy lifting done; now build the HTML UI/form
		//
		mstw_bb_admin_notice( );
				
		$current_tourney = mstw_bb_get_current_tourney( );
		//mstw_bb_log_msg( 'Current Tourney: ' . $current_tourney );
		
		if ( '' == $current_tourney ) {
			
		}
		
		$tourney_obj = get_page_by_path( $current_tourney, OBJECT, 'mstw_bb_tourney' );
		
		//$rounds = get_post_meta( $tourney_obj -> ID, 'rounds', true );
		
		//
		// Get the tourney's games, if there are any
		// Need this for post( ) to determine whether or not to create games (CPTs)
		// or just update existing games
		//
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'mstw_bb_game',
			'meta_query'       => array(
					array( 'key' => 'tournament',
					       'value' => $current_tourney
					     )
			        ),
			'order_by'         => 'meta_value_num',
			'meta_key'         => 'game_nbr',
			'order'            => 'ASC',
			// pull the right tournament
			// order the games by game #
			);
			
		$games = get_posts( $args );
		
		//mstw_bb_log_msg( "Games:" );
		//mstw_bb_log_msg( $games );
		
		?>
		<form id="bracket-builder" class="add:the-list: validate" method="post" enctype="multipart/form-data" action="">
		
			<input type="hidden" value="<?php echo count( $games ) ?>" name="games" id = "games" />
			<input type="hidden" value="Yes" name="are_you_sure" id = "are_you_sure" />
			
			<div class="alignleft actions mstw-bb-controls">
				<?php
				$tourneys = $this -> build_tourney_select( $current_tourney, 'bb-current-tourney' );
				//$ret = -1;
				if ( -1 == $tourneys ) { //No tourneys found
				?>
					<div class='mstw-bb-admin-instructions'>
					  <?php _e( 'Create a tournament before editting it.', 'mstw-bracket-builder' );?>
					</div>
				<?php
				} else {
					?>
					<a href="<?php  echo admin_url( 'admin.php?page=mstw-bb-edit-tournament' )?>" class="button mstw-bb-control-button"><?php _e( 'Update Tournament Table', 'mstw-bracket-builder' ) ?></a>
					
				<?php	
				}
				?>
 			</div> <!-- .leftalign actions -->
			 
			<table id="edit-tourneys" class="wp-list-table widefat auto striped posts" >
			
			  <?php 
			  $this -> build_tourneys_table_header( );
			  $this -> build_tourneys_table_body( $tourney_obj, $games );
			  ?>
			  
			  <!-- Submit button -->
			  <tbody>
			  <tr> 
			   <td colspan="2" class="submit">
			   <?php submit_button( __( 'Update Games', 'mstw-bracket-builder' ), 'primary', 'submit' ) ?>
			  </tr>
			  </tbody>
			  
			</table> 
		</form>		
		</div><!-- end wrap -->
		<!-- end of form HTML -->
	<?php
	} //End edit_bracket_screen()
	
	//-------------------------------------------------------------
	//	build_tourneys_table_header - builds tournament table header
	//
	function build_tourneys_table_header( ) {
		//mstw_bb_log_msg( 'build_tourneys_table_header:' );
		?>
		<thead>
		  
		  <tr>
		   <th><?php _e( 'Game', 'mstw-bracket-builder' ) ?></th>
		   <th><?php _e( 'Date', 'mstw-bracket-builder' ) ?></th>
		   <th><?php _e( 'Time', 'mstw-bracket-builder' ) ?></th>
		   <th><?php _e( 'Time TBA', 'mstw-bracket-builder' ) ?></th>
		   
		   <!--<th><?php //_e( 'Team A/Home', 'mstw-bracket-builder' ) ?></th>-->
		   <th></th>
		   <th><?php _e( 'Team A Text', 'mstw-bracket-builder' ) ?></th>
		   
		   <!--<th><?php //_e( 'Team B/Away', 'mstw-bracket-builder' ) ?></th>-->
		   <th></th>
		   <th><?php _e( 'Team B Text', 'mstw-bracket-builder' ) ?></th>
		   
		   <!--<th><?php //_e( 'Location', 'mstw-bracket-builder' ) ?></th>-->
		   <th></th>
		   <th><?php _e( 'Location Text', 'mstw-bracket-builder' ) ?></th>
		   
		   <th><?php _e( 'Period', 'mstw-bracket-builder' ) ?></th>
		   <th><?php _e( 'Time', 'mstw-bracket-builder' ) ?></th>
		   
		   <th><?php _e( 'Team A Score', 'mstw-bracket-builder' ) ?></th>
		   <th><?php _e( 'Team B Score', 'mstw-bracket-builder' ) ?></th>
		
		   <th><?php _e( 'Is Final', 'mstw-bracket-builder' ) ?></th>
		   
		  </tr>
		</thead>
					
		<?php
	} //End: build_tourneys_table_header( )
	
	//-------------------------------------------------------------
	//	build_tourneys_table_body - builds tournament table body for 
	//		$tourney (CPT Object)
	//
	function build_tourneys_table_body( $tourney, $games ) {
		//mstw_bb_log_msg( 'build_tourneys_table_body:' );
		//mstw_bb_log_msg( "Tourney:" ) ;
		//mstw_bb_log_msg( $tourney );
		//mstw_bb_log_msg( "Games:" );
		//mstw_bb_log_msg( $games );
		
		$cols = 15;
		
		$rounds = get_post_meta( $tourney -> ID, 'rounds', true );
		//mstw_bb_log_msg( $rounds );
		
		
		
		//
		// Get the tourney's teams, if there are any
		//
		/*
		$tourney_league = get_post_meta( $tourney -> ID, 'league', true );
		//mstw_bb_log_msg( "tourney league = " . $tourney_league );
		
		$args = array( 'numberposts'    => -1,
					   'post_type'      => 'mstw_lm_team',
					   'mstw_lm_league' => $tourney_league,
					   'meta_key'		=> 'team_name',
					   'orderby'        => 'meta_value',
					   'order' => 'ASC' 
					  );
				  
		$teams = get_posts( $args );
		
		$teams = null;
		*/
		//mstw_bb_log_msg( $teams );
		
		?>
		<tbody>
		  <?php 
		  $round_start_game = 0;
		  
		  for ( $i = 1; $i <= $rounds; $i++ ) {
			$this -> build_round_header_row( $i );
			
			$round_nbr_games = pow( 2, $rounds ) / pow( 2, $i );
			//mstw_bb_log_msg( " Round: $i Nbr Games: $round_nbr_games" );
			
			for ( $j = 1; $j <= $round_nbr_games; $j++ ) {
				//mstw_bb_log_msg( "game: $j" );
				$this -> build_table_row( $tourney, $teams, $games, $i, $j + $round_start_game );
			}
			
			$round_start_game += $round_nbr_games;
			
		  } 
		  ?>
		</tbody>
		
		<?php
		
	} //End: build_tourneys_table_body( )
	
	//-------------------------------------------------------------
	//	build_round_header_row - builds tournament table rows that
	//		separate rounds
	//
	function build_round_header_row( $rnd_nbr ) {
		// mstw_bb_log_msg( "build_round_header_row:" );
		// Want to add a setting for "Round"
		$cols = 15;
		?>
		<tr class='round-header'>
		  <td colspan=<?php echo $cols ?>>
		    <?php echo __( 'Round', 'mstw-bracket-builder') . " $rnd_nbr" ?>
		  </td>
		</tr>
		<?php
	} //End: build_round_header_row( )
	
	//-------------------------------------------------------------
	//	build_table_row - builds a tournament table row for the 
	//		$game_nbr of $round_nbr
	//
	function build_table_row( $tourney, $teams, $games, $round_nbr, $game_nbr ) {
		//mstw_bb_log_msg( "build_table_row: round=$round_nbr game=$game_nbr" );
		?>
		<tr> <!-- game <?php echo $game_nbr ?> -->
		  <td class="game-nbr">
		    <?php // post( ) uses the hidden field ?>
			<input type='hidden' id='game-nbr_<?php echo $round_nbr . '_' . $game_nbr?>' name='game-nbr_<?php echo $round_nbr . '_' . $game_nbr?>' value='<?php echo $game_nbr ?>' />
			<?php echo $game_nbr ?>
		  </td>
		  <?php 
		  $game = ( count( $games ) > 0 ) ? $games[ $game_nbr - 1 ] : null ;
		  
		  //mstw_bb_log_msg( 'game:' );
		  //mstw_bb_log_msg( $game );)
		  
		  $this -> build_date_cell( $game, $game_nbr  );
		  $this -> build_time_cell( $game, $game_nbr );
		  $this -> build_time_is_tba_cell( $game, $game_nbr );
		  
		  $this -> build_team_cell( $game, $game_nbr, 'home', $teams );
		  $this -> build_team_text_cell( $game, $game_nbr, 'home' );
		  
		  $this -> build_team_cell( $game, $game_nbr, 'away', $teams );
		  $this -> build_team_text_cell( $game, $game_nbr, 'away' );
		  
		  $this -> build_location_cell( $game, $game_nbr );
		  $this -> build_location_text_cell( $game, $game_nbr );
		  
		  $this -> build_period_cell( $game, $game_nbr );
		  $this -> build_time_remaining_cell( $game, $game_nbr );
		  
		  $this -> build_score_cell( $game, $game_nbr, 'home' );
		  $this -> build_score_cell( $game, $game_nbr, 'away' );
		  
		  $this -> build_is_final_cell( $game, $game_nbr );
		  ?>

		  
		</tr>
		<?php
		
	} //End: build_table_row( )
	
	//-------------------------------------------------------------
	//	build_date_cell - build a date cell (text)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_date_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_date_cell:" );
		$tag = "date_$game_nbr";
		
		if ( null === $game ) {
			$timestamp = current_time( 'timestamp' );
			$date_str = date( 'Y-m-d', $timestamp );
			
		} else {
			$timestamp = (int)get_post_meta( $game -> ID, 'dtg', true );
			$date_str = date( 'Y-m-d', (int)get_post_meta( $game -> ID, 'dtg', true ) );
			
		}
		
		?>
		<td>
		<input type='text' size=10 class='game-date' id='<?php echo $tag?>' name='<?php echo $tag?>' 
			value='<?php echo $date_str ?>' />
		</td>
		<?php
		
	} //End: build_date_cell( )
	
	//-------------------------------------------------------------
	//	build_time_cell - build a time cell (text)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_time_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_time_cell:" );
		$tag = "time_$game_nbr";
		
		if ( null === $game ) {
			$time_str = '12:00';
			
		} else {
			$time_str = date( 'H:i', (int)get_post_meta( $game -> ID, 'dtg', true ) );
			
		}
		
		?>
			<td>
			<input type='text' size=5 class='game-time' id='<?php echo $tag?>' name='<?php echo $tag?>' 
				value='<?php echo $time_str ?>' />
			</td>
		<?php
		
	} //End: build_time_cell( )
	
	//-------------------------------------------------------------
	//	build_time_cell - build a time cell (text)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_time_is_tba_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_time_is_tba_cell:" );
		$tag = "time_$game_nbr";
		
		$tag = "time_is_tba_$game_nbr";
		$value = ( null === $game ) ? 0 : get_post_meta( $game -> ID, "time_is_tba", true );
		$checked = checked( $value, 1, false );
		?>
			<td class="time-is-tba">
			<input type='checkbox' id='<?php echo $tag?>' name='<?php echo $tag?>' 
				value=1 <?php echo $checked ?>/> <!--value='<?php //echo $value ?>' /> -->
			</td>
		<?php
		
	} //End: build_time_is_tba_cell( )
	
	//-------------------------------------------------------------
	//	build_team_cell - build a team cell (select-option)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//		$is_home: indicates 'home' or 'away' team
	//
	function build_team_cell( $game, $game_nbr, $is_home = 'home', $teams = null ) {
		//mstw_bb_log_msg( "build_team_cell:" );
		$team = ( 'home' == $is_home ) ? 'home' : 'away';
		$tag = $is_home . "_". $game_nbr;
		$value = ( null === $game ) ? -1 : get_post_meta( $game -> ID, $is_home, true );
		
		?>
		<td>
		  <input type="hidden" name="<?php echo $tag ?>" id="<?php echo $tag ?>" value="<?php echo $value ?>" />
		  <?php /*
		  <select name="<?php echo $tag ?>" id="<?php echo $tag ?>">
			<option value='-1' <?php selected( $value, -1 );  ?>>----</option>
			<?php
			if ( null !== $teams ) {
				foreach ( $teams as $team ) {
					$selected = selected( $value, $team -> post_name );
					?>
					<option value="<?php echo $team->post_name ?>" <?php echo $selected ?>>
					  <?php echo $team->post_title ?>
					</option>
				<?php		
				} //End: foreach ( $teams as $team )
			} //End: if ( null !== $teams )
			?>
		  </select>
		  */ ?>
		</td>
		
	<?php	
	} //End: build_team_cell( )
	
	//-------------------------------------------------------------
	//	build_team_text_cell - build a team text cell (text)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//		$is_home: indicates 'home' or 'away' team
	//
	function build_team_text_cell( $game, $game_nbr, $is_home = 'home' ) {
		//mstw_bb_log_msg( "build_team_text_cell:" );
		$team = ( 'home' == $is_home ) ? 'home' : 'away';
		$tag = $is_home . "_text_" . $game_nbr;
		$data = $is_home . "_text";
		$value = ( null === $game ) ? -1 : get_post_meta( $game -> ID, $data, true );
		$value = ( '' == $value ) ? -1 : $value;
		?>
		<td>
			<input type='text' size='16' id='<?php echo $tag?>' name='<?php echo $tag?>' value='<?php echo $value ?>' />
		</td>
		<?php
		
	} //End: build_team_text_cell( )
	
	//-------------------------------------------------------------
	//	build_location_cell - build a location cell (select-option control)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_location_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_location_cell:" );
		$tag = "loc_$game_nbr";
		$value = ( null === $game ) ? -1 : get_post_meta( $game -> ID, 'location', true );
		$value = ( '' == $value ) ? -1 : $value;
		?>
			<td>
			  <input type="hidden" name="<?php echo $tag ?>" id="<?php echo $tag ?>" value="<?php echo $value ?>" />
			  
			  <?php /*
			  mstw_lm_build_venues_control( $value, $tag ) ?>
			<!-- <input type='text' id='<?php //echo $tag?>' name='<?php //echo $tag?>' 
				value='<?php //echo $value ?>' /> -->
			*/ ?>
			</td>
		<?php
		
	} //End: build_location_cell( )
	
	//-------------------------------------------------------------
	//	build_location_text_cell - build a location text cell (text control)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_location_text_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_location_text_cell:" );
		$tag = "loc_text_$game_nbr";
		$value = ( null === $game ) ? '' : get_post_meta( $game -> ID, 'location_text', true );
		?>
		<td>
		  <input type='text' size='16' id='<?php echo $tag?>' name='<?php echo $tag?>' 
			value='<?php echo $value ?>' />
		</td>
		<?php
		
	} //End: build_location_text_cell( )
	
	//-------------------------------------------------------------
	//	build_score_cell - build a team score cell (text)
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//		$is_home: indicates 'home' or 'away' team
	//
	function build_score_cell( $game, $game_nbr, $is_home = 'home' ) {
		//mstw_bb_log_msg( "build_score_cell:" );
		$team = ( 'home' == $is_home ) ? 'home' : 'away';
		$tag = $is_home . "_score_" . $game_nbr;
		$data = $is_home . "_score";
		$value = ( null === $game ) ? '' : get_post_meta( $game -> ID, $data, true );
		?>
			<td>
			<input size="4" type='text' id='<?php echo $tag?>' name='<?php echo $tag?>' 
				value='<?php echo $value ?>' />
			</td>
		<?php
		
	} //End: build_score_cell( )
	
	//-------------------------------------------------------------
	//	build_period_cell - build a game period cell
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_period_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_period_cell:" );
		$tag = "period_$game_nbr";
		$value = ( null === $game ) ? '' : get_post_meta( $game -> ID, "period", true );
		?>
			<td>
			<input type='text' size='4' id='<?php echo $tag?>' name='<?php echo $tag?>' 
				value='<?php echo $value ?>' />
			</td>
		<?php
		
	} //End: build_period_cell( )
	
	//-------------------------------------------------------------
	//	build_time_remaining_cell - build a game time remaining cell
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_time_remaining_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_period_cell:" );
		$tag = "time_remaining_$game_nbr";
		$value = '';
		$value = ( null === $game ) ? '' : get_post_meta( $game -> ID, "time_remaining", true );
		?>
		<td>
		  <input type='text' class='time-remaining' size='6' id='<?php echo $tag?>' name='<?php echo $tag ?>' value='<?php echo $value ?>' />
		</td>
		<?php
		
	} //End: build_time_remaining_cell( )
	
	//-------------------------------------------------------------
	//	build_is_final_cell - build a game is final cell
	//		$game: mstw_bb_game CPT or null
	//		$game_nbr: used for HTML control name and ID
	//
	function build_is_final_cell( $game, $game_nbr ) {
		//mstw_bb_log_msg( "build_is_final_cell:" );
		$tag = "is_final_$game_nbr";
		$value = ( null === $game ) ? 0 : get_post_meta( $game -> ID, "is_final", true );
		$checked = checked( $value, 1, false );
		//mstw_bb_log_msg( "game: " . $game->ID . " is_final: $value, checked: $checked" );
		?>
			<td class="is-final">
			<input type='checkbox' id='<?php echo $tag?>' name='<?php echo $tag?>' 
				value=1 <?php echo $checked ?>/> <!--value='<?php //echo $value ?>' /> -->
			</td>
		<?php
		
	} //End: build_is_final_cell( )
	
	//-------------------------------------------------------------
	// post - handles POST submissions - this is the heavy lifting
	//-------------------------------------------------------------
	function post( $options ) {
		//mstw_bb_log_msg( 'MSTW_BB_SCHEDULE_BUILDER.post:' );
		//mstw_bb_log_msg( $options );
		//mstw_bb_log_msg( $_FILES );
		//mstw_bb_log_msg( $_POST );
		
		if ( !$options ) {
			//mstw_bb_add_admin_notice( 'error', __( 'Problem encountered. Exiting.', 'mstw-bracket-builder' ) );
			mstw_bb_log_msg( 'Houston, we have a problem in MSTW League Manger - CSV Import ... no $options' );
			return;
		}
		
		/*
		 *  THIS IS FOR DEBUGGING
		 */
		//return;
		
		switch( $options['submit_value'] ) {
			
			case __( 'Update Games', 'mstw-bracket-builder' ):
				mstw_bb_log_msg( 'Updating Games ...' );
				if ( !array_key_exists( 'games', $_POST ) or !array_key_exists( 'bb-current-tourney', $_POST )) {
					mstw_bb_log_msg( 'Oops! No games or tourney field?? ' );
					mstw_bb_add_admin_notice( 'error',  __( 'No games updated. Did any data change?', 'mstw-bracket-builder' ) );
					
				} else {
					$nbr_games = $_POST['games'];
					//mstw_bb_log_msg( 'Existing games: ' . $nbr_games );
					
					// Count for admin message
					$nbr_updated = 0; 
					
					while ( $element = each( $_POST ) ) {
						//mstw_bb_log_msg( 'element: ' );
						//mstw_bb_log_msg( 'value = ' . $element['value'] );
						//mstw_bb_log_msg( 'key = ' . $element['key'] );
						$pos = strpos( $element['key'], 'game-nbr' );
						
						if ( false !== $pos ) {
							// $game_meta is passed to update_game( )
							$game_meta = array( );
							
							// Get the game number
							$us_pos = strrpos( $element['key'], '_' );
							$game_nbr = substr( $element['key'], $us_pos + 1 );
							//mstw_bb_log_msg( "Found game: $game_nbr" );
							
							// Get the round number
							$str = substr( $element['key'], 0, $us_pos );
							//mstw_bb_log_msg( "Round string: $str" );
							$us_pos = strrpos( $str, '_' );
							//$round_nbr = substr( $str, $us_pos + 1 );
							//mstw_bb_log_msg( "Round #: $round_nbr" );
							
							// Get date and time
							$element = each( $_POST );
							//$game_date = $element['value'];
							//mstw_bb_log_msg( "Game Date: $game_date" );
							$game_meta['date'] = $element['value'];
							
							// Get the game time
							$element = each( $_POST );
							//$game_time = $element['value'];
							//mstw_bb_log_msg( "Game Time: $game_time" );
							$game_meta['time'] = $element['value'];
							
							// Gotta be careful here time_is_tba is a checkbox
							// so we'll either get the time_is_tba or home team
							$element = each( $_POST );
							if ( false === strpos( $element['key'], 'tba' ) ) {
								// tba not there, so add it and add element, which is home
								$game_meta['time_is_tba'] = 0;
								$game_meta['home'] = $element['value'];
								
							} else {
								// update time_is_tba, then grab the home element
								$game_meta['time_is_tba'] = 1;
								// Get home team (slug)
								$element = each( $_POST );
								//$home = $element['value'];
								//mstw_bb_log_msg( "Home Team: $home" );
								$game_meta['home'] = $element['value'];
								
							}
							
							// Get home team (text)
							$element = each( $_POST );
							//$home_text = $element['value'];
							//mstw_bb_log_msg( "Home Team Text: $home_text" ); 
							$game_meta['home_text'] = $element['value'];
							
							// Get away team (slug)
							$element = each( $_POST );
							//$away = $element['value'];
							//mstw_bb_log_msg( "Home Team: $away" ); 
							$game_meta['away'] = $element['value'];
							
							// Get away team (text)
							$element = each( $_POST );
							//$away_text = $element['value'];
							//mstw_bb_log_msg( "Home Team Text: $away_text" );
							$game_meta['away_text'] = $element['value'];

							// Get location (slug)
							$element = each( $_POST );
							//$location = $element['value'];
							//mstw_bb_log_msg( "Location: $location" );
							$game_meta['location'] = $element['value'];

							// Get location (text)
							$element = each( $_POST );
							//$location_text = $element['value'];
							//mstw_bb_log_msg( "Location Text: $location_text" );
							$game_meta['location_text'] = $element['value'];
							
							// Get game period
							$element = each( $_POST );
							//$game_period = $element['value'];
							//mstw_bb_log_msg( "Game Period: $game_period" );
							$game_meta['period'] = $element['value'];
							
							// Get time remaining
							$element = each( $_POST );
							//$time_remaining = $element['value'];
							//mstw_bb_log_msg( "Time Remaining: $time_remaining" );
							$game_meta['time_remaining'] = $element['value'];
							
							// Get home (team A) score
							$element = each( $_POST );
							//$home_score = $element['value'];
							//mstw_bb_log_msg( "Home Score: $home_score" );
							$game_meta['home_score'] = $element['value'];
							
							// Get away (team B) score
							$element = each( $_POST );
							//$away_score = $element['value'];
							//mstw_bb_log_msg( "Away Score: $away_score" );
							$game_meta['away_score'] = $element['value'];
							
							// Special handling for Is Final 
							$is_final = ( array_key_exists( 'is_final_' . $game_nbr, $_POST ) ) ? 1 : 0;
							//mstw_bb_log_msg( "Game Is Final: $is_final" );
							$game_meta['is_final'] = $is_final;
							
							//mstw_bb_log_msg( "Game Data:" );
							//mstw_bb_log_msg( $game_meta );
							//return;

							if ( 0 == $nbr_games ) {
								// Games don't exist, create them before updating them
								$game_id = $this -> create_game( $_POST['bb-current-tourney'], $game_nbr, $round_nbr );
								if ( $game_id > 0 ) {
									$this -> update_game( $game_id, $game_meta );
									$nbr_updated++;
									
								} else {
									mstw_bb_log_msg( $_POST['bb-current-tourney'] . ": error creating game $game_nbr" );
									
								}
								
							} else {
								// Games exist, update them
								$game_slug = $_POST['bb-current-tourney'] . "-" . $game_nbr;
								$game_obj = get_page_by_path( $game_slug, OBJECT, 'mstw_bb_game' );
								if ( $game_obj ) {
									$this -> update_game( $game_obj -> ID, $game_meta );
									$nbr_updated++;
								} else {
									mstw_bb_log_msg( "Error: can't find game $game_slug" );
									
								}	
							}
							
						} // End: if ( false !== $pos )
							
					} // End: while ( $element = each( $_POST ) )
					
					if( $nbr_updated > 0 ) {
						mstw_bb_add_admin_notice( 'updated', sprintf( __( '%s games updated.', 'mstw-bracket-builder' ), $nbr_updated ) );
						
					} else {
						mstw_bb_add_admin_notice( 'error', __( 'No games updated.', 'mstw-bracket-builder' ) );
					}
					
				} // End if-then for current tourney
				
				break;
			
			default:
				mstw_bb_log_msg( 'Error encountered in post() method. $submit_value = ' . $submit_value . '. Exiting' );
				break;
		}

	} //End: post( )
	
	//-------------------------------------------------------------
	//	create_game - creates a new game CPT
	//
	// ARGUMENTS:
	//	$tourney_slug: tournament slug
	//	$game_nbr: game number
	//	$rnd_nbr: round number
	//  $bracket: tournament bracket ( 1=winners, 2=losers ) defaults to 1
	//
	//	Game title will be "[Tournament Name] Game [Game #]"
	//	Game slug will be "$tourney_slug_$game_nbr]"
	//	 
	// RETURNS:
	//	$game_id if new game CPT is created, or 0 on failure
	//	 
	//
	function create_game ( $tourney_slug, $game_nbr, $rnd_nbr, $bracket=1 ) {
		//mstw_bb_log_msg( "create_game: Tourney: $tourney_slug, Game: $game_nbr, Round: $rnd_nbr, Bracket: $bracket" );
		
		$game_slug = $tourney_slug . '-' . $game_nbr;
		
		$tourney_obj = get_page_by_path( $tourney_slug, OBJECT, 'mstw_bb_tourney' );
		
		if ( null === $tourney_obj ) {
			mstw_bb_log_msg( "Oops! No CPT found for slug: $tourney_slug" );
			return -1;
		}
		
		$game_title = get_the_title( $tourney_obj ) . ' Game ' . $game_nbr;
		
		//mstw_bb_log_msg( "create game with title: $game_title and slug: $game_slug" );
		
		if( has_action('save_post_mstw_bb_game') ) {
			mstw_bb_log_msg( "Have a save_post_mstw_bb_game action. Hummm ..." );
			return 0;
			
		} else {
			//mstw_bb_log_msg( "No save_post_mstw_bb_game action ... shouldn't be." );
			
			$game_args = array( 'post_title'  => $game_title,
								'post_type'   => 'mstw_bb_game',
								'post_status' => 'publish',
								'post_name'   => $game_slug,
							  );
						
			$game_id = wp_insert_post( $game_args );
			
			if ( $game_id > 0 ) {
				
				update_post_meta( $game_id, 'game_nbr', $game_nbr );
				update_post_meta( $game_id, 'round_nbr', $rnd_nbr );
				update_post_meta( $game_id, 'tournament', $tourney_slug );
				update_post_meta( $game_id, 'bracket', $bracket );
				
			}
			
			return $game_id; // return zero on insert failure
			
		}
		
	} //End: create_game( )
	
	//-------------------------------------------------------------
	//	update_game - updates a games meta data
	//
	// ARGUMENTS:
	//	$game_id: ID of game to update
	//	$game_meta: meta data to update
	//	  
	// RETURNS:
	//	 
	//
	function update_game ( $game_id, $game_meta ) {
		//mstw_bb_log_msg( 'MSTW_BB_BRACKET_BUILDER.update_game' );
		//mstw_bb_log_msg( "Game meta data: " );
		//mstw_bb_log_msg( $game_meta );
		
		foreach ( $game_meta as $key => $value ) {
			switch ( $key ) {
				// date and time have to be combined as a timestamp
				case 'date': 
					$dtg = strtotime( $game_meta['date'] . ' ' . $game_meta['time'] );
					if ( false != $dtg ) {
						
						update_post_meta( $game_id, 'dtg', $dtg );
					}
					
					break;
					
				case 'time':
					break;
					
				case 'home':
					/*
					$game_nbr = get_post_meta( $game_id, 'home', true );
					if ( 1 == $game_nbr ) {
						update_post_meta( $game_id, 'home', 'cal-bears' );
						update_post_meta( $game_id, 'away', 'oregon-ducks' );
						
					} else if ( 2 == $game_nbr ) {
						update_post_meta( $game_id, 'home', 'stanford-cardinal' );
						update_post_meta( $game_id, 'away', 'osu-beavers' );
						
					}
					*/
					//break;
				case 'away':
					//break;
					
				case 'location':
					update_post_meta( $game_id, $key, $value );
					//mstw_bb_log_msg( "$game_id $key $value" );
					/*
					$game_nbr = get_post_meta( $game_id, 'game_nbr', true );
					if ( 1 == $game_nbr ) {
						update_post_meta( $game_id, 'location', 'california-memorial-stadium' );
						
					} else if ( 2 == $game_nbr ) {
						update_post_meta( $game_id, 'location', 'stanford-stadium' );
						
					} else if ( 5 == $game_nbr ) {
						update_post_meta( $game_id, 'location', 'levis-stadium' );
						
					}
					*/
					//break;
					
				// the rest are straightforward
				default:
					update_post_meta( $game_id, $key, $value );
					//if ( 'is_final' == $key  or 'time_is_tba' == $key ){
					//	mstw_bb_log_msg( "update $game_id key: $key, value: $value" );
					//}
					break;
				
			} //End: switch
			
		} //End: foreach
		
	} //End: update_game( )
	
	//-------------------------------------------------------------------------
	// build_tourney_select - builds a select-option control for tourneys 
	//
	//	ARGUMENTS: 
	//	  $current_tourney: tourney that will be selected
	//	  $css_tag: name & id attribute of control
	//
	//	RETURNS:
	//	  Outputs the HTML control and returns the number of tourneys found
	//	  Otherwise, returns -1 if no tourneys are found
	//
	function build_tourney_select( $current_tourney, $css_tag = '' ) {
		//mstw_bb_log_msg( 'build_tourney_select' );
		$tourney_list = $this -> build_tourney_list( );
		if ( $tourney_list ) {
			//mstw_bb_log_msg( "tourney list:" );
			//mstw_bb_log_msg( $tourney_list );
			?>
			<select name='<?php echo $css_tag ?>' id='<?php echo $css_tag ?>' >
			<?php
			foreach ( $tourney_list as $slug => $name ) {
				$selected = selected( $slug, $current_tourney, false );
				?>
				<option value=<?php echo "$slug $selected" ?>><?php echo $name ?> </option>
			<?php		
			}
			?>
			</select>
			
			<?php
			return count( $tourney_list );
			
		}
		else {
			return -1;
		}
		
	} //End: build_tourney_select( )
	
	//-------------------------------------------------------------------------
	// build_tourney_list - creates list of tourneys 
	//
	//	ARGUMENTS: 
	//	  None
	//
	//	RETURNS:
	//	  Associative array of tourneys in slug => name format, 
	//	  or '' if no tourneys exist
	//
	function build_tourney_list( ) {
		//mstw_bb_log_msg( 'build_tourney_list' );
		
		$args = array (
			'posts_per_page'   => -1,
			'post_type'        => 'mstw_bb_tourney',
			'order_by'         => 'title',
			);
			
		$tourneys = get_posts( $args );
		
		if ( $tourneys ) {
			$tourney_list = array( );
			
			foreach ( $tourneys as $tourney ) {
				$tourney_list[ $tourney -> post_name ] = get_the_title( $tourney );	
			}
			
			return $tourney_list;
			
		} else {
			
			mstw_bb_log_msg( 'build_tourney_list: no tourneys found' );
			return '';
		}
		
	} //End: build_tourney_list( )
	
	//-------------------------------------------------------------
	// quick_start_screen - outputs HTML for Quick Start screen
	//-------------------------------------------------------------
	function quick_start_screen( ) {
		//mstw_bb_log_msg( "quick_start_screen:" );
		?>
		
		<div class="wrap">
		<h2>Bracket Builder - Quick Start</h2>
		<p>The MSTW Bracket Builder plugin creates, manages, and displays multiple tournaments. Shortcodes are available to display brackets (knockout rounds), and tables of games (fixtures). The front end displays can be formatted via shortcode arguments, and the plugin’s stylesheet.

		Two shortcodes for front end displays are currently available – tournament brackets and tournament game tables. See <a href="http://shoalsummitsolutions.com/bb-shortcodes/" target="_blank">the Shortcodes man page</a> for information on using these shortcodes, and <a href="http://dev.shoalsummitsolutions.com/league-manager/" target="_blank">the MSTW Dev Site</a> for examples of these shortcodes.
		</p>
		
		<h3>Getting Started</h3>
		<p>The following steps will get Bracket Builder up and running quickly.</p>
		<ol>
		<li><a href="<?php echo admin_url( '/edit.php?post_type=mstw_bb_tourney' ) ?>">TOURNAMENTS</a>. Add at least one tournament on the Tournaments screen.<br/>
		Provide a title (you can edit the slug, which will be used in the shortcodes) and set the parameters as desired.
		</li>
		<li><a href="<?php echo admin_url( '/admin.php?page=mstw-bb-edit-tournament' ) ?>">EDIT TOURNAMENT</a>.Select a Tournament, press the "Update Tournament Table" button, then add the information for the tournament's games.</li>
		</ol>
		
		<p>That’s basically it. You can now display the tournament(s) on the front end of your site using <a href="http://shoalsummitsolutions.com/bb-shortcodes/" target="_blank">the MSTW Bracket Builder shortcodes.</a>.</p>
		
		</div>
		
	<?php	
	} //End: quick_start_screen( )
	
	//-------------------------------------------------------------
	// process_option - checks/cleans up the $_POST values
	//-------------------------------------------------------------
	function process_option( $name, $default, $params, $is_checkbox ) {
		//checkboxes which if unchecked do not return values in $_POST
		if ( $is_checkbox and !array_key_exists( $name, $params ) ) {
			$params[ $name ] = $default;	
		}
		
		if ( array_key_exists( $name, $params ) ) {
			$value = stripslashes( $params[ $name ] );
			
		} elseif ( $is_checkbox ) {
			//deal with unchecked checkbox value
		
		} else {
			$value = null;
		}
		
		return $value;
		
	} //End function process_option()
	
} //End: class MSTW_BB_bracket_BUILDER
?>
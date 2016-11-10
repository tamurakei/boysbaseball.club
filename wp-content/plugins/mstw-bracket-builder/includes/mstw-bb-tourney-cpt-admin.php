<?php
/*----------------------------------------------------------------------------
 * mstw-bb-tourney-cpt-admin.php
 *	Handles the admin screen(s) for the mstw_bb_tourney CPT.
 *	It is loaded conditioned from the admin_init hook. 
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed AS IS in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *--------------------------------------------------------------------------*/

//-----------------------------------------------------------------
// Add the meta boxes for the mstw_bb_tourney custom post type
//
add_action( 'add_meta_boxes_mstw_bb_tourney', 'mstw_bb_tourney_metaboxes' );

function mstw_bb_tourney_metaboxes( ) {
	//mstw_bb_log_msg( 'mstw_bb_tourney_metaboxes:' );
	
	//mstw_bb_admin_notice( );
	
	//
	// Removes the league taxonomy meta box from the sidebar
	//
	//remove_meta_box( 'mstw_bb_leaguediv', 'mstw_bb_game', 'side');
	
	/*add_meta_box( 'mstw-bb-tourney-data-help', 
				  __( 'Add/Edit Game Help', 'mstw-bracket-builder' ), 
				  'mstw_bb_game_data_help_metabox', 
				  'mstw_bb_tourney', 
				  'normal', 
				  'high', 
				  null );*/
				  
	add_meta_box( 'mstw-bb-tourney-data', 
				  __( 'Tournament Data', 'mstw-bracket-builder' ), 
				  'mstw_bb_tourney_data_metabox', 
				  'mstw_bb_tourney', 
				  'normal', 
				  'high', 
				  null );
				  
					
} //End: mstw_bb_tourney_metaboxes( )

//-----------------------------------------------------------------
// Build the HELP meta box for the Add/Edit Tournament screen
//
function mstw_bb_tourney_data_help_metabox( $post ) {
	?>
	<p class='mstw-bb-admin-instructions'><?php _e( 'To quickly add games to a league schedule, use the Add Games screen, or CSV Import games. You can quickly update all games in a league using the Update screen. This screen provides finer control of individual games (which you may or may not ever need!) You can hide this information using the arrow at the top right.', 'mstw-bracket-builder' ) ?></p>
	
	<p class='mstw-bb-admin-instructions'><?php _e( 'See the', 'mstw-bracket-builder') ?> <a href="http://shoalsummitsolutions.com/lm-edit-game" target="_blank"><?php _e( 'Edit Game man page', 'mstw-bracket-builder' ) ?></a> <?php _e( 'for more information.', 'mstw-bracket-builder') ?></p>
	
	
	<h2>Game Data</h2>
	<ul class='mstw-bb-admin-instructions'>
	<li><?php _e( 'The game title does not appear on the front end displays. It is used to create the default game slug, and can help with searching and sorting on the All Games admin screen. Choose wisely.', 'mstw-bracket-builder' ) ?></li>
	<li><?php _e( 'If you change the Nonleague Game checkbox, the teams lists will be changed to display ALL teams in the database. Changing this setting may cause the Home and Visiting Team selections to change.', 'mstw-bracket-builder' ) ?></li>
	</ul>
	
	<h2>Game Status</h2>
	<ul class='mstw-bb-admin-instructions'>
	<li> <?php _e( 'This section is for the game status, or the game final results if the "Game Is Final" box is checked. It appears on the league scoreboard and single game displays.', 'mstw-bracket-builder' ) ?></li>
	<li><?php _e( 'If the "Game Is Open" checkbox is checked, the game status will be available for public updates. Games may be opened and closed for public updates automatically based on the plugin Settings. If the "Game Is Final" box is checked, the game is closed to further public updates.', 'mstw-bracket-builder' ) ?></li>
	</ul>
	
	<?php
	
}
//-----------------------------------------------------------------
// Build the meta box (controls) for the Games custom post type
//
function mstw_bb_tourney_data_metabox( $post ) {
	//mstw_bb_log_msg( 'mstw_bb_tourney_data_metabox:' );
	
	wp_nonce_field( plugins_url(__FILE__), 'mstw_bb_tourney_nonce' );
	
	//$options = wp_parse_args( get_option( 'mstw_bb_options' ),  mstw_bb_get_defaults( ) );
	
	//mstw_bb_set_current_league( 'pac-12' );
	
	// Retrieve the metadata values if they exist
	//$league = get_post_meta( $post->ID, 'league', true );
	// Not sure we need this //
	//$season = get_post_meta( $post->ID, 'season', true );
	
	$rounds = get_post_meta( $post->ID, 'rounds', true );
	
	$round_names = get_post_meta( $post->ID, 'round_names', true );
	
	if ( '' == $round_names ) {
		$round_names = array( );
		for ( $i = 1; $i < 7; $i++ ) {
			$round_names[] = sprintf( __( 'Round %s ' , 'mstw-bracket-builder' ), $i );
		}
	}
	
	$elimination = get_post_meta( $post->ID, 'elimination', true );
	
	$has_consolation = get_post_meta( $post->ID, 'has_consolation', true );
	
	$scheduling_method = get_post_meta( $post->ID, 'scheduling_method', true );
	
	$location_group = get_post_meta( $post->ID, 'location_group', true );
	
	
	//$game_media_link = get_post_meta( $post->ID, 'game_media_link', true );
	//$game_nonleague = get_post_meta( $post->ID, 'game_nonleague', true );
	
	/*if( '' == $league ) {
		// NEW POST
		$league = mstw_lm_get_current_league( );
		
		$season = mstw_lm_get_league_current_season( $league );
		
		//mstw_bb_log_msg( "mstw_lm_game_data_metabox: new game with league= $game_league, season= $season" );
		
	}
	*/
	?>
	
   <table class="form-table mstw-bb-admin-table">
	<!-- Row 1: League, Season -->
	<tr valign="top">
		<th scope="row"><label for="league" ><?php _e( 'Teams (League):', 'mstw-bracket-builder' ); ?></label></th>
		
		<td>
		  <?php 
		  /*
		  if( function_exists( 'mstw_lm_build_league_select' ) ) { 
			mstw_lm_build_league_select( $league, 'league' ); ?>
			<br/><span class="description"><?php _e( 'The selected league from MSTW League Manager provides the teams for the tournament.', 'mstw-bracket-builder' ) ?></span>
		  <?php
		  }
		  else {
			  */
			  ?>
			  <input type="hidden" name="league" id="league" value="-1" />
			  <span class="description"><?php _e( 'Not available in this release.', 'mstw-bracket-builder' ) ?></span>
			  <?php //_e( 'Install the MSTW League Manager plugin to access this function.', 'mstw-bracket-builder' ) ?>
		  <?php	
		  //}
		  ?>
		  
		</td>	
	</tr>
	
	<!-- Row 2: # rounds -->
	<tr valign="top">
	 <th scope="row"><label for="rounds" >
	  <?php _e( '# of rounds:', 'mstw-bracket-builder' ) ?></label>
	 </th>
	 <td>
	  <select name="rounds" id="rounds">
		<option value=2 <?php selected( $rounds, 2 )?>><?php _e( '2 (4 teams)', 'mstw-bracket-builder' ) ?></option>
		<option value=3 <?php selected( $rounds, 3 )?>><?php _e( '3 (8 teams)', 'mstw-bracket-builder' ) ?></option>
		<option value=4 <?php selected( $rounds, 4 )?>><?php _e( '4 (16 teams)', 'mstw-bracket-builder' ) ?></option>
		<option value=5 <?php selected( $rounds, 5 )?>><?php _e( '5 (32 teams)', 'mstw-bracket-builder' ) ?></option>
		<option value=6 <?php selected( $rounds, 6 )?>><?php _e( '6 (64 teams)', 'mstw-bracket-builder' ) ?></option>
	  </select>
	  <br/><span class="description"><?php _e( 'The number of rounds defines the maximum number of teams in the tournament. 32 and 64 team tournaments are available in the premium version.', 'mstw-bracket-builder' ) ?></span>
	 </td>
	</tr>
	
	<!-- Row 3: Single or Double Elimination -->
	<tr valign="top">
	 <th scope="row"><label for="elimination" >
	  <?php _e( 'Single or Double Elimination:', 'mstw-bracket-builder' ) ?></label>
	 </th>
	 <td>
	  <select name="elimination" id="elimination">
		<option value=1 <?php selected( $elimination, 1 )?>><?php _e( 'Single', 'mstw-bracket-builder' ) ?></option>
		<option value=2 disabled <?php selected( $elimination, 2 )?>><?php _e( 'Double', 'mstw-bracket-builder' ) ?></option>
	  </select>
	  <br/><span class="description"><?php _e( 'Double elimination tournaments are available in the premium version.', 'mstw-bracket-builder' ) ?></span>
	 </td>
	</tr>
	
	<!-- Row 4: Has consolation game -->
	<tr valign="top">
		<th scope="row"><label for="has_consolation" ><?php _e( 'Add Consolation Game:', 'mstw-bracket-builder' ) ?></label></th>
		<td><input type='checkbox' name="has_consolation" id="has_consolation" value=1 <?php checked( $has_consolation, 1, true ) ?> />
			<br/><span class="description"><?php _e( 'Check if tournament has a consolation game for third place. Consolation games are available in the premium version. ', 'mstw-bracket-builder' ) ?></span>
		</td>
	</tr>
	
	<!-- Row 5: Scheduling Method -->
	<tr valign="top">
	 <th scope="row"><label for="scheduling_method" >
	  <?php _e( 'Scheduling Method:', 'mstw-bracket-builder' ) ?></label>
	 </th>
	 <td>
	  <select name="scheduling_method" id="scheduling_method">
		<option value='manual' <?php selected( 'manual', $scheduling_method ) ?>><?php echo __( 'Manual', 'mstw-bracket-builder' ) ?></option>
		<option value='seed' disabled <?php selected( 'seed', $scheduling_method ) ?>><?php echo __( 'Seed by Rank', 'mstw-bracket-builder' ) ?></option>
		<option value='random' disabled <?php selected( 'random', $scheduling_method ) ?>><?php echo __( 'Random Seed', 'mstw-bracket-builder' ) ?></option>
	  </select>
	  <br/><span class="description"><?php _e( 'Scheduling by seed and randomly are available in the premium version.', 'mstw-bracket-builder' ) ?></span>
	 </td>
	</tr>
	
	<tr>
	   <th>Round Names:</th>
	   <td>
	    Round 1: <input type=text name="round_1_name" id="round_1_name" value="<?php echo$round_names[0] ?>" /><br/>
	    Round 2: <input type=text name="round_2_name" id="round_2_name" value="<?php echo$round_names[1] ?>" /><br/>
	    Round 3: <input type=text name="round_3_name" id="round_3_name" value="<?php echo$round_names[2] ?>" /><br/>
	    Round 4: <input type=text name="round_4_name" id="round_4_name" value="<?php echo$round_names[3] ?>" /><br/>
	    Round 5: <input type=text name="round_5_name" id="round_5_name" value="<?php echo$round_names[4] ?>" /><br/>
	    Round 6: <input type=text name="round_6_name" id="round_6_name" value="<?php echo$round_names[5] ?>" />
	   </td>
	  </tr>

	 </table>
	
<?php        	
} //End: mstw_bb_game_data_metabox()

//-----------------------------------------------------------
//	mstw_bb_build_teams_list - Build (echoes to output) the 
//		select-option control of team names	
//		
// ARGUMENTS:
//	$current_team: current team (selected in control)
//	$id: string used as the select-option control's "id" and "name"
// RETURNS:
//	0 if there are no teams in the database
//	1 if select-option control was built successfully
//
function mstw_bb_build_teams_list( $current_league = null, $current_team, $id ) {
	//mstw_bb_log_msg( 'in mstw_bb_build_teams_list ...' );
	
	//if( $league_slug ) build better metaquery
	
	//$current_league = 'pac-12';
	
	$team_slugs = mstw_lm_build_team_slug_array( $current_league );
	
	if ( $team_slugs ){
		$child_league_query = array( 'key'     => 'team_slug',
									 'value'   => $team_slugs,
									 'compare' => 'IN',
									);
	}
	
	$teams = get_posts(array( 'numberposts' => -1,
					  'post_type'      => 'mstw_lm_team',
					  'orderby'        => 'title',
					  'mstw_lm_league' => $current_league,
					  'order'          => 'ASC' 
					));	

	if( $teams ) {
		
	?>
		<select id=<?php echo $id ?> name=<?php echo $id ?> >
			<?php
			foreach( $teams as $team ) {
				$selected = ( $current_team == $team->post_name ) ? 'selected="selected"' : '';
				echo "<option value='" . $team->post_name . "'" . $selected . ">" . get_the_title( $team->ID ) . "</option>";
			}
			?>
		</select>
	<?php
		return 1;
	} 
	else { // No teams found
		return 0;
	}
	
} //End: mstw_bb_build_teams_list( )

function mstw_bb_remove_updated_message( $messages ) {
	//mstw_bb_log_msg( 'in mstw_bb_remove_updated_message' );
    return array();
}

//-----------------------------------------------------------------
// SAVE THE MSTW_BB_TOURNEY CPT META DATA
//
add_action( 'save_post_mstw_bb_tourney', 'mstw_bb_save_tourney_meta', 20, 2 );

function mstw_bb_save_tourney_meta( $post_id, $post ) {
	//mstw_bb_log_msg( 'mstw_bb_save_tourney_meta:' );
	//mstw_bb_log_msg( '$post_id = ' . $post_id );
	//mstw_bb_log_msg( $_POST );
	
	// check if this is an auto save routine. 
	// If it is our form has not been submitted, so don't do anything
	if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || $post->post_status == 'auto-draft' || $post->post_status == 'trash' ) {
		//mstw_bb_log_msg( 'in mstw_bb_save_tourney_meta ... doing autosave ... nevermind!' );
		return; //$post_id;
	}
	
	//check that we are in the right context ... saving from edit page
	// If NONCE is valid, process user input
	//
	if( isset($_POST['mstw_bb_tourney_nonce'] ) && 
		check_admin_referer( plugins_url(__FILE__), 'mstw_bb_tourney_nonce' ) ) {
			
		// These are the 'standard' fields. Sanitize and store.
		$data_fields = array( //'game_unix_dtg', // Gotta build this from date & time
							  
							  'league',
							  'rounds',
							  
							  'elimination', 
							  'has_consolation',
							  
							  'scheduling_method',
							  
							  'round_names',
							  
							);
							
		foreach( $data_fields as $field ) {
			//mstw_bb_log_msg( 'updating field: ' . $field );
			//if ( 'team_link' == $field ) {
				//mstw_bb_log_msg( sanitize_text_field( esc_attr( $_POST[ $field ] ) ) );
			//}
			switch( $field ) {
			
				case 'has_consolation':
					$has_consolation = mstw_safe_ref( $_POST, 'has_consolation' );
					$has_consolation = ( 1 == $has_consolation ) ? 1 : 0;
					update_post_meta( $post_id, $field, $has_consolation );
					break;
				
				case 'round_names':
					// update checkboxes for final and open
					// if game is marked final, close it
					//
					$round_names = array( );
					for ( $i = 0; $i < 6; $i++ ) {
						$round_names[] = $_POST[ 'round_' . strval( $i+1 ) . '_name' ];
					}
					
					update_post_meta( $post_id, $field, $round_names );
					//mstw_bb_log_msg( 'Round names:' );
					//mstw_bb_log_msg( $round_names );
					break;
					
				default:
					update_post_meta( $post_id, $field, sanitize_text_field( esc_attr( $_POST[ $field ] ) ) );
					break;
			}
			
		}
		
	}
	else  if ( strpos( wp_get_referer( ), 'trash' ) === FALSE ) {	
		mstw_bb_log_msg( 'Oops! In mstw_bb_save_tourney_meta() tourney nonce not valid' );
		mstw_bb_add_admin_notice( 'error', __( 'Invalid referrer. Contact system admin.', 'mstw-bracket-builder') );
	}
	
} //End: mstw_bb_save_tourney_meta

// ----------------------------------------------------------------
// Set up the View All Tourneys table
//
add_filter( 'manage_edit-mstw_bb_tourney_columns', 
			'mstw_bb_edit_tourney_columns' ) ;

function mstw_bb_edit_tourney_columns( $columns ) {	

	$columns = array(
		'cb' 			      => '<input type="checkbox" />',
		'title' 		      => __( 'Title', 'mstw-bracket-builder' ),
		'tourney_teams'       => __( 'Slug', 'mstw-bracket-builder' ),
		'tourney_rounds'      => __( 'Rounds', 'mstw-bracket-builder' ),
		'tourney_elim'        => __( 'Elimination', 'mstw-bracket-builder' ),
		'tourney_sched'       => __( 'Schedule', 'mstw-bracket-builder' ),
		'tourney_loc_group'   => __( 'Location Group', 'mstw-bracket-builder' ),
		'tourney_consolation' => __( 'Consolation Game', 'mstw-bracket-builder' ),
		);

	return $columns;
} //End: mstw_bb_edit_tourney_columns( )

//-----------------------------------------------------------------
// Display the View All Games table columns
// 
add_action( 'manage_mstw_bb_tourney_posts_custom_column',
			'mstw_bb_manage_tourney_columns', 10, 2 );

function mstw_bb_manage_tourney_columns( $column, $post_id ) {
	//mstw_bb_log_msg( 'mstw_bb_manage_tourney_columns' );
	
	switch( $column ) {	
		case 'tourney_teams' :
			$league = get_post_meta( $post_id, 'league', true );
			echo $league;
			break;
		
		case 'tourney_rounds' :
			$rounds = get_post_meta( $post_id, 'rounds', true );
			echo $rounds;
			break;
			
		case 'tourney_elim':
			$elim = get_post_meta( $post_id, 'elimination', true );
			$elim = ( 2 == $elim ) ? 'Double' : 'Single' ;
			echo $elim;
			break;

		case 'tourney_sched' :
			$sched = get_post_meta( $post_id, 'scheduling_method', true );
			if ( 'seed' == $sched ) {
				$sched = "By Seed";
			} else if ( 'random' == $sched ) {
				$sched = "Random Seed";
			} else {
				$sched = "Manual";
			}
			echo $sched;
			break;

		case 'tourney_loc_group':
			// Get the post meta
			echo "Not Coded";
			break;
		
		case 'tourney_consolation':
			$consol = get_post_meta( $post_id, 'has_consolation', true );
			$consol = ( 1 == $consol ) ? 'Yes' : 'No' ;
			echo $consol;	
			
			break;
			
		
	
		default :
			/* Just break out of the switch statement for everything else. */
			break;
	}
} //End: mstw_bb_manage_tourney_columns( ) 

//-----------------------------------------------------------------
// Contextual help callback. Action set in mstw-bb-admin.php
// 
function mstw_bb_tourneys_help( ) {
	//mstw_bb_log_msg( "mstw_bb_tourneys_help:" );
	if ( array_key_exists( 'post_type', $_GET ) and 'mstw_bb_tourney' == $_GET['post_type'] ) {
		//mstw_bb_log_msg( 'got the right post type, show the help' );
		
		$screen = get_current_screen( );
		// We are on the correct screen because we take advantage of the
		// load-* action ( in mstw-bb-admin.php, mstw_lm_admin_menu()
		
		//mstw_bb_log_msg( "current screen:" );
		//mstw_bb_log_msg( $screen );
		
		mstw_bb_help_sidebar( $screen );
				
		$tabs = array( array(
						'title'    => __( 'Overview', 'mstw-bracket-builder' ),
						'id'       => 'tourneys-overview',
						'callback'  => 'mstw_bb_tourneys_overview' ),
					 );
					 
		foreach( $tabs as $tab ) {
			$screen->add_help_tab( $tab );
		}
		
	}
} //End: mstw_bb_tourneys_help( )

function mstw_bb_tourneys_overview( $screen, $tab ) {
	if( !array_key_exists( 'id', $tab ) ) {
		return;
	}
		
	switch ( $tab['id'] ) {
		case 'games-overview':
			?>
			<p><?php _e( 'Add, edit, and delete tournaments on this screen.', 'mstw-bracket-builder' ) ?></p>
			<p><?php _e( 'Roll over a Tournament Title to edit or delete a tournament. NOTE that deleting a tournament moves the tournament to the Trash, but does not completely remove it from the database. Go to the trash and empty it to delete tournaments permanently.', 'mstw-bracket-builder' ) ?></p>
			<p><?php //_e( 'Use the Leagues and Teams filters to filter the list by league and/or team. Click the Title column header to sort the list by Title. Click again to reverse the sort.', 'mstw-bracket-builder' ) ?></p>
			 
			<p><a href="http://shoalsummitsolutions.com/lm-games/" target="_blank"><?php _e( 'See the Touraments man page for more details.', 'mstw-bracket-builder' ) ?></a></p>
			
			<?php				
			break;
		
		default:
			break;
	} //End: switch ( $tab['id'] )

} //End: mstw_bb_tourneys_overview( )

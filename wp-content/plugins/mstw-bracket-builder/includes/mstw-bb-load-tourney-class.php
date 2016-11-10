<?php
/* ------------------------------------------------------------------------
 * 	MSTW Bracket Builder Load Tourney Class
 *	Loads canned tournaments into MSTW Bracket Builder Plugin
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed AS IS in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *--------------------------------------------------------------------------*/
 
class MSTW_BB_LOAD_TOURNEY {
	
	//-------------------------------------------------------------
	//	form - builds the user interface for the Schedule Builder screen
	//-------------------------------------------------------------
	function form( ) {
		//mstw_sb_log_msg( 'MSTW_BB_LOAD_TOURNEY.form ...' );
		?>
		<!-- begin main wrapper for page content -->
		<div class="wrap">
		
		<!-- For busy indicator
		<div class="progress-indicator">
			<img src="res/images/icon_loading_75x75.gif" alt="" />
		</div>
		-->
		
		<h1><?php _e( 'Load Tourney', 'mstw-bracket-builder' )?></h1>
		
		<!--
		<p class='mstw-lm-admin-instructions'>
		 <?php _e( 'Read the contextual help tab on the top right of this screen.', 'mstw-bracket-builder' ) ?> 
		</p>
		-->
		
		<?php
		// Check & cleanup the returned $_POST values
		$submit_value = $this->process_option( 'submit', 0, $_POST, false );
		
		//mstw_sb_log_msg( 'request method: ' . $_SERVER['REQUEST_METHOD'] );
		//mstw_sb_log_msg( '$_POST =' );
		//mstw_sb_log_msg( $_POST );
		
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
		?>	
	
		<form id="schedule-builder" class="add:the-list: validate" method="post" enctype="multipart/form-data" action="">
		
			<input type="hidden" value="Yes" name="are_you_sure" id = "are_you_sure" />
 			
			<table id="load-tourney" class="form-table" >
			  <tbody>
			    <tr>
				  <th>  <!-- Select League dropdown -->
				    <?php _e( 'Select Tourney:', 'mstw-bracket-builder' ) ?>
				  </th>
				  <td>
				    <?php $this -> select_tourney_control( ) ?>
				  </td>
				</tr>

				<tr> <!-- Submit button -->
				  <td colspan="2" class="submit">
				  <?php //submit_button( 'Create Schedule', 'primary', '', true ) ?>
				  <!--<input class="button button-primary" type="submit" name="submit" value="<?php _e( 'Load Tourney', 'mstw-bracket-builder' ); ?>"/>-->
				  <input type="submit" onclick="sb_confirm_build_schedule( )" class="button button-primary" name="submit"  value="<?php _e( 'Load Tourney', 'mstw-bracket-builder' ) ?>" />
				  </td>
			    </tr>
			  </tbody>
			</table> 
		</form>		
		</div><!-- end wrap -->
		<!-- end of form HTML -->
	<?php
	} //End of function form()
	
	//-------------------------------------------------------------
	//	select_tourney - displays the HTML for the select tourney control
	//
	function select_tourney_control( ) {
		//mstw_sb_log_msg( "MSTW_BB_LOAD_TOURNEY.select_tourney:" ;

		?>
		<select name='select_tourney' id='select_tourney' class='bb-tourney-pulldown'>
		  <option value='euro-2016'>Euro 2016</option>	
		</select>
		<?php
		
	} //End: select_tourney( )
	
	//-------------------------------------------------------------
	// post - handles POST submissions - this is the heavy lifting
	//-------------------------------------------------------------
	function post( $options ) {
		//mstw_sb_log_msg( 'MSTW_BB_LOAD_TOURNEY.post:' );
		//mstw_sb_log_msg( $options );
		//mstw_sb_log_msg( $_FILES );
		mstw_sb_log_msg( $_POST );
		
		if ( !$options ) {
			//mstw_sb_add_admin_notice( 'error', __( 'Problem encountered. Exiting.', 'mstw-bracket-builder' ) );
			mstw_sb_log_msg( 'Houston, we have a problem in MSTW League Manger - CSV Import ... no $options' );
			return;
		}
		
		if ( 'No' == $_POST['are_you_sure'] ) {
			mstw_sb_add_admin_notice( 'updated', __( 'Build Schedule cancelled.', 'mstw-bracket-builder' ) );
			return;
		}
		
		switch( $options['submit_value'] ) {
			case __( 'Load Tourney', 'mstw-bracket-builder' ):
				$tourney_slug = $_POST['select_tourney'];
				mstw_bb_log_msg( "tourney_slug: $tourney_slug" );
				
				switch ( $tourney_slug ) {
					case 'euro-2016':
						$ret_val = $this -> load_euro_2016( $tourney_slug );
						break;
				}
				
				break;
			
			default:
				mstw_sb_log_msg( 'Error encountered in post() method. $submit_value = ' . $submit_value . '. Exiting' );
				break;
		}

	} //End: post( )
	
	//-------------------------------------------------------------
	//	load_euro_2016 - load data for Euro 2016 Soccer Tourney
	//
	// ARGUMENTS:
	//	 None
	//   
	// RETURNS:
	//	 1 if successful; 0 on failure
	//
	function load_euro_2016 ( $tourney_slug ) {
		mstw_bb_log_msg( "load_euro_2016: tourney: $tourney_slug" );
		
		// FOR TEST & DEBUG
		$tourney_slug = 'euro-2016-1';
		mstw_bb_log_msg( "load_euro_2016: revised tourney: $tourney_slug" );
		
		$ret_val = 1;
		
		mstw_bb_log_msg( "1. create the bracket CPT");
		// Check if tournament euro-2016 CPT exists
		$tourney_obj = get_page_by_path( $tourney_slug, OBJECT, 'mstw_bb_tourney' );
		if( null === $tourney_obj ) {
			mstw_bb_log_msg( "tourney $tourney_slug does not exist" );
			$tourney_id = $this -> create_euro_2016_CPT( $tourney_slug );
			$this -> update_euro_2016_CPT( $tourney_id );
			
		} else {
			mstw_bb_log_msg( "tourney $tourney_slug does exist" );
			$tourney_obj = get_page_by_path( $tourney_slug, OBJECT, 'mstw_bb_tourney' );
			$tourney_id = $tourney_obj -> ID;
			$this -> update_euro_2016_CPT( $tourney_id );
			
		}
		
		// Add the game objects to the bracket
		mstw_bb_log_msg( "2. add the games to the braket" );
		// CPT mstw_bb_game
		$this -> create_euro_2016_games( $tourney_id );
		$this -> update_euro_2016_games( $tourney_id );
		
		
		return $ret_val;
		
	} //End: load_euro_2016 ( )
	
	function create_euro_2016_CPT ( $tourney_slug = 'euro-2016' ) {
		mstw_bb_log_msg( "create_euro_2016_CPT: tourney slug: $tourney_slug" );
		
		
		// Create post
		$args = array( 'post_title'  => 'Euro 2016',
					   'post_type'   => 'mstw_bb_tourney',
					   'post_status' => 'publish',
					   'post_name'   => $tourney_slug,
					  );
					  
		remove_action( 'save_post_mstw_bb_tourney', 'mstw_bb_save_tourney_meta', 20 );
						
		$tourney_id = wp_insert_post( $args );
		
		add_action( 'save_post_mstw_bb_tourney', 'mstw_bb_save_tourney_meta', 20, 2 );
			
		return $tourney_id;
		
	} //End: create_euro_2016_CPT( )
	
	function update_euro_2016_CPT ( $tourney_id ) {
		mstw_bb_log_msg( "update_euro_2016_CPT:" );
		
		$round_names = array( __( 'Round of 16', 'mstw-bracket-builder' ),
							  __( 'Quarter-finals', 'mstw-bracket-builder' ),
							  __( 'Semi-finals', 'mstw-bracket-builder' ),
							  __( 'Final', 'mstw-bracket-builder' ),
							 );
		
		update_post_meta( $tourney_id, 'has_consolation', 0 );
		update_post_meta( $tourney_id, 'league', 'euro-2016' );
		update_post_meta( $tourney_id, 'elimination', 1 );
		update_post_meta( $tourney_id, 'rounds', 4 );
		update_post_meta( $tourney_id, 'scheduling_method', 'manual' );
		update_post_meta( $tourney_id, 'round_names', $round_names );
		
		//return ??
		
	} //End: update_euro_2016_CPT( )
	
	function create_euro_2016_games ( $tourney_id ) {
		mstw_bb_log_msg( "create_euro_2016_games:" );
		
		// Create game post ( if it doesn't exist )
		
		// Add game meta data
		
	} //End: create_euro_2016_games( )
	
	
	function update_euro_2016_games ( $tourney_id ) {
		mstw_bb_log_msg( "update_euro_2016_games:" );
		
		// Create game post ( if it doesn't exist )
		
		// Add game meta data
		
	} //End: update_euro_2016_games( )
	

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

} //End: class MSTW_BB_TOURNEY_BUILDER
?>
<?php
/*	mstw-bb-admin.php
 *	Main file for the admin portion of the MSTW Bracket Builder Plugin
 *	Loaded conditioned on is_admin() 
 */

/*-----------------------------------------------------------------------
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed AS IS in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *---------------------------------------------------------------------*/

 //
 // Double check that we are on an admin page
 //
 if ( is_admin( ) ) {
	 //-----------------------------------------------------------------
	 // Set-up Action and Filter Hooks for the Settings on the admin side
	 //-----------------------------------------------------------------
	 
	 add_action( 'admin_enqueue_scripts', 'mstw_bb_admin_enqueue_scripts' );
	 
	 //-----------------------------------------------------------------
	 // Load the stuff admin needs
	 // This is called from the init hook in mstw-bracket-builder.php
	 //
	 add_action( 'admin_init', 'mstw_bb_admin_init' );
	 
	 // Remove Quick Edit Menu
	 add_filter( 'post_row_actions', 'mstw_bb_remove_quick_edit', 10, 2 );
	
	 //-----------------------------------------------------------------
	 // Include the necessary files for admin screens
	 //-----------------------------------------------------------------
	 include_once 'mstw-bb-bracket-builder-class.php';
	 
	 include_once 'mstw-bb-load-tourney-class.php';
	 
	 //mstw_bb_log_msg( 'adding admin menu action' );
	 // Add a menu item for the Admin pages
	 // Use priority 100 so this runs after league manager menus
	 add_action('admin_menu', 'mstw_bb_admin_menu', 100 );
 
 
	 //include_once 'mstw-bb-bracket-builder-class.php';
	 
	 //include_once 'mstw-bb-edit-bracket-class.php';	 
		
 } else {
	die( __( 'You is no admin. You be a cheater!', 'mstw-bracket-builder' ) );
	
 } //End: if ( is_admin() )

 
 function mstw_bb_admin_init( ) {
	//mstw_bb_log_msg( 'mstw_bb_admin_init:' );
	
	
	//add_action( 'admin_enqueue_scripts', 'mstw_bb_admin_enqueue_scripts' );
		
		// Clean up seasons (options) when league is deleted
		// mstw_bb_cleanup_league_meta is in mstw-lm-league-tax-admin.php
		//add_action( 'delete_term_taxonomy', 'mstw_bb_cleanup_league_meta', 10, 1 );
		//add_action( 'delete_term_relationships', 10, 2 );

		// Add custom admin bulk messages for CPTs (deleting & restoring CPTs)
		//add_filter( 'bulk_post_updated_messages', 'mstw_bb_bulk_post_updated_messages', 10, 2 );

		// Hide the publishing actions on the edit and new CPT screens
		add_action( 'admin_head-post.php', 'mstw_bb_hide_publishing_actions' );
		add_action( 'admin_head-post-new.php', 'mstw_bb_hide_publishing_actions' );

		// Hide the list icons on the CPT edit (all) screens
		add_action( 'admin_head-edit.php', 'mstw_bb_hide_list_icons' );	

		// Remove edit from the Bulk Actions pull-down
		//add_filter( 'bulk_actions-edit-mstw_bb_team', 'mstw_bb_remove_bulk_edit' );
		//add_filter( 'bulk_actions-edit-mstw_bb_game', 'mstw_bb_remove_bulk_edit' );
		//add_filter( 'bulk_actions-edit-mstw_bb_venue', 'mstw_bb_remove_bulk_edit' );
		//add_filter( 'bulk_actions-edit-mstw_bb_record', 'mstw_bb_remove_bulk_edit' );
		
		// Remove delete from the Bulk Actions pull-down
		//add_filter( 'bulk_actions-edit-mstw_bb_league', 'mstw_bb_remove_bulk_delete' );
		
		// Testing the plugin's mstw_bb_sports_list filter
		//add_filter( 'mstw_bb_tbd_list', 'mstw_bb_upgrade_tbd_list', 10, 1 );
		
		// Testing the plugin's mstw_bb_points_calc filter
		//add_filter( 'mstw_bb_date_formats', 'mstw_bb_upgrade_date_formats', 10, 1 );
		
		// Testing the plugin's mstw_bb_points_calc filter
		//add_filter( 'mstw_bb_time_formats', 'mstw_bb_upgrade_time_formats', 10, 1 );
		
		//
		// Add custom admin messages for adding/editting custom taxonomy terms
		//
		//add_filter( 'term_updated_messages', 'mstw_bb_updated_term_messages');
		

		include_once 'mstw-bb-tourney-cpt-admin.php';	

 } //End: mstw_bb_admin_init( )

 
 //-----------------------------------------------------------------
 // Adds the Bracket Builder admin menus,
 // and adds the actions for WP contextual help
 //
 function mstw_bb_admin_menu( ) {
	//mstw_bb_log_msg( 'mstw_bb_admin_menu:' );
		 
	//
	// Bracket Builder
	//
	//if ( is_plugin_active( 'mstw-league-manager/mstw-league-manager.php' ) ) {
		 
		if ( class_exists( 'MSTW_BB_BRACKET_BUILDER' ) ) {
			$builder = new MSTW_BB_BRACKET_BUILDER;
			
			$builder_menu = add_menu_page( 
				__( 'Bracket Builder', 'mstw-bracket-builder' ), //$page_title, 
				__( 'Bracket Builder', 'mstw-bracket-builder' ), //$menu_title, 
				'read',                      //$capability,
				'mstw-bb-bracket-builder',  //menu page slug
				array( $builder, 'quick_start_screen' ),  // Callback function
				plugins_url( 'images/mstw-admin-menu-icon.png', dirname( __FILE__ ) ),   //$menu_icon
				"58.96" //menu position
				);
					
			  
			//
			// Tournaments
			//
			$manage_tourneys_page = add_submenu_page( 	
				'mstw-bb-bracket-builder', //parent page  
				__( 'Tournaments', 'mstw-bracket-builder' ), //page title
				__( 'Tournaments', 'mstw-bracket-builder' ), //menu title
				'read', // Capability required to see this option.
				//'mstw-bb-tournments',
				//array( $builder, 'manage-tournaments' ),
				'edit.php?post_type=mstw_bb_tourney', // Slug name to refer to this menu
				null	// Callback to output content						
				);
					
			//add_action( "load-edit.php", 'mstw_lm_games_help' );
			//add_action( "load-$edit_page", array( $edit_screen, 'add_help' ) )
			
			//
			// Edit Tournament
			//
			$page = add_submenu_page( 
				'mstw-bb-bracket-builder', //parent page 
				__( 'Edit Tournament', 'mstw-bracket-builder' ), //page title
				__( 'Edit Tournament', 'mstw-bracket-builder' ),  //menu title
				'read',    // Capability required to see this option.
				'mstw-bb-edit-tournament', // Slug name to refer to this menu
				array( $builder, 'edit_bracket_screen' )  // Callback to output content
			   );
			   
			//
			// Load Tournament
			//
			/*
			if ( class_exists( 'MSTW_BB_LOAD_TOURNEY' ) ) {
				$loader = new MSTW_BB_LOAD_TOURNEY;
				$page = add_submenu_page( 
					'mstw-bb-bracket-builder', //parent page 
					__( 'Load Tournament', 'mstw-bracket-builder' ), //page title
					__( 'Load Tournament', 'mstw-bracket-builder' ),  //menu title
					'read',    // Capability required to see this option.
					'mstw-bb-load-tournament', // Slug name to refer to this menu
					array( $loader, 'form' )  // Callback to output content
				   );
			}	
			*/			
			
		} else {		
			mstw_bb_log_msg( 'mstw_bb_admin_menu: MSTW_BB_BRACKET_BUILDER class does not exist' );
		}
		
	//} else {
	//	mstw_bb_log_msg( 'mstw_bb_admin_menu: League Manager v1.1 or higher must be active.' );
		 
	//}
	
 } //End: mstw_bb_admin_menu()
	

 //----------------------------------------------------------------
 // Hide the publishing actions on the edit and new CPT screens
 // Callback for admin_head-post.php & admin_head-post-new.php actions
 //
 function mstw_bb_hide_publishing_actions( ) {
	//mstw_bb_log_msg( 'in ... mstw_bb_hide_publishing_actions' );
	//mstw_bb_log_msg( $post_type );
	
	$post_type = mstw_get_current_post_type( );

	if( 'mstw_bb_tourney' == $post_type ) {	
		?>
			<style type="text/css">
				#misc-publishing-actions,
				#minor-publishing-actions{
					display:none;
				}
				div.view-switch {
					display: none;
				}
				div.tablenav-pages.one-page {
					display: none;
				}
				
			</style>
		<?php					
	}
} //End: mstw_bb_hide_publishing_actions( )
	
 //----------------------------------------------------------------
 // Hide the list icons on the CPT edit (all) screens
 // Callback for admin_head-edit action
 function mstw_bb_hide_list_icons( ) {
	//mstw_bb_log_msg( 'in ... mstw_bb_hide_list_icons' );
	//mstw_bb_log_msg( $post_type );
	
	$post_type = mstw_get_current_post_type( );
	
	if ( 'mstw_bb_tourney'   == $post_type ) {
		?>
			<style type="text/css">
				select#filter-by-date ,
				div.view-switch {
					display: none;
				}	
			</style>
		<?php
	}
	
 } //End: mstw_bb_hide_list_icons( )
	
 //-----------------------------------------------------------------	
 // mstw_bb_admin_enqueue_scripts - Add admin scripts and CSS stylesheets:
 //		mstw-bb-admin-styles.css - basic admin screen styles
 // 
 //		datepicker & timepicker for brackets (datepicker as a dependency)
 //		media-upload & another-media for loading team logos 
 //		lm-add-games for the add games screen
 //		lm-update-games for the update games screen
 //		lm-manage-games for the Add/Edit Game (CPT) screen
 //

 function mstw_bb_admin_enqueue_scripts( $hook_suffix ) {
	//mstw_bb_log_msg( 'mstw_bb_admin_enqueue_scripts:' );
	//mstw_bb_log_msg( "hook_suffix= $hook_suffix" );
	
	global $typenow;
	global $pagenow;
	
	//mstw_bb_log_msg( 'enqueueing: ' . plugins_url( 'css/mstw-bb-admin-styles.css',dirname( __FILE__ ) ) );	
	wp_enqueue_style( 'sb-admin-styles', plugins_url( 'css/mstw-bb-admin-styles.css', dirname( __FILE__ ) ), array(), false, 'all' );
	
	//
	// If it's the edit tournaments screen, enqueue the edit tournaments script
	//	
	//mstw_bb_log_msg( '$typenow = ' . $typenow );
	//mstw_bb_log_msg( '$hook_suffix = ' . $hook_suffix );
	
	if ( 'bracket-builder_page_mstw-bb-edit-tournament' == $hook_suffix  ) {
		//mstw_bb_log_msg( '$typenow = ' . $typenow );
		//mstw_bb_log_msg( '$hook_suffix = ' . $hook_suffix );
		
		wp_enqueue_script( 'jquery' );
		
		//mstw_bb_log_msg( 'enqueueing script: ' . plugins_url( 'js/bb-build-bracket.js', dirname( __FILE__ ) ) );
		wp_enqueue_script( 'bb-build-bracket', 
						   plugins_url( 'js/bb-build-bracket.js', dirname( __FILE__ ) ), 
						   array( 'jquery-ui-core', 'jquery-ui-datepicker' ), 
						   false, 
						   true );
						   
		// in JavaScript, object properties are accessed as 
		// mstw_bb_ajax_object.ajax_url, mstw_bb_ajax_object.some_string, etc. 
		// NOTE: can't use '-' in JavaScript object 'mstw_bb_ajax_object'
		/*
		$data_array = array( 
						'ajax_url' => admin_url( 'admin-ajax.php' ),
						'some_string' => __( 'String to translate', 'mstw-bracket-builder' ),
						'a_value' => '10',
						 );
		wp_localize_script( 'bb-build-bracket', 'mstw_bb_ajax_object',
		$data_array );
		*/
		
		//mstw_bb_log_msg( 'enqueueing script: ' . plugins_url( 'js/jquery.timepicker.js', dirname( __FILE__ ) ) );
		
		wp_enqueue_script( 'jquery-timepicker', 
						   plugins_url( 'js/jquery.timepicker.js', dirname( __FILE__ ) ), 
						   array( 'jquery-ui-core' ), 
						   false, 
						   true );
		
		//mstw_bb_log_msg( 'enqueueing stylesheet: ' . plugins_url( 'css/jquery-ui.css', dirname( __FILE__ ) ) );		
		wp_enqueue_style( 'jquery-style', 
						   plugins_url( 'css/jquery-ui.css', dirname( __FILE__ ) ), 
						   array(), 
						   false, 
						   'all' );	
		
		//mstw_bb_log_msg( 'enqueueing stylesheet: ' . plugins_url( 'css/jquery.timepicker.css', dirname( __FILE__ ) ) );			
		wp_enqueue_style( 'jquery-time-picker-style', 
						  plugins_url( 'css/jquery.timepicker.css', dirname( __FILE__ ) ), 
						  array(), 
						  false, 
						  'all' );
	}
	
 } //End: mstw_bb_admin_enqueue_scripts( )

  //-----------------------------------------------------------------
 // mstw_bb_ajax_callback - callback for ALL AJAX posts in the plugin
 //
 //	ARGUMENTS: 
 //		None. AJAX post is global.
 //	
 //	RETURNS:
 //		$response: JSON response to the AJAX post (including error messages)
 //
 function mstw_bb_ajax_callback ( ) {
	//mstw_bb_log_msg( 'mstw_bb_ajax_callback:' );
	global $wpdb;  //this provides access to the WP DB
	
	//mstw_bb_log_msg( 'received data: $_POST[]' );
	//mstw_bb_log_msg( $_POST );
	
	if ( array_key_exists( 'real_action', $_POST ) ) {
		
		$action = $_POST['real_action'];
		//mstw_bb_log_msg( 'action= ' . $action );
		
		switch( $action ) {
			case 'change_tournament':
				$response = mstw_bb_ajax_change_tournament( );
				break;
				
			default:
				mstw_bb_log_msg( "Error: Invalid action, $action, on page: " . $_POST['page'] );
				$response['error'] = __( 'AJAX Error: invalid action.', 'mstw-bracket-builder' );
				break;
		}
		
	} else {
		mstw_bb_log_msg( "AJAX Error: no action found." );
		$response['error'] = __( 'AJAX Error: no action found.', 'mstw-bracket-builder' );
	}
	
	//mstw_bb_log_msg( $response );
	echo json_encode( $response );
	
	wp_die( ); //gotta have this to keep server straight
	
 } //End: mstw_bb_ajax_callback( )

 //-----------------------------------------------------------------
 // mstw_bb_ajax_change_tournament - changes current tournament in options DB,
 //		and builds response when tournament select-option is changed.  
 //
 //	ARGUMENTS: 
 //		None. AJAX post is global.
 //	
 //	RETURNS:
 //		$response: Success or error message.
 //
 function mstw_bb_ajax_change_tournament( ) {
	//mstw_bb_log_msg( 'mstw_bb_ajax_change_tournament:' );
	//$_POST should be global
	//mstw_bb_log_msg( $_POST );
	
	$response = array( 'response'   => 'tournament',
					   'seasons'    => '',
					   'teams'      => '',
					   'error'      => ''
					 );
		
	if ( array_key_exists( 'tournament', $_POST ) ) {
		
		mstw_bb_set_current_tourney( $_POST['tournament'] );
		
	} else {
		
		// got a problem
		mstw_bb_log_msg( "AJAX Error: No tournament provided to handler." ); 
		$response['error'] = __( 'AJAX Error: No tournament provided to handler.', 'mstw-bracket-builder' );	
		
	}
	
	return $response;
	
 } //End: mstw_bb_ajax_change_tournament( )
	
 //-----------------------------------------------------------------
 // Remove Quick Edit Menu	
 //
 function mstw_bb_remove_quick_edit( $actions, $post ) {
	//mstw_bb_log_msg( 'in mstw_bb_remove_quick_edit ... ' );
	
	if ( 'mstw_bb_tourney'   == $post->post_type ) {
			
		unset( $actions['inline hide-if-no-js'] );
		//unset( $actions['view'] );
		
	}
	
	return $actions;
		
 } //End: mstw_bb_remove_quick_edit()
	
 //-----------------------------------------------------------------
 // Remove the Bulk Actions edit option
 //	actions for mstw_bb_game, _team, _venue, _record
 //	
 function mstw_bb_remove_bulk_edit( $actions ){
		unset( $actions['edit'] );
		return $actions;
 } //End: mstw_bb_remove_bulk_edit()
 
 //-----------------------------------------------------------------
 // Remove the Bulk Actions delete option, which entirely removes
 //	the pulldown and button for the mstw_bb_league taxonomy 
 //
 function mstw_bb_remove_bulk_delete( $actions ){
		//unset( $actions['edit'] );
		unset( $actions['delete'] );
		return $actions;
 } //End: mstw_bb_remove_bulk_delete( )

 
	
 //-----------------------------------------------------------------
 // register_uninstall_hook(__FILE__, 'mstw_bb_delete_plugin_options');

 //-----------------------------------------------------------------
 // Callback for: register_uninstall_hook(__FILE__, 'mstw_bb_delete_plugin_options')
 //-----------------------------------------------------------------
 // It runs when the user deactivates AND DELETES the plugin. 
 // It deletes the plugin options DB entry, which is an array storing all the plugin options
 //-----------------------------------------------------------------
 //function mstw_bb_delete_plugin_options() {
 //	delete_option('mstw_bb_options');
 //
 
 //-----------------------------------------------------------------
 // mstw_bb_delete_plugin_options() - callback for uninstall hook
 //
<?php
/*---------------------------------------------------------------------------
 *	mstw-bb-cpts.php
 *		Registers the custom post types for MSTW Bracket Builder
 *		mstw_bb_game, mstw_bb_tourney //mstw_ss_schedule, mstw_ss_venue
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is distributed AS IS in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *---------------------------------------------------------------------*/
 
// ----------------------------------------------------------------
// Register the MSTW Bracket Builder Custom Post Types 
//
function mstw_bb_register_cpts( ) {
	//mstw_bb_log_msg( "mstw_bb_register_cpts:" );
	
	$menu_icon_url = plugins_url( 'images/mstw-admin-menu-icon.png', dirname( __FILE__ ) );
	
	//mstw_bb_log_msg( "menu icon: $menu_icon_url" );
			
	$capability = 'read';
		
	//-----------------------------------------------------------------------
	// register mstw_bb_game custom post type
	//
	$args = array(
		'label'				=> __( 'Games', 'mstw-bracket-builder' ),
		'description'		=> __( 'CPT for games in MSTW Bracket Builder Plugin', 'mstw-bracket-builder' ),
		
		'public' 			    => true,
		'show_ui'			    => true, //default is value of public
		'show_in_nav_menus'	    => false, //default is value of public
		//going to build own admin menu
		'show_in_menu'		    => false, //default is value of show_ui
		'show_in_admin_bar'     => false, //default is value of show_in_menu
		
		//only applies if show_in_menu is true
		//'menu_position'		=> 25, //25 is below comments, which is the default
		'menu_icon'     	    => $menu_icon_url,
		
		'query_var' 		    => true, //post_type is default mstw_ss_game
		'can_export'		    => true, //default is true
		

		
		//'rewrite' 			=> array(
		//	'slug' 			=> 'game',
		//	'with_front' 	=> false,
		//),
		
		'supports' 			=> array( 'title' ),
		
		//post is the default capability type
		//'capability_type'	=> array( 'game', 'games' ), 
		
		//'map_meta_cap' 		=> true,
											
		'labels' 			=> array(
									'name' => __( 'Games', 'mstw-bracket-builder' ),
									'singular_name' => __( 'Game', 'mstw-bracket-builder' ),
									'all_items' => __( 'Games', 'mstw-bracket-builder' ),
									'add_new' => __( 'Add New Game', 'mstw-bracket-builder' ),
									'add_new_item' => __( 'Add Game', 'mstw-bracket-builder' ),
									'edit_item' => __( 'Edit Game', 'mstw-bracket-builder' ),
									'new_item' => __( 'New Game', 'mstw-bracket-builder' ),
									//'View Game Schedule' needs a custom page template that is of no value.
									'view_item' => __( 'View Game', 'mstw-bracket-builder' ),
									'search_items' => __( 'Search Games', 'mstw-bracket-builder' ),
									'not_found' => __( 'No Games Found', 'mstw-bracket-builder' ),
									'not_found_in_trash' => __( 'No Games Found In Trash', 'mstw-bracket-builder' ),
									)
		);
		
	register_post_type( 'mstw_bb_game', $args );
	
	//----------------------------------------------------------------------------
	// register mstw_bb_tourney post type
	//
	$args = array(
		'public' 			=> true,
		'show_ui'			=> true,
		'show_in_menu'		=> false, //default is value of show_ui
		'show_in_admin_bar' => false, //default is value of show_in_menu
		
		'menu_icon'     	=> $menu_icon_url,
		//'show_in_menu' 		=> 'edit.php?post_type=scheduled_games',
		'query_var' 		=> true, //default is mstw_ss_team
		//'rewrite' 			=> array(
		//	'slug' 			=> 'mstw-ss-team',
		//	'with_front' 	=> false,
		//),
		
		'supports' 			=> array( 'title' ),
		
		//post is the default capability type
		//'capability_type'	=> array( 'team', 'teams' ), 
		
		//'map_meta_cap' 		=> true,
		
		'labels' 			=> array(
									'name' => __( 'Tournament', 'mstw-bracket-builder' ),
									'singular_name' => __( 'Tournament', 'mstw-bracket-builder' ),
									'all_items' => __( 'Tournaments', 'mstw-bracket-builder' ),
									'add_new' => __( 'Add New Tournament', 'mstw-bracket-builder' ),
									'add_new_item' => __( 'Add Tournament', 'mstw-bracket-builder' ),
									'edit_item' => __( 'Edit Tournament', 'mstw-bracket-builder' ),
									'new_item' => __( 'New Tournament', 'mstw-bracket-builder' ),
									//'View Game Schedule' needs a custom page template that is of no value.
									'view_item' => null, 
									'search_items' => __( 'Search Tournaments', 'mstw-bracket-builder' ),
									'not_found' => __( 'No Tournaments Found', 'mstw-bracket-builder' ),
									'not_found_in_trash' => __( 'No Tournaments Found In Trash', 'mstw-bracket-builder' ),
									)
		);
		
	register_post_type( 'mstw_bb_tourney', $args);

} //End: mstw_bb_register_cpts( )
?>
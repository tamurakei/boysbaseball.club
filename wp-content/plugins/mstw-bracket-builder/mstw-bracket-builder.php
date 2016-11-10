<?php
/*
Plugin Name: MSTW Bracket Builder
Plugin URI: https://wordpress.org/plugins/mstw-bracket-builder/
Description: Builds brackets for 4 to 64 team tournaments.
Version: 1.0
Author: Mark O'Donnell
Author URI: http://shoalsummitsolutions.com
Text Domain: mstw-bracket-builder
*/

/*---------------------------------------------------------------------------
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2016 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.

 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *	GNU General Public License for details. <http://www.gnu.org/licenses/>
*-------------------------------------------------------------------------*/
 
//------------------------------------------------------------------------
// Activate only if MSTW LEAGUE MANAGER (v1.1 or greater) IS ACTIVE
//
//register_activation_hook( __FILE__, 'mstw_bb_activation' );

function mstw_bb_activation( ) {
	//error_log( 'mstw_bb_activation:' );
	
	/*
	if ( is_plugin_active( 'mstw-bracket-builder/mstw-bracket-builder.php' ) ) {
		//error_log( "MSTW League Manager IS active. Activate!" );
		$plugins_dir = dirname ( dirname ( __FILE__ ) );
		$league_manager = $plugins_dir . '/mstw-bracket-builder/mstw-bracket-builder.php';
		//error_log( 'league manager: '  . $league_manager );
		$data = get_plugin_data( $league_manager );
		$version = $data['Version'];
		//error_log( 'version: ' . (float)$version );
		if ( (float)$version < 0.5 ) {
			mstw_bb_activation_abort( );
			
		} else {
			update_option( 'mstw_bb_version', $version );
		}
		
	//} else {
		//error_log( "MSTW League Manager NOT active. Abort!" );
		//mstw_bb_activation_abort( );
	//}
	*/
	
} //End: mstw_bb_activation( )

//------------------------------------------------------------------------
// Set up an admin message of activation fails because MSTW League MANAGER
//	is not active
//
function mstw_bb_activation_abort( ) {
	//error_log( 'mstw_bb_activation_abort:' );
	
	deactivate_plugins( plugin_basename( __FILE__ ) );
	
	wp_die( __( 'MSTW League Manager version 1.1 or higher must be activated before activating MSTW Schedule Builder. [Press back arrow in browser to continue.]', 'mstw-schedule-builder' ) );
	
} //End: mstw_bb_activation_abort( )

//------------------------------------------------------------------------
// Initialize the plugin ... include files, define globals, register CPTs
//
add_action( 'init', 'mstw_bb_init' );

function mstw_bb_init( ) {
	// ----------------------------------------------------------------
	// Check that League Manager is still active
	//
	/*include_once(  ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( !is_plugin_active( 'mstw-bracket-builder/mstw-bracket-builder.php' ) ) {
		 
		 die( __( 'League Manager v1.1 or higher must be active.', 'mstw-bracket-builder' ) );
		 
	} 
	*/
	//------------------------------------------------------------------------
	// "Helper functions" used throughout MSTW Schedule Builder
	//
	require_once( plugin_dir_path( __FILE__ ) . 'includes/mstw-bb-utility-functions.php' );
	
	//-----------------------------------------------------------------
	// Include the necessary files for admin screens
	//
	//$directory = plugin_dir_path( __FILE__ );
	//mstw_bb_log_msg( "Directory: $directory" );
	
	require_once( plugin_dir_path( __FILE__ ) . 'includes/mstw-bb-cpts.php'  );
	mstw_bb_register_cpts( );
	
	//mstw_bb_log_msg( 'mstw_bb_init:' );
	//mstw_bb_log_msg( 'required once mstw-utility-functions.php' );
	
	// ----------------------------------------------------------------
	// Set up translation/localization with the 'mstw-bracket-builder'
	// This means the WP language packs will be used exclusively
	//
	load_plugin_textdomain( 'mstw-bracket-builder' );
	
	//mstw_bb_log_msg( 'loaded mstw-bracket-builder text domain' );
	
	//-----------------------------------------------------------------
	// If on an admin screen, load the admin functions (gotta have 'em)
	//
	if ( is_admin( ) ) {
		require_once ( plugin_dir_path( __FILE__ ) . 'includes/mstw-bb-admin.php' );
	}
	
	// ----------------------------------------------------------------
	// add ajax action for all bracket builder screen
	// mstw_bb_ajax_callback( ) is in mstw-bb-admin.php
	//
	add_action( 'wp_ajax_bracket_builder', 'mstw_bb_ajax_callback' );
	
	
	// Enqueue the plugin's stylesheet and any scripts
	add_action( 'wp_enqueue_scripts', 'mstw_bb_enqueue_scripts' );
	
	//------------------------------------------------------------------------
	// Functions for MSTW Tourney Bracket shortcode
	//
	include_once( plugin_dir_path( __FILE__ ) . 'includes/mstw-bb-tourney-bracket-class.php' );
	
	
	//------------------------------------------------------------------------
	// Functions for MSTW venue table shortcode
	//
	include_once( plugin_dir_path( __FILE__ ) . 'includes/mstw-bb-tourney-table-class.php' );
	
} //End: mstw_bb_init( )

// ----------------------------------------------------------------
// filter so single-tourney template does  not need to be in the theme directory
//
add_filter( "single_template", "mstw_bb_single_tourney_template" );

function mstw_bb_single_tourney_template( $single_template ) {
	mstw_bb_log_msg( "mstw_bb_single_tourney_template" );
	 global $post;

	 if ($post->post_type == 'mstw_bb_tourney') {
		  $single_template = dirname( __FILE__ ) . '/templates/single-tourney.php';  
	 }
	
	 return $single_template;
	 
} //End: mstw_bb_single_tourney_template()

// ----------------------------------------------------------------
// Enqueue the stylesheet for the front end
// add_filter( 'enqueue_styles', 'mstw_bb_enqueue_styles ) is in mstw_bb_init( )
//
function mstw_bb_enqueue_scripts( ) {
	//mstw_bb_log_msg( "mstw_bb_enqueue_scripts:" );
	
	// Find the full path to the plugin's css file 
	$mstw_bb_style_url = plugins_url( '/css/mstw-bb-styles.css', __FILE__ );
	
	wp_register_style( 'mstw_bb_style', $mstw_bb_style_url );
	
	$mstw_bb_style_file = plugin_dir_path( __FILE__ ) . 'css/mstw-bb-styles.css';

	// If stylesheet exists, enqueue the style
	if ( file_exists( $mstw_bb_style_file ) ) {	
		wp_enqueue_style( 'mstw_bb_style' );			
	} 

	$mstw_bb_custom_stylesheet = get_stylesheet_directory( ) . '/mstw-bb-custom-styles.css';
	
	//mstw_bb_log_msg( 'custom stylesheet path: ' . $mstw_bb_custom_stylesheet );
	
	if ( file_exists( $mstw_bb_custom_stylesheet ) ) {
		$mstw_bb_custom_stylesheet_url = get_stylesheet_directory_uri( ) . '/mstw-bb-custom-styles.css';
		//mstw_bb_log_msg( 'custom stylesheet uri: ' . $mstw_bb_custom_stylesheet_url );
		wp_register_style( 'mstw_bb_custom_style', $mstw_bb_custom_stylesheet_url );
		wp_enqueue_style( 'mstw_bb_custom_style' );
	}
	
} //End: mstw_bb_enqueue_scripts( )
?>
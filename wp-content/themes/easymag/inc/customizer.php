<?php
/**
 * EasyMag Theme Customizer.
 *
 * @package EasyMag
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function easymag_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	// Header Settings
	$wp_customize->add_panel( 'easymag_header_options',	array(
		'priority' 			=> 200,
		'title' 			=> __( 'Header Bar', 'easymag' ),
		'description' 		=> __( 'Header Settings', 'easymag' ),
		'capabitity' 		=> 'edit_theme_options'
	) );

	// Sticky Menu
	$wp_customize->add_section( 'easymag_sticky_menu_section', array(
		'priority' 			=> 100,
		'title' 			=> __( 'Sticky Menu', 'easymag' ),
	) );

	$wp_customize->add_setting( 'easymag_sticky_menu', array(
		'default' 			=> 0,
		'capability' 		=> 'edit_theme_options',
		'sanitize_callback' => 'easymag_checkbox_sanitize'
	) );

	$wp_customize->add_control( 'easymag_sticky_menu', array(
		'type' 				=> 'checkbox',
		'label' 			=> __( 'Check to enable the sticky Main menu', 'easymag' ),
		'settings' 			=> 'easymag_sticky_menu',
		'section' 			=> 'easymag_sticky_menu_section'
	) );

	// Activate Date
	$wp_customize->add_section( 'easymag_hide_date_section', array(
		'priority' 			=> 101,
		'title' 			=> __( 'Header Bar Date', 'easymag' )
	) );

	$wp_customize->add_setting( 'easymag_hide_date_setting', array(
		'default' 			=> '1',
		'capability' 		=> 'edit_theme_options',
		'sanitize_callback'	=> 'easymag_checkbox_sanitize'
	) );

	$wp_customize->add_control( 'easymag_hide_date', array(
		'type' 				=> 'checkbox',
		'label' 			=> __( 'Hide Header Date', 'easymag' ),
		'section' 			=> 'easymag_hide_date_section',
		'settings' 			=> 'easymag_hide_date_setting'
	) );

	// Main Menu Color
	$wp_customize->add_section( 'easymag_menu_color_section', array(
		'priority' 			=> 3,
		'title' 			=> __( 'Menu Color', 'easymag' ),
		'panel'				=> 'easymag_header_options'
	) );

	$wp_customize->add_setting( 'easymag_menu_color', array(
		'priority' 			     => 6,
		'default' 			     => '#ffffff',
		'capability' 			 => 'edit_theme_options',
		'sanitize_callback'		 => 'easymag_color_sanitize',
		'sanitize_js_callback'   => 'easymag_color_escaping_sanitize'
	) );

	// Main Menu Color
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'easymag_menu_color_picker', array(
		'label' 		=> __( 'Menu Font Color', 'easymag' ),
		'section' 		=> 'colors',
		'settings' 		=> 'easymag_menu_color'
	) ) );

	$wp_customize->add_setting(	'easymag_menu_bg_color', array(
		'priority' 				 => 7,
		'default' 				 => '#cf4141',
		'capability' 			 => 'edit_theme_options',
		'sanitize_callback'		 => 'easymag_color_sanitize',
		'sanitize_js_callback'   => 'easymag_color_escaping_sanitize'
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'easymag_menu_bg_color_picker',
			array(
				'label' 			=> __( 'Menu Background', 'easymag' ),
				'section' 			=> 'colors',
				'settings' 			=> 'easymag_menu_bg_color'
			)
		)
	);

	$wp_customize->add_setting(
		'easymag_menu_color_hover',
		array(
			'priority' 			     => 8,
			'default' 			     => '#ffffff',
			'capability' 			 => 'edit_theme_options',
			'sanitize_callback'		 => 'easymag_color_sanitize',
			'sanitize_js_callback'   => 'easymag_color_escaping_sanitize'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'easymag_menu_hover_color_picker',
			array(
				'label' 			=> __( 'Menu Hover Font Color', 'easymag' ),
				'section' 			=> 'colors',
				'settings' 			=> 'easymag_menu_color_hover'
			)
		)
	);

	$wp_customize->add_setting(
		'easymag_menu_hover_bg_color',
		array(
			'priority' 				 => 9,
			'default' 				 => '#be3434',
			'capability' 			 => 'edit_theme_options',
			'sanitize_callback'		 => 'easymag_color_sanitize',
			'sanitize_js_callback'   => 'easymag_color_escaping_sanitize'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'easymag_menu_hover_bg_color_picker',
			array(
				'label' 			=> __( 'Menu Hover Background', 'easymag' ),
				'section' 			=> 'colors',
				'settings' 			=> 'easymag_menu_hover_bg_color'
			)
		)
	);

	// Layout and Content
	$wp_customize->add_panel(
		'easymag_layout_options',
		array(
			'capabitity' 		=> 'edit_theme_options',
			'description' 		=> __( 'Layout and Content Settings', 'easymag' ),
			'priority' 			=> 201,
			'title' 			=> __( 'Layout and Content', 'easymag' )
		)
	);

	// Website Default Layout
	$wp_customize->add_section(
		'easymag_website_layout',
		array(
			'priority' 			=> 1,
			'title' 			=> __( 'Website Layout', 'easymag' ),
			'panel'				=> 'easymag_layout_options'
		)
	);

	$wp_customize->add_setting(
		'easymag_default_layout',
		array(
			'default' 			=> 'boxed_layout',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'easymag_site_layout_sanitize'
		)
	);

	$wp_customize->add_control( 'easymag_default_layout', array(
		'type'			 	=> 'radio',
		'label' 			=> __( 'Choose layout: The change will make to whole site', 'easymag' ),
		'choices' 			=> array(
			'boxed_layout'  => __( 'Boxed Layout', 'easymag' ),
			'wide_layout'  	=> __( 'Wide Layout', 'easymag' )
		),
		'section'			=> 'easymag_website_layout',
		'settings' 			=> 'easymag_default_layout'
	) );

	// Website Default Layout
	$wp_customize->add_section(
		'easymag_website_layout',
		array(
			'priority' 			=> 1,
			'title' 			=> __( 'Website Layout', 'easymag' ),
			'panel'				=> 'easymag_layout_options'
		)
	);

	$wp_customize->add_setting(
		'easymag_default_layout',
		array(
			'default' 			=> 'wide_layout',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'easymag_site_layout_sanitize'
		)
	);

	$wp_customize->add_control(
		'easymag_default_layout',
		array(
			'type'			 	=> 'radio',
			'label' 			=> __( 'Choose layout: The change will make to whole site', 'easymag' ),
			'choices' 			=> array(
				'boxed_layout'  => __( 'Boxed Layout', 'easymag' ),
				'wide_layout'  	=> __( 'Wide Layout', 'easymag' )
			),
			'section'			=> 'easymag_website_layout',
			'settings' 			=> 'easymag_default_layout'
		)
	);

	// Related Posts
	$wp_customize->add_section(
		'easymag_related_posts_section',
		array(
			'priority' 			=> 4,
			'title' 			=> __( 'Related Posts', 'easymag' ),
			'panel' 			=> 'easymag_layout_options',
		)
	);

	$wp_customize->add_setting(
		'easymag_related_posts_setting',
		array(
			'default' 			=> 0,
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback'	=> 'easymag_checkbox_sanitize'
		)
	);

	$wp_customize->add_control(
		'easymag_related_posts',
		array(
			'type' 				=> 'checkbox',
			'label' 			=> __( 'Check to activate the related posts', 'easymag' ),
			'section' 			=> 'easymag_related_posts_section',
			'settings' 			=> 'easymag_related_posts_setting'
		)
	);

	// Default Font Size
	$wp_customize->add_section(
		'easymag_font_size_section',
		array(
			'priority' 			=> 5,
			'title' 			=> __( 'Default Font Size', 'easymag' ),
			'panel'				=> 'easymag_layout_options'
		)
	);

	$wp_customize->add_setting(
		'easymag_font_size',
		array(
			'default' 			=> '15',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'easymag_sanitize_integer'
		)
	);

	$wp_customize->add_control(
		'easymag_font_size',
		array(
			'type'			 	=> 'number',
			'label' 			=> __( 'Set Default Font Size', 'easymag' ),
			'section'			=> 'easymag_font_size_section',
			'settings' 			=> 'easymag_font_size'
		)
	);

	// Font Colors
	$wp_customize->add_section(
		'easymag_font_color_section',
		array(
			'priority' 			=> 6,
			'title' 			=> __( 'Font Color', 'easymag' ),
			'panel'				=> 'easymag_layout_options'
		)
	);

	$wp_customize->add_setting(
		'easymag_font_color',
		array(
			'default' 			     => '#2f363e',
			'capability' 			 => 'edit_theme_options',
			'sanitize_callback'		 => 'easymag_color_sanitize',
			'sanitize_js_callback'   => 'easymag_color_escaping_sanitize'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'easymag_font_color',
			array(
				'label' 		=> __( 'Font Color', 'easymag' ),
				'section' 		=> 'colors',
				'settings' 		=> 'easymag_font_color'
			)
		)
	);

	// Primary Color
	$wp_customize->add_setting(
		'easymag_primary_color',
		array(
			'default' 			     => '#cc2936',
			'capability' 			 => 'edit_theme_options',
			'sanitize_callback'		 => 'easymag_color_sanitize',
			'sanitize_js_callback'   => 'easymag_color_escaping_sanitize'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'easymag_primary_color',
			array(
				'label' 		=> __( 'Primary Color', 'easymag' ),
				'section' 		=> 'colors',
				'settings' 		=> 'easymag_primary_color'
			)
		)
	);

	// Checkbox Sanitize
	function easymag_checkbox_sanitize( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}

	// Color Sanitizate
	function easymag_color_sanitize( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ))
			return '#' . $unhashed;

		return $color;
	}

	// Color Escape Sanitize
	function easymag_color_escaping_sanitize( $input ) {
		$input = esc_attr( $input );
		return $input;
	}

	// Layout Sanitize
	function easymag_site_layout_sanitize( $input ) {
		$valid_keys = array(
			'boxed_layout' => __( 'Boxed Layout', 'easymag' ),
			'wide_layout'  => __( 'Wide Layout', 'easymag' )
		);

		if ( array_key_exists( $input, $valid_keys ) ) {
			return $input;
		} else {
			return '';
		}
	}

	// Page Layout Sanitize
	function easymag_page_layout_sanitize( $input ) {
		$valid_keys = array(
			'right_sidebar' => __( 'Right Sidebar', 'easymag'),
			'left_sidebar'  => __( 'Left Sidebar', 'easymag' ),
			'full_width'  	=> __( 'Full Width', 'easymag' )
		);

		if ( array_key_exists( $input, $valid_keys ) ) {
			return $input;
		} else {
			return '';
		}
	}

	// Number Integer
	function easymag_sanitize_integer( $input ) {
		return absint( $input );
	}

}
add_action( 'customize_register', 'easymag_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function easymag_customize_preview_js() {
	wp_enqueue_script( 'easymag_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'easymag_customize_preview_js' );

/**
 * Enqueue Inline styles generated by customizer
 */
function easymag_customizer_styles() {

	$color = get_theme_mod( 'easymag_font_color' );

	if ( $color != '' ) {
		$dt_color = "
	body,
	h1 a,
	h2 a,
	h3 a,
	h4 a,
	h5 a,
	h6 a,
	.dt-sidebar .dt-social-icons li .fa,
    a {
		color: {$color};
	}
	";
	} else {
		$dt_color = '';
	}

	$font_size = get_theme_mod( 'easymag_font_size' );

	if ( $font_size != '' ) {
		$dt_font_size = "
	body {
		font-size: {$font_size}px;
	}
	";
	} else {
		$dt_font_size = '';
	}

	$primary = get_theme_mod( 'easymag_primary_color' );

	if ( $primary != '' ) {
		$dt_primary_color = "
	a:hover,
	.dt-footer-cont li a:hover,
	.dt-sec-menu li a:hover,
	.dt-featured-posts-wrap h2 a:hover,
	.dt-pagination-nav .current,
	.dt-footer .dt-news-layout-wrap a:hover {
		color: {$primary};
	}

	.dt-news-layout2 .dt-news-post:hover,
	.dt-pagination-nav .current,
	.dt-pagination-nav a:hover {
		border-color: {$primary} ;
	}	
	
	.sticky {
		border-color: {$primary} !important;	
	}	

	.dt-news-layout1 .dt-news-post-img .fa:hover,
	.dt-news-layout-half .dt-news-post-img .fa:hover,
	.dt-sidebar-news .dt-news-post-img .fa:hover,
	.dt-footer h2:after,
	.dt-footer .tagcloud a:hover,
	.dt-related-posts .dt-news-post-img .fa:hover,
	.dt-search-bar,
	.dt-category-posts .dt-news-post-img .fa:hover,
	.dt-category-post-readmore a:hover,
	.dt-nav-md-trigger:hover .fa,
	.tagcloud a:hover {
		background: {$primary};
	}
	";
	} else {
		$dt_primary_color = '';
	}

	$rgba = easymag_hex2rgba( $primary, .75 );
	if ( $rgba != '' ) {
		$dt_rgba = "
	.dt-news-layout1 .dt-news-post-img .fa,
	.dt-news-layout-half .dt-news-post-img .fa,
	.dt-sidebar-news .dt-news-post-img .fa,
	.dt-related-posts .dt-news-post-img .fa,
	.dt-category-posts .dt-news-post-img .fa,
	#back-to-top:hover {
		background: {$rgba};
	}
	";
	} else {
		$dt_rgba = '';
	}

	$menu_bg		= get_theme_mod( 'easymag_menu_bg_color' );

	if ( $menu_bg != '' ) {
		$dt_menu_bg = "
	.dt-menu-bar,
	.dt-main-menu li ul {
		background: {$menu_bg} !important;
	}
	";
	} else {
		$dt_menu_bg = '';
	}

	$menu_color		= get_theme_mod( 'easymag_menu_color' );
	if ( $menu_color != '' ) {
		$dt_menu_color = "
	.dt-main-menu li a,
	.dt-main-menu li:hover,
	.menu-item-has-children:after,
	.current-menu-item a,
	.dt-nav-md li a,
	.dt-nav-md .menu-item-has-children:after,
	.dt-logo-md a,
	.dt-nav-md-trigger {
		color: {$menu_color};
	}
	";
	} else {
		$dt_menu_color = '';
	}

	$menu_hover_bg	= get_theme_mod( 'easymag_menu_hover_bg_color' );

	if ( $menu_hover_bg != '' ) {
		$dt_menu_hover_bg = "
	.dt-main-menu li:hover,
	.dt-main-menu li a:hover,
	.current-menu-item > a,
	.dt-nav-md li a:hover,
	.current-menu-item.menu-item-has-children {
		background: {$menu_hover_bg} !important;
	}
	";
	} else {
		$dt_menu_hover_bg = '';
	}

	$menu_color_hover = get_theme_mod( 'easymag_menu_color_hover' );

	if ( $menu_color_hover != '' ) {
		$dt_menu_color_hover = "
	.dt-main-menu li:hover,
	.dt-main-menu li a:hover,
	.current-menu-item > a,
	.dt-nav-md li a:hover ,
	.current-menu-item.menu-item-has-children:after,
	.current-menu-item.menu-item-has-children:hover:after,
	.menu-item-has-children:hover:after,
	.dt-main-menu li:hover > a {
		color: {$menu_color_hover} !important;
	}
	";
	} else {
		$dt_menu_color_hover = '';
	}

	$dt_related_posts = 33.333333;

	$dt_related_posts_li = ".dt-related-posts li { width: calc({$dt_related_posts}% - 20px); }";

	$custom_css = $dt_color . $dt_font_size . $dt_primary_color . $dt_rgba . $dt_menu_bg . $dt_menu_color . $dt_menu_hover_bg . $dt_menu_color_hover . $dt_related_posts_li;

	wp_add_inline_style( 'easymag-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'easymag_customizer_styles' );

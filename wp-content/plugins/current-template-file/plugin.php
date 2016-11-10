<?php

/**
* Plugin Name:       Current Template File
* Plugin URI:        http://wordpress.org/extend/plugins/current-template-file
* Description:       Displays the current template file (and template parts if any) in WordPress admin toolbar
* Version:           1.3.1
* Author:            Konstantinos Kouratoras
* Author URI:        http://www.kouratoras.gr
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       current-template-file
* Domain Path:       /languages
*/

class CurrentTemplateFile {

	/**
     * Constructor
     */
	public function __construct() {

		//Load localisation files
        add_action("plugins_loaded", array(&$this, "ctf_text_domain"));

		//Plugin init
		add_action( 'all', array( $this, 'ctf_template_parts' ), 1, 3 );

		//Admin bar button
		add_action('admin_bar_init', array(&$this, 'ctf_admin_bar_init'));
	}

	/**
     * This function loads the text domain
     */
    function ctf_text_domain() {
        load_plugin_textdomain('current-template-file', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
    }

	/**
     * This function initializes admin bar
     */
	function ctf_admin_bar_init() {

		if (current_user_can( 'manage_options' ) && !is_admin() && is_admin_bar_showing()) {
			add_action('admin_bar_menu', array(&$this, 'ctf_admin_bar_item_add'), 100);
		}
	}

	/**
     * This function fetches template parts
     */
	function ctf_template_parts( $tag, $slug = null, $name = null ) {

		if ( strpos( $tag, 'get_template_part_' ) === 0)
		{
			if ( $slug != null ) {

				$current_templates = array();
				if ( $name != null ) {
					$current_templates[] = "{$slug}-{$name}.php";
				}
				$current_templates[] = "{$slug}.php";
				$current_template_part = str_replace( get_template_directory() . '/', '', locate_template( $current_templates ) );

				if ( $current_template_part != '' ) {
					$this->current_template_parts[] = $current_template_part;
				}
			}
		}
	}

	/**
     * This function adds admin bar items
     */
	function ctf_admin_bar_item_add() {

		global $wp_admin_bar;
		global $template;
		$template = str_ireplace( get_stylesheet_directory() . '/', '', str_ireplace( get_template_directory() . '/', '', $template ) );

		$wp_admin_bar->add_menu(array(
			'id' => 'ctf-header',
			'title' => __('Current Template File', 'current-template-file'),
			'href' => false,
			'parent' => false
		));

		$wp_admin_bar->add_menu(array(
			'id' => 'ctf-folder',
			'title' => __('Template folder', 'current-template-file'),
			'href' => false,
			'parent' => 'ctf-header'
		));

		$wp_admin_bar->add_menu(array(
			'id' => 'ctf-folder-value',
			'title' =>substr( get_template_directory_uri(), ( strpos( get_template_directory_uri(), 'wp-content') ) ),
			'href' => false,
			'parent' => 'ctf-folder'
		));

		$wp_admin_bar->add_menu(array(
			'id' => 'ctf-template',
			'title' => __('Template file', 'current-template-file'),
			'href' => false,
			'parent' => 'ctf-header'
		));

		$wp_admin_bar->add_menu(array(
			'id' => 'ctf-template-value',
			'title' => $template,
			'href' => false,
			'parent' => 'ctf-template'
		));

		if ( count( $this->current_template_parts ) > 0 ) {

			$wp_admin_bar->add_menu(array(
				'id' => 'ctf-template-parts',
				'title' => __('Template parts', 'current-template-file'),
				'href' => false,
				'parent' => 'ctf-header'
			));

			foreach ( $this->current_template_parts as $template_part_key => $template_part ) {
				$wp_admin_bar->add_menu(array(
						'id' => 'ctf-template-parts-' . $template_part_key,
						'title' => $template_part,
						'href' => false,
						'parent' => 'ctf-template-parts'
				));
			}
		}
	}
}

new CurrentTemplateFile();

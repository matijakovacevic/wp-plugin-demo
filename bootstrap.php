<?php
/*
Plugin Name: WordPress Plugin demo
Plugin URI:  https://github.com/matijakovacevic/wp-plugin-demo
Description: A demo for an object-oriented/MVC WordPress plugin
Version:     0.1
Author:      Matija Kovačević
*/

/*
 * This plugin was built on top of WordPress-Plugin-Demo by Ian Dunn.
 * See https://github.com/iandunn/WordPress-Plugin-Demo for details.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'WPD_NAME',                 'WordPress Plugin Demo' );
define( 'WPD_REQUIRED_PHP_VERSION', '5.3' );                          // because of get_called_class()
define( 'WPD_REQUIRED_WP_VERSION',  '3.1' );                          // because of esc_textarea()

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function wpd_requirements_met() {
	global $wp_version;
	//require_once( ABSPATH . '/wp-admin/includes/plugin.php' );		// to get is_plugin_active() early

	if ( version_compare( PHP_VERSION, WPD_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}

	if ( version_compare( $wp_version, WPD_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	/*
	if ( ! is_plugin_active( 'plugin-directory/plugin-file.php' ) ) {
		return false;
	}
	*/

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function wpd_requirements_error() {
	global $wp_version;

	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( wpd_requirements_met() ) {
	require_once( __DIR__ . '/classes/wpd-module.php' );
	require_once( __DIR__ . '/classes/wordpress-plugin-demo.php' );
	require_once( __DIR__ . '/classes/wpd-settings.php' );

	if ( class_exists( 'WordPress_Plugin_Demo' ) ) {
		$GLOBALS['wpd'] = WordPress_Plugin_Demo::get_instance();
		register_activation_hook(   __FILE__, array( $GLOBALS['wpd'], 'activate' ) );
		register_deactivation_hook( __FILE__, array( $GLOBALS['wpd'], 'deactivate' ) );
	}
} else {
	add_action( 'admin_notices', 'wpd_requirements_error' );
}

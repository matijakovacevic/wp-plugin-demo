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

if (! defined('ABSPATH')) {
    die('Access denied.');
}

define('WPD_NAME',                 'WordPress Plugin Demo');
define('WPD_REQUIRED_PHP_VERSION', '5.3');                          // because of get_called_class()
define('WPD_REQUIRED_WP_VERSION',  '3.1');                          // because of esc_textarea()

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function wpd_requirements_met()
{
    global $wp_version;
    //require_once( ABSPATH . '/wp-admin/includes/plugin.php' );		// to get is_plugin_active() early

    if (version_compare(PHP_VERSION, WPD_REQUIRED_PHP_VERSION, '<')) {
        return false;
    }

    if (version_compare($wp_version, WPD_REQUIRED_WP_VERSION, '<')) {
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
function wpd_requirements_error()
{
    global $wp_version;

    require_once dirname(__FILE__).'/views/requirements-error.php';
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if (wpd_requirements_met()) {
    require_once __DIR__.'/classes/wpd-widget.php';
    require_once __DIR__.'/classes/wordpress-plugin-demo.php';

    if (class_exists('WordPress_Plugin_Demo')) {
        $GLOBALS['wpd'] = new WordPress_Plugin_Demo();
        $GLOBALS['wpd']->generateShortcodes(array(
            array(
                'name'    => 'video',
                'content' => true,
                'action'  => function($atts, $content) {
                    $cont = ($content !== null) ? '<p>'. $content .'</p>' : '';

                    return <<<VIDEO
$cont
<video controls>
  <source src="movie.mp4" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">
Your browser does not support the video tag.
</video>
VIDEO;
                },
            ),
            array(
                'name'    => 'audio',
                'content' => true,
                'action'  => function($atts, $content) {
                    $cont = ($content !== null) ? '<p>'. $content .'</p>' : '';

                    return <<<AUDIO
$cont
<audio controls>
  <source src="horse.ogg" type="audio/ogg">
  <source src="horse.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
AUDIO;
                },
            )
        ));
        register_activation_hook(__FILE__, array( $GLOBALS['wpd'], 'activate' ));
        register_deactivation_hook(__FILE__, array( $GLOBALS['wpd'], 'deactivate' ));
    }
} else {
    wp_die(wpd_requirements_error());
}

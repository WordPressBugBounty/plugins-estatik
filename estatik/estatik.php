<?php

/**
 * Plugin Name:       Estatik
 * Plugin URI:        http://estatik.net
 * Description:       A simple version of Estatik Real Estate plugin for Wordpress.
 * Version:           4.1.11
 * Author:            Estatik
 * Author URI:        http://estatik.net
 * Text Domain:       es
 * License:           GPL2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'DS' ) ) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if ( ! defined( 'ES_PLUGIN_INCLUDES' ) ) {
	define( 'ES_FILE', __FILE__ );
	define( 'ES_PLUGIN_PATH', dirname( ES_FILE ) );
	define( 'ES_PLUGIN_URL', plugin_dir_url( ES_FILE ) );
	define( 'ES_PLUGIN_INCLUDES', dirname( ES_FILE ) . DS . 'includes' . DS );
	define( 'ES_PLUGIN_CLASSES', dirname( ES_FILE ) . DS . 'includes' . DS . 'classes' . DS );
	define( 'ES_PLUGIN_BASENAME', plugin_basename( __FILE__) );
	define( 'ESTATIK4', true );
}

register_activation_hook( __FILE__, 'es_deactivate_active_plugins' );

/**
 * Check for Estatik active plugins and deactivate them.
 *
 * @return void
 */
function es_deactivate_active_plugins() {
	if ( ! function_exists('get_plugins') ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();
	$plugin_names = array( 'Estatik', 'Estatik PRO', 'Estatik Premium' );

	foreach ( $plugins as $plugin_file => $plugin_data ) {
		if ( in_array( $plugin_data['Name'], $plugin_names ) && is_plugin_active( $plugin_file ) ) {
			deactivate_plugins( $plugin_file );
		}
	}
}

require_once ES_PLUGIN_CLASSES . 'class-estatik.php';

Estatik::get_instance();

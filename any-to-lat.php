<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/tux255
 * @since             1.0.0
 * @package           Any_To_Lat
 *
 * @wordpress-plugin
 * Plugin Name:       Any to Lat
 * Plugin URI:        https://github.com/tux255/Any-to-Lat
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Andrii Haranin
 * Author URI:        https://github.com/tux255
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       any-to-lat
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ANY_TO_LAT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-any-to-lat-activator.php
 */
function activate_any_to_lat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-any-to-lat-activator.php';
	Any_To_Lat_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-any-to-lat-deactivator.php
 */
function deactivate_any_to_lat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-any-to-lat-deactivator.php';
	Any_To_Lat_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_any_to_lat' );
register_deactivation_hook( __FILE__, 'deactivate_any_to_lat' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-any-to-lat.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_any_to_lat() {

	$plugin = new Any_To_Lat();
	$plugin->run();

}
run_any_to_lat();

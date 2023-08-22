<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp_project
 * @since             1.0.0
 * @package           Metal_Slug
 *
 * @wordpress-plugin
 * Plugin Name:       quadruple-event
 * Plugin URI:        https://wp_project
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            JCVD
 * Author URI:        https://wp_project
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       metal-slug
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
define( 'METAL_SLUG_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-metal-slug-activator.php
 */
function activate_metal_slug() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-metal-slug-activator.php';
	Metal_Slug_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-metal-slug-deactivator.php
 */
function deactivate_metal_slug() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-metal-slug-deactivator.php';
	Metal_Slug_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_metal_slug' );
register_deactivation_hook( __FILE__, 'deactivate_metal_slug' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-metal-slug.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_metal_slug() {

	$plugin = new Metal_Slug();
	$plugin->run();

}
run_metal_slug();

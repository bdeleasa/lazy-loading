<?php

/**
 *
 * @link              https://github.com/bdeleasa/lazy-loading
 * @since             1.0.0
 * @package           Lazy_Loading
 *
 * @wordpress-plugin
 * Plugin Name:       Lazy Loading Images
 * Plugin URI:        https://github.com/bdeleasa/lazy-loading
 * Description:       Enables lazy loading for images using a jQuery script.
 * Version:           1.0.0
 * Author:            Brianna Deleasa
 * Author URI:        http://briannadeleasa.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lazy-loading
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Global variables
define( 'LLI_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'LLI_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lazy-loading-activator.php
 */
function activate_lazy_loading_images() {
	require_once LLI_PLUGIN_DIR_PATH . 'includes/class-lazy-loading-activator.php';
	Lazy_Loading_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lazy-loading-deactivator.php
 */
function deactivate_lazy_loading_images() {
	require_once LLI_PLUGIN_DIR_PATH . 'includes/class-lazy-loading-deactivator.php';
	Lazy_Loading_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lazy_loading_images' );
register_deactivation_hook( __FILE__, 'deactivate_lazy_loading_images' );

/**
 * Custom functions used throughout the plugin
 */
require LLI_PLUGIN_DIR_PATH . 'includes/functions.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require LLI_PLUGIN_DIR_PATH . 'includes/class-lazy-loading.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lazy_loading_images() {

	$plugin = new Lazy_Loading();
	$plugin->run();

}
run_lazy_loading_images();
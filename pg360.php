<?php

/**
 *
 * @link              www.ProdGraphy.com
 * @since             1.0.0
 * @package           Pg360
 *
 * @wordpress-plugin
 * Plugin Name:       360° Generator
 * Plugin URI:        www.ProdGraphy.com
 * Description:       Easy to use plugin produce amazing and interactive 360° photos from ordinary set of photos with multi options like size control, color filters ,cursor shape customization, speed control...etc , make your business achieve whole new level of professionalism and increase your site traffic. 

 * Version:           1.1.2
 * Author:            ProdGraphy.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pg360
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PG_360_GENERATOR_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pg360-activator.php
 */
function activate_pg360() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pg360-activator.php';
	Pg360_Activator::pg360_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pg360-deactivator.php
 */
function deactivate_pg360() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pg360-deactivator.php';
	Pg360_Deactivator::pg360_deactivate();
}

register_activation_hook( __FILE__, 'activate_pg360' );
register_deactivation_hook( __FILE__, 'deactivate_pg360' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pg360.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pg360() {

	$plugin = new Pg360();
	$plugin->run();

}
run_pg360();

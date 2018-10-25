<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly
}

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://developer.wasakredit.se/
 * @since             1.0.0
 * @package           Wasa_Kredit_Checkout_Standalone
 *
 * @wordpress-plugin
 * Plugin Name:       Wasa Kredit Checkout (Standalone)
 * Plugin URI:        https://github.com/wasakredit/woocommerce-plugin
 * Description:       Wasa Kredit Checkout offers financing as a payment method for B2B. This is 
 * Author:            Wasa Kredit
 * Version:           1.0.0
 * Author URI:        https://developer.wasakredit.se
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wasa-kredit-checkout-standalone
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define('WASA_KREDIT_CHECKOUT_STANDALONE_VERSION', '1.0.0');

register_activation_hook( __FILE__, 'Wasa_Kredit_Checkout_Standalone_Setup::activate' );

register_deactivation_hook( __FILE__, 'Wasa_Kredit_Checkout_Standalone_Setup::deactivate' );

require plugin_dir_path( __FILE__ ) . 'includes/class-wasa-kredit-checkout.php';

Wasa_Kredit_Checkout_Standalone::run();

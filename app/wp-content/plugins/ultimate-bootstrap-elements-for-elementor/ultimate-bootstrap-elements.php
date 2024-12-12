<?php
/**
 * Plugin Name: Ultimate Bootstrap Elements for Elementor
 * Plugin URI: https://wordpress.org/plugins/ultimate-bootstrap-elements-for-elementor
 * Description: Enhance your Elementor page building experience with Bootstrap Components and many other extension elements.
 * Version: 1.4.9
 * Author: G5Theme
 * Author URI: http://themeforest.net/user/g5theme
 * Text Domain: ube
 * Domain Path: /languages/
 * License: GPLv2 or later
 * Elementor tested up to: 3.22.1
 * Elementor Pro tested up to: 3.22.0
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Define plugin constants
define('UBE_PLUGIN_FILE', __FILE__);
define('UBE_ABSPATH', plugin_dir_path(__FILE__));
define('UBE_TEMPLATE_DEBUG_MODE', false);

include_once UBE_ABSPATH . 'inc/functions/preload-ube.php';
if (!did_action('elementor/loaded')) {
	add_action('admin_notices', 'ube_required_elementor_active');
	return;
}

include_once UBE_ABSPATH . 'inc/ube.class.php';
function UBE() {
	return UltimateBootstrapElements::get_instance();
}

UBE();


<?php
/**
 *    Plugin Name: Smart Framework
 *    Plugin URI: http://smartframework.g5plus.net/
 *    Description: Smart Framework is a simple, truly extensible and fully responsive options framework for WordPress themes and plugins.
 *    Version: 1.0
 *    Author: g5plus
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: smart-framework
 *    Domain Path: /languages/
 *
 * @package     SmartFramework
 * @subpackage  Core
 * @author      g5plus
 *
 **/
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Framework')) {
	class GSF_Framework
	{
		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			spl_autoload_register(array($this, 'incAutoload'));
			spl_autoload_register(array($this, 'fieldsAutoload'));
			spl_autoload_register(array($this, 'coreAutoload'));
			$this->includes();
			$this->hook()->init();
			GSF()->assets()->init();
			GSF()->core()->init();
			GSF()->adminMetaBoxes()->init();
			GSF()->adminThemeOption()->init();
			GSF()->adminWidget()->init();
			GSF()->adminTaxonomy()->init();
			GSF()->adminUserMeta()->init();
			$this->customCss()->init();
		}

		/**
		 * Inc library auto loader
		 *
		 * @param $class
		 */
		public function incAutoload($class)
		{
			$file_name = preg_replace('/^GSF_Inc_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
                $this->loadFile(GSF()->pluginDir("inc/{$file_name}.class.php"));
			}
		}

		/**
		 * Field auto loader
		 * @param $class
		 */
		public function fieldsAutoload($class)
		{
			$file_name = preg_replace('/^GSF_Field_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
                $this->loadFile(GSF()->pluginDir("fields/{$file_name}/{$file_name}.class.php"));
			}
		}

		/**
		 * Field auto loader
		 * @param $class
		 */
		public function coreAutoload($class)
		{
			$file_name = preg_replace('/^GSF_Core_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile(GSF()->pluginDir("core/{$file_name}/{$file_name}.class.php"));
			}
		}

        public function loadFile($path) {
            if ( $path && is_readable($path) ) {
                include_once($path);
                return true;
            }
            return false;
        }

		/**
		 * Include library
		 */
		private function includes() {
			require_once GSF()->pluginDir('fields/field.php');
		}

		public function pluginVer() {
			if (!function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			$plugin_data = get_plugin_data( __FILE__ );
			return $plugin_data['Version'];
		}

		/**
		 *
		 * @param string $path
		 * @return string
		 */
		public function pluginUrl($path = '') {
			$plugin_name = apply_filters('gsf_plugin_url', 'lustria-framework');

			$plugin_dir = str_replace('\\', '/', trailingslashit(dirname(__FILE__)));
			$template_dir = str_replace('\\', '/', trailingslashit(get_template_directory()));
			if (strpos($plugin_dir, $template_dir) === false) {
				return trailingslashit(plugins_url($plugin_name)) . $path;
			}

			$sub_template_dir = substr($plugin_dir, strlen($template_dir));
			return trailingslashit(get_template_directory_uri() . $sub_template_dir) . $path;
		}

		/**
		 * Get Plugin Dir
		 *
		 * @param string $path
		 * @return string
		 */
		public function pluginDir($path = '') {
			return plugin_dir_path(__FILE__) . $path;
		}

		public function assetsHandle($handle = '') {
			return apply_filters('gsf_assets_prefix', 'gsf_') . $handle;
		}

		/**
		 * @return GSF_Inc_Hook
		 */
		public function hook() {
			return GSF_Inc_Hook::getInstance();
		}

		/**
		 * GSF helper function
		 * @return GSF_Inc_Helper
		 */
		public function helper() {
			return GSF_Inc_Helper::getInstance();
		}

		/**
		 * @return GSF_Inc_Custom_Css
		 */
		public function customCss() {
			return GSF_Inc_Custom_Css::getInstance();
		}

		/**
		 * GSF Assets
		 *
		 * @return GSF_Inc_Assets
		 */
		public function assets() {
			return GSF_Inc_Assets::getInstance();
		}

		/**
		 * GSF ajax
		 * @return GSF_Inc_Admin_Ajax
		 */
		public function adminAjax() {
			return GSF_Inc_Admin_Ajax::getInstance();
		}

		/**
		 * GSF Core
		 * @return GSF_Core_Core
		 */
		public function core() {
			return GSF_Core_Core::getInstance();
		}

		/**
		 * GSF Theme Options
		 * @return GSF_Inc_Admin_Theme_Options
		 */
		public function adminThemeOption() {
			return GSF_Inc_Admin_Theme_Options::getInstance();
		}

		/**
		 * GSF Meta Boxes
		 * @return GSF_Inc_Admin_Meta_Boxes
		 */
		public function adminMetaBoxes() {
			return GSF_Inc_Admin_Meta_Boxes::getInstance();
		}

		/**
		 * Widget Loader
		 *
		 * @return GSF_Inc_Admin_Widget
		 */
		public function adminWidget() {
			return GSF_Inc_Admin_Widget::getInstance();
		}

		/**
		 * GSF Taxonomy
		 * @return GSF_Inc_Admin_Taxonomy
		 */
		public function adminTaxonomy() {
			return GSF_Inc_Admin_Taxonomy::getInstance();
		}

		/**
		 * GSF User Meta
		 * @return GSF_Inc_Admin_User_Meta
		 */
		public function adminUserMeta() {
			return GSF_Inc_Admin_User_Meta::getInstance();
		}

        /**
         * @return GSF_Inc_File
         */
		public function file() {
		    return GSF_Inc_File::getInstance();
        }
	}

	/**
	 * @return GSF_Framework
	 */
	function GSF()
	{
		return GSF_Framework::getInstance();
	}

	/**
	 * Init Smart Framework
	 */
	GSF()->init();
}
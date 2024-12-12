<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'UltimateBootstrapElements' ) ) {
	final class UltimateBootstrapElements {
		/*
         * loader instances
         */
		private static $_instance = null;

		public static function get_instance() {
			if ( self::$_instance === null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->includes();

			/**
			 * Include abstract class
			 */
			include_once UBE_ABSPATH . 'inc/abstracts/module-abstract.class.php';

			add_action('after_setup_theme',array($this,'init'),1);
		}


		/**
		 * Init plugin
		 */
		public function init() {
            /**
			 * Init plugin business
			 */
			UBE_Assets::get_instance()->init();
            UBE_Admin_Core::get_instance()->init();
            UBE_Form_Handler::get_instance()->init();

            UBE_Elements_Manager::get_instance()->init();
            UBE_Controls_Manager::get_instance()->init();
            UBE_Modules_Manager::get_instance()->init();
            UBE_Ajax::get_instance()->init();
            UBE_Icon::get_instance()->get_icons();
			do_action( 'ube_init' );
		}

		/**
		 * Include functions for plugin
		 */
		public function includes() {
			/**
			 * Load plugin functions
			 */
            include_once UBE_ABSPATH . 'inc/functions/constants.php';
			include_once UBE_ABSPATH . 'inc/functions/autoload.php';
			include_once UBE_ABSPATH . 'inc/functions/core.php';
			include_once UBE_ABSPATH . 'inc/functions/color.php';
			include_once UBE_ABSPATH . 'inc/functions/elements.php';
            include_once UBE_ABSPATH . 'inc/functions/config.php';
            include_once UBE_ABSPATH . 'inc/functions/site-setting.php';
            include_once UBE_ABSPATH . 'inc/functions/image.php';
            include_once UBE_ABSPATH . 'inc/functions/button.php';
			include_once UBE_ABSPATH . 'inc/functions/image-effect.php';
            include_once UBE_ABSPATH . 'inc/functions/data.php';
		}

        public function elementor() {
            return Elementor\Plugin::$instance;
        }
	}
}

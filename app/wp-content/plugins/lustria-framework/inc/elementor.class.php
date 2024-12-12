<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5P_Inc_Elementor')) {
	class G5P_Inc_Elementor {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action('elementor_pro/init',array($this,'remove_elementor_pro_mini_cart_template'));
		}

		public function remove_elementor_pro_mini_cart_template() {
			$modules = ElementorPro\Plugin::instance()->modules_manager;
			$modules_woocommerce = $modules->get_modules('woocommerce');
			if ($modules_woocommerce !== NULL) {
				remove_filter( 'woocommerce_add_to_cart_fragments', [ $modules_woocommerce, 'e_cart_count_fragments' ] );
			}
		}
	}
}
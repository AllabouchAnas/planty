<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5P_Inc_Polylang')) {
	class G5P_Inc_Polylang {
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action('init', array($this,'register_assets'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'), 9);
			add_filter('woocommerce_ajax_get_endpoint', array($this,'change_woocommerce_ajax_get_endpoint'),10, 2);
			add_filter('pll_is_ajax_on_front',array($this,'change_pll_is_ajax_on_front'));
		}

		public function is_active() {
			return class_exists( 'WooCommerce') && function_exists('PLL');
		}

		public function get_current_lang() {
			$current_lang = get_locale();
			if (function_exists('pll_current_language')) {
				$current_lang = pll_current_language();
			}
			return $current_lang;
		}

		public function register_assets() {
			$current_lang = $this->get_current_lang();
			wp_register_script(G5P()->assetsHandle('woocommerce-polylang'), G5P()->helper()->getAssetUrl('assets/js/woocommerce-polylang.min.js'), array('jquery'), G5P()->pluginVer(), true);
			wp_localize_script(G5P()->assetsHandle('woocommerce-polylang'),'g5_woocommerce_polylang_var', array(
				'current_lang' => $current_lang
			));
		}

		public function enqueue_assets() {
			if ($this->is_active()) {
				wp_enqueue_script(G5Plus_Lustria()->helper()->assetsHandle('woocommerce-polylang'));
			}
		}

		public function change_woocommerce_ajax_get_endpoint($endpoint,$request) {
			$current_lang = $this->get_current_lang();
			$endpoint = add_query_arg('lang',$current_lang ,$endpoint);
			$endpoint = str_replace('%25%25endpoint%25%25','%%endpoint%%', $endpoint);
			return $endpoint;
		}

		public function change_pll_is_ajax_on_front($is_ajax_on_front) {
			if (isset($_REQUEST['wc-ajax'])) {
				$is_ajax_on_front = TRUE;
			}
			return $is_ajax_on_front;
		}
	}
}
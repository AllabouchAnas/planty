<?php
/**
 * The template for displaying typography.php
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Custom_Vc_Param_Typography')) {
	class G5P_Custom_Vc_Param_Typography
	{
		public function __construct()
		{
			add_action('vc_load_default_params', array($this, 'register_param'));
			add_action( 'vc_backend_editor_enqueue_js_css', array($this,'enqueue_admin_resources'));
            add_action('vc_frontend_editor_enqueue_js_css',array($this,'enqueue_admin_resources'));
		}

		public function register_param()
		{
			vc_add_shortcode_param('gsf_typography', array($this, 'render_param'),G5P()->helper()->getAssetUrl('core/vc/vc-params/typography/assets/typography.min.js'));
		}

		public function render_param($settings, $value)
		{
			ob_start();
			G5P()->helper()->getTemplate('core/vc/vc-params/typography/templates/typography.tpl',array('settings' => $settings, 'value' => $value));
			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
			wp_enqueue_style(G5P()->assetsHandle('field_typography'));
		}
	}
	new G5P_Custom_Vc_Param_Typography();
}
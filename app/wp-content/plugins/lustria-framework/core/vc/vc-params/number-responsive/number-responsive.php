<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Custom_Vc_Param_Number_Responsive')) {
	class G5P_Custom_Vc_Param_Number_Responsive
	{
		public $size_types = array(
            'xl' => 'Desktop',
			'lg' => 'Tablet',
			'md' => 'Tablet Portrait',
			'sm' => 'Mobile Landscape',
			'mb' => 'Mobile'
		);

		public function __construct()
		{
			add_action('vc_load_default_params', array($this, 'register_param'));
			add_action( 'vc_backend_editor_enqueue_js_css', array($this,'enqueue_admin_resources'));
            add_action('vc_frontend_editor_enqueue_js_css',array($this,'enqueue_admin_resources'));
		}

		public function register_param()
		{
			vc_add_shortcode_param('gsf_number_responsive', array($this, 'render_param'),G5P()->helper()->getAssetUrl('core/vc/vc-params/number-responsive/assets/number-responsive.min.js'));
		}

		public function render_param($settings, $value)
		{
			ob_start();
			G5P()->helper()->getTemplate('core/vc/vc-params/number-responsive/templates/number-responsive.tpl',array('settings' => $settings, 'value' => $value, 'size_types' => $this->size_types));
			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
            wp_enqueue_style(G5P()->assetsHandle('vc-number-responsive'),G5P()->helper()->getAssetUrl('core/vc/vc-params/number-responsive/assets/number-responsive.min.css'));
		}
	}
	new G5P_Custom_Vc_Param_Number_Responsive();
}
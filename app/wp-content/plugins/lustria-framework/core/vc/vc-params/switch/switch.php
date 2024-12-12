<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Custom_Vc_Param_Switch')) {
	class G5P_Custom_Vc_Param_Switch
	{
		public function __construct()
		{
			add_action('vc_load_default_params', array($this, 'register_param'));
			add_action( 'vc_backend_editor_enqueue_js_css', array($this,'enqueue_admin_resources'));
            add_action('vc_frontend_editor_enqueue_js_css',array($this,'enqueue_admin_resources'));
		}

        public function register_param()
        {
            vc_add_shortcode_param('gsf_switch', array($this, 'render_param'),G5P()->helper()->getAssetUrl('core/vc/vc-params/switch/assets/switch.min.js'));
        }

		public function render_param($settings, $value)
		{
			ob_start();
			G5P()->helper()->getTemplate('core/vc/vc-params/switch/templates/switch.tpl',array('settings' => $settings, 'value' => $value));
			return ob_get_clean();
		}

		public function enqueue_admin_resources() {
			wp_enqueue_style(GSF()->assetsHandle('field_switch'));
		}
	}
	new G5P_Custom_Vc_Param_Switch();
}
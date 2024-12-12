<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class UBE_Module_Templates extends UBE_Abstracts_Module {
	public function init() {
		add_action( 'elementor/editor/footer', array($this, 'modal_templates'));
		add_action( 'wp_ajax_ube_get_prebuilt_templates', array($this, 'get_prebuilt_templates_ajax'));
		add_action( 'wp_ajax_ube_get_prebuilt_template_content', array($this, 'get_prebuilt_template_content_ajax'));
	}

	public function modal_templates() {
		ube_get_template('modules/templates/modal.php');
	}

	public function get_templates() {
		$preview_image = apply_filters('ube_template_preview_image', array(
			'dir' => '',
			'url' => ''
		));

		$data = apply_filters('ube_prebuilt_templates', array(
			'categories' => array(),
			'templates' => array()
		));

		$data['categories'] = array_merge(array(
			'' => esc_html__('All Categories','ube')
		), $data['categories']);

		foreach ($data['templates'] as $key => &$item) {
			if (file_exists("{$preview_image['dir']}{$key}.jpg")) {
				$item['preview'] = "{$preview_image['url']}{$key}.jpg";
			}
			else {
				$item['preview'] = '';
			}
		}

		return $data;
	}

	public function get_prebuilt_templates_ajax() {
		if (!isset($_REQUEST['_ajax_nonce']) || !wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'ube_get_prebuilt_templates_action')) {
			return;
		}

		$data = $this->get_templates();
		foreach ($data['templates'] as $key => &$item) {
			unset($item['data']);
		}

		wp_send_json_success($data);
		die();
	}

	public function get_prebuilt_template_content_ajax() {
		if (!isset($_REQUEST['_ajax_nonce']) || !wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']), 'ube_get_prebuilt_template_content_action')) {
			return;
		}

		$template_id = sanitize_text_field($_REQUEST['id']);

		$data = $this->get_templates();

		if (isset($data['templates'][$template_id])) {
			$template_data = json_decode($data['templates'][$template_id]['data'], true);
			foreach ($template_data as $key => $value) {
				$template_data[$key]['id'] = uniqid();
			}
			wp_send_json_success($template_data);
		}
		else {
			wp_send_json_error(esc_html__('Template not found!','ube'));
		}
		die();
	}
}
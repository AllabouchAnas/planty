<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class UBE_Form_Handler {
    private static $_instance = null;

    public static function get_instance() {
        return self::$_instance === null ? self::$_instance = new self() : self::$_instance;
    }

    public function init() {
        add_action( 'init', array( $this, 'save_setting_elements' ) );
        add_action( 'init', array( $this, 'save_setting_api' ) );
    }

    public function save_setting_elements() {
        if (!isset($_POST['save_setting_elements_nonce'])
            || !wp_verify_nonce(sanitize_text_field($_POST['save_setting_elements_nonce']), 'save_setting_elements_action')) {
            return;
        }

        $elements = isset($_POST['ube_elements']) ? ube_recursive_sanitize_text_field($_POST['ube_elements']) : array();

        $available_elements = ube_get_elements_available();

        foreach ($available_elements as $el) {
            if (!isset($elements[$el])) {
                $elements[$el] = 0;
            }
        }

        ube_update_setting_elements($elements);

        UBE_Admin_Message::get_instance()->add_message(esc_html__('Elements setting save changed!', 'ube'), 'success');

        wp_redirect($_POST['_wp_http_referer']);
        die();
    }

    public function save_setting_api() {
        if (!isset($_POST['save_setting_api_nonce'])
            || !wp_verify_nonce(sanitize_text_field($_POST['save_setting_api_nonce']), 'save_setting_api_action')) {
            return;
        }

        $api = isset($_POST['ube_api']) ? ube_recursive_sanitize_text_field($_POST['ube_api']) : array();

        ube_update_setting_integrated_api($api);

        UBE_Admin_Message::get_instance()->add_message(esc_html__('API setting save changed!', 'ube'), 'success');

        wp_redirect($_POST['_wp_http_referer']);
        die();
    }
}
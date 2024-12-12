<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('UBE_Admin_Settings')):
    class UBE_Admin_Settings
    {
        private static $_instance = null;

        public static function get_instance() {
            if (self::$_instance === null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
            add_action('admin_menu', array($this, 'admin_menu'));
        }

        public function admin_menu() {
            add_menu_page(
                esc_html__('UBE Elements', 'ube'),
                esc_html__('UBE Elements', 'ube'),
                'manage_options',
                'ube-settings',
                array($this, 'ube_admin_page'),
                'dashicons-chart-pie',
                3
            );
        }

        public function ube_admin_page() {
            ube_get_admin_template('ube-settings.php');
        }
    }
endif;
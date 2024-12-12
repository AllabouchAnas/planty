<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('UBE_Admin_Core')):
    class UBE_Admin_Core
    {
        private static $_instance = null;

        public static function get_instance() {
            if (self::$_instance === null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
            UBE_Admin_Settings::get_instance()->init();
            UBE_Admin_Message::get_instance()->init();
        }
    }
endif;
<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Lustria_Cache')) {
    class G5Plus_Lustria_Cache
    {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        private $group = 'G5Plus_Lustria';

        public function set_cache( $key, $data,$expire = 0 ) {
            return wp_cache_set($key,$data,$this->group,$expire);
        }

        public function get_cache( $key, $default = null ) {
            $found = false;
            $cache = wp_cache_get($key,$this->group,false,$found);
            return $found ? $cache : $default;
        }

        public function get_sidebar() {
            $cache_key = 'sidebar';
            $sidebar = $this->get_cache($cache_key);
            if ($sidebar !== null) {
                return $sidebar;
            }
            $sidebar = G5Plus_Lustria()->options()->get_sidebar();
            if (function_exists('is_woocommerce') && is_woocommerce()) {
                $presetId = G5Plus_Lustria()->helper()->getCurrentPreset();
                $custom_sidebar = G5Plus_Lustria()->metaBox()->get_sidebar();
                if (empty($presetId) && empty($custom_sidebar) && $sidebar == 'main') {
                    $sidebar = 'woocommerce';
                }

            }

            if ((function_exists('is_cart') && is_cart())
            || (function_exists('is_checkout') && is_checkout())
            || (function_exists('is_account_page') && is_account_page())) {
                $sidebar = '';
            }

            $this->set_cache($cache_key,$sidebar);
            return $sidebar;
        }


    }
}
<?php
if (!class_exists('G5P_Inc_Term_Meta')) {
    class G5P_Inc_Term_Meta {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_page_title_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_page_title_enable', $id); }
        public function get_page_title_content_block($id = ''){ return $this->getMetaValue('g5plus_lustria_page_title_content_block', $id); }
        public function get_page_title_content($id = ''){ return $this->getMetaValue('g5plus_lustria_page_title_content', $id); }
        public function get_product_taxonomy_color($id = ''){ return $this->getMetaValue('g5plus_lustria_product_taxonomy_color', $id); }
        public function get_product_taxonomy_text($id = ''){ return $this->getMetaValue('g5plus_lustria_product_taxonomy_text', $id); }
        public function get_product_taxonomy_image($id = ''){ return $this->getMetaValue('g5plus_lustria_product_taxonomy_image', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $queried_object = get_queried_object();
                $id = $queried_object->term_id;
            }

            $value = get_term_meta($id, $meta_key, true);
            if ($value === '') {
                $default = &$this->getDefault();
                if (isset($default[$meta_key])) {
                    $value = $default[$meta_key];
                }
            }
            return $value;
        }


        public function &getDefault() {
            $default = array (
                'g5plus_lustria_page_title_enable' => '',
                'g5plus_lustria_page_title_content_block' => '',
                'g5plus_lustria_page_title_content' => '',
                'g5plus_lustria_product_taxonomy_color' => '',
                'g5plus_lustria_product_taxonomy_text' => '',
                'g5plus_lustria_product_taxonomy_image' => ''
            );
            return $default;
        }
    }
}
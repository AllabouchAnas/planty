<?php
if (!class_exists('G5Plus_Lustria_MetaBox_Product')) {
    class G5Plus_Lustria_MetaBox_Product {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_product_single_layout($id = ''){ return $this->getMetaValue('g5plus_lustria_product_single_layout', $id); }
        public function get_product_single_video($id = ''){ return $this->getMetaValue('g5plus_lustria_product_single_video', $id); }
        public function get_product_related_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_enable', $id); }
        public function get_product_related_algorithm($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_algorithm', $id); }
        public function get_product_related_carousel_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_carousel_enable', $id); }
        public function get_product_related_columns_gutter($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_columns_gutter', $id); }
        public function get_product_related_columns($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_columns', $id); }
        public function get_product_related_columns_md($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_columns_md', $id); }
        public function get_product_related_columns_sm($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_columns_sm', $id); }
        public function get_product_related_columns_xs($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_columns_xs', $id); }
        public function get_product_related_columns_mb($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_columns_mb', $id); }
        public function get_product_related_per_page($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_per_page', $id); }
        public function get_product_related_animation($id = ''){ return $this->getMetaValue('g5plus_lustria_product_related_animation', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $id = get_the_ID();
            }

            $value = get_post_meta($id, $meta_key, true);
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
                'g5plus_lustria_product_single_layout' => '',
                'g5plus_lustria_product_single_video' => '',
                'g5plus_lustria_product_related_enable' => '',
                'g5plus_lustria_product_related_algorithm' => '',
                'g5plus_lustria_product_related_carousel_enable' => '',
                'g5plus_lustria_product_related_columns_gutter' => '',
                'g5plus_lustria_product_related_columns' => '',
                'g5plus_lustria_product_related_columns_md' => '',
                'g5plus_lustria_product_related_columns_sm' => '',
                'g5plus_lustria_product_related_columns_xs' => '',
                'g5plus_lustria_product_related_columns_mb' => '',
                'g5plus_lustria_product_related_per_page' => '',
                'g5plus_lustria_product_related_animation' => ''
            );
            return $default;
        }
    }
}
<?php
if (!class_exists('G5Plus_Lustria_MetaBox_Post')) {
	class G5Plus_Lustria_MetaBox_Post {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_single_post_layout($id = ''){ return $this->getMetaValue('g5plus_lustria_single_post_layout', $id); }
        public function get_single_reading_process_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_reading_process_enable', $id); }
        public function get_single_tag_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_tag_enable', $id); }
        public function get_single_share_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_share_enable', $id); }
        public function get_single_navigation_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_navigation_enable', $id); }
        public function get_single_author_info_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_author_info_enable', $id); }
        public function get_single_related_post_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_enable', $id); }
        public function get_single_related_post_algorithm($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_algorithm', $id); }
        public function get_single_related_post_carousel_enable($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_carousel_enable', $id); }
        public function get_single_related_post_per_page($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_per_page', $id); }
        public function get_single_related_post_columns_gutter($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_columns_gutter', $id); }
        public function get_single_related_post_columns($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_columns', $id); }
        public function get_single_related_post_columns_md($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_columns_md', $id); }
        public function get_single_related_post_columns_sm($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_columns_sm', $id); }
        public function get_single_related_post_columns_xs($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_columns_xs', $id); }
        public function get_single_related_post_columns_mb($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_columns_mb', $id); }
        public function get_single_related_post_paging($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_paging', $id); }
        public function get_single_related_post_animation($id = ''){ return $this->getMetaValue('g5plus_lustria_single_related_post_animation', $id); }
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
                'g5plus_lustria_single_post_layout' => '',
                'g5plus_lustria_single_reading_process_enable' => '',
                'g5plus_lustria_single_tag_enable' => '',
                'g5plus_lustria_single_share_enable' => '',
                'g5plus_lustria_single_navigation_enable' => '',
                'g5plus_lustria_single_author_info_enable' => '',
                'g5plus_lustria_single_related_post_enable' => '',
                'g5plus_lustria_single_related_post_algorithm' => '',
                'g5plus_lustria_single_related_post_carousel_enable' => '',
                'g5plus_lustria_single_related_post_per_page' => '',
                'g5plus_lustria_single_related_post_columns_gutter' => '',
                'g5plus_lustria_single_related_post_columns' => '',
                'g5plus_lustria_single_related_post_columns_md' => '',
                'g5plus_lustria_single_related_post_columns_sm' => '',
                'g5plus_lustria_single_related_post_columns_xs' => '',
                'g5plus_lustria_single_related_post_columns_mb' => '',
                'g5plus_lustria_single_related_post_paging' => '',
                'g5plus_lustria_single_related_post_animation' => '',
            );
            return $default;
        }
    }
}
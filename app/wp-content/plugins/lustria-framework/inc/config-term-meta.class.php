<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Term_Meta')) {
    class G5P_Inc_Config_Term_Meta
    {
        /*
     * loader instances
     */
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {
            // Defined Theme Options
            add_filter('gsf_term_meta_config', array($this, 'register_term_meta'));
        }

        public function getProductTaxonomy() {
            $taxonomies = array();
            if(class_exists('WooCommerce')) {
                $attribute_taxonomies = wc_get_attribute_taxonomies();
                if (!empty($attribute_taxonomies)) {
                    foreach ($attribute_taxonomies as $tax) {
                        if (wc_attribute_taxonomy_name($tax->attribute_name)) {
                            $taxonomies['pa_' . $tax->attribute_name] = $tax->attribute_type;
                        }
                    }
                }
            }
            return $taxonomies;
        }

        public function getTaxonomy()
        {
            return apply_filters('gsf_term_meta_taxonomy', array('category'));
        }

        public function register_term_meta()
        {
            $prefix = G5P()->getMetaPrefix();

            $configs['gsf_taxonomy_setting'] = array(
                'name' => esc_html__('Advance Setting', 'lustria-framework'),
                'layout' => 'horizontal',
                'taxonomy' => $this->getTaxonomy(),
                'fields' => array(
                    array(
                        'id' => "{$prefix}group_page_title",
                        'type' => 'group',
                        'title' => esc_html__('Page Title', 'lustria-framework'),
                        'fields' => array(
                            G5P()->configOptions()->get_config_toggle(array(
                                'title' => esc_html__('Page Title Enable', 'lustria-framework'),
                                'id' => "{$prefix}page_title_enable"
                            ), true),
                            G5P()->configOptions()->get_config_content_block(array(
                                'id' => "{$prefix}page_title_content_block",
                                'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'lustria-framework'),
                                'required' => array("{$prefix}page_title_enable", '!=', 'off')
                            ), true),

                            array(
                                'title' => esc_html__('Custom Page title', 'lustria-framework'),
                                'id' => "{$prefix}page_title_content",
                                'type' => 'text',
                                'default' => '',
                                'required' => array("{$prefix}page_title_enable", '!=', 'off'),
                                'desc' => esc_html__('Enter custom page title for this page', 'lustria-framework')
                            )
                        )
                    )
                ));
            $configs['gsf_taxonomy_product_setting'] = array(
                'name' => esc_html__('Product Category Content', 'lustria-framework'),
                'layout' => 'horizontal',
                'taxonomy' => 'product_cat',
                'fields' => array(
                    array(
                        'id' => "{$prefix}sub_title",
                        'type' => 'text',
                        'title' => esc_html__('Sub title', 'lustria-framework'),
                        'desc' => esc_html__('Specify the Content Block to use as a category content.', 'lustria-framework'),

                    )
                ));

            if($this->getProductTaxonomy()) {
                foreach ($this->getProductTaxonomy() as $key => $value) {
                    if('select' !== $value) {
                        $configs['gsf_product_' . $key . '_setting'] = array(
                            'name' => esc_attr__('Additional Fields', 'lustria-framework'),
                            'layout' => 'horizontal',
                            'taxonomy' => array($key),
                            'fields' => array(
                                array(
                                    'title' => ucfirst($value),
                                    'id' => "{$prefix}product_taxonomy_" . $value,
                                    'type' => $value,
                                    'default' => ''
                                )
                            )
                        );
                    }
                }
            }

            return $configs;
        }
    }
}
<?php
if (!defined('ABSPATH')) exit;
if (!class_exists('G5P_Core_Vc')) {
    final class G5P_Core_Vc
    {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
            spl_autoload_register(array($this, 'vcAutoload'));
            add_action( 'plugins_loaded',array($this, 'includeVcShortcode') );
            // Custom vc param
            add_action('vc_after_init', array($this,'custom_param_vc_tta_accordions'));
            add_action('vc_after_init', array($this,'custom_param_vc_tta_tabs'));

            add_action('admin_enqueue_scripts', array($this, 'enqueue_backend_assets'));
        }

        /**
         * Field auto loader
         * @param $class
         */
        public function vcAutoload($class)
        {
            $file_name = preg_replace('/^G5P_Vc_/', '', $class);
            if ($file_name !== $class) {
                $file_name = strtolower($file_name);
                $file_name = str_replace('_', '-', $file_name);
                G5P()->loadFile(G5P()->pluginDir("core/vc/inc//{$file_name}.class.php"));
            }
        }

        public function includeVcShortcode() {
            if (class_exists('Vc_Manager')) {
                //$this->defaultTemplate()->init();
                $this->template()->init();
                $this->autoComplete()->init();
                G5P()->shortcode()->init();
                $this->customize()->init();
            }
        }

        public function enqueue_backend_assets(){
            if (class_exists('Vc_Manager') && Vc_Manager::getInstance()->backendEditor()->isValidPostType()) {
                wp_enqueue_style(G5P()->assetsHandle('vc-backend'));
                wp_enqueue_script(G5P()->assetsHandle('vc-backend'));
            }
        }

        /**
         * @return G5P_Vc_Custom_Default_Template
         */
        public function defaultTemplate() {
            return G5P_Vc_Custom_Default_Template::getInstance();
        }

        /**
         * @return G5P_Vc_Template
         */
        public function template() {
            return G5P_Vc_Template::getInstance();
        }

        /**
         * @return G5P_Vc_Auto_Complete
         */
        public function autoComplete() {
            return G5P_Vc_Auto_Complete::getInstance();
        }

        /**
         * @return G5P_Vc_Customize
         */
        public function customize() {
            return G5P_Vc_Customize::getInstance();
        }

        public function custom_param_vc_tta_accordions()
        {
            $colors = array(
                esc_html__('Accent', 'lustria-framework') => 'accent'
            );
            $param_color = WPBMap::getParam('vc_tta_accordion', 'color');
            $param_color['value'] = array_merge($colors, $param_color['value']);
            $param_color['heading'] = esc_html__('Color', 'lustria-framework');
            $param_color['std'] = 'accent';
            vc_update_shortcode_param('vc_tta_accordion', $param_color);
        }

        public function custom_param_vc_tta_tabs()
        {
            $colors = array(
                esc_html__('Accent', 'lustria-framework') => 'accent'
            );
            $param_color = WPBMap::getParam('vc_tta_tabs', 'color');
            $param_shape = WPBMap::getParam('vc_tta_tabs', 'shape');
            $param_color['value'] = array_merge($colors, $param_color['value']);
            $param_color['heading'] = esc_html__('Color', 'lustria-framework');
            $param_color['std'] = 'accent';
            vc_update_shortcode_param('vc_tta_tabs', $param_color);
            vc_update_shortcode_param('vc_tta_tabs', $param_shape);
        }
    }
}
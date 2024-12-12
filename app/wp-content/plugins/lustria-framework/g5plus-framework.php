<?php
/**
 *    Plugin Name: Lustria Framework
 *    Plugin URI: http://g5plus.net
 *    Description: The Lustria Framework plugin.
 *    Version: 3.0
 *    Author: g5plus
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: lustria-framework
 *    Domain Path: /languages/
 *
 * @package G5Plus Framework
 * @category Core
 * @author g5plus
 *
 **/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5Plus_Framework')) {
    class G5Plus_Framework
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

        /**
         * Init plugin
         */
        public function init()
        {
            /**
             * Auto load libraries
             */
            spl_autoload_register(array($this, 'incAutoload'));
            spl_autoload_register(array($this, 'coreAutoload'));
            spl_autoload_register(array($this, 'dashboardAutoload'));

            $this->hook()->init();
            $this->loadFile(G5P()->pluginDir('libs/smart-framework/smart-framework.php'));

            $this->cpt()->init();
            $this->core()->init();
            $this->configOptions()->init();
            $this->configMetaBox()->init();
            $this->configTermMeta()->init();
            $this->configUserMeta()->init();
            $this->widget()->init();
			$this->polylang()->init();
			$this->elementor()->init();

            add_action('plugins_loaded', array($this, 'loadTextDomain'));
        }

        public function loadTextDomain()
        {
            load_plugin_textdomain('lustria-framework', false, $this->pluginDir('languages'));
        }

        /**
         * Get plugin url
         *
         * @param string $path
         * @return string
         */
        public function pluginUrl($path = '')
        {
            $plugin_dir = str_replace('\\', '/', trailingslashit(dirname(__FILE__)));
            $template_dir = str_replace('\\', '/', trailingslashit(get_template_directory()));
            if (strpos($plugin_dir, $template_dir) === false) {
                return trailingslashit(plugins_url($this->pluginName())) . $path;
            }

            $sub_template_dir = substr($plugin_dir, strlen($template_dir));
            return trailingslashit(get_template_directory_uri() . $sub_template_dir) . $path;
        }

        public function pluginName()
        {
            return 'lustria-framework';
        }

        public function theme_info() {
            return  apply_filters( 'gsf_theme_info', array(
                'support' => 'http://support.g5plus.net/',
                'docs'    => 'http://document.g5plus.net/lustria/',
                'knowledgeBase' => 'http://support.g5plus.net/knowledge-base/',
                'video_tutorials_url' => '#',
                'changelog' => 'http://lustria.g5plus.net/changelog.html'
            ) );
        }

        /**
         * Get Plugin Dir
         *
         * @param string $path
         * @return string
         */
        public function pluginDir($path = '')
        {
            return plugin_dir_path(__FILE__) . $path;
        }

	    public function template_path() {
		    return apply_filters('gsf_template_path', 'lustria-framework');
	    }



	    public function get_template_element( $template_name, $args = array() ) {
		    $located = $this->locate_template_element($template_name, $args);

		    $action_args = array(
			    'located'       => $located,
			    'template_name' => $template_name,
			    'args' => $args
		    );

		    if ($action_args['located'] !== '') {

			    if ( ! empty( $args ) && is_array( $args ) ) {
				    if ( isset( $args['action_args'] ) ) {
					    _doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_template_element.', 'lustria-framework' ), $this->pluginVer() );
					    unset( $args['action_args'] );
				    }
				    extract( $args ); // @codingStandardsIgnoreLine
			    }

			    do_action( 'gsf_before_template_element_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
			    include( $action_args['located'] );
			    do_action( 'gsf_after_template_element_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
		    }
	    }


	    public function locate_template_element($template_name, $args = array()) {
		    $located = '';
		    // Theme or child theme template
		    $template = trailingslashit(get_stylesheet_directory()) . $this->template_path() . $template_name;
		    if (file_exists($template)) {
			    $located = $template;
		    } else {
			    $template = trailingslashit(get_template_directory()) . $this->template_path() . $template_name;
			    if (file_exists($template)) {
				    $located = $template;
			    }
		    }

		    // Plugin template
		    if (! $located) {
			    $located = $this->pluginDir() . 'elements/' . $template_name;
		    }

		    $located = apply_filters( 'gsf_locate_template_element', $located, $template_name, $args);

		    if (!file_exists($located)) {
			    return '';
		    }

		    // Return what we found.
		    return $located;
	    }

        public function loadFile($path)
        {
            if ($path && is_readable($path)) {
                include_once($path);
                return true;
            }
            return false;
        }

        public function assetsHandle($handle = '')
        {
            return apply_filters('gsf_assets_prefix', 'gsf_') . $handle;
        }

        /**
         * Auto load libraries included
         *
         * @param string $class Class name
         */
        public function incAutoLoad($class)
        {
            $file_name = preg_replace('/^G5P_Inc_/', '', $class);
            if ($file_name !== $class) {
                $file_name = strtolower($file_name);
                $file_name = str_replace('_', '-', $file_name);
                $this->loadFile(G5P()->pluginDir("inc/{$file_name}.class.php"));
            }
        }

        /**
         * Field auto loader
         * @param $class
         */
        public function coreAutoload($class)
        {
            $file_name = preg_replace('/^G5P_Core_/', '', $class);
            if ($file_name !== $class) {
                $file_name = strtolower($file_name);
                $file_name = str_replace('_', '-', $file_name);
                $this->loadFile(G5P()->pluginDir("core/{$file_name}/{$file_name}.class.php"));
            }
        }

        public function dashboardAutoload($class)
        {
            $file_name = preg_replace('/^G5P_Dashboard_/', '', $class);
            if ($file_name !== $class) {
                $file_name = strtolower($file_name);
                $file_name = str_replace('_', '-', $file_name);
                G5P()->loadFile(G5P()->pluginDir("core/dashboard/{$file_name}.class.php"));
            }
        }

        /**
         * Get Option Name
         * @return string
         */
        public function getOptionName()
        {
            return 'g5plus_lustria_options';
        }

        /**
         * Get Option Skin Name
         * @return string
         */
        public function getOptionSkinName()
        {
            return 'g5plus_lustria_skin_options';
        }

        /**
         * Get Meta Prefix
         * @return string
         */
        public function getMetaPrefix()
        {
            return 'g5plus_lustria_';
        }

        public function pluginVer()
        {
            if (!function_exists('get_plugin_data')) {
                require_once(ABSPATH . 'wp-admin/includes/plugin.php');
            }
            $plugin_data = get_plugin_data(__FILE__);
            return $plugin_data['Version'];
        }

        public function is_dev(){
            return function_exists('DEV');
        }

        /**
         * @return G5P_Inc_Hook
         */
        public function hook()
        {
            return G5P_Inc_Hook::getInstance();
        }

        /**
         * GSF Assets
         *
         * @return G5P_Inc_Assets
         */
        public function assets()
        {
            return G5P_Inc_Assets::getInstance();
        }

        /**
         * @return G5P_Inc_Settings
         */
        public function settings()
        {
            return G5P_Inc_Settings::getInstance();
        }

        /**
         * @return G5P_Inc_Config_Options
         */
        public function configOptions()
        {
            return G5P_Inc_Config_Options::getInstance();
        }

        /**
         * @return G5P_Inc_Config_Meta_Boxes
         */
        public function configMetaBox()
        {
            return G5P_Inc_Config_Meta_Boxes::getInstance();
        }

        /**
         * @return G5P_Inc_Config_Term_Meta
         */
        public function configTermMeta()
        {
            return G5P_Inc_Config_Term_Meta::getInstance();
        }

        /**
         * @return G5P_Inc_Config_User_Meta
         */
        public function configUserMeta()
        {
            return G5P_Inc_Config_User_Meta::getInstance();
        }

        /**
         * @return G5P_Inc_Custom_Post_Type
         */
        public function cpt()
        {
            return G5P_Inc_Custom_Post_Type::getInstance();
        }

        /**
         * @return G5P_Inc_Options
         */
        public function options()
        {
            return G5P_Inc_Options::getInstance();
        }

        /**
         * @return G5P_Inc_Options_Skin
         */
        public function optionsSkin()
        {
            return G5P_Inc_Options_Skin::getInstance();
        }

        /**
         * @return G5P_Inc_MetaBox
         */
        public function metaBox()
        {
            return G5P_Inc_MetaBox::getInstance();
        }

        /**
         * @return G5P_Inc_MetaBox_Post
         */
        public function metaBoxPost()
        {
            return G5P_Inc_MetaBox_Post::getInstance();
        }

        /**
         * @return G5P_Inc_Term_Meta
         */
        public function termMeta()
        {
            return G5P_Inc_Term_Meta::getInstance();
        }

        /**
         * @return G5P_Inc_Term_Meta_Product
         */
        public function termMetaProduct()
        {
            return G5P_Inc_Term_Meta_Product::getInstance();
        }

        /**
         * @return G5P_Inc_User_Meta
         */
        public function userMeta()
        {
            return G5P_Inc_User_Meta::getInstance();
        }


        /**
         * @return G5P_Inc_ShortCode
         */
        public function shortCode()
        {
            return G5P_Inc_ShortCode::getInstance();
        }

        /**
         * GSF helper function
         * @return G5P_Inc_Helper
         */
        public function helper()
        {
            return G5P_Inc_Helper::getInstance();
        }

        /**
         * GSF file function
         * @return G5P_Inc_File
         */
        public function file() {
            return G5P_Inc_File::getInstance();
        }

        /**
         * GSF Core
         * @return G5P_Core_Core
         */
        public function core()
        {
            return G5P_Core_Core::getInstance();
        }

        /**
         * @return G5P_Inc_Widget
         */
        public function widget()
        {
            return G5P_Inc_Widget::getInstance();
        }


        /**
         * @return G5P_Inc_MetaBox_Product
         */
        public function metaBoxProduct() {
            return G5P_Inc_MetaBox_Product::getInstance();
        }

	    /**
	     * @return G5P_Inc_Polylang
	     */
		public function polylang() {
			return G5P_Inc_Polylang::getInstance();
		}

	    /**
	     * @return G5P_Inc_Elementor
	     */
	    public function elementor() {
		    return G5P_Inc_Elementor::getInstance();
	    }



        public function image_resize()
        {
            require_once(G5P()->pluginDir('libs/class-g5plus-image-resize.php'));
            return G5Plus_Image_Resize::getInstance();
        }

        public function activation_hook() {
            $pt_array = ( $pt_array = get_option( 'wpb_js_content_types' ) ) ? ( $pt_array ) : array( 'page' );

            if ( ! in_array( 'gsf_content', $pt_array ) ) {
                $pt_array[] = 'gsf_content';
            }

            if ( ! in_array( 'gsf_template', $pt_array ) ) {
                $pt_array[] = 'gsf_template';
            }

            if ( ! in_array( 'xmenu_mega', $pt_array ) ) {
                $pt_array[] = 'xmenu_mega';
            }

            // Update user roles
            $user_roles = get_option( 'wp_user_roles' );

            if ( ! empty( $user_roles ) ) {
                foreach ( $user_roles as $key => $value ) {
                    $user_roles[ $key ]['capabilities']['vc_access_rules_post_types']              = 'custom';
                    $user_roles[ $key ]['capabilities']['vc_access_rules_post_types/page']         = true;
                    $user_roles[ $key ]['capabilities']['vc_access_rules_post_types/gsf_xmenu_mega'] = true;
                    $user_roles[ $key ]['capabilities']['vc_access_rules_post_types/gsf_content']    = true;
                    $user_roles[ $key ]['capabilities']['vc_access_rules_post_types/gsf_template']     = true;
                }
            }

            update_option( 'wpb_js_content_types', $pt_array );
            update_option( 'wp_user_roles', $user_roles );
        }

    }

    /**
     * Get Plugin Object Instance
     *
     * @return G5Plus_Framework
     */
    function G5P()
    {
        return G5Plus_Framework::getInstance();
    }

    /**
     * Init Plugin
     */
    G5P()->init();

    register_activation_hook( __FILE__, array(G5P(),'activation_hook'));

}

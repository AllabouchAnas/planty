<?php
/**
 *    Plugin Name: G5Plus Post Like
 *    Plugin URI: http://g5plus.net
 *    Description: Post Like
 *    Version: 1.1
 *    Author: g5plus
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: g5plus-post-like
 *    Domain Path: /languages/
 **/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5Plus_Post_Like')) {
    class G5Plus_Post_Like {

        public $key = 'g5plus_post_liked';


        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
	        spl_autoload_register(array($this, 'autoLoad'));
            add_action( 'after_setup_theme', array( $this, 'register_shortcode' ) );
            add_action('init', array($this, 'registerAssets'));
            add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'));
	        add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueAssets' ) );

            add_action('wp_ajax_nopriv_gpl_post_like', array($this,'like'));
            add_action('wp_ajax_gpl_post_like', array($this,'like'));
            $this->includes();
        }

        public function autoLoad($class) {
	        $file_name = preg_replace('/^GPL_/', '', $class);
	        if ($file_name !== $class) {
		        $file_name = strtolower($file_name);
		        $file_name = str_replace('_', '-', $file_name);
		        $this->loadFile(GPL()->pluginDir("inc/{$file_name}.class.php"));
	        }
        }

        public function includes() {
			$this->columns()->init();
        }

        /**
         * Get plugin assets url
         * @param $file
         * @return string
         */
        public function getAssetUrl($file)
        {
            if (!file_exists($this->pluginDir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
                $ext = explode('.', $file);
                $ext = end($ext);
                $normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
                if ($normal_file != $file) {
                    $normal_file = untrailingslashit($normal_file) . ".{$ext}";
                    if (file_exists($this->pluginDir($normal_file))) {
                        return $this->pluginUrl(untrailingslashit($normal_file));
                    }
                }
            }
            return $this->pluginUrl(untrailingslashit($file));
        }

        public function assetsHandle($handle = '')
        {
            return apply_filters('gpl_assets_prefix', 'gpl_') . $handle;
        }


        public function registerAssets() {

            //ladda
            wp_register_style('ladda', $this->getAssetUrl('assets/vendors/ladda/ladda-themeless.min.css'), array(), '1.0.5');
            wp_register_script('ladda-spin', $this->getAssetUrl('assets/vendors/ladda/spin.min.js'), array('jquery'), '1.0.5', true);
            wp_register_script('ladda', $this->getAssetUrl('assets/vendors/ladda/ladda.min.js'), array('jquery','ladda-spin'), '1.0.5', true);
            wp_register_script('ladda-jquery', $this->getAssetUrl('assets/vendors/ladda/ladda.jquery.min.js'), array('jquery','ladda'), '1.0.5', true);




            wp_register_style('font-awesome', $this->getAssetUrl('assets/vendors/font-awesome/css/font-awesome.css'), array(), '4.7.0');

            wp_register_script($this->assetsHandle('main'),$this->getAssetUrl('assets/js/main.min.js'),array('jquery'),'1.0',true);
	        wp_register_script($this->assetsHandle('admin-post'),$this->getAssetUrl('assets/js/admin-post.min.js'),array('jquery'),'1.0',true);
        }

        public function enqueueAssets() {
            //ladda
            wp_enqueue_style('ladda');
            wp_enqueue_script('ladda-jquery');

            // js Main
            wp_enqueue_script($this->assetsHandle('main'));

            // js variable
            wp_localize_script(
                $this->assetsHandle('main'),
                'gpl_variable',
                array(
                    'ajax_url' => admin_url('admin-ajax.php')
                )
            );
        }

	    public function adminEnqueueAssets($page) {


        	if ($page === 'post.php' || $page === 'post-new.php') {
		        $post_types = array('post');

		        global $post_type;

		        if ( ! in_array( $post_type, (array) $post_types ) )
			        return;
		        wp_enqueue_script($this->assetsHandle('admin-post'));
	        }

	    }

        public function register_shortcode() {
            add_shortcode( 'g5plus-post-like', array( $this, 'render' ) );
        }

        public function pluginName() {
            return 'g5plus-post-like';
        }

        /**
         * Get plugin url
         *
         * @param string $path
         * @return string
         */
        public function pluginUrl($path = '') {
            $plugin_dir = str_replace('\\', '/', trailingslashit(dirname(__FILE__)));
            $template_dir = str_replace('\\', '/', trailingslashit(get_template_directory()));
            if (strpos($plugin_dir, $template_dir) === false) {
                return trailingslashit(plugins_url($this->pluginName())) . $path;
            }

            $sub_template_dir = substr($plugin_dir, strlen($template_dir));
            return trailingslashit(get_template_directory_uri() . $sub_template_dir) . $path;
        }

        /**
         * Get Plugin Dir
         *
         * @param string $path
         * @return string
         */
        public function pluginDir($path = '') {
            return plugin_dir_path(__FILE__) . $path;
        }

        public function loadTextDomain() {
            load_plugin_textdomain( 'g5plus-post-like', false, $this->pluginDir('languages'));
        }

        public function loadFile($path) {
            if ( $path && is_readable($path) ) {
                include_once($path);
                return true;
            }
            return false;
        }

        public function getTemplate($slug, $args = array()) {
            if ($args && is_array($args)) {
                extract($args);
            }

            $public_template = apply_filters('gpl_template_path', 'g5plus-post-like/');
            $located = $this->pluginDir("templates/{$slug}.php");

            /**
             * Include template in child theme
             */
            if (is_readable(trailingslashit(get_stylesheet_directory()) . "{$public_template}{$slug}.php")) {
                $located = trailingslashit(get_stylesheet_directory()) . "{$public_template}{$slug}.php";
            }
            else if (is_readable(trailingslashit(get_template_directory()) . "{$public_template}{$slug}.php")) {
                /**
                 * Include template in current theme
                 */
                $located = trailingslashit(get_template_directory()) . "{$public_template}{$slug}.php";
            }

            // Allow 3rd party plugins to filter template file from their plugin.
            $located = apply_filters('dlp_addons_template_path', $located, $slug, $args);

            do_action( 'gpl_before_template_part', $located, $slug, $args );
            include $located;
            do_action( 'gpl_before_template_part', $located, $slug, $args );
        }

        public function render(){
            $this->getTemplate('post-like');
        }

        /**
         * Check Post is liked
         *
         * @param null $post_id
         * @return bool|int
         */
        public function get_post_liked($post_id = null){
            if (!isset($post_id) || ($post_id == null)) {
                $post_id = get_the_ID();
            }
            $postLiked = isset($_COOKIE[$this->key]) ? $_COOKIE[$this->key] : '';
            return strpos($postLiked,"||{$post_id}||") === false ? false : true;
        }

        /**
         * Get Like Count
         *
         * @param null $post_id
         * @return int|mixed
         */
        public function get_like_count($post_id = null) {
            if (!isset($post_id) || ($post_id == null)) {
                $post_id = get_the_ID();
            }

            $like_count = get_post_meta($post_id,$this->key,true);
            if ($like_count === '') {
                $like_count = 0;
            }
            return $like_count;
        }

        /**
         * Update Like Count
         *
         * @param $like_count
         * @param null $post_id
         */
        public function update_like_count($like_count,$post_id =  null) {
            if (!isset($post_id) || ($post_id == null)) {
                $post_id = get_the_ID();
            }
            if ($like_count < 0) $like_count = 0;
            update_post_meta($post_id,$this->key,$like_count);
        }

        public function like(){
            $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
            if (!wp_verify_nonce($nonce,$this->key)){
                wp_send_json_error();
            }
            $post_id = isset($_POST['id']) ? intval($_POST['id'])  : -1;
            $status = isset($_POST['status']) ? json_decode($_POST['status']) : false;
            $like_count = $this->get_like_count($post_id);
            $postLiked = isset($_COOKIE[$this->key]) ? $_COOKIE[$this->key] : '';
            if ($status === false) {
                $like_count++;
                if ($postLiked === '') {
                    $postLiked = "||{$post_id}||";
                } else {
                    $postLiked .= "{$post_id}||";
                }
            } else {
                $like_count--;
                $postLiked = str_replace("||{$post_id}||",'',$postLiked);
            }
            $this->update_like_count($like_count,$post_id);
            setcookie($this->key,$postLiked,time()+60*60*24*30,'/');
	        $like_count = number_format_i18n($like_count);
            wp_send_json_success($like_count);
        }

        public function get_spinner_color() {
            return apply_filters('gpl_spinner_color','#f00');
        }

	    /**
	     * @return GPL_Columns
	     */
        public function columns() {
        	return GPL_Columns::getInstance();
        }
    }

    /**
     * Get Plugin Object Instance
     *
     * @return G5Plus_Post_Like
     */
    function GPL() {
        return G5Plus_Post_Like::getInstance();
    }

    /**
     * Init Plugin
     */
    GPL()->init();
}
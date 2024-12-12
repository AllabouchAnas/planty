<?php
/**
 *    Plugin Name: G5 Install Demo
 *    Plugin URI: http://g5plus.net
 *    Description: Install site demo data with one click.
 *    Version: 1.1.3
 *    Author: G5
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: gid
 *    Domain Path: /languages/
 *
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'G5InstallDemo' ) ) {
	class G5InstallDemo {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public $meta_prefix = 'gid_';

		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

			$this->init();
		}

		public function init() {
			$this->includes();
			do_action('gid_init');
		}

		public function load_file( $path ) {
			if ( $path && is_readable( $path ) ) {
				include_once $path;

				return true;
			}

			return false;
		}

		public function plugin_dir( $path = '' ) {
			return plugin_dir_path( __FILE__ ) . $path;
		}

		public function plugin_url( $path = '' ) {
			return trailingslashit( plugins_url( basename( __DIR__ ) ) ) . $path;
		}

		public function includes() {
			$this->load_file( $this->plugin_dir( 'inc/assets.php' ) );
			$this->load_file( $this->plugin_dir( 'inc/install-setup.php' ) );
			$this->load_file( $this->plugin_dir( 'inc/dashboard-menu.php' ) );
			$this->load_file( $this->plugin_dir( 'inc/ajax.php' ) );
			$this->load_file( $this->plugin_dir( 'inc/elementor.php' ) );
		}

		public function load_text_domain() {
			load_plugin_textdomain( 'gid', false, $this->plugin_dir( 'languages' ) );
		}

		public function assets_handle( $handle = '' ) {
			return apply_filters( 'gid_assets_prefix', $this->meta_prefix ) . $handle;
		}

		public function asset_url( $file ) {
			if ( ! file_exists( $this->plugin_dir( $file ) ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
				$ext         = explode( '.', $file );
				$ext         = end( $ext );
				$normal_file = preg_replace( '/((\.min\.css)|(\.min\.js))$/', '', $file );
				if ( $normal_file != $file ) {
					$normal_file = untrailingslashit( $normal_file ) . ".{$ext}";
					if ( file_exists( $this->plugin_dir( $normal_file ) ) ) {
						return $this->plugin_url( untrailingslashit( $normal_file ) );
					}
				}
			}

			return $this->plugin_url( untrailingslashit( $file ) );
		}



		public function get_plugin_template( $slug, $args = array() ) {
			$located = $this->plugin_dir( $slug );

			$action_args = array(
				'located'       => $located,
			);

			if ( ! file_exists( $action_args['located'] ) ) {
				_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $slug ), $this->plugin_ver() );
				return '';
			}

			if ( ! empty( $args ) && is_array( $args ) ) {
				if ( isset( $args['action_args'] ) ) {
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_plugin_template.', 'gid' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			include( $action_args['located']);

			return $action_args['located'];
		}


		public function get_template( $template_name, $args = array() ) {
			$located = $this->locate_template($template_name, $args);
			$action_args = array(
				'template_name' => $template_name,
				'located'       => $located,
				'args'          => $args,
			);

			if ( ! empty( $args ) && is_array( $args ) ) {
				if ( isset( $args['action_args'] ) ) {
					_doing_it_wrong( __FUNCTION__, __( 'action_args should not be overwritten when calling get_template.', 'gid' ), $this->plugin_ver() );
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}

			if ($action_args['located'] !== '') {
				do_action( 'gid_before_template_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
				include( $action_args['located'] );
				do_action( 'gid_after_template_part', $action_args['template_name'], $action_args['located'], $action_args['args'] );
			}
		}

		public function locate_template( $template_name, $args = array() ) {
			$located = '';

			// Theme or child theme template
			$template = trailingslashit( get_stylesheet_directory() ) . 'g5plus/gid/' . $template_name;
			if ( file_exists( $template ) ) {
				$located = $template;
			}

			// Plugin template
			if ( ! $located ) {
				$located = $this->plugin_dir() . 'templates/' . $template_name;
			}

			if ( ! file_exists( $located ) ) {
				_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), $this->plugin_ver() );

				return '';
			}

			// Return what we found.
			return apply_filters( 'gid_locate_template', $located, $template_name, $args );
		}

		public function plugin_ver() {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_ver  = isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '1.1.1';
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ) {
				$plugin_ver = mt_rand() . '';
			}

			return $plugin_ver;
		}
		
		public function demo_menu_parent() {
			return apply_filters('gid_install_demo_page_parent', 'themes.php');
		}
	}

	function GID() {
		return G5InstallDemo::getInstance();
	}

	GID();
}
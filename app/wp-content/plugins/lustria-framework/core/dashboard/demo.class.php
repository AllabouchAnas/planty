<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5P_Dashboard_Demo')) {
	class G5P_Dashboard_Demo {
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

		public function init(){
			add_filter('gid_install_demo_page_parent',array($this,'change_gid_install_demo_page_parent'));
			add_filter('gsf_dashboard_menu',array($this,'change_dashboard_menu'));
			add_action('gid_demo_page_before',array($this,'add_tabs'));
			add_filter('gid_demo_list',array($this,'demo_list'));
			add_filter('g5dev_option_key_for_setting_file', array($this,'change_option_key_for_setting_file'));

			add_filter('g5dev_option_key_for_attachment_file', array($this,'change_option_key_for_attachment_file'));
			add_filter('g5dev_attachment_in_post_type_for_import_setting',array($this,'change_attachment_in_post_type_for_import_setting'));

			add_filter('gid_post_types_register_before_install',array($this,'change_post_types_register_before_install'));
			add_filter('gid_taxonomy_register_before_install', array($this,'change_taxonomy_register_before_install'));

			add_filter('gid_post_type_allow_install' , array($this,'change_post_type_allow_install'));

			add_filter('gid_post_meta_change_term_id',array($this,'change_post_meta_change_term_id'));

			add_filter('gid_term_meta_change_post_id', array($this,'change_term_meta_change_post_id'));

			add_filter('gid_options_key_change_theme_options', array($this,'change_options_key_change_theme_options'));

			add_filter('gid_post_meta_change_media_field', array($this,'change_post_meta_change_media_field'));

			add_filter('gid_post_meta_change_post_id',array($this,'change_post_meta_change_post_id'));

		}

		public function change_post_meta_change_post_id($meta_keys) {
			$metaPrefix = G5P()->getMetaPrefix();
			return wp_parse_args(array(
				"{$metaPrefix}page_title_content_block"
			),$meta_keys);
		}

		public function change_post_meta_change_media_field($meta_keys) {
			return wp_parse_args(array(
				'gf_format_gallery_images'
			),$meta_keys);
		}

		public function change_options_key_change_theme_options($options_keys) {
			return wp_parse_args(array(
				'gsf_preset_options_keys_%' => 'like',
				G5P()->getOptionName() . '%' => 'like',
			),$options_keys);
		}

		public function change_term_meta_change_post_id($meta_keys) {
			$metaPrefix = G5P()->getMetaPrefix();
			return wp_parse_args(array(
				"{$metaPrefix}page_title_content_block" => '='
			),$meta_keys);
		}

		public function change_post_meta_change_term_id($meta_keys) {
			$metaPrefix = G5P()->getMetaPrefix();
			return wp_parse_args(array(
				"{$metaPrefix}page_menu" => '=',
				"{$metaPrefix}page_mobile_menu" => '='
			),$meta_keys);

		}

		public function change_post_type_allow_install() {
			return array(
				G5P()->cpt()->get_content_block_post_type(),
				G5P()->cpt()->get_template_post_type(),
				G5P()->cpt()->get_xmenu_post_type()
			);
		}

		public function change_taxonomy_register_before_install() {
			return array(
				G5P()->cpt()->get_template_post_type() => G5P()->cpt()->get_template_taxonomy()
			) ;
		}

		public function change_post_types_register_before_install() {
			return G5P()->cpt()->get_template_post_type();
		}

		public function change_attachment_in_post_type_for_import_setting($post_types_attachment) {
			return array(
				G5P()->cpt()->get_content_block_post_type(),
				G5P()->cpt()->get_template_post_type(),
				G5P()->cpt()->get_xmenu_post_type()
			);
		}

		public function change_option_key_for_attachment_file() {
			return array(
				'gsf_preset_options_keys_%' => 'like',
				G5P()->getOptionName() . '%' => 'like',
			);
		}

		public function change_option_key_for_setting_file($option_keys) {
			 return wp_parse_args( array(
				 'gsf_preset_options_keys_%' => 'like',
				 G5P()->getOptionName() . '%' => 'like',
				 G5P()->getOptionSkinName() => '=',
				 'gsf-widget-areas' => '=',
				 'post_views_counter_settings_display' => '=',
				 'gsf_font_options' => '=',
			 ),$option_keys);
		}

		public function add_tabs() {
			wp_enqueue_style(G5P()->assetsHandle('dashboard'));
			G5P()->helper()->getTemplate( 'core/dashboard/templates/tabs', array( 'current_page' => 'install_demo' ) );
		}

		public function change_dashboard_menu($menu) {
			if (function_exists('GID')) {
				$menu['install_demo'] = array(
					'menu_title'      => esc_html__( 'Install Demo', 'lustria-framework' ),
					'link' => admin_url('admin.php?page=gid_install_demo'),
					'priority' => 25
				);
			}
			return $menu;
		}

		public function change_gid_install_demo_page_parent() {
			return "gsf_welcome";
		}



		public function demo_list() {
			return array(
				'main' => array(
					'name' => esc_html__( 'Main (Use With WPBakery Page Builder)', 'lustria-framework' ),
					'thumbnail' => G5P()->pluginUrl('assets/demo-data/main/preview.jpg'),
					'preview' => 'https://lustria.g5plus.net/main/',
					//'preview' => 'http://dev.g5plus.net/lustria/',
					'dir' => G5P()->pluginDir('assets/demo-data/main/'),
					'theme' => 'g5plus-lustria',
					'builder' => 'vc',
				),
				'elementor' => array(
					'name' => esc_html__( 'Main (Use With Elementor)', 'lustria-framework' ),
					'thumbnail' => G5P()->pluginUrl('assets/demo-data/elementor/preview.jpg'),
					'preview' => 'https://lustria.g5plus.net/elementor/',
					//'preview' => 'http://dev.g5plus.net/lustria-elementor/',
					'dir' => G5P()->pluginDir('assets/demo-data/elementor/'),
					'theme' => 'g5plus-lustria',
					'builder' => 'elementor',
				),
			);
		}


	}
}
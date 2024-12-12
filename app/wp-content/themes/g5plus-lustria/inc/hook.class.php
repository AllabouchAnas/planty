<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Lustria_Hook')) {
	class G5Plus_Lustria_Hook
	{
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
			$this->addAction();
			$this->addFilter();
		}

		private function addAction()
		{
			/**
			 * Initialize Theme
			 */
			add_action('after_setup_theme', array(G5Plus_Lustria()->themeSetup(), 'init'));

			/**
			 * Required Plugins
			 */
			add_action('tgmpa_register', array(G5Plus_Lustria()->requirePlugin(), 'init'));

			/**
			 * Register Sidebar
			 */
			add_action('widgets_init', array(G5Plus_Lustria()->registerSidebar(), 'init'));

			add_action('init', array(G5Plus_Lustria()->assets(), 'registerAssets'));

			/**
			 * Enqueue FrontEnd Resource
			 */
			add_action('wp_enqueue_scripts', array(G5Plus_Lustria()->assets(), 'enqueueAssets'), 99);
			add_action('wp_enqueue_scripts', array(G5Plus_Lustria()->assets(), 'enqueue_assets_content_block'), 100);
			add_action('wp_enqueue_scripts', array(G5Plus_Lustria()->assets(), 'enqueue_icon_font'));
			add_action('wp_enqueue_scripts', array(G5Plus_Lustria()->assets(), 'getCustomCss'), 100);
			add_action('wp_footer', array(G5Plus_Lustria()->assets(), 'custom_script'));

			add_action('enqueue_block_editor_assets', array(G5Plus_Lustria()->assets(), 'enqueue_block_editor_assets'));

			/**
			 * Head Meta
			 * *******************************************************
			 */
			add_action('wp_head', array(G5Plus_Lustria()->templates(), 'head_meta'), 0);

			/**
			 * Social Meta
			 * *******************************************************
			 */
			add_action('wp_head', array(G5Plus_Lustria()->templates(), 'social_meta'), 5);

			/**
			 * Search Popup
			 * *******************************************************
			 */
			add_action('wp_ajax_nopriv_search_popup', array(G5Plus_Lustria()->ajax(), 'search_result'));
			add_action('wp_ajax_search_popup', array(G5Plus_Lustria()->ajax(), 'search_result'));

			/**
			 * Load Posts
			 * *******************************************************
			 */
			add_action('wp_ajax_nopriv_pagination_ajax', array(G5Plus_Lustria()->ajax(), 'pagination_ajax_response'));
			add_action('wp_ajax_pagination_ajax', array(G5Plus_Lustria()->ajax(), 'pagination_ajax_response'));


			/**
			 * Login, Register
			 */
			add_action('wp_ajax_nopriv_gsf_user_login_ajax', array(G5Plus_Lustria()->ajax(), 'gsf_user_login_ajax_callback'));
			add_action('wp_ajax_gsf_user_login_ajax', array(G5Plus_Lustria()->ajax(), 'gsf_user_login_ajax_callback'));
			add_action('wp_ajax_nopriv_gsf_user_sign_up_ajax', array(G5Plus_Lustria()->ajax(), 'gsf_user_sign_up_ajax_callback'));
			add_action('wp_ajax_gsf_user_sign_up_ajax', array(G5Plus_Lustria()->ajax(), 'gsf_user_sign_up_ajax_callback'));

			/**
			 * Product Quickview
			 */
			add_action('wp_ajax_nopriv_product_quick_view', array(G5Plus_Lustria()->ajax(), 'popup_product_quick_view'));
			add_action('wp_ajax_product_quick_view', array(G5Plus_Lustria()->ajax(), 'popup_product_quick_view'));


			/**
			 * Site Loading Template
			 * *******************************************************
			 */
			add_action('g5plus_before_page_wrapper', array(G5Plus_Lustria()->templates(), 'site_loading'), 5);

			/**
			 * Top Drawer Template
			 * *******************************************************
			 */
			add_action('g5plus_before_page_wrapper_content', array(G5Plus_Lustria()->templates(), 'top_drawer'), 10);

			/**
			 * Header Template
			 * *******************************************************
			 */
			add_action('g5plus_before_page_wrapper_content', array(G5Plus_Lustria()->templates(), 'header'), 15);


			/**
			 * Content Wrapper Start Template
			 * *******************************************************
			 */
			add_action('g5plus_main_wrapper_content_start', array(G5Plus_Lustria()->templates(), 'content_wrapper_start'), 1);

			/**
			 * Content Wrapper End Template
			 * *******************************************************
			 */
			add_action('g5plus_main_wrapper_content_end', array(G5Plus_Lustria()->templates(), 'content_wrapper_end'), 1);

			/**
			 * Back To Top Template
			 * *******************************************************
			 */
			add_action('g5plus_after_page_wrapper', array(G5Plus_Lustria()->templates(), 'back_to_top'), 5);

			/**
			 * Page Title Template
			 * *******************************************************
			 */
			add_action('g5plus_before_main_content', array(G5Plus_Lustria()->templates(), 'page_title'), 5);

			/**
			 * Footer
			 * *******************************************************
			 */
			add_action('g5plus_after_page_wrapper_content', array(G5Plus_Lustria()->templates(), 'footer'), 5);

			/**
			 * Blog
			 * *******************************************************
			 */
			add_action('g5plus_before_post_image', array(G5Plus_Lustria()->templates(), 'zoom_image_thumbnail'));
			add_action('g5plus_after_archive_wrapper', array(G5Plus_Lustria()->blog(), 'pagination_markup'));
			//add_action('g5plus_before_archive_wrapper',array(G5Plus_Lustria()->blog(),'category_filter_markup'));
			add_action('g5plus_after_archive_post', array(G5Plus_Lustria()->blog(), 'archive_ads_markup'));


			add_action('pre_get_posts', array(G5Plus_Lustria()->query(), 'pre_get_posts'));

			/**
			 * Single Blog
			 * *******************************************************
			 */
			add_action('g5plus_single_post_tag_share', array(G5Plus_Lustria()->templates(), 'post_single_tag_share'));
			add_action('g5plus_after_single_post', array(G5Plus_Lustria()->templates(), 'post_single_author_info'), 15);
			add_action('g5plus_after_single_post', array(G5Plus_Lustria()->templates(), 'post_single_navigation'), 20);
			add_action('g5plus_after_single_post', array(G5Plus_Lustria()->templates(), 'post_single_related'), 25);
			add_action('g5plus_after_single_post', array(G5Plus_Lustria()->templates(), 'post_single_comment'), 30);
			add_action('wp_footer', array(G5Plus_Lustria()->templates(), 'post_single_reading_process'));

			/**
			 * Single Page
			 * *******************************************************
			 */
			add_action('g5plus_after_single_page', array(G5Plus_Lustria()->templates(), 'post_single_comment'), 30);

			add_action( 'wp_ajax_gsf_custom_css_editor', array( G5Plus_Lustria()->assets(), 'custom_css_editor_callback' ));
			add_action( 'wp_ajax_nopriv_gsf_custom_css_editor', array( G5Plus_Lustria()->assets(), 'custom_css_editor_callback' ));


			add_action('wp_ajax_gsf_custom_css_block_editor', array(G5Plus_Lustria()->assets(), 'custom_css_block_editor_callback'));
			add_action('wp_ajax_nopriv_gsf_custom_css_block_editor', array(G5Plus_Lustria()->assets(), 'custom_css_block_editor_callback'));

		}

		private function addFilter()
		{
			// add icon font
			add_filter('gsf_font_icon_assets', array(G5Plus_Lustria()->fontIcons(), 'registerAssets'));
			add_filter('gsf_font_icon_config', array(G5Plus_Lustria()->fontIcons(), 'registerConfig'));

			//add custom font
			add_filter('gsf_theme_font_default', array($this, 'themeFontsDefault'));

			add_filter('body_class', array(G5Plus_Lustria()->helper(), 'body_class'));
			add_filter('get_the_excerpt', array(G5Plus_Lustria()->helper(), 'excerpt'), 100);
			add_filter('gsf_extra_class', array(G5Plus_Lustria()->helper(), 'extra_class'));
			add_filter('wp_list_categories', array(G5Plus_Lustria()->helper(), 'cat_count_span'), 10, 2);
			add_filter('get_archives_link', array(G5Plus_Lustria()->helper(), 'archive_count_span'));

			add_filter('wp_nav_menu_args', array(G5Plus_Lustria()->helper(), 'main_menu_one_page'), 20);
			/*$lazy_load_images = G5Plus_Lustria()->options()->get_lazy_load_images();
			if ($lazy_load_images === 'on') {
				add_filter( 'post_thumbnail_html', array(G5Plus_Lustria()->helper(),'post_thumbnail_lazyLoad'), 10, 3 );
				add_filter('the_content',array(G5Plus_Lustria()->helper(),'content_lazyLoad'));

			}*/

			add_filter('xmenu_submenu_transition', array($this, 'menuTransition'), 20, 2);
			add_filter('gpl_spinner_color', array($this, 'postLikeSpinnerColor'));

			add_filter('elementor/fonts/groups', array($this, 'change_elementor_font_groups'));
			add_filter('elementor/fonts/additional_fonts',array($this, 'change_elementor_fonts'));

			add_filter( 'editor_stylesheets', array( G5Plus_Lustria()->assets(), 'custom_editor_styles' ), 100 );

		}


		public function themeFontsDefault($fonts)
		{
			return array(
				array(
					'name' => "Edmondsans",
					'family' => "edmondsans",
					'kind' => 'custom',
					'css_url' => G5Plus_Lustria()->helper()->getAssetUrl('assets/vendors/edmondsans/stylesheet.css'),
					'variants' => array(
						'400',
						'500',
						'700'
					)
				),
				array(
					'name' => "Bambola",
					'family' => "bambola",
					'kind' => 'custom',
					'css_url' => G5Plus_Lustria()->helper()->getAssetUrl('assets/vendors/bambola/stylesheet.css'),
					'variants' => array(
						'400',
					)
				)
			);
		}

		public function change_elementor_font_groups($font_groups)
		{
			return wp_parse_args(array(
				'lustria' => esc_html__('Lustria', 'g5plus-lustria')
			), $font_groups);
		}

		public function change_elementor_fonts($fonts)
		{
			return wp_parse_args(array(
				'Edmondsans' => 'lustria',
				'Bambola' => 'lustria',
			), $fonts);
		}

		public function menuTransition($transition, $args)
		{
			if (isset($args->main_menu)) {
				$transition = G5Plus_Lustria()->options()->get_menu_transition();
			}
			return $transition;
		}

		public function postLikeSpinnerColor()
		{
			return G5Plus_Lustria()->options()->get_accent_color();
		}
	}
}

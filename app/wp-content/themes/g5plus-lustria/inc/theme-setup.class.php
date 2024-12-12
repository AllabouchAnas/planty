<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Lustria_Theme_Setup')) {
	class G5Plus_Lustria_Theme_Setup {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init(){
			/**
			 * Make theme available for translation.
			 */
			load_theme_textdomain('g5plus-lustria', get_template_directory() . '/languages');

			// Add default posts and comments RSS feed links to head.
			add_theme_support('automatic-feed-links');

            add_theme_support('woocommerce');

            // Declare theme support for features.
            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support('title-tag');

			/**
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			 */
			add_theme_support('post-thumbnails');

			/**
			 * Register Menu Location
			 */
            register_nav_menus(array(
                'primary' => esc_html__('Primary Menu', 'g5plus-lustria'),
                'left-menu' => esc_html__('Left Menu', 'g5plus-lustria'),
                'right-menu' => esc_html__('Right Menu', 'g5plus-lustria'),
                'mobile'  => esc_html__('Mobile Menu', 'g5plus-lustria'),
            ));

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support('html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			));

			/**
			 * Enable support for Post Formats.
			 * See https://developer.wordpress.org/themes/functionality/post-formats/
			 */
			add_theme_support('post-formats', array(
				'gallery',
				'video',
				'audio',
				'quote',
				'link'
			));

			// add image sizes


			add_theme_support("custom-header");
			add_theme_support("custom-background");
			add_theme_support('customize-selective-refresh-widgets');

			add_theme_support('gsf_font_management');


			$editor_style = array(
				G5Plus_Lustria()->helper()->getAssetUrl('assets/vendors/bootstrap-4.0.0/css/bootstrap.min.css'),
				G5Plus_Lustria()->helper()->getAssetUrl('assets/css/editor/style.min.css?v' . uniqid()),
			);

            $editor_style = apply_filters('g5plus_editor_style',$editor_style);

            add_editor_style($editor_style);

            add_theme_support('editor-styles');

            add_theme_support( 'wp-block-styles' );

            add_theme_support( 'responsive-embeds' );
            add_theme_support( 'align-wide' );


			$GLOBALS['content_width'] = apply_filters('g5plus_content_width', 1170);
		}
	}
}
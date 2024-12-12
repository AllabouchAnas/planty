<?php
use Elementor\Core\Responsive\Files\Frontend as FrontendFile;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UBE_Assets {
	private static $_instance = null;

	public static function get_instance() {
		return self::$_instance === null ? self::$_instance = new self() : self::$_instance;
	}

	public function init() {
		add_action( 'init', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );


		add_action( 'elementor/frontend/after_enqueue_styles', array($this, 'enqueue_styles' ) );
		add_filter( 'elementor/core/responsive/get_stylesheet_templates', array($this, 'get_responsive_stylesheet_templates' )  );

	}

	public function register_scripts() {
		/**
		 * Vendors assets
		 */
		$goolge_map_options = get_option( 'ube_integrated_api', false );
		$api                = '';
		if ( $goolge_map_options !== false ) {
			$api = $goolge_map_options['google_map_api_key'];
		}
		wp_register_style( 'bootstrap', ube_get_asset_url( 'assets/vendors/bootstrap/css/bootstrap.min.css' ), array(), '4.6.0' );
		wp_register_script( 'bootstrap', ube_get_asset_url( 'assets/vendors/bootstrap/js/bootstrap.bundle.js' ), array( 'jquery' ), '4.6.0', true );
		wp_register_style( 'slick', ube_get_asset_url( 'assets/vendors/slick/slick.min.css' ), array(), '1.8.0' );
		wp_register_script( 'slick', ube_get_asset_url( 'assets/vendors/slick/slick.min.js' ), array( 'jquery' ), '1.8.0', true );
		wp_register_script( 'countup', ube_get_asset_url( 'assets/vendors/counter/countUp.min.js' ), array(), '1.8.0', true );
		wp_register_script( 'vivus', ube_get_asset_url( 'assets/vendors/vivus/vivus.min.js' ), array(), '1.8.0', true );
		wp_register_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . $api, array(), '', true );
		wp_register_script( 'share', ube_get_asset_url( 'assets/vendors/share/goodshare.min.js' ), array(), '1.8.0', true );
		wp_register_style( 'font-awesome', ube_get_asset_url( 'assets/vendors/font-awesome/css/all.min.css' ), array(), '6.6.0' );
		wp_register_script( 'typed', ube_get_asset_url( 'assets/vendors/typed/typed.min.js' ), array( 'jquery' ), '1.0.0' );


		wp_register_script( 'jquery-event-move', ube_get_asset_url( 'assets/vendors/twentytwenty/js/jquery.event.move.js' ), array( 'jquery' ), '1.8.0', true );
		wp_register_style( 'twentytwenty', ube_get_asset_url( 'assets/vendors/twentytwenty/css/twentytwenty.css' ), array(), '1.8.0' );
		wp_register_script( 'twentytwenty', ube_get_asset_url( 'assets/vendors/twentytwenty/js/jquery.twentytwenty.js' ), array( 'jquery' ), '1.8.0', true );

		wp_register_script( 'imagesloaded', ube_get_asset_url( 'assets/vendors/imagesloaded/imagesloaded.pkgd.min.js' ), array( 'jquery' ), 'v4.1.4', true );
		wp_register_script( 'isotope', ube_get_asset_url( 'assets/vendors/isotope/isotope.pkgd.min.js' ), array( 'jquery' ), 'v3.0.6', true );

		wp_register_style( 'justifiedGallery', ube_get_asset_url( 'assets/vendors/justifiedGallery/justifiedGallery.min.css' ), array(), 'v3.8.0' );
		wp_register_script( 'justifiedGallery', ube_get_asset_url( 'assets/vendors/justifiedGallery/jquery.justifiedGallery.min.js' ), array( 'jquery' ), 'v3.8.0', true );

		wp_register_script( 'chartjs', ube_get_asset_url( 'assets/vendors/chartjs/chart.min.js' ), array(), '', true );

		wp_register_script( 'parallax', ube_get_asset_url( 'assets/vendors/jparallax/parallax.min.js' ), array( 'jquery' ), '', true );

		// Ladda
		wp_register_style( 'ladda', ube_get_asset_url( 'assets/vendors/ladda/ladda-themeless.min.css' ), array(), '1.0.5' );
		wp_register_script( 'ladda-spin', ube_get_asset_url( 'assets/vendors/ladda/spin.min.js' ), array( 'jquery' ), '1.0.5', true );
		wp_register_script( 'ladda', ube_get_asset_url( 'assets/vendors/ladda/ladda.min.js' ), array(
			'jquery',
			'ladda-spin'
		), '1.0.5', true );
		wp_register_script( 'ladda-jquery', ube_get_asset_url( 'assets/vendors/ladda/ladda.jquery.min.js' ), array(
			'jquery',
			'ladda'
		), '1.0.5', true );

		wp_register_script( 'mapmarker', ube_get_asset_url( 'assets/vendors/mapmarker/mapmarker.jquery.min.js' ), array( 'jquery' ), '1.0', true );

		// spectrum picker color
		wp_register_style( 'spectrum', ube_get_asset_url( 'assets/vendors/spectrum/spectrum.min.css' ), array(), '2.0.5' );
		wp_register_script( 'spectrum', ube_get_asset_url( 'assets/vendors/spectrum/spectrum.min.js' ), array( 'jquery' ), '2.0.5', true );

		// mapbox gl js
		wp_register_style( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css', array(), '3.0.1' );
        wp_register_script( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js', array(), '3.0.1', true );
		/**
		 * Register widgets scripts
		 */
		wp_register_script( 'ube-widget-accordion', ube_get_asset_url( 'assets/js/elements/accordion.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );
		wp_register_script( 'ube-widget-tabs', ube_get_asset_url( 'assets/js/elements/tabs.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );
		wp_register_script( 'ube-widget-slider', ube_get_asset_url( 'assets/js/elements/slider.min.js' ), array('jquery','slick'), ube_get_plugin_version(), true );
		wp_register_script( 'ube-widget-fancy-text', ube_get_asset_url( 'assets/js/elements/fancy-text.min.js' ), array(
			'jquery',
			'typed'
		), ube_get_plugin_version(), true );
		wp_register_script( 'ube-widget-progress', ube_get_asset_url( 'assets/js/elements/progress.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );
		wp_register_script( 'ube-widget-flip-box', ube_get_asset_url( 'assets/js/elements/flip-box.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );
		wp_register_script( 'ube-widget-countdown', ube_get_asset_url( 'assets/js/elements/countdown.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-counter', ube_get_asset_url( 'assets/js/elements/counter.min.js' ), array(
			'jquery',
			'countup'
		), '', true );
		wp_register_script( 'ube-widget-icon-box', ube_get_asset_url( 'assets/js/elements/icon-box.min.js' ), array(
			'jquery',
			'vivus'
		), '', true );
		wp_register_script( 'ube-widget-social-icon', ube_get_asset_url( 'assets/js/elements/social-icon.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-google-map', ube_get_asset_url( 'assets/js/elements/google-maps.min.js' ), array(
			'jquery',
			'google-map',
			'mapmarker'
		), '', true );
		wp_register_script( 'ube-widget-image', ube_get_asset_url( 'assets/js/elements/image.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-image-comparison', ube_get_asset_url( 'assets/js/elements/image-comparison.min.js' ), array(
			'jquery',
			'twentytwenty',
			'jquery-event-move'
		), '', true );
		wp_register_script( 'ube-widget-search-box', ube_get_asset_url( 'assets/js/elements/search-box.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-image-marker', ube_get_asset_url( 'assets/js/elements/image-marker.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-gallery-grid', ube_get_asset_url( 'assets/js/elements/gallery-grid.min.js' ), array(
			'jquery',
		), '', true );
		wp_register_script( 'ube-widget-gallery-masonry', ube_get_asset_url( 'assets/js/elements/gallery-masonry.min.js' ), array(
			'jquery',
			'imagesloaded',
			'isotope',
			'ube-widget-gallery-grid'
		), '', true );
		wp_register_script( 'ube-widget-gallery-justified', ube_get_asset_url( 'assets/js/elements/gallery-justified.min.js' ), array(
			'jquery',
			'justifiedGallery',
			'imagesloaded',
			'ube-widget-gallery-grid'
		), '', true );
		wp_register_script( 'ube-widget-offcanvas', ube_get_asset_url( 'assets/js/elements/offcanvas.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-modal', ube_get_asset_url( 'assets/js/elements/modal.min.js' ), array( 'jquery' ), '', true );
		wp_register_script( 'ube-widget-chart', ube_get_asset_url( 'assets/js/elements/chart.min.js' ), array(
			'jquery',
			'chartjs'
		), '', true );
		wp_register_script( 'ube-widget-image-layers', ube_get_asset_url( 'assets/js/elements/image-layers.min.js' ), array(
			'jquery',
			'parallax'
		), '', true );
		wp_register_script( 'ube-widget-post', ube_get_asset_url( 'assets/js/elements/post.min.js' ), array(
			'jquery',
			'slick',
			'ladda-jquery',
		), '', true );
		wp_register_script( 'ube-widget-post-masonry', ube_get_asset_url( 'assets/js/elements/post-masonry.min.js' ), array(
			'jquery',
			'imagesloaded',
			'isotope',
			'ladda-jquery'
		), '', true );
		wp_register_script( 'ube-widget-post-metro', ube_get_asset_url( 'assets/js/elements/post-metro.min.js' ), array( 'jquery' ), '', true );

		wp_register_script( 'ube-widget-map-box', ube_get_asset_url( 'assets/js/elements/mapbox.min.js' ), array(
			'jquery',
			'mapbox-gl',
		), '', true );

        $maxbox_options = get_option( 'ube_integrated_api', false );
        $mapbox_api_access_token   = 'pk.eyJ1IjoiZzVvbmxpbmUiLCJhIjoiY2t1bWY4NzBiMWNycDMzbzZwMnI5ZThpaiJ9.ZifefVtp4anluFUbAMxAXg';
        if ( $maxbox_options !== false ) {
            $mapbox_api_access_token = $maxbox_options['map_box_mapbox_api_access_token'];
        }
        wp_localize_script( 'ube-widget-map-box', 'ube_map_box_config', array(
            'accessToken'     => $mapbox_api_access_token,

        ) );

		wp_register_script( 'ube-widget-bullet-one-page-scroll-navigation', ube_get_asset_url( 'assets/js/elements/bullet-one-page-scroll-navigation.min.js' ), array(
			'jquery',
		), '', true );


		/**
		 * Plugin assets
		 */
		wp_register_script( 'ube-color', ube_get_asset_url( 'assets/js/color.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );

		wp_register_script( 'ube-frontend', ube_get_asset_url( 'assets/js/frontend.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );

		wp_register_style( 'ube-frontend', ube_get_asset_url( 'assets/css/frontend.min.css' ), array(), ube_get_plugin_version() );

		wp_register_style( 'ube-admin', ube_get_asset_url( 'assets/css/admin.min.css' ), array(), ube_get_plugin_version() );
		wp_register_script( 'ube-admin', ube_get_asset_url( 'assets/js/admin.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );


	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_script( 'bootstrap' );

		wp_enqueue_style( 'font-awesome' );

		wp_enqueue_style( 'ube-frontend' );
		wp_enqueue_script( 'ube-frontend' );

		$ajax_url = admin_url( 'admin-ajax.php' );
		wp_localize_script( 'ube-frontend', 'ajaxAdminUrl', array(
			'url' => $ajax_url
		) );
	}

	public function admin_enqueue_scripts() {
		// select2
		wp_enqueue_style( 'select2', ube_get_asset_url( 'assets/vendors/select2/css/select2.min.css' ), array(), '4.1.0' );
		wp_enqueue_script( 'select2', ube_get_asset_url( 'assets/vendors/select2/js/select2.min.js' ), array( 'jquery' ), '4.1.0', true );

		wp_enqueue_style( 'spectrum' );
		wp_enqueue_script( 'spectrum' );

		wp_enqueue_style( 'ube-admin' );
		wp_enqueue_script( 'ube-admin' );
	}

	public function editor_enqueue_scripts() {
		wp_enqueue_style( 'ube-editor', ube_get_asset_url( 'assets/css/editor.min.css' ), array(), ube_get_plugin_version() );
		wp_enqueue_script( 'ube-color', ube_get_asset_url( 'assets/js/color.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );
		wp_enqueue_script( 'ube-editor', ube_get_asset_url( 'assets/js/editor.min.js' ), array( 'jquery' ), ube_get_plugin_version(), true );
		wp_enqueue_style( 'font-awesome', ube_get_asset_url( 'assets/vendors/font-awesome/css/all.min.css' ), array(), '6.6.0' );


		$ajax_url       = admin_url( 'admin-ajax.php' );

		wp_localize_script( 'ube-editor', 'ubeEditorData', array(
			'ajax_url'               => $ajax_url,
			'template_nonce'         => wp_create_nonce( 'ube_get_prebuilt_templates_action' ),
			'template_content_nonce' => wp_create_nonce( 'ube_get_prebuilt_template_content_action' ),

			'dynamic_url'  => wp_nonce_url( admin_url( "admin-ajax.php?action=ube_dynamic_content" ), 'ube_dynamic_content_action', 'ube_dynamic_content_nonce' ),
		) );
	}

	public function enqueue_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$frontend_file_name = 'frontend' . $suffix . '.css';
		$has_custom_file = Elementor\Plugin::$instance->breakpoints->has_custom_breakpoints();
		if ( $has_custom_file ) {
			$frontend_file = new FrontendFile( 'responsive-' . $frontend_file_name, self::get_responsive_templates_path() . $frontend_file_name );

			$time = $frontend_file->get_meta( 'time' );

			if ( ! $time ) {
				$frontend_file->update();
			}

			$frontend_file_url = $frontend_file->get_url();

		} else {
			$frontend_file_url = ube_get_asset_url('assets/css/responsive-frontend.min.css');
		}

		wp_enqueue_style(
			'ube-responsive-frontend',
			$frontend_file_url,
			[],
			$has_custom_file ? null : ube_get_plugin_version()
		);

	}

	private function get_responsive_templates_path() {
		return UBE_ABSPATH . 'assets/css/templates/';
	}

	public function get_responsive_stylesheet_templates( $templates ) {
		$templates_paths = glob( self::get_responsive_templates_path() . '*.css' );

		foreach ( $templates_paths as $template_path ) {
			$file_name = 'responsive-' . basename( $template_path );

			$templates[ $file_name ] = $template_path;
		}

		return $templates;
	}
}
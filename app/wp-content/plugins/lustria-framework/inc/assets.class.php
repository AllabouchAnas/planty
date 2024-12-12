<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5P_Inc_Assets')) {
	class G5P_Inc_Assets {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function registerScript() {

			wp_register_script(G5P()->assetsHandle('vc-backend'), G5P()->helper()->getAssetUrl('assets/js/vc-backend.min.js'), array('jquery'), G5P()->pluginVer(), true);
            wp_register_script(G5P()->assetsHandle('dashboard-system-status'), G5P()->helper()->getAssetUrl('assets/js/dashboard-system-status.min.js'), array('jquery'), G5P()->pluginVer(), true);

            wp_register_script('powertip', G5P()->helper()->getAssetUrl('assets/vendors/jquery.powertip/jquery.powertip.min.js'), array('jquery'), '1.2.0', true);


		}



		public function registerStyle() {

			/**
			 * Framework style
			 */
            wp_register_style(G5P()->assetsHandle('vc-backend'), G5P()->helper()->getAssetUrl('assets/css/vc-backend.min.css'), array(), G5P()->pluginVer());
			wp_register_style(G5P()->assetsHandle('admin-bar'), G5P()->helper()->getAssetUrl('assets/css/admin-bar.min.css'), array(), G5P()->pluginVer());
            wp_register_style(G5P()->assetsHandle('dashboard'), G5P()->helper()->getAssetUrl('assets/css/dashboard.min.css'), array(), G5P()->pluginVer());

            wp_register_style('powertip', G5P()->helper()->getAssetUrl('assets/vendors/jquery.powertip/jquery.powertip.css'), array(), '1.2.0');
            wp_register_style('powertip-dark', G5P()->helper()->getAssetUrl('assets/vendors/jquery.powertip/jquery.powertip-dark.min.css'), array(), '1.2.0');

            wp_register_script(G5P()->assetsHandle('post-format'), G5P()->helper()->getAssetUrl('assets/js/post-format.min.js'), array('jquery'), G5P()->pluginVer(), true);
		}

		public function dequeue_resource () {
		    wp_dequeue_style('yith-wcwl-font-awesome');
        }

        public function dequeue_resource_admin() {
            $screen         = get_current_screen();
            $screen_id      = $screen ? $screen->id : '';

            if ( function_exists('wc_get_screen_ids') && !in_array( $screen_id, wc_get_screen_ids() ) ) {
                wp_dequeue_style( 'woocommerce_admin_styles' );
            }
        }

		public function registerShortCodeAssets() {

			$googlemap_api_key = G5P()->options()->get_google_map_api_key();
			$protocol = (!empty ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://maps.google.com/maps/api/js?libraries=places&language=" : "http://maps.google.com/maps/api/js?libraries=places&language=";
			wp_register_script('gmap3', G5P()->helper()->getAssetUrl('shortcodes/google-map/assets/js/gmap3/gmap3.min.js'), array('jquery'), G5P()->pluginVer(), true);
			wp_register_script('google-map', $protocol . get_locale() . '&key=' . esc_html($googlemap_api_key), array('gmap3'), '1.0', false);


			// Shortcode assets
			foreach ( $this->shortcode_assets() as $shortcode_name => $shortcode_src ) {
				if ( ! empty( $shortcode_src ) ) {
					if ( isset( $shortcode_src['css'] ) && ! empty( $shortcode_src['css'] ) ) {
						wp_register_style( G5P()->assetsHandle( $shortcode_name ), $shortcode_src['css'],
							isset( $shortcode_src['css_deps'] ) ? $shortcode_src['css_deps'] : array(),
							G5P()->pluginVer() );
					}
					if ( isset( $shortcode_src['js'] ) && ! empty( $shortcode_src['js'] ) ) {
						wp_register_script( G5P()->assetsHandle( $shortcode_name ), $shortcode_src['js'],
							isset( $shortcode_src['js_deps'] ) ? $shortcode_src['js_deps'] : array( 'jquery' ),
							G5P()->pluginVer(), true );
					}
				}
			}
		}

		public function shortcode_assets() {
			$shortcode_list = apply_filters( 'gsf_shortcode_assets', array(
				'banner' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/banner/assets/scss/banner.min.css'),
					'js' => ''
				),
				'countdown' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/countdown/assets/scss/countdown.min.css'),
					'js' => G5P()->helper()->getAssetUrl('shortcodes/countdown/assets/js/countdown.min.js'),
				),
				'counter' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/counter/assets/scss/counter.min.css'),
					'js' => G5P()->helper()->getAssetUrl('shortcodes/counter/assets/js/countUp.min.js'),
				),
				'gallery' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/gallery/assets/scss/gallery.min.css'),
					'js' => G5P()->helper()->getAssetUrl('shortcodes/gallery/assets/js/gallery.min.js'),
				),
				'google_map' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/google-map/assets/scss/google-map.min.css'),
					'js' => '',
					'js_name' => 'google-map'
				),
				'heading' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/heading/assets/scss/heading.min.css'),
					'js' => ''
				),
				'info_box' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/info-box/assets/scss/info-box.min.css'),
					'js' => ''
				),
				'lists' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/lists/assets/scss/lists.min.css'),
					'js' => ''
				),
				'our_team' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/our-team/assets/scss/our-team.min.css'),
					'js' => ''
				),
				'partners' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/partners/assets/scss/partners.min.css'),
					'js' => ''
				),
				'pie_chart' => array(
					'css' => G5P()->helper()->getAssetUrl('/shortcodes/pie-chart/assets/scss/pie-chart.min.css'),
					'js' => G5P()->helper()->getAssetUrl('/shortcodes/pie-chart/assets/js/jquery.vc_chart.min.js'),
					'js_deps' => array('jquery')
				),
				'pricing_tables' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/pricing-tables/assets/scss/pricing-tables.min.css'),
					'js' => ''
				),
				'product_category' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/product-category/assets/scss/product-category.min.css'),
					'js' => ''
				),
				'product_singular' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/product-singular/assets/scss/product-singular.min.css'),
					'js' => ''
				),
				'space' => array(
					'css' =>'',
					'js' => G5P()->helper()->getAssetUrl('shortcodes/space/assets/js/space.min.js'),
				),
				'testimonials' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/testimonials/assets/scss/testimonials.min.css'),
					'js' => G5P()->helper()->getAssetUrl('shortcodes/testimonials/assets/js/testimonials.min.js'),
					'js_deps' => array('jquery')
				),
				'video' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/video/assets/scss/video.min.css'),
					'js' => '',
				),
				'view_demo' => array(
					'css' => G5P()->helper()->getAssetUrl('shortcodes/view-demo/assets/scss/view-demo.min.css'),
					'js' => '',
				),

			) );
			return $shortcode_list;
		}

		public function enqueue_assets_for_shortcode( $shortcode_name ) {
			$shortcode_list = $this->shortcode_assets();
			$shortcode_src  = isset( $shortcode_list[ $shortcode_name ] ) ? $shortcode_list[ $shortcode_name ] : array();
			if ( ! empty( $shortcode_src ) ) {
				if ( isset( $shortcode_src['css'] ) && ! empty( $shortcode_src['css'] ) ) {
					wp_enqueue_style( G5P()->assetsHandle( $shortcode_name ) );
				}

				if ( isset( $shortcode_src['css_name'] ) && ! empty( $shortcode_src['css_name'] ) ) {
					wp_enqueue_style( $shortcode_src['css_name'] );
				}

				if ( isset( $shortcode_src['js'] ) && ! empty( $shortcode_src['js'] ) ) {
					wp_enqueue_script( G5P()->assetsHandle( $shortcode_name ) );
				}

				if ( isset( $shortcode_src['js_name'] ) && ! empty( $shortcode_src['js_name'] ) ) {
					wp_enqueue_script( $shortcode_src['js_name'] );
				}
			}
		}

		public function enqueue_shortcode_assets( $content ) {
			$shortcode_assets = $this->shortcode_assets();
			$pattern          = '/(\[gsf_' . implode( ')|(\[gsf_', array_keys( $shortcode_assets ) ) . ')/';

			if ( preg_match_all( $pattern, $content, $matchs ) ) {
				$shortcode_exists = array_unique( $matchs[0] );

				foreach ( $shortcode_exists as $shortcode_name ) {
					$shortcode_name = substr( $shortcode_name, 5 );

					$this->enqueue_assets_for_shortcode( $shortcode_name );
				}
			}
		}

	}
}
<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'UBE_Icon' ) ) {
	class UBE_Icon {
		private static $_instance;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function get_svg( $icon ) {
			$arr = $this->get_icons();
			if ( array_key_exists( $icon, $arr ) ) {
				$repl = '<svg ';
				$svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
				$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
				$svg  = preg_replace( '/>\s*</', '><', $svg );    // Remove whitespace between SVG tags.

				return sprintf( '<span class="ube-icon">%s</span>', $svg );
			}

			return null;
		}

		public function get_icons() {
			//TODO: ADD CACHE
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			$icons = array();
			$files = list_files( ube_get_plugin_dir( 'assets/svg' ) );

			foreach ( $files as $file ) {
				$k           = basename( $file, '.svg' );
				$content     = file_get_contents( $file );
				$icons[ $k ] = $content;
			}

			return apply_filters( 'dip_svg_icons', $icons );
		}


	}
}
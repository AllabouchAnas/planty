<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


abstract class UBE_Abstracts_Elements extends Elementor\Widget_Base {
    public static function is_enabled() {
        return true;
    }

	public function get_categories() {
		return array( 'ultimate-bootstrap-elements' );
	}

	public function get_keywords() {
		return array_merge( array(
			'ube',
			'ultimate addons'
		), $this->get_ube_keywords() );
	}

	public function get_ube_keywords() {
		return array();
	}

	public function get_icon() {
		return 'ube-badge ' . $this->get_ube_icon();
	}

	public function get_ube_icon() {
		return 'eicon-elementor-square';
	}

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
	}

	/**
	 * Change protected to public function
	 */
	public function add_inline_editing_attributes( $key, $toolbar = 'basic' ) {
		parent::add_inline_editing_attributes( $key, $toolbar );
	}

	public function get_repeater_setting_key( $setting_key, $repeater_key, $repeater_item_index ) {
		return parent::get_repeater_setting_key( $setting_key, $repeater_key, $repeater_item_index );
	}

	public function parse_text_editor( $content ) {
		return parent::parse_text_editor( $content );
	}

	public function get_attachment_image_src($settings, $image_size_key = 'image', $image_key = null ) {
		if ( ! $image_key ) {
			$image_key = $image_size_key;
		}

		$image = $settings[ $image_key ];

		// Old version of image settings.
		if ( ! isset( $settings[ $image_size_key . '_size' ] ) ) {
			$settings[ $image_size_key . '_size' ] = '';
		}

		$size = $settings[ $image_size_key . '_size' ];


		$image_src = '';

		// If is the new version - with image size.
		$image_sizes = get_intermediate_image_sizes();

		$image_sizes[] = 'full';

		if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
			$image['id'] = '';
		}

		$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();

		// On static mode don't use WP responsive images.
		if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
			$img_src_arr = wp_get_attachment_image_src($image['id'],$size);
			if ($img_src_arr && isset($img_src_arr[0])) {
				$image_src = $img_src_arr[0];
			}
		} else {
			$image_src = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'image_size', $settings );
		}

		if ( ! $image_src && isset( $image['url'] ) ) {
			$image_src = $image['url'];
		}
		return $image_src;
	}


	public function get_svg_gradient_defs( array $settings, $name, $id ) {
		if ( 'gradient' !== $settings["{$name}_color_type"] ) {
			return false;
		}
		$color_a_stop = $settings["{$name}_color_a_stop"];
		$color_b_stop = $settings["{$name}_color_b_stop"];

		$color_a_stop_value = $color_a_stop['size'] . $color_a_stop['unit'];
		$color_b_stop_value = $color_b_stop['size'] . $color_a_stop['unit'];
		ob_start();
		?>
		<svg style="position: absolute; width: 0; height: 0; overflow: hidden;" aria-hidden="true" focusable="false">
			<defs>
				<linearGradient id="<?php echo esc_attr( $id ); ?>" x1="0%" y1="0%" x2="0%" y2="100%">
					<stop class="stop-a" offset="<?php echo esc_attr( $color_a_stop_value ); ?>"/>
					<stop class="stop-b" offset="<?php echo esc_attr( $color_b_stop_value ); ?>"/>
				</linearGradient>
			</defs>
		</svg>
		<?php
		return ob_get_clean();
	}




}
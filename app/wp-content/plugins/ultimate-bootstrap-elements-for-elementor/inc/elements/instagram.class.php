<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class UBE_Element_Instagram extends UBE_Abstracts_Elements_Grid {

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 1.4.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'ube-instagram';
	}

	private $_items = [];
	private $_userName = '';

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {
		// TODO: Implement add_repeater_controls() method.
	}

	protected function get_repeater_defaults() {
		// TODO: Implement get_repeater_defaults() method.
	}

	protected function print_grid_item() {
		// TODO: Implement print_grid_item() method.
	}

	public function get_title() {
		return esc_html__( 'Instagram', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-instagram-gallery';
	}

	public function get_ube_keywords() {
		return array( 'ube', 'instagram' , 'ube instagram' );
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$slider_enable = isset( $settings['slider_enable'] ) ? $settings['slider_enable'] : '';
		$limit         = ! empty( $settings['limit'] ) ? $settings['limit'] : 8;
		$token         = ! empty( $settings['access_token'] ) ? $settings['access_token'] : 'IGQVJVMjNzYTBTYmtHazhoZA2xIWjlvOVNOYmVtdUtjT2k5clhROVF5V3RyQUxwc0g3WERfWDh0TGVaREtqNG5kYmtqRGJIV3dlbVgzQXU4OHgzY3I2UHVTdW5veGJnSm1vaWtVQkN4emdUTXFzMVVRSgZDZD';
		$response      = wp_remote_get( 'https://graph.instagram.com/me/media?fields=id%2Ccaption%2Cmedia_type%2Cmedia_url%2Ccomment%2Clike%2Cpermalink%2Cusername%2Cthumbnail_url&limit=' . esc_attr( $limit ) . '&access_token=' . esc_attr( $token ) );
		if ( is_wp_error( $response ) ) {
			echo '<p>' . esc_html__( 'Incorrect user ID specified.', 'ube' ) . '</p>';

			return;
		}
		$response_body = json_decode( $response['body'] );
		if ( empty( $response_body ) ) {
			echo '<p>' . esc_html__( 'Incorrect user ID specified.', 'ube' ) . '</p>';

			return;
		}

		if ( ! isset( $response_body->data ) || ! is_array( $response_body->data ) || count( $response_body->data ) == 0 ) {
			echo '<p>' . esc_html__( 'Incorrect user ID specified.', 'ube' ) . '</p>';

			return;
		}


		foreach ( $response_body->data as $item ) {
			$image              = [];
			$image['permalink'] = $item->permalink;
			$image['image_src'] = $item->media_url;
			$this->_userName    = $item->username;
			$type = $item->media_type;
			if ( $type == "VIDEO" ) {
				$image['image_src'] = $item->thumbnail_url;
			}
			$this->_items[]     = $image;
		}

		$this->add_render_attribute( 'instagram_btn', 'href', 'https://www.instagram.com/' . $this->_userName );
		$this->add_render_attribute( 'instagram_btn', 'target', '_blank' );

		$wrapper_classes = array(
			'ube-instagram'
		);
		$this->add_render_attribute( 'wrapper', 'class', $wrapper_classes );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ) ?>>
			<?php
			if ( $slider_enable === 'on' ) {
				$this->print_slider( $settings, 'ube-instagram-list' );
			} else {
				$this->print_grid( $settings, 'ube-instagram-list' );
			}
			?>
			<?php if ( $settings['show_user_name'] === 'yes' ): ?>
				<a class="ube-instagram-follow"
				   href="<?php echo esc_url( 'https://www.instagram.com/' . $this->_userName ) ?>" target="_blank">
					<i class="fab fa-instagram"></i>
					<span><?php echo esc_html__( 'Follow', 'ube' ) ?> @<?php echo $this->_userName; ?></span>
				</a>
			<?php endif; ?>
		</div>
		<?php


	}

	protected function print_grid_items( array $settings ) {
		$this->print_items($settings,'elementor-grid-item');
	}

	protected function print_slider_items(array $settings) {
		$this->print_items($settings,'ube-slider-item');
	}

	protected function print_items(array $settings,$item_class = '') {
		$item_classes = array(
			'ube-instagram-item'
		);

		if (!empty($item_class)) {
			$item_classes[] = $item_class;
		}

		if ( ! empty( $settings['hover_animation'] ) ) {
			$item_classes[] = 'ube-image-hover-' . $settings['hover_animation'];
		}
		if ( ! empty( $settings['hover_image_animation'] ) ) {
			$item_classes[] = 'ube-image-hover-' . $settings['hover_image_animation'];
		}
		$this->add_render_attribute( 'item', 'class', $item_classes );
		foreach ( $this->_items as $item ) {
			?>
			<div <?php $this->print_render_attribute_string( 'item' ) ?>>
				<div class="ube-image">
					<a class="card-img" href="<?php echo esc_url( $item['permalink'] ) ?>">
						<img src="<?php echo esc_url( $item['image_src'] ) ?>"
						     alt="<?php echo esc_attr( $this->_userName ) ?>">
					</a>
				</div>
				<a class="ube-instagram-icon" href="<?php echo esc_url( $item['image_src'] ); ?>"
				   data-elementor-lightbox-slideshow="<?php echo esc_attr( $this->get_id() ) ?>">
					<i class="fab fa-instagram"></i>
				</a>
			</div>
		<?php }
	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_grid_section_controls( [ 'slider_enable!' => 'on' ] );
		$this->register_slider_section_controls([
			'name'     => 'slider_enable',
			'operator' => '=',
			'value'    => 'on'
		]);
		$this->register_style_section_controls();
	}

	protected function register_grid_section_controls( $condition = [] ) {
		parent::register_grid_section_controls( $condition );
		$this->remove_control( 'grid_content_position' );
		$this->remove_control( 'grid_content_alignment' );
		$this->remove_control( 'grid_content_padding' );
	}

	protected function register_slider_section_controls($condition = []) {
		parent::register_slider_section_controls($condition);
		$this->remove_control('slider_type');
		$this->update_control('fade_enabled',[
			'conditions'   => [
				'terms' => [
					[
						'name'     => 'slides_to_show',
						'operator' => '==',
						'value'    => '1',
					],
				],
			],
		]);

		$this->remove_control('slider_content_position');
		$this->remove_control('slider_content_alignment');

	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'ube' ),
			]
		);


		$this->add_control(
			'access_token',
			[
				'label'       => esc_html__( 'Instagram Access Token', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				//'placeholder'   => esc_html__( 'IGQVJVMjNzYTBTYmtHazhoZA2xIWjlvOVNOYmVtdUtjT2k5clhROVF5V3RyQUxwc0g3WERfWDh0TGVaREtqNG5kYmtqRGJIV3dlbVgzQXU4OHgzY3I2UHVTdW5veGJnSm1vaWtVQkN4emdUTXFzMVVRSgZDZD', 'ube' ),
				'label_block' => true,
				'description' => wp_kses_post( __( '(<a href="https://www.youtube.com/watch?v=X2ndbJAnQKM" target="_blank">Lookup your Access Token</a>)', 'ube' ) ),
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Item Limit', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 200,
				'step'    => 1,
				'default' => 8,
			]
		);


		$this->add_control(
			'show_user_name',
			[
				'label'        => esc_html__( 'User Name', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'slider_enable',
			[
				'label'        => esc_html__( 'Slider', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);


		$this->end_controls_section();
	}

	protected function register_style_section_controls() {
		$this->register_style_image_section_controls();
		$this->register_style_user_name_section_controls();
	}

	protected function register_style_image_section_controls() {
		$this->start_controls_section( 'style_image_section', [
			'label' => esc_html__( 'Images', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Hover Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_hover_effect(),

			]
		);
		$this->add_control(
			'hover_image_animation',
			[
				'label'   => esc_html__( 'Hover Image Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_image_effect(),
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .card-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'

				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .card-img',
			]
		);

		$this->add_control(
			'image_overlay',
			[
				'label'     => esc_html__( 'Background Overlay', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .card-img:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Font Size', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-instagram-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-instagram-icon' => 'color: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();
	}

	protected function register_style_user_name_section_controls() {
		$this->start_controls_section( 'style_user_name_section', [
			'label'     => esc_html__( 'User Name', 'ube' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'show_user_name' => 'yes',
			],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'user_name_typography',
				'selector' => '{{WRAPPER}} .ube-instagram-follow',
			]
		);

		$this->add_responsive_control(
			'user_name_text_align',
			[
				'label' => esc_html__('Alignment', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'user_name_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-instagram-follow' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'user_name_tabs' );

		$this->start_controls_tab( 'user_name_tab_normal', [
				'label' => esc_html__( 'Normal', 'ube' )
			]
		);

		$this->add_control(
			'user_name_text_color',
			[
				'label' => esc_html__( 'Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-instagram-follow' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();


		$this->start_controls_tab( 'user_name_tab_normal_hover', [
				'label' => esc_html__( 'Hover', 'ube')
			]
		);


		$this->add_control(
			'user_name_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-instagram-follow:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();



		$this->end_controls_tabs();

		$this->end_controls_section();


	}


}


<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;


class UBE_Element_Slider extends UBE_Abstracts_Elements_Grid {

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
		return 'ube-slider';
	}

	public function get_title() {
		return esc_html__( 'Slider', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-slider-push';
	}

	public function get_ube_keywords() {
		return array( 'slider', 'ube', 'ube slider' );
	}

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {
		$repeater->add_control(
			'slider_content_template',
			[
				'label'   => esc_html__( 'Choose Template', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_page_templates(),
			]
		);
		$repeater->add_responsive_control(
			'horizontal_align',
			[
				'label'     => esc_html__( 'Horizontal Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-slider-box' => '-webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
				],
			]
		);
		$repeater->add_responsive_control(
			'vertical_align',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-slider-box' => 'align-items:{{VALUE}}',
				],
			]
		);


		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'           => 'slider_background',
				'label'          => esc_html__( 'Background', 'ube' ),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'attachment' => [ 'description' => esc_html__( 'Note: Attachment Fixed only work when \'Fade Animation\' option is enabled and on desktop.', 'ube' ) ],
				],
				'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}} .ube-slide-bg',
			]
		);

		$repeater->add_control(
			'background_color_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'ube' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-slide-bg::after ' => 'background: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'slider_background_image[url]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'slider_background_animation',
			[
				'label'       => esc_html__( 'Background Animation', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'label_block' => false,
				'options'     => [
					''                    => esc_html__( 'Choose Background Animation', 'ube' ),
					'kern-burns-zoom-out' => esc_html__( 'Kern Burns Zoom Out', 'ube' ),
					'kern-burns-zoom-in'  => esc_html__( 'Kern Burns Zoom In', 'ube' ),
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'slider_background_image[url]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);
	}

	protected function get_repeater_defaults() {

	}

	protected function print_grid_item() {
		$settings                   = $this->get_settings_for_display();
		$item                       = $this->get_current_item();
		$slider_setting_key         = $this->get_repeater_setting_key( 'slider_item', 'slider_items', $item['_id'] );
		$slider_setting_key_content = $this->get_repeater_setting_key( 'slider_item_content', 'slider_items', $item['_id'] );
		ube_get_template( 'elements/slider.php', array(
			'element'                     => $this,
			'slider_setting_key'          => $slider_setting_key,
			'slider_background_animation' => $item['slider_background_animation'],
			'slider_content_template'     => $item['slider_content_template'],
			'slider_background_image'     => $item['slider_background_image'],
			'slider_background_color'     => $item['slider_background_color'],
			'slider_dots_type'            => $settings['slider_dots_type'],
			'slider_setting_key_content'  => $slider_setting_key_content,
			'slider_content_layout'       => $settings['slider_content_layout']
		) );

	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$slider_classes = '';
		if ( ! empty( $settings['slider_dots_type'] ) ) {
			$slider_classes .= 'ube-slider-' . $settings['slider_dots_type'];
		}
		if ( $settings['sliders_background_animation'] !== '' ) {
			$slider_classes .= ' ube-sliders-background-' . $settings['sliders_background_animation'];
		}
		if ( $settings['sliders_swipe_animation'] !== '' ) {
			$slider_classes .= ' ube-sliders-swipe-' . $settings['sliders_swipe_animation'];
		}
		$this->print_slider( $settings, $slider_classes );
	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_items_section_controls();
		$this->register_slider_section_controls();
	}

	protected function register_slider_section_controls( $condition = [] ) {
		parent::register_slider_section_controls();
		$this->update_control( 'slides_to_show', [ 'default' => 1 ] );
		$this->remove_control( 'slider_content_position' );
		$this->remove_control( 'slider_content_alignment' );
		$this->update_control( 'fade_enabled', [
			'conditions' => [
				'terms' => [
					[
						'name'     => 'slides_to_show',
						'operator' => '==',
						'value'    => '1',
					],
				],
			],
		] );
		$this->update_control( 'slider_dots_color', [
			'conditions' => [
				'terms' => [
					[
						'name'     => 'slider_dots_type',
						'operator' => '==',
						'value'    => 'basic',
					],
				],
			],
		] );
	}

	protected function register_items_section_controls() {
		parent::register_items_section_controls();
	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'section_slider_item', [
				'label' => esc_html__( 'Slider', 'ube' ),
			]
		);
		$this->add_control(
			'sliders_swipe_animation',
			[
				'label'       => esc_html__( 'Swipe Animation', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'label_block' => false,
				'options'     => [
					''            => esc_html__( 'Choose Swipe Animation', 'ube' ),
					'swirl-left'  => esc_html__( 'Swirl Left', 'ube' ),
					'swirl-right' => esc_html__( 'Swirl Right', 'ube' ),
					'burn'        => esc_html__( 'Burn', 'ube' ),
					'blur'        => esc_html__( 'Blur', 'ube' ),
					'flash'       => esc_html__( 'Flash', 'ube' ),
				],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'slides_to_show',
							'operator' => '==',
							'value'    => 1
						],
						[
							'name'     => 'center_mode',
							'operator' => '==',
							'value'    => ''
						]
					]
				]
			]
		);
		$this->add_control(
			'sliders_background_animation',
			[
				'label'       => esc_html__( 'Background Animation', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'label_block' => false,
				'options'     => [
					''                    => esc_html__( 'Choose Background Animation', 'ube' ),
					'kern-burns-zoom-out' => esc_html__( 'Kern Burns Zoom Out', 'ube' ),
					'kern-burns-zoom-in'  => esc_html__( 'Kern Burns Zoom In', 'ube' ),
				],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'slides_to_show',
							'operator' => '==',
							'value'    => 1
						],
						[
							'name'     => 'center_mode',
							'operator' => '==',
							'value'    => ''
						]
					]
				],
				'separator'   => 'after',
			]
		);
		$this->add_responsive_control(
			'slider_dots_type',
			[
				'label'       => esc_html__( 'Dots Type', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'basic',
				'label_block' => false,
				'options'     => [
					'basic'      => esc_html__( 'Basic', 'ube' ),
					'thumbnails' => esc_html__( 'Thumbnails', 'ube' ),
				],
				'condition'   => [
					'navigation_dots' => 'on'
				]
			]
		);
		$this->add_responsive_control(
			'slider_height',
			[
				'label'      => esc_html__( 'Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em' ],
				'separator'  => 'before',
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-slider .ube-slider-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'slider_content_layout',
			[
				'label'       => esc_html__( 'Content Layout', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'basic',
				'label_block' => false,
				'options'     => [
					'container' => esc_html__( 'Container', 'ube' ),
					'full'      => esc_html__( 'Full width', 'ube' ),
				],
			]
		);
		$this->end_controls_section();
	}

}


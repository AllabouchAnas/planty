<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

abstract class UBE_Abstracts_Elements_Slider extends UBE_Abstracts_Elements {

	public function get_style_depends() {
		return array( 'slick' );
	}

	public function get_script_depends() {
		return array( 'slick', 'ube-widget-slider' );
	}

	protected function register_slider_section_controls( $condition = [] ) {
		$this->register_slider_general_section_controls( $condition );
		$this->register_slider_style_section_controls( $condition );
		$this->register_slider_advanced_section_controls( $condition );
	}

	protected function register_slider_general_section_controls( $condition = [] ) {
		$section_slider_config = [
			'label' => esc_html__( 'Slider Options', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		];

		if ( count( $condition ) > 0 ) {
			$section_slider_config['conditions'] = [
				'terms' => [
					$condition
				]
			];
		}

		$this->start_controls_section(
			'section_slider',
			$section_slider_config
		);

		$this->add_control(
			'slider_type',
			[
				'label'   => esc_html__( 'Slider Type', 'ube' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'ube' ),
						'icon'  => 'eicon-h-align-stretch',
					],
					'vertical'   => [
						'title' => esc_html__( 'Vertical', 'ube' ),
						'icon'  => ' eicon-v-align-stretch',
					],

				],
			]
		);
		$this->add_responsive_control( 'slides_to_show', [
			'label'   => esc_html__( 'Slides To Show', 'ube' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 12,
			'step'    => 1,
			'default' => 4,
		] );

		$this->add_responsive_control(
			'navigation_arrow',
			[
				'label'   => esc_html__( 'Navigation Arrow', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'off' => esc_html__( 'Hide', 'ube' ),
					'on'  => esc_html__( 'Show', 'ube' ),

				],
				'default' => 'off',
			]
		);

		$this->add_responsive_control(
			'navigation_dots',
			[
				'label'   => esc_html__( 'Navigation Dots', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'off' => esc_html__( 'Hide', 'ube' ),
					'on'  => esc_html__( 'Show', 'ube' ),

				],
				'default' => 'on',
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label'        => esc_html__( 'Center Mode', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'center_padding',
			[
				'label'       => esc_html__( 'Center Padding', 'ube' ),
				'description' => esc_html__( 'Side padding when in center mode (px/%)', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '50px',
				'condition'   => [
					'center_mode' => 'on'
				]
			]
		);

		$this->add_control(
			'autoplay_enable',
			[
				'label'        => esc_html__( 'Autoplay Slides', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 500,
				'default'   => 5000,
				'condition' => [
					'autoplay_enable' => 'on'
				]
			]
		);

		$this->add_control(
			'infinite_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label'   => esc_html__( 'Transition Speed', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 300,
			]
		);

		$this->add_responsive_control( 'slider_space_between_items', [
			'label'     => esc_html__( 'Space Between Items', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}} .slick-slider' => '--ube-slider-gap: {{VALUE}}px;',
			],
		] );


		$this->add_responsive_control( 'slider_content_position', [
			'label'                => esc_html__( 'Content Position', 'ube' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__( 'Default', 'ube' ),
				'top'    => esc_html__( 'Top', 'ube' ),
				'middle' => esc_html__( 'Middle', 'ube' ),
				'bottom' => esc_html__( 'Bottom', 'ube' ),
			],
			'selectors_dictionary' => [
				'top'    => 'start',
				'middle' => 'center',
				'bottom' => 'end',
			],
			'selectors' => [
				'{{WRAPPER}} .ube-slider-item' => 'display: grid;align-items: {{VALUE}};',

			],
			'condition'            => [
				'grid_mode!' => 'on'
			]
		] );

		$this->add_responsive_control( 'slider_content_alignment', [
			'label'                => esc_html__( 'Content Alignment', 'ube' ),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__( 'Default', 'ube' ),
				'left'   => esc_html__( 'Left', 'ube' ),
				'center' => esc_html__( 'Center', 'ube' ),
				'right'  => esc_html__( 'Right', 'ube' ),
			],
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
			'selectors' => [
				'{{WRAPPER}} .ube-slider-item' => 'display: grid;justify-content: {{VALUE}};',
			],
			'condition'            => [
				'grid_mode!' => 'on'
			]
		] );

		$this->end_controls_section();
	}

	protected function register_slider_advanced_section_controls( $condition = [] ) {

		$section_slider_advanced_config = [
			'label' => esc_html__( 'Slider Options', 'ube' ),
			'tab'   => Controls_Manager::TAB_ADVANCED,
		];

		if ( count( $condition ) > 0 ) {
			$section_slider_advanced_config['conditions'] = [
				'terms' => [
					$condition
				]
			];
		}

		$this->start_controls_section(
			'section_slider_advanced',
			$section_slider_advanced_config
		);

		$this->add_control(
			'adaptive_height',
			[
				'label'        => esc_html__( 'Adaptive Height', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause Autoplay On Hover', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
				'condition'    => [
					'autoplay_enable' => 'on'
				]
			]
		);

		$this->add_control(
			'single_slide_scroll',
			[
				'label'        => esc_html__( 'Single Slide Scroll', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'fade_enabled',
			[
				'label'        => esc_html__( 'Fade Animation', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'slides_to_show',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'name'     => 'slider_type',
							'operator' => '==',
							'value'    => 'horizontal',
						],
					],
				],
			]
		);


		$this->add_control(
			'slider_syncing',
			[
				'label'        => esc_html__( 'Slider Syncing', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'slider_syncing_element',
			[
				'label'       => esc_html__( 'ID or Class Of Slider To Syncing', 'ube' ),
				'description' => esc_html__( 'Set the slider to be the navigation of other slider (Class or ID Name)', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'slider_syncing' => 'on'
				]
			]
		);

		$this->add_control(
			'focus_on_select',
			[
				'label'        => esc_html__( 'Enable Focus On Select Element', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'grid_mode',
			[
				'label'        => esc_html__( 'Enabled Grid Mode', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'slide_rows',
			[
				'label'     => esc_html__( 'Slide Rows', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'grid_mode' => 'on'
				],
				'default'   => 2
			]
		);

		$this->add_responsive_control( 'slides_per_row', [
			'label'     => esc_html__( 'Slides Per Row', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 1,
			'max'       => 12,
			'step'      => 1,
			'default'   => 1,
			'condition' => [
				'grid_mode' => 'on'
			]
		] );


		$this->add_control(
			'rtl_mode',
			[
				'label'        => esc_html__( 'RTL Mode', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}


	protected function register_slider_style_section_controls( $condition = [] ) {
		$this->register_navigation_arrow_style_section_controls( $condition );
		$this->register_navigation_dot_style_section_controls( $condition );
	}

	protected function register_navigation_arrow_style_section_controls( $condition = [] ) {
		$conditions = [
			'terms' => [
				[
					'name'     => 'navigation_arrow',
					'operator' => '=',
					'value'    => 'on'
				]
			]
		];

		if ( count( $condition ) > 0 ) {
			$conditions['terms'][] = $condition;
		}

		$this->start_controls_section(
			'slider_navigation_arrows_style', [
				'label'      => esc_html__( 'Navigation Arrows', 'ube' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => $conditions
			]
		);
		$this->add_responsive_control( 'slider_arrows_position', [
			'label'     => esc_html__( 'Arrow Position', 'ube' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'default',
			'options'   => [
				'default'    => [
					'title' => esc_html__( 'Default', 'ube' ),
					'icon'  => 'eicon-v-align-bottom',
				],
				'vertical'   => [
					'title' => esc_html__( 'Vertical Center', 'ube' ),
					'icon'  => 'eicon-v-align-stretch',
				],
				'horizontal' => [
					'title' => esc_html__( 'Horizontal Center', 'ube' ),
					'icon'  => 'eicon-h-align-stretch',
				],
			],
			'condition' => [
				'navigation_arrow' => 'on'
			]
		] );

		$this->start_controls_tabs(
			'slider_arrows_tabs',
			[
				'condition' => [
					'navigation_arrow' => 'on'
				]
			]
		);
		$this->start_controls_tab(
			'slider_arrows_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);
		$this->add_control(
			'slider_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .slick-arrow' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'slider_arrow_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .slick-arrow',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_arrow_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}}  .slick-arrow'
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_arrows_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'slider_arrow_hover_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .slick-arrow:hover',

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_arrow_border_hover',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}}  .slick-arrow:hover'
			]
		);
		$this->add_control(
			'slider_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .slick-arrow:hover' => 'color: {{VALUE}}',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'slider_arrows_type',
			[
				'label'     => esc_html__( 'Type', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'separator' => 'before',
				'options'   => [
					''        => esc_html__( 'Default', 'ube' ),
					'outline' => esc_html__( 'Outline', 'ube' ),
					'classic' => esc_html__( 'Classic', 'ube' ),
				],
			]
		);

		$this->add_control(
			'slider_arrows_size',
			[
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => [
					''   => esc_html__( 'Default', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'lg' => esc_html__( 'Larger', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
				'style_transfer' => true,
			]
		);
		$this->add_control(
			'slider_arrows_shape',
			[
				'label'     => esc_html__( 'Shape', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'round',
				'options'   => [
					'round'   => esc_html__( 'Round', 'ube' ),
					'square'  => esc_html__( 'Square', 'ube' ),
					'rounded' => esc_html__( 'Rounded', 'ube' ),
				],
				'condition' => [
					'slider_arrows_type!' => ''
				],

			]
		);


		$this->end_controls_section();
	}

	protected function register_navigation_dot_style_section_controls( $condition = [] ) {
		$conditions = [
			'terms' => [
				[
					'name'     => 'navigation_dots',
					'operator' => '=',
					'value'    => 'on'
				]
			]
		];

		if ( count( $condition ) > 0 ) {
			$conditions['terms'][] = $condition;
		}

		$this->start_controls_section(
			'slider_navigation_dots_style', [
				'label'      => esc_html__( 'Navigation Dots', 'ube' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => $conditions
			]
		);
		$this->add_responsive_control(
			'dots_position',
			[
				'label'       => esc_html__( 'Dots Position', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'default'     => 'outset',
				'options'     => [
					'outset' => esc_html__( 'Outset', 'ube' ),
					'inset'  => esc_html__( 'Inset', 'ube' ),

				],
			]
		);
		$this->add_control(
			'slider_dots_size',
			[
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => [
					''   => esc_html__( 'Default', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'lg' => esc_html__( 'Larger', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
				'style_transfer' => true,
			]
		);
		$this->add_control(
			'slider_dots_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .slick-dots>ul li' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function register_slider_item_style_section_controls($condition = []) {
		$conditions = [
			'terms' => [
				/*[
					'name'     => 'navigation_dots',
					'operator' => '=',
					'value'    => 'on'
				]*/
			]
		];

		if ( count( $condition ) > 0 ) {
			$conditions['terms'][] = $condition;
		}

		$this->start_controls_section(
			'section_slider_item_style',
			[
				'label'     => esc_html__( 'Slider Item', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'conditions' => $conditions
			]
		);


		$this->add_control(
			'slider_item_same_height_enable',
			[
				'label'        => esc_html__( 'Same Height', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_responsive_control( 'slider_item_padding', [
			'label'      => esc_html__( 'Padding', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em', 'rem' ],
			'selectors'  => [
				'{{WRAPPER}} .ube-slider-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs('slider_item_tabs');
		$this->start_controls_tab('slider_item_tab_normal',[
			'label' => esc_html__('Normal','ube')
		]);




		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_item_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-slider-item',
			]
		);


		$this->add_responsive_control(
			'slider_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'

				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'slider_item_box_shadow',
				'selector' => '{{WRAPPER}}  .ube-slider-item',
			]
		);

		$this->add_control(
			'slider_item_background',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-slider-item' => 'background-color: {{VALUE}};',
				]
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab('slider_item_tab_hover',[
			'label' => esc_html__('Hover','ube')
		]);




		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_item_border_hover',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-slider-item:hover',
			]
		);


		$this->add_responsive_control(
			'slider_item_border_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-slider-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'

				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'slider_item_box_shadow_hover',
				'selector' => '{{WRAPPER}}  .ube-slider-item:hover',
			]
		);

		$this->add_control(
			'slider_item_background_hover',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-slider-item:hover' => 'background-color: {{VALUE}};',
				]
			]
		);


		$this->add_control(
			'slider_item_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-slider-item' => 'transition: background {{SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s',
				],
			]
		);



		$this->end_controls_tab();


		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function print_slider( array $settings = null, $wrapper_class = '', $is_advanced = false ) {
		if ( null === $settings ) {
			$settings = $this->get_active_settings();
		}
		$wrapper_classes = array(
			'ube-slider',
			$wrapper_class
		);

		if ( $is_advanced === false ) {
			$wrapper_classes[] = 'slick-slider';
			$wrapper_classes[] = 'manual';
		}


		$slider_type = $slides_to_show = $slides_to_show_tablet = $slides_to_show_mobile =
		$navigation_arrow = $navigation_arrow_tablet = $navigation_arrow_mobile =
		$navigation_dots = $navigation_dots_tablet = $navigation_dots_mobile = $slider_arrows_position = $slider_arrows_shape =
		$dots_position = $slider_arrows_type = $slider_arrows_size = $slider_dots_size =
		$center_mode =
		$center_padding = $center_padding_tablet = $center_padding_mobile =
		$autoplay_enable = $autoplay_speed = $infinite_loop = $transition_speed =
		$adaptive_height = $pause_on_hover = $single_slide_scroll = $fade_enabled =
		$slider_syncing = $slider_syncing_element = $focus_on_select =
		$grid_mode = $slide_rows = $slide_rows_tablet = $slide_rows_mobile =
		$slides_per_row = $slides_per_row_tablet = $slides_per_row_mobile = $rtl_mode = $slider_item_same_height_enable = $slider_content_position = $slider_content_alignment =  '';
		extract( $settings );

		if (empty($slides_to_show)) {
			$slides_to_show = 1;
		}

		$slides_to_show_tablet = $slides_to_show_tablet == '' ? $slides_to_show : $slides_to_show_tablet;
		$slides_to_show_mobile = $slides_to_show_mobile == '' ? $slides_to_show_tablet : $slides_to_show_mobile;

		$navigation_arrow_tablet = $navigation_arrow_tablet == '' ? $navigation_arrow : $navigation_arrow_tablet;
		$navigation_arrow_mobile = $navigation_arrow_mobile == '' ? $navigation_arrow_tablet : $navigation_arrow_mobile;

		$navigation_dots_tablet = $navigation_dots_tablet == '' ? $navigation_dots : $navigation_dots_tablet;
		$navigation_dots_mobile = $navigation_dots_mobile == '' ? $navigation_dots_tablet : $navigation_dots_mobile;

		$center_padding_tablet = $center_padding_tablet == '' ? $center_padding : $center_padding_tablet;
		$center_padding_mobile = $center_padding_mobile == '' ? $center_padding_tablet : $center_padding_mobile;

		$slide_rows_tablet = $slide_rows_tablet == '' ? $slide_rows : $slide_rows_tablet;
		$slide_rows_mobile = $slide_rows_mobile == '' ? $slide_rows_tablet : $slide_rows_mobile;

		$slides_per_row_tablet = $slides_per_row_tablet == '' ? $slides_per_row : $slides_per_row_tablet;
		$slides_per_row_mobile = $slides_per_row_mobile == '' ? $slides_per_row_tablet : $slides_per_row_mobile;

		if ( ! empty( $slider_arrows_position ) ) {
			$wrapper_classes[] = 'ube-slider-arrow-position-' . $slider_arrows_position;
		}
		if ( ! empty( $dots_position ) ) {
			$wrapper_classes[] = 'ube-slider-dot-position-' . $dots_position;
		}
		if ( ! empty( $slider_arrows_type ) ) {
			$wrapper_classes[] = 'ube-slider-arrow-type-' . $slider_arrows_type;
		}
		if ( ! empty( $slider_arrows_size ) ) {
			$wrapper_classes[] = 'ube-slider-arrow-size-' . $slider_arrows_size;
		}
		if ( ! empty( $slider_arrows_shape ) ) {
			$wrapper_classes[] = 'ube-slider-arrow-' . $slider_arrows_shape;
		}

		if ( ! empty( $slider_dots_size ) ) {
			$wrapper_classes[] = 'ube-slider-dots-' . $slider_dots_size;
		}

		if (($slider_item_same_height_enable === 'on') || ($slider_content_position !== '') || ($slider_content_alignment !== '')) {
			$wrapper_classes[] = 'ube-slider-same-height';
		}

		$slick_options = array(
			'vertical'        => $slider_type === 'vertical',
			'verticalSwiping' => $slider_type === 'vertical',
			'slidesToShow'    => intval( $slides_to_show ),
			'slidesToScroll'  => $single_slide_scroll === 'on' ? 1 : intval( $slides_to_show ),
			'centerMode'      => $center_mode === 'on',
			'centerPadding'   => $center_padding,
			'arrows'          => $navigation_arrow === 'on',
			'dots'            => $navigation_dots === 'on',
			'infinite'        => ( $center_mode === 'on' ) ? true : ( $infinite_loop === 'on' ),
			'adaptiveHeight'  => $adaptive_height === 'on',
			'speed'           => intval( $transition_speed ),
			'autoplay'        => $autoplay_enable === 'on',
			'pauseOnHover'    => $pause_on_hover === 'on',
			'fade'            => $fade_enabled === 'on',
			'rtl'             => $rtl_mode === 'on',
			'focusOnSelect'   => $focus_on_select === 'on',
			'draggable'       => true,
		);
		if ( ! empty( $autoplay_speed ) ) {
			$slick_options['autoplaySpeed'] = intval( $autoplay_speed );
		}

		if ( ( $slider_syncing === 'on' ) && ( ! empty( $slider_syncing_element ) ) ) {
			$slick_options['asNavFor'] = $slider_syncing_element;
		}
		if ( $slider_arrows_position == 'vertical' ) {
			$slick_options['prevArrow'] = '<div class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-up"></i></div>';
			$slick_options['nextArrow'] = '<div class="slick-next" aria-label="Next"><i class="fas fa-chevron-down"></i></div>';
		}


		$mobile_breakpoint_value = \Elementor\Plugin::$instance->breakpoints->get_breakpoints( 'mobile' )->get_value();
		$tablet_breakpoint_value = \Elementor\Plugin::$instance->breakpoints->get_breakpoints( 'tablet' )->get_value();

		$tablet_settings = array(
			'slidesToShow'   => intval( $slides_to_show_tablet ),
			'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval( $slides_to_show_tablet ),
			'centerPadding'  => $center_padding_tablet,
			'arrows'         => $navigation_arrow_tablet === 'on',
			'dots'           => $navigation_dots_tablet === 'on',
		);

		$mobile_settings = array(
			'slidesToShow'   => intval( $slides_to_show_mobile ),
			'slidesToScroll' => $single_slide_scroll === 'on' ? 1 : intval( $slides_to_show_mobile ),
			'centerPadding'  => $center_padding_mobile,
			'arrows'         => $navigation_arrow_mobile === 'on',
			'dots'           => $navigation_dots_mobile === 'on',
		);

		if ( $grid_mode === 'on' ) {
			$slick_options['rows']         = intval( $slide_rows );
			$slick_options['slidesPerRow'] = intval( $slides_per_row );

			$tablet_settings['rows']         = intval( $slide_rows_tablet );
			$tablet_settings['slidesPerRow'] = intval( $slides_per_row_tablet );

			$mobile_settings['rows']         = intval( $slide_rows_mobile );
			$mobile_settings['slidesPerRow'] = intval( $slides_per_row_mobile );
		}

		$responsive = array(
			array(
				'breakpoint' => ( $tablet_breakpoint_value + 1 ),
				'settings'   => $tablet_settings
			),
			array(
				'breakpoint' => ( $mobile_breakpoint_value + 1 ),
				'settings'   => $mobile_settings
			)
		);

		$slick_options['responsive'] = $responsive;

		$this->add_render_attribute( 'slider', array(
			'data-slick-options' => json_encode( $slick_options ),
			'class'              => $wrapper_classes,
		) );
		?>
        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
			<?php $this->print_slider_items( $settings ) ?>
        </div>
		<?php
	}

	protected function print_slider_items( array $settings ) {

	}
}
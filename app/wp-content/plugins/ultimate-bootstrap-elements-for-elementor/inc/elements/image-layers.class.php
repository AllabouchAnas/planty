<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

class UBE_Element_Image_Layers extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-image-layers';
	}

	public function get_title() {
		return esc_html__( 'Image Layers', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-photo-library';
	}

	public function get_ube_keywords() {
		return array( 'image', 'layers', 'library', 'ube', 'image layers', 'ube image layers' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-image-layers' );
	}

	protected function register_controls() {
		$this->add_layers_section();
		$this->section_artboard_style();
		$this->section_image_style();
	}


	private function add_layers_section() {
		$this->start_controls_section( 'layers_section', [
			'label' => esc_html__( 'Layers', 'ube' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'static', [
			'label' => esc_html__( 'Static Layer', 'ube' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$repeater->start_controls_tabs( 'layer_tabs' );

		$repeater->start_controls_tab( 'layer_content_tab', [
			'label' => esc_html__( 'Image', 'ube' ),
		] );

		$repeater->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'ube' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		] );

		$repeater->add_control('image_link', [
			'label' => esc_html__('Link', 'ube'),
			'type' => Controls_Manager::URL,
			'separator' => 'before',
		]);

		$repeater->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'image_size',
			'default'   => 'full',
			'separator' => 'before',
		] );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'layer_position_tab', [
			'label' => esc_html__( 'Position', 'ube' ),
		] );

		$repeater->add_responsive_control( 'width', [
			'label'      => esc_html__( 'Width', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => 5,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1920,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$repeater->add_control(
			'horizontal_offset',
			[
				'label'     => esc_html__( 'Horizontal Align', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'default'   => 'left',
				'toggle'    => false,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => ' eicon-h-align-right',
					],
				],
				'condition' => [
					'static!' => 'yes'
				]

			]
		);

		$repeater->add_responsive_control( 'left_offset', [
			'label'      => esc_html__( 'Left Offset', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => - 100,
					'max' => 100,
				],
				'px' => [
					'min' => - 1000,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}}!important;',
			],
			'condition'  => [
				'horizontal_offset' => 'left',
				'static!'           => 'yes'
			]
		] );
		$repeater->add_responsive_control( 'right_offset', [
			'label'      => esc_html__( 'Right Offset', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => - 100,
					'max' => 100,
				],
				'px' => [
					'min' => - 1000,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}}!important;left:auto!important;',
			],
			'condition'  => [
				'horizontal_offset' => 'right',
				'static!'           => 'yes'
			]
		] );
		$repeater->add_control(
			'vertical_offset',
			[
				'label'     => esc_html__( 'Vertical Align', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'default'   => 'top',
				'toggle'    => false,
				'options'   => [
					'top'    => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'static!' => 'yes'
				]

			]
		);
		$repeater->add_responsive_control( 'top_offset', [
			'label'      => esc_html__( 'Top Offset', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => - 100,
					'max' => 100,
				],
				'px' => [
					'min' => - 1000,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}}!important;',
			],
			'condition'  => [
				'vertical_offset' => 'top',
				'static!'         => 'yes'
			]
		] );

		$repeater->add_responsive_control( 'bottom_offset', [
			'label'      => esc_html__( 'Bottom Offset', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => - 100,
					'max' => 100,
				],
				'px' => [
					'min' => - 1000,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'bottom: {{SIZE}}{{UNIT}}!important;top:auto!important;',
			],
			'condition'  => [
				'vertical_offset' => 'bottom',
				'static!'         => 'yes'
			]
		] );
		$repeater->add_responsive_control( 'margin', [
			'label'      => esc_html__( 'Margin', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .layer-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'static' => 'yes'
			]
		] );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'layer_style_tab', [
			'label' => esc_html__( 'Style', 'ube' ),
		] );

		$repeater->add_responsive_control( 'border_radius', [
			'label'      => esc_html__( 'Border Radius', 'ube' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .layer-content, {{WRAPPER}} {{CURRENT_ITEM}} .layer-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$repeater->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_shadow',
			'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .layer-content',
		] );
		$repeater->add_control( 'depth_animation', [
			'label'       => esc_html__( 'Animation Depth', 'ube' ),
			'type'        => Controls_Manager::NUMBER,
			'default'     => 0.1,
			'min'         => 0,
			'max'         => 1,
			'step'        => 0.1,
			'description' => esc_html__( 'Animation depth for parallax animation. Example 0.1,0.2...', 'ube' ),
		] );

		$repeater->add_control('custom_class_item', [
			'label' => esc_html__('Custom Class', 'ube'),
			'label_block' => true,
			'type' => Controls_Manager::TEXT,
			'placeholder' => esc_html__('Enter your custom class', 'ube'),
		]);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'layer_loop_tab', [
			'label' => esc_html__( 'Loop', 'ube' ),
		] );

		$repeater->add_control( 'loop', [
			'label'   => esc_html__( 'Loop', 'ube' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				''                => esc_html__( 'None', 'ube' ),
				'rotate'          => esc_html__( 'Rotate', 'ube' ),
				'move-horizontal' => esc_html__( 'Move - Horizontal', 'ube' ),
				'move-vertical'   => esc_html__( 'Move - Vertical', 'ube' ),
			],
			'default' => '',
		] );

		$repeater->add_control( 'loop_speed', [
			'label'     => esc_html__( 'Transition Duration', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 3000,
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .ube-layer-loop'     => 'animation-duration: {{VALUE}}ms;',
			],
		] );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control( 'layers', [
			'type'   => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
		] );

		$this->end_controls_section();
	}

	public function section_artboard_style() {
		//Wrapper style

		$this->start_controls_section(
			'section_style_artboart',
			[
				'label' => esc_html__( 'Artboard', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control( 'width', [
			'label'      => esc_html__( 'Width', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => 5,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1920,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .ube-image-layers' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'height', [
			'label'      => esc_html__( 'Height', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'min' => 5,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1000,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .ube-image-layers' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
				],
				'condition' => [ 'width[size]!' => '' ]
			]
		);
		$this->add_responsive_control(
			'align_2',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .layers-wrapper' => 'text-align: {{VALUE}};',
				],
				'condition' => [ 'width[size]' => '' ]
			]
		);

		$this->add_control(
			'section_style_animation',
			[
				'label'        => esc_html__( 'Parallax Animation', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);


		$this->end_controls_section();

	}

	public function section_image_style() {
		//Wrapper style

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Hover Image Animation', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_image_effect(),
			]
		);


		$this->add_control(
			'background_hover_overlay_color',
			[
				'label'     => esc_html__( 'Background Overlay Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-image-hover-shine:hover .card-img::before'                                        => 'background: {{VALUE}}',
					'{{WRAPPER}} .ube-image-hover-circle:hover .card-img::before'                                       => 'background: {{VALUE}}',
					'{{WRAPPER}} .ube-image:not(ube-image-hover-circle):not(.ube-image-hover-circle) .card-img::before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'hover_animation' => [ '', 'shine', 'circle' ]
				]
			]
		);
		$this->add_control(
			'hover_overlay_animation',
			[
				'label'   => esc_html__( 'Hover Overlay Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_hover_effect(),
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label'     => esc_html__( 'Transition Hover Duration', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-image img'                         => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .ube-image .card-img'                   => 'transition-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-image .card-img::before'           => 'transition-duration: {{SIZE}}s;animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .ube-image-hover-flash:hover .card-img' => 'animation-duration: {{SIZE}}s;',
				],
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .ube-image img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);


		$this->add_control(
			'opacity_hover',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-image:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .ube-image:hover img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

	}


	protected function render() {

		ube_get_template( 'elements/image-layers.php', array(
			'element' => $this
		) );

	}
}
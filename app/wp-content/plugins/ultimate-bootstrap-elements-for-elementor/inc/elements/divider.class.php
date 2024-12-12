<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Divider extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-divider';
	}

	public function get_title() {
		return esc_html__( 'Divider', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-divider';
	}

	public function get_ube_keywords() {
		return array( 'divider' , 'ube' , 'ube divider' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'divider_settings_section', [
			'label' => esc_html__( 'Divider', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'divider_style',
			[
				'label'   => esc_html__( 'Style', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'solid'  => esc_html__( 'Solid', 'ube' ),
					'double' => esc_html__( 'Double', 'ube' ),
					'dashed' => esc_html__( 'Dashed', 'ube' ),
					'dotted' => esc_html__( 'Dotted', 'ube' ),
					'groove' => esc_html__( 'Groove', 'ube' ),
					'ridge'  => esc_html__( 'Ridge', 'ube' ),
				],
				'default' => 'solid',
			]
		);

		$this->add_responsive_control(
			'divider_add_element',
			[
				'label'   => esc_html__( 'Add Element', 'ube' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					''     => [
						'title' => esc_html__( 'None', 'ube' ),
						'icon'  => 'eicon-ban',
					],
					'text' => [
						'title' => esc_html__( 'Text', 'ube' ),
						'icon'  => 'eicon-t-letter-bold',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'ube' ),
						'icon'  => 'eicon-star',
					],
				],
				'default' => 'icon',
			]
		);

		$this->add_control(
			'divider_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'far fa-paper-plane',
					'library' => 'fa-regular',
				],
				'condition' => [
					'divider_add_element' => 'icon',
				]
			]
		);

		$this->add_control( 'divider_text', [
			'label'     => esc_html__( 'Text', 'ube' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Text', 'ube' ),
			'dynamic'   => [
				'active' => true,
			],
			'condition' => [
				'divider_add_element' => 'text',
			]
		] );

		$this->add_control(
			'divider_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-divider' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control( 'divider_alignment', [
			'label'     => esc_html__( 'Alignment', 'ube' ),
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
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'divider_section_style', [
			'label' => esc_html__( 'Divider', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-divider-separator' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .ube-divider-element'   => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_size',
			[
				'label'      => esc_html__( 'Size', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-divider-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-divider-element'   => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_gap',
			[
				'label'      => esc_html__( 'Gap', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 400,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-divider' => 'padding-top: {{SIZE}}{{UNIT}};padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'divider_element_section_style', [
			'label'     => esc_html__( 'Element', 'ube' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'divider_add_element!' => '',
			]
		] );

		$this->add_control(
			'divider_element_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-divider-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'divider_element_background',
			'selector' => '{{WRAPPER}} .ube-divider-content',
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'divider_element_typography',
				'selector' => '{{WRAPPER}} .ube-divider-content',
			]
		);

		$this->add_responsive_control(
			'divider_element_space',
			[
				'label'      => esc_html__( 'Space', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-divider-content' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'divider_element_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-divider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'divider_element_border',
				'selector'  => '{{WRAPPER}} .ube-divider-content',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_element_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-divider-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		ube_get_template( 'elements/divider.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/divider.php' );
	}
}
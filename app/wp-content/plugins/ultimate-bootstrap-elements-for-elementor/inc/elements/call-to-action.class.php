<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Call_To_Action extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-call-to-action';
	}

	public function get_title() {
		return esc_html__( 'Call To Action', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-image-rollover';
	}

	public function get_ube_keywords() {
		return array( 'call to action', 'ube' , 'ube call to action' );
	}

	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_content_style();
		$this->register_section_button_style();
	}

	private function register_section_content() {

		$this->start_controls_section( 'call_to_action_settings_section', [
			'label' => esc_html__( 'Content', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'call_to_action_title',
			[
				'label'       => esc_html__( 'Title & Description', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'The Ultimate Addons For Elementor', 'ube' ),
				'placeholder' => esc_html__( 'Enter your title', 'ube' ),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'call_to_action_description',
			[
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Add a strong one liner supporting the heading above and giving users a reason to click on the button below.', 'ube' ),
				'placeholder' => esc_html__( 'Enter your description', 'ube' ),
				'separator'   => 'none',
				'rows'        => 5,
				'show_label'  => false,
			]
		);

		$this->add_control( 'call_to_action_title_size', [
			'label'   => esc_html__( 'Size', 'ube' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				'' => esc_html__( 'Default', 'ube' ),
				'sm' => esc_html__( 'Sm', 'ube' ),
				'md' => esc_html__( 'Md', 'ube' ),
				'lg' => esc_html__( 'Lg', 'ube' ),
				'xl' => esc_html__( 'XL', 'ube' ),
				'xxl' => esc_html__( 'XXL', 'ube' ),
			),
			'default' => '',
		] );

		$this->add_control(
			'call_to_action_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
				'default'   => 'h2',
				'condition' => [
					'call_to_action_title!' => '',
				],
			]
		);

		$this->add_control(
			'call_to_action_button',
			[
				'label'     => esc_html__( 'Button Text', 'ube' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => esc_html__( 'Click Here', 'ube' ),
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'call_to_action_button_type',
			[
				'label'   => esc_html__( 'Type', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'outline',
				'options' => [
					''        => esc_html__( 'Classic', 'ube' ),
					'outline' => esc_html__( 'Outline', 'ube' ),
					'link'    => esc_html__( 'Link', 'ube' ),
					'3d'      => esc_html__( '3D', 'ube' ),
				],
				'condition' => [
					'call_to_action_button!' => '',
				],
			]
		);

		$this->add_control(
			'call_to_action_button_scheme',
			[
				'label'     => esc_html__( 'Scheme', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => ube_get_color_schemes( false ),
				'default'   => 'dark',
				'condition' => [
					'call_to_action_button_type[value]!' => 'link',
					'call_to_action_button!' => '',
				],
			]
		);

		$this->add_control(
			'call_to_action_button_shape',
			[
				'label'     => esc_html__( 'Shape', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'rounded',
				'options'   => [
					'rounded' => esc_html__( 'Rounded', 'ube' ),
					'square'  => esc_html__( 'Square', 'ube' ),
					'round'   => esc_html__( 'Round', 'ube' ),
				],
				'condition' => [
					'call_to_action_button_type[value]!' => 'link',
					'call_to_action_button!' => '',
				],
			]
		);

		$this->add_control(
			'call_to_action_button_size',
			[
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'md',
				'options'        => [
					'xs' => esc_html__( 'Extra Small', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'md' => esc_html__( 'Medium', 'ube' ),
					'lg' => esc_html__( 'Large', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
				'style_transfer' => true,
				'condition' => [
					'call_to_action_button!' => '',
				],
			]
		);

		$this->add_control(
			'position_button',
			[
				'label'     => esc_html__( 'Position Button', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom',
				'options'   => [
					'top'    => esc_html__( 'Top', 'ube' ),
					'bottom' => esc_html__( 'Bottom', 'ube' ),
					'left'   => esc_html__( 'Left', 'ube' ),
					'right'  => esc_html__( 'Right', 'ube' ),
				],
				'condition' => [
					'call_to_action_button!' => '',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon Button', 'ube' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'ube' ),
					'right' => esc_html__( 'After', 'ube' ),
				],
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'call_to_action_link',
			[
				'label'       => esc_html__( 'Link', 'ube' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
				'condition'   => [
					'call_to_action_button!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	private function register_section_content_style() {

		$this->start_controls_section( 'call_to_action_section_style', [
			'label' => esc_html__( 'Content', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control(
			'callto_content_style_align',
			[
				'label'        => esc_html__( 'Alignment', 'ube' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			]
		);

		$this->add_control(
			'callto_content_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => esc_html__( 'Top', 'ube' ),
					'middle' => esc_html__( 'Middle', 'ube' ),
					'bottom' => esc_html__( 'Bottom', 'ube' ),
				],
				'default' => 'middle',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action' => 'align-items: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'position_button',
							'operator' => 'in',
							'value'    => [
								'left',
								'right',
							]
						],
						[
							'name'     => 'call_to_action_button',
							'operator' => '!==',
							'value'    => '',
						]
					]
				]
			]
		);


		$this->add_responsive_control(
			'callto_container_width',
			[
				'label'      => esc_html__( 'Max Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1500,
						'step' => 5,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-call-to-action'   => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'callto_mw_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto;margin-left:0;',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto;margin-right:0;',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action' => '{{VALUE}}',
				],
				'condition' => [
					'callto_container_width[size]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'callto_container_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-call-to-action' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'heading_style_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Title', 'ube' ),
				'separator'  => 'before',
				'condition' => [
					'call_to_action_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'callto_action_title_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-call-to-action-title',
				'condition' => [
					'call_to_action_title!' => '',
				],
			]
		);

		$this->add_control('title_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'condition' => [
				'call_to_action_title!' => '',
			],
		]);

		$this->add_control(
			'description_style_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Description', 'ube' ),
				'separator'  => 'before',
				'condition' => [
					'call_to_action_description!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'callto_action_description_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-call-to-action-description',
				'condition' => [
					'call_to_action_description!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'callto_action_description_margin',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'call_to_action_description!' => '',
				],
			]
		);

		$this->add_control('description_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'condition' => [
				'call_to_action_description!' => '',
			],
		]);

		$this->add_control(
			'color_style_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Colors', 'ube' ),
				'separator'  => 'before',
			]
		);

		$this->start_controls_tabs( 'color_tabs' );

		$this->start_controls_tab( 'colors_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'callto_action_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'callto_action_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'call_to_action_title!' => '',
				],
			]
		);

		$this->add_control(
			'callto_action_description_color',
			[
				'label'     => esc_html__( 'Description Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-description' => 'color: {{VALUE}};',
				],
				'condition' => [
					'call_to_action_description!' => '',
				],
			]
		);

		$this->add_control(
			'callto_action_button_color',
			[
				'label' => esc_html__( 'Button Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action .btn' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'call_to_action_button!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'colors_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'callto_action_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'callto_action_title_color_hover',
			[
				'label'     => esc_html__( 'Title Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-title:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'call_to_action_title!' => '',
				],
			]
		);

		$this->add_control(
			'callto_action_description_color_hover',
			[
				'label'     => esc_html__( 'Description Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-description:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'call_to_action_description!' => '',
				],
			]
		);

		$this->add_control(
			'callto_action_button_color_hover',
			[
				'label' => esc_html__( 'Button Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action .btn:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'call_to_action_button!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function register_section_button_style() {

		$this->start_controls_section( 'call_to_action_button_style', [
			'label'     => esc_html__( 'Button', 'ube' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'call_to_action_button!' => '',
			],
		] );

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action .btn' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-call-to-action .btn',
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);
		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action .btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-call-to-action .btn',

			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'label'     => esc_html__( 'Border', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-call-to-action .btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-call-to-action .btn',
			]
		);


		$this->end_controls_tab(); // Button Normal tab end

		// Button Hover tab start
		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action .btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_hover_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-call-to-action .btn:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_hover_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-call-to-action .btn:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-call-to-action .btn:hover',
			]
		);

		$this->end_controls_tab(); // Button Hover tab end

		$this->end_controls_tabs();


		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-call-to-action .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-call-to-action .btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Icon', 'ube' ),
				'separator'  => 'before',
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Spacing', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-icon-right i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-btn-icon-left i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Size', 'ube'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem'],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-btn i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style',
			[
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-btn i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-call-to-action-btn i:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public function render() {
		ube_get_template( 'elements/call-to-action.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/call-to-action.php' );
	}
}
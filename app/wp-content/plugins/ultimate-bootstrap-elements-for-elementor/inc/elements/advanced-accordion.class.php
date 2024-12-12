<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

class UBE_Element_Advanced_Accordion extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-advanced-accordion';
	}

	public function get_title() {
		return esc_html__( 'Advanced Accordion', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-accordion';
	}

	public function get_ube_keywords() {
		return array( 'accordion' , 'ube' , 'advanced' , 'advanced accordion' , 'ube advanced accordion');
	}

	public function get_script_depends() {
		return array( 'ube-widget-accordion' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_style();
		$this->section_title_style();
		$this->section_content_style();
		$this->section_icon_toggle_style();


	}

	public function section_content() {
		$this->start_controls_section(
			'section_tab', [
				'label' => esc_html__( 'General Settings', 'ube' ),
			]
		);
		$this->add_control(
			'accordion_type',
			[
				'label'       => esc_html__( 'Accordion Type', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'accordion',
				'label_block' => false,
				'options'     => [
					'accordion' => esc_html__( 'Accordion', 'ube' ),
					'toggle'    => esc_html__( 'Toggle', 'ube' ),
				],
			]
		);
		$this->add_control(
			'accordion_spacing',
			[
				'label'        => esc_html__( 'Spacing', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'default'      => 'no',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'accordion_tab_icon',
			[
				'label'                  => esc_html__( 'Icon', 'ube' ),
				'type'                   => Controls_Manager::ICONS,
				'separator'              => 'before',
				'fa4compatibility'       => 'icon',
				'default'                => [
					'value'   => 'fas fa-caret-right',
					'library' => 'fa-solid',
				],
				'recommended'            => [
					'fa-solid' => [
						'chevron-right',
						'caret-right',
						'plus',
					],
				],
				'label_block'            => false,
				'skin'                   => 'inline',
				'exclude_inline_options' => [ 'svg' ]
			]
		);
		$this->add_control(
			'accordion_tab_icon_position',
			[
				'label'     => esc_html__( 'Accordion Tab Icon Position', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'default'   => 'right',
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
					'accordion_tab_icon[value]!' => ''
				]

			]
		);
		$this->add_control(
			'accordion_toggle_icon',
			[
				'label'     => esc_html__( 'Toggle Icon', 'ube' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'accordion_display_toggle' => 'yes'
				]
			]
		);
		$this->add_control(
			'accordion_scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'accordion_active_default',
			[
				'label'        => esc_html__( 'Active as Default', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$repeater->add_control(
			'accordion_item_scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);

		$repeater->add_control(
			'acc_title', [
				'label'       => esc_html__( 'Title', 'ube' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);


		$repeater->add_control(
			'acc_content', [
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => UBE_Controls_Manager::WIDGETAREA,
				'label_block' => true,
			]
		);

		$this->add_control(
			'accordion_items',
			[
				'label'       => esc_html__( 'Content', 'ube' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'separator'   => 'before',
				'title_field' => '{{ acc_title }}',
				'default'     => [
					[
						'acc_title'                => esc_html__('Accordion Tab Title 1','ube'),
						'accordion_active_default' => 'yes'
					],
					[
						'acc_title'                => esc_html__('Accordion Tab Title 2','ube'),
						'accordion_active_default' => 'no'
					],
					[
						'acc_title'                => esc_html__('Accordion Tab Title 3','ube'),
						'accordion_active_default' => 'no'
					],
				],
				'fields'      => $repeater->get_controls(),
			]
		);


		$this->end_controls_section();
		// Icon setting
	}

	public function section_wrapper_style() {
		//Wrapper style

		$this->start_controls_section(
			'accordion_section_general_style', [
				'label' => esc_html__( 'General Setting', 'ube' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'accordion_card_margin',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => - 300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'accordion_spacing' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'accordion_card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card.ube-accordion-separate'                                                          => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card.ube-accordion-separate:not(.active) .ube-accordion-card-header'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card.ube-accordion-separate.active .ube-accordion-card-header'                        => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate):first-child'                                        => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate):first-child .ube-accordion-card-header'             => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate):last-child'                                         => 'border-bottom-left-radius: {{BOTTOM}}{{UNIT}}; border-bottom-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate):last-child:not(.active) .ube-accordion-card-header' => 'border-bottom-left-radius: {{BOTTOM}}{{UNIT}}; border-bottom-right-radius: {{RIGHT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'accordion_card_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'ube' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card'                                                                           => 'border-width:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-accordion.accordion > .ube-accordion-card.ube-accordion-separate:not(:first-of-type):not(:last-of-type)' => 'border-bottom-width: {{BOTTOM}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'accordion_card_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card'                                                                           => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ube-accordion.accordion > .ube-accordion-card.ube-accordion-separate:not(:first-of-type):not(:last-of-type)' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'      => 'accordion_background_card',
				'label'     => esc_html__( 'Background', 'ube' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .ube-accordion .ube-accordion-card',
				'condition' => [
					'accordion_scheme' => ''
				]
			]
		);

		$this->end_controls_section();

	}

	public function section_title_style() {
		//Title Style Section

		$this->start_controls_section(
			'accordion_section_title_style', [
				'label' => esc_html__( 'Tab Style', 'ube' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name'     => 'accordion_title_typography',
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card-header .ube-accordion-link',
			]
		);

		$this->add_responsive_control(
			'accordion_tab_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs(
			'accordion_style_tabs'
		);
		$this->start_controls_tab(
			'accordion_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);
		$this->add_control(
			'accordion_title_color_normal', [
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-header .ube-accordion-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'accordion_background_normal',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card .ube-accordion-card-header',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'accordion_title_border_normal',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card .ube-accordion-card-header,{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate).active .ube-accordion-card-header,{{WRAPPER}} .ube-accordion .ube-accordion-card.ube-accordion-separate .ube-accordion-card-header',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordion_title_boxshadown_normal',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card',
			]
		);


		$this->end_controls_tab();
		$this->start_controls_tab(
			'accordion_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_control(
			'accordion_title_color_hover', [
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-header:hover .ube-accordion-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'accordion_background_hover',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card-header:hover',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'accordion_title_border_hover',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card .ube-accordion-card-header:hover,{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate).active .ube-accordion-card-header:hover,{{WRAPPER}} .ube-accordion .ube-accordion-card.ube-accordion-separate .ube-accordion-card-header:hover',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordion_title_boxshadown_hover',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'accordion_style_active_tab',
			[
				'label' => esc_html__( 'Active', 'ube' ),
			]
		);
		$this->add_control(
			'accordion_title_color_active', [
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card.active .ube-accordion-card-header .ube-accordion-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'accordion_background_active',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card.active .ube-accordion-card-header',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'accordion_title_border_active',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card.active .ube-accordion-card-header,{{WRAPPER}} .ube-accordion .ube-accordion-card:not(.ube-accordion-separate).active .ube-accordion-card-header,{{WRAPPER}} .ube-accordion .ube-accordion-card.ube-accordion-separate.active .ube-accordion-card-header',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordion_title_boxshadown_active',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card.active',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	public function section_content_style() {
		//Content Style Section
		$this->start_controls_section(
			'accordion_section_content_style', [
				'label' => esc_html__( 'Content Style', 'ube' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'accordion_content_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card-body',
			]
		);

		$this->add_control(
			'accordion_content_color', [
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-body p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-body'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name'     => 'accordion_content_typography',
				'selector' => '{{WRAPPER}} .ube-accordion .ube-accordion-card-body p, {{WRAPPER}} .ube-accordion .ube-accordion-card-body',
			]
		);
		$this->add_responsive_control(
			'accordion_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'accordion_content_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

	}

	public function section_icon_toggle_style() {
		//Icon Style Section
		$this->start_controls_section(
			'accordion_section_icon_style', [
				'label'     => esc_html__( 'Icon Style', 'ube' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'accordion_tab_icon!' => ''
				]
			]
		);

		$this->add_responsive_control(
			'accordion_icon_tab_size',
			[
				'label'     => esc_html__( 'Icon Size', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],

			]
		);
		$this->add_responsive_control(
			'accordion_icon_tab_gap',
			[
				'label'     => esc_html__( 'Icon Gap', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => '10',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .left-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'accordion_tab_icon_position' => 'left'
				]
			]
		);
		$this->add_control(
			'accordion_icon_color', [
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-accordion .ube-accordion-card .ube-accordion-card-header .ube-accordion-link .ube-accordion-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		ube_get_template( 'elements/adv-accordion.php', array(
			'element' => $this
		) );

	}
}
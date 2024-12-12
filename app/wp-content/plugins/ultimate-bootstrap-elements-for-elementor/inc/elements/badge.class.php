<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;

class UBE_Element_Badge extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-badge';
	}

	public function get_title()
	{
		return esc_html__('Badge', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-pro-icon';
	}

	public function get_ube_keywords()
	{
		return array('badge', 'ube' , 'ube badge');
	}

	protected function register_controls()
	{
		$this->start_controls_section('badge_settings_section', [
			'label' => esc_html__('Badge Content', 'ube'),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control('badge_text', [
			'label'   => esc_html__('Text', 'ube'),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__('Badge Text', 'ube'),
			'dynamic' => [
				'active' => true,
			],
		]);

		$this->add_control(
			'badge_view',
			[
				'label'   => esc_html__('View', 'ube'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__('Default', 'ube'),
					'badge-pill'    => esc_html__('Pill', 'ube'),
				],
				'default' => '',
			]
		);
		$this->add_control(
			'badge_color_scheme',
			[
				'label'   => esc_html__('Scheme', 'ube'),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => 'primary',
			]
		);

		$this->add_control(
			'badge_link',
			[
				'label' => esc_html__( 'Link', 'ube' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
			'badge_align',
			[
				'label' => esc_html__( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'ube' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Badge Style', 'ube' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'selector' => '{{WRAPPER}} .badge',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'badge_text_shadow',
				'selector' => '{{WRAPPER}} .badge',
			]
		);

		$this->start_controls_tabs( 'tabs_badge_style' );

		$this->start_controls_tab(
			'tab_badge_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_badge_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'badge_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .badge:hover, {{WRAPPER}} .badge:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .badge:hover, {{WRAPPER}} .badge:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .badge:hover, {{WRAPPER}} .badge:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'ube' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'badge_border',
				'selector' => '{{WRAPPER}} .badge',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .badge',
			]
		);

		$this->add_responsive_control(
			'badge_text_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/badge.php', array(
			'element' => $this
		));
	}

	protected function content_template() {
		ube_get_template('elements-view/badge.php');
	}
}
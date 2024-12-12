<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Modals extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-modals';
	}

	public function get_title()
	{
		return esc_html__('Modals', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-slider-vertical';
	}

	public function get_script_depends() {
		return array( 'ube-widget-modal' );
	}

	public function get_ube_keywords()
	{
		return array('modals' , 'ube' , 'ube modals');
	}

	protected function register_controls()
	{
		$this->start_controls_section('modal_content_section', [
			'label' => esc_html__('Content', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'modal_enable_header',
			[
				'label' => esc_html__('Enable Header', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'modal_header_text',
			[
				'label' => esc_html__('Header Content', 'ube'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__('Modal Header Content', 'ube'),
				'condition' => [
					'modal_enable_header' => 'yes'
				],
			]
		);

		$this->add_control(
			'modal_content_source',
			[
				'label' => esc_html__('Content Source', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom' => esc_html__('Custom', 'ube'),
					'template' => esc_html__('Elementor Template', 'ube'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'modal_template_id',
			[
				'label' => esc_html__('Template', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_page_templates(),
				'condition' => [
					'modal_content_source' => 'template'
				],
			]
		);

		$this->add_control(
			'modal_custom_content',
			[
				'label' => esc_html__('Content', 'ube'),
				'type' => Controls_Manager::WYSIWYG,
				'title' => esc_html__('Content', 'ube'),
				'show_label' => false,
				'condition' => [
					'modal_content_source' => 'custom',
				],
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipis elit, sed do eiusmod tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitati ulla laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in repre in voluptate velit esse cillum dolore eu.', 'ube'),
			]
		);

		$this->add_control(
			'modal_enable_footer',
			[
				'label' => esc_html__('Enable Footer', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'modal_footer_text',
			[
				'label' => esc_html__('Footer Text', 'ube'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__('Modal Footer Content', 'ube'),
				'condition' => [
					'modal_enable_footer' => 'yes'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'modal_button_tab_content',
			[
				'label' => esc_html__('Button', 'ube'),
			]
		);

		$this->add_control(
			'modal_button_text',
			[
				'label' => esc_html__('Text', 'ube'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Show Modal', 'ube'),
			]
		);

		$this->add_control(
			'modal_button_icon',
			[
				'label' => esc_html__('Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_responsive_control(
			'modal_icon_btn_space',
			[
				'label' => esc_html__('Space Icon', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show > i' => 'margin-right: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('modal_wrapper_tab_style', [
			'label' => esc_html__('Wrapper', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'modal_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-dialog' => 'max-width: {{SIZE}}px;margin-left: auto; margin-right: auto;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_color',
				'selector' => '{{WRAPPER}} .ube-modal .modal-content',
			]
		);

		$this->add_responsive_control(
			'modal_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('modal_button_show_tab_style', [
			'label' => esc_html__('Button Show', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->start_controls_tabs('modal_tabs_button_style');

		$this->start_controls_tab(
			'modal_tab_button_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'modal_btn_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_btn_color',
				'selector' => '{{WRAPPER}} .ube-modal-btn-show',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_btn_typography',
				'selector' => '{{WRAPPER}} .ube-modal-btn-show',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'modal_tab_button_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'modal_btn_color_hover',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_btn_color_hover',
				'selector' => '{{WRAPPER}} .ube-modal-btn-show:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_btn_typography_hover',
				'selector' => '{{WRAPPER}} .ube-modal-btn-show:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'modal_btn_align',
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
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'modal_btn_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show' => 'width: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'modal_btn_height',
			[
				'label' => esc_html__('Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'modal_btn_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'modal_btn_border',
				'selector' => '{{WRAPPER}} .ube-modal-btn-show',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'modal_btn_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-show' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'modal_header_tab_style',
			[
				'label' => esc_html__('Header', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'modal_enable_header' => 'yes'
				],
			]
		);

		$this->add_control(
			'modal_header_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_header_bg_color',
				'selector' => '{{WRAPPER}} .ube-modal .modal-header',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_header_typography',
				'selector' => '{{WRAPPER}} .ube-modal .modal-title',
			]
		);

		$this->add_responsive_control(
			'modal_header_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'modal_header_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'modal_footer_tab_style',
			[
				'label' => esc_html__('Footer', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'modal_enable_footer' => 'yes'
				],
			]
		);

		$this->add_control(
			'modal_footer_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .modal-footer-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_footer_bg_color',
				'selector' => '{{WRAPPER}} .ube-modal .modal-footer',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_footer_typography',
				'selector' => '{{WRAPPER}} .ube-modal .modal-footer-content',
			]
		);

		$this->add_responsive_control(
			'modal_footer_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'modal_footer_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section('modal_button_close_tab_style', [
			'label' => esc_html__('Button Close', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'modal_enable_footer' => 'yes'
			],
		]);

		$this->start_controls_tabs('modal_tabs_button_close_style');

		$this->start_controls_tab(
			'modal_tab_button_close_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'modal_btn_close_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-close' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_btn_close_color',
				'selector' => '{{WRAPPER}} .ube-modal-btn-close',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_btn_close_typography',
				'selector' => '{{WRAPPER}} .ube-modal-btn-close',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'modal_tab_button_close_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'modal_btn_close_color_hover',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-close:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_btn_close_color_hover',
				'selector' => '{{WRAPPER}} .ube-modal-btn-close:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_btn_close_typography_hover',
				'selector' => '{{WRAPPER}} .ube-modal-btn-close:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'modal_btn_close_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-close' => 'width: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'modal_btn_close_height',
			[
				'label' => esc_html__('Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-close' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'modal_btn_close_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'modal_btn_close_border',
				'selector' => '{{WRAPPER}} .ube-modal-btn-close',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'modal_btn_close_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal-btn-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'modal_content_tab_style',
			[
				'label' => esc_html__('Content', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'modal_content_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .modal-body' => 'color: {{VALUE}};',
				],
				'condition' => [
					'modal_content_source' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_content_bg_color',
				'selector' => '{{WRAPPER}} .ube-modal .modal-body',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'modal_content_typography',
				'selector' => '{{WRAPPER}} .ube-modal .modal-body,{{WRAPPER}} .ube-modal .modal-body > p',
				'condition' => [
					'modal_content_source' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'modal_content_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'modal_content_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-modal .modal-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/modals.php', array(
			'element' => $this
		));
	}
}
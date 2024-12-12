<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;


class UBE_Element_Vertical_Menu extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'vertical-menu';
	}

	public function get_title()
	{
		return esc_html__('Vertical Menu', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-menu-bar';
	}

	public function get_ube_keywords()
	{
		return array('menu', 'vertical menu', 'ube', 'ube vertical menu');
	}

	public function get_script_depends()
	{
		return array('ube-widget-menu');
	}

	public $nav_menu_index = 1;

	public function get_nav_menu_index()
	{
		return $this->nav_menu_index++;
	}

	public function get_available_menus()
	{
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ($menus as $menu) {
			$options[$menu->slug] = $menu->name;
		}

		return $options;
	}

	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_wrapper_section_controls();
		$this->register_main_menu_section_controls();
		$this->register_sub_menu_section_controls();
		$this->register_toggle_button_section_controls();
	}

	protected function register_layout_section_controls()
	{
		$this->start_controls_section('menu_settings_section', [
			'label' => esc_html__('Menu Content', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$menus = $this->get_available_menus();

		if (!empty($menus)) {
			$this->add_control(
				'menu',
				[
					'label' => esc_html__('Menu', 'ube'),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys($menus)[0],
					'save_default' => true,
					'separator' => 'after',
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . esc_html__('There are no menus in your site.', 'ube') . '</strong><br>' . sprintf(wp_kses_post(__('Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'ube')), admin_url('nav-menus.php?action=edit&menu=0')),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
		}

		$this->add_control(
			'menu_toggle_schame',
			[
				'label' => esc_html__('Scheme', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'navbar-dark' => esc_html__('Light', 'ube'),
					'navbar-light' => esc_html__('Dark', 'ube'),
				],
				'default' => 'navbar-light',
			]
		);

		$this->add_control(
			'menu_border',
			[
				'label' => esc_html__('Border', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'banner_button_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .navbar-nav > .menu-item ',
				'condition' => [
					'menu_border' => 'yes',
				]
			]
		);

		$this->add_control(
			'menu_toggle_button',
			[
				'label' => esc_html__('Toggle Button', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'menu_always_show',
			[
				'label' => esc_html__('Menu Always Show', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
				'condition' => [
					'menu_toggle_button' => 'yes',
				]
			]
		);

		$this->add_control(
			'toggle_align',
			[
				'label' => esc_html__('Toggle Align', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin-left: auto;margin-right: auto',
					'right' => 'margin-left: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => '{{VALUE}}',
				],
				'label_block' => false,
				'condition' => [
					'menu_toggle_button' => 'yes',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function register_main_menu_section_controls()
	{
		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => esc_html__('Main Menu', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'menu_maint_heading_label',
			[
				'label' => esc_html__('Item Main Menu', 'ube'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->start_controls_tabs('tabs_menu_item_style');

		$this->start_controls_tab(
			'menu_tab_item_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'menu_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .navbar-nav .menu-item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_text_typography',
				'selector' => '{{WRAPPER}} .navbar-nav .menu-item > a',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'menu_tab_item_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'menu_text_hover_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .navbar-nav .menu-item > a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_text_typography_hover',
				'selector' => '{{WRAPPER}} .navbar-nav .menu-item > a:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_tab_item_active',
			[
				'label' => esc_html__('Active', 'ube'),
			]
		);

		$this->add_control(
			'menu_text_ative_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menu-item.current-menu-item > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .menu-item.current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_text_typography_active',
				'selector' => '{{WRAPPER}} .navbar-nav .menu-item.current-menu-item > a',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'menu_padding_item',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .navbar-nav > .menu-item .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_margin_item',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .navbar-nav .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function register_toggle_button_section_controls()
	{
		$this->start_controls_section('menu_toggle_button_tab_style', [
			'label' => esc_html__('Toggle Button', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'menu_toggle_button' => 'yes',
			]
		]);

		$this->start_controls_tabs('menu_tabs_toggle_button_style');

		$this->start_controls_tab(
			'menu_tab_toggle_button_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'menu_toggle_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'menu_toggle_button_color',
				'selector' => '{{WRAPPER}} .elementor-menu-toggle',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_toggle_button_typography',
				'selector' => '{{WRAPPER}} .elementor-menu-toggle',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_tab_toggle_button_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'menu_toggle_text_hover_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'menu_toggle_button_color_hover',
				'selector' => '{{WRAPPER}} .elementor-menu-toggle:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'menu_toggle_button_size',
			[
				'label' => esc_html__('Size', 'ube'),
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
					'{{WRAPPER}} .elementor-menu-toggle' => 'font-size: {{SIZE}}px;',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_toggle_button_width',
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
					'{{WRAPPER}} .elementor-menu-toggle' => 'width: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'menu_toggle_button_height',
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
					'{{WRAPPER}} .elementor-menu-toggle' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'menu_toggle_button_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_toggle_button_border',
				'selector' => '{{WRAPPER}} .elementor-menu-toggle',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'menu_toggle_button_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_sub_menu_section_controls()
	{
		$this->start_controls_section(
			'section_style_sub_menu',
			[
				'label' => esc_html__('Sub Menu', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_menu_typography',
				'selector' => '{{WRAPPER}} .dropdown-menu .menu-item > a',
			]
		);

		$this->start_controls_tabs('tabs_sub_menu_item_style');

		$this->start_controls_tab(
			'sub_menu_tab_item_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'sub_menu_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu .menu-item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_menu_tab_item_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'sub_menu_text_hover_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu .menu-item:hover > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_menu_tab_item_ative',
			[
				'label' => esc_html__('Active', 'ube'),
			]
		);

		$this->add_control(
			'sub_menu_text_ative_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu .menu-item.current-menu-item > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dropdown-menu .menu-item.current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function register_wrapper_section_controls()
	{
		$this->start_controls_section(
			'section_style_wrapper',
			[
				'label' => esc_html__('Wrapper', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control('menu_max_width', [
			'label' => esc_html__('Max Width', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'tablet_default' => [
				'unit' => 'px',
			],
			'mobile_default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', '%'],
			'range' => [
				'%' => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 2000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-vertical-menu' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('menu_alignment', [
			'label' => esc_html__('Alignment', 'ube'),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__('Left', 'ube'),
					'icon' => 'eicon-h-align-left',
				],
				'center' => [
					'title' => esc_html__('Center', 'ube'),
					'icon' => 'eicon-h-align-center',
				],
				'flex-end' => [
					'title' => esc_html__('Right', 'ube'),
					'icon' => 'eicon-h-align-right',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'menu_background',
			'selector' => '{{WRAPPER}} .navbar-nav',
		]);

		$this->add_responsive_control(
			'menu_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .navbar-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function render()
	{
		ube_get_template('elements/vertical-menu.php', array(
			'element' => $this
		));
	}
}
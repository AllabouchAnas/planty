<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Inline_Menu extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'inline-menu';
	}

	public function get_title()
	{
		return esc_html__('Inline Menu', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-nav-menu';
	}

	public function get_ube_keywords()
	{
		return array('menu', 'inline menu', 'ube', 'ube inline menu');
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
			'menu_events_submenu',
			[
				'label' => esc_html__('Events Mode', 'ube'),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Events for show submenu', 'ube'),
				'options' => [
					'hover' => esc_html__('Hover', 'ube'),
					'click' => esc_html__('Click', 'ube'),
				],
				'default' => 'hover',
			]
		);

		$this->add_control(
			'menu_dropdown_direction',
			[
				'label' => esc_html__('Dropdown Direction', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'down' => esc_html__('Down', 'ube'),
					'up' => esc_html__('Up', 'ube'),
				],
				'default' => 'down',
			]
		);

		$this->add_control(
			'menu_style_hover',
			[
				'label' => esc_html__('Hover Style', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__('None', 'ube'),
					'01' => esc_html__('Style 01', 'ube'),
					'02' => esc_html__('Style 02', 'ube'),
					'03' => esc_html__('Style 03', 'ube'),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'menu_align_items',
			[
				'label' => esc_html__('Align', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'start' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-h-align-right',
					],
					'between' => [
						'title' => esc_html__('Stretch', 'ube'),
						'icon' => 'eicon-h-align-stretch',
					],
				],
			]
		);

		$this->add_control(
			'menu_color_scheme',
			[
				'label' => esc_html__('Menu Scheme', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => esc_html__('Main Menu', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'main_menu_background',
			'selector' => '{{WRAPPER}} .ube-inline-menu',
		]);


		$this->start_controls_tabs('tabs_menu_item_style');

		$this->start_controls_tab(
			'menu_tab_item_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'main_menu_item_background',
			'selector' => '{{WRAPPER}} .navbar-nav .menu-item',
		]);

		$this->add_control(
			'menu_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .navbar-nav .menu-item' => 'color: {{VALUE}};',
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

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'main_menu_item_hover_background',
			'selector' => '{{WRAPPER}} .navbar-nav .menu-item:hover',
		]);

		$this->add_control(
			'menu_text_hover_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .navbar-nav .menu-item:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navbar-nav .menu-item:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .navbar-nav .menu-item:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_text_typography_hover',
				'selector' => '{{WRAPPER}} .navbar-nav .menu-item:hover > a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_tab_item_ative',
			[
				'label' => esc_html__('Active', 'ube'),
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'main_menu_item_ative_background',
			'selector' => '{{WRAPPER}} .navbar-nav .menu-item.current-menu-item',
		]);

		$this->add_control(
			'menu_text_ative_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menu-item.current-menu-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .menu-item.current-menu-ancestor' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_text_typography_active',
				'selector' => '{{WRAPPER}} .navbar-nav .menu-item.current-menu-item',
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
				'selectors' => [
					'{{WRAPPER}} .navbar-nav > .menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_margin_item',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .navbar-nav > .menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_menu',
			[
				'label' => esc_html__('Sub Menu', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_menu_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 30,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'sub_menu_background',
			'selector' => '{{WRAPPER}} .dropdown-menu',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name' => 'box_box_shadow',
			'selector' => '{{WRAPPER}} .dropdown-menu',
		]);

		$this->add_responsive_control(
			'sub_menu_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_menu_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'menu_heading_label',
			[
				'label' => esc_html__('Item Sub Menu', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_menu_typography',
				'selector' => '{{WRAPPER}} .dropdown-menu .menu-item > a',
			]
		);

		$this->add_responsive_control(
			'sub_menu_item_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .dropdown-menu .menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'sub_menu_item_background',
			'selector' => '{{WRAPPER}} .dropdown-menu .menu-item',
		]);

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

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'sub_menu_item_hover_background',
			'selector' => '{{WRAPPER}} .dropdown-menu .menu-item:hover',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_menu_tab_item_active',
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
		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'sub_menu_item_activate_background',
			'selector' => '{{WRAPPER}} .dropdown-menu .menu-item.current-menu-item',
		]);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

	}

	public function render()
	{
		ube_get_template('elements/inline-menu.php', array(
			'element' => $this
		));
	}
}
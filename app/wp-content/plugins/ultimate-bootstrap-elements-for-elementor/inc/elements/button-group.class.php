<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use Elementor\Repeater;

class UBE_Element_Button_Group extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-button-group';
	}

	public function get_title()
	{
		return esc_html__('Button Group', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-dual-button';
	}

	public function get_ube_keywords()
	{
		return array('button', 'group', 'ube', 'button group', 'ube button group');
	}

	protected function register_controls()
	{

		$this->start_controls_section('button_group_settings_section', [
			'label' => esc_html__('Button Group Content', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control('button_group_style', [
			'label' => esc_html__('Style', 'ube'),
			'type' => Controls_Manager::SELECT,
			'default' => 'btn-group',
			'options' => [
				'btn-group' => esc_html__('Inline', 'ube'),
				'btn-group-vertical' => esc_html__('Vertical', 'ube'),
			],
			'style_transfer' => true,
		]);

		$this->add_control('button_group_layout', [
			'label' => esc_html__('Layout', 'ube'),
			'type' => Controls_Manager::SELECT,
			'default' => 'classic',
			'options' => [
				'classic' => esc_html__('Classic', 'ube'),
				'outline' => esc_html__('Outline', 'ube'),
			],
			'style_transfer' => true,
		]);

		$repeater = new Repeater();

		$repeater->add_control('button_group_text', [
			'label' => esc_html__('Text', 'ube'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('Text', 'ube'),
			'label_block' => true,
		]);

		$repeater->add_control('button_group_icon', [
			'label' => esc_html__('Icon', 'ube'),
			'type' => Controls_Manager::ICONS,
		]);

		$repeater->add_control('button_group_link', [
			'label' => esc_html__('Link', 'ube'),
			'type' => Controls_Manager::URL,
			'dynamic' => [
				'active' => true,
			],
			'default' => [
				'url' => '#',
				'is_external' => false,
			],
			'placeholder' => esc_html__('https://your-link.com', 'ube'),
		]);

		$this->add_control('button_group_items', [
			'label' => esc_html__('Items', 'ube'),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
				['button_group_text' => esc_html__('Button #1', 'ube'),],
				['button_group_text' => esc_html__('Button #2', 'ube'),],
				['button_group_text' => esc_html__('Button #3', 'ube'),],
			],
			'title_field' => '{{{ elementor.helpers.renderIcon( this, button_group_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ button_group_text }}}',
		]);

		$this->add_control(
			'button_group_color_scheme',
			[
				'label' => esc_html__('Scheme', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => 'primary',
				'condition' => [
					'button_group_layout' => 'classic',
				],
			]
		);
		$this->add_control(
			'button_group_outline_color_scheme',
			[
				'label' => esc_html__('Outline Scheme', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => 'primary',
				'condition' => [
					'button_group_layout' => 'outline',
				],
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'button_group_wrapper_style',
			[
				'label' => esc_html__('Wrapper', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control('alignment', [
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
				]
			]
			,
			'prefix_class' => 'elementor%s-align-',
			'default' => '',
		]);

		$this->add_control('button_group_size', [
			'label' => esc_html__('Size', 'ube'),
			'type' => Controls_Manager::SELECT,
			'default' => 'btn-md',
			'options' => [
				'btn-sm' => esc_html__('Small', 'ube'),
				'btn-md' => esc_html__('Medium', 'ube'),
				'btn-lg' => esc_html__('Large', 'ube'),
			],
			'style_transfer' => true,
		]);

		$this->add_responsive_control('button_group_width', [
			'label' => esc_html__('Width (px)', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'max' => 1000,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-button-group .btn' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('button_group_spacing', [
			'label' => esc_html__('Spacing', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'max' => 1000,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-button-group .btn + .btn' => 'margin-left: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('button_group_mb', [
			'label' => esc_html__('Margin Bottom Item', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'max' => 1000,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-button-group .btn' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'button_group_style' => 'btn-group',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('button_group_skin_style', [
			'label' => esc_html__('Skin', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_group_typography',
				'selector' => '{{WRAPPER}} .ube-button-group .btn',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'button_group_text_shadow',
				'selector' => '{{WRAPPER}} .ube-button-group .btn',
			]
		);

		$this->start_controls_tabs('tabs_button_group_style');

		$this->start_controls_tab(
			'tab_button_group_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'button_group_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_group_background_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_group_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'button_group_hover_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn:hover, {{WRAPPER}} .ube-button-group .btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_group_background_hover_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn:hover, {{WRAPPER}} .ube-button-group .btn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_group_hover_border_color',
			[
				'label' => esc_html__('Border Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn:hover, {{WRAPPER}} .ube-button-group .btn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_group_hover_animation',
			[
				'label' => esc_html__('Hover Animation', 'ube'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_group_border',
				'selector' => '{{WRAPPER}} .ube-button-group .btn',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_group_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-button-group:not(.btn-group-vertical) > .btn:last-child:not(.dropdown-toggle)' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
					'{{WRAPPER}} .ube-button-group:not(.btn-group-vertical) > .btn:first-child:not(.dropdown-toggle)' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-button-group.btn-group-vertical > .btn:last-child:not(.dropdown-toggle)' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-button-group.btn-group-vertical > .btn:first-child:not(.dropdown-toggle)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
				],
			]
		);

		$this->add_responsive_control(
			'button_group_text_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('button_group_icon_style', [
			'label' => esc_html__('Icon', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control('button_group_icon_position', [
			'label' => esc_html__('Icon Position', 'ube'),
			'type' => Controls_Manager::SELECT,
			'default' => 'before',
			'options' => [
				'before' => esc_html__('Before', 'ube'),
				'after' => esc_html__('After', 'ube'),
			],
			'style_transfer' => true,
		]);

		$this->add_control('button_group_icon_spacing', [
			'label' => esc_html__('Spacing', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'max' => 50,
				],
			],
			'default' => [
				'size' => 5,
			],
			'selectors' => [
				'{{WRAPPER}} .ube-button-group.icon-before .btn i' => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .ube-button-group.icon-after .btn i' => 'margin-left: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('button_group_icon_font_size', [
			'label' => esc_html__('Font Size', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-button-group .btn i' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->start_controls_tabs('icon_skin_tabs');

		$this->start_controls_tab('icon_skin_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_control(
			'button_group_icon_text_color',
			[
				'label' => esc_html__('Icon Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('icon_skin_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_control(
			'button_group_icon_text_color_hover',
			[
				'label' => esc_html__('Icon Color Hover', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-button-group .btn:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/button-group.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{
		ube_get_template('elements-view/button-group.php');
	}
}
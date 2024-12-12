<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Repeater;

class UBE_Element_Business_Hours extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-business-hours';
	}

	public function get_title()
	{
		return esc_html__('Business Hours', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-calendar';
	}

	public function get_ube_keywords()
	{
		return array('business hours' , 'ube' , 'ube business hours');
	}

	protected function register_controls()
	{
		$this->start_controls_section('bh_settings_section', [
			'label' => esc_html__('Business Hours Content', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'bh_layout',
			[
				'label' => esc_html__('Layout', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => '01',
				'options' => [
					'01' => esc_html__('Layout 01', 'ube'),
					'02' => esc_html__('Layout 02', 'ube'),
					'03' => esc_html__('Layout 03', 'ube'),
					'04' => esc_html__('Layout 04', 'ube'),
				],
				'separator' => 'after',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'bh_day',
			[
				'label' => esc_html__('Day', 'ube'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Saturday', 'ube'),
			]
		);

		$repeater->add_control(
			'bh_time',
			[
				'label' => esc_html__('Time', 'ube'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__('9:00 AM - 6:00 PM', 'ube'),
			]
		);

		$repeater->add_control(
			'bh_this_day',
			[
				'label' => esc_html__('Highlight this day', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'bh_day_color',
			[
				'label' => esc_html__('Day Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item{{CURRENT_ITEM}}.ube-business-hours-hight-ligh span.ube-business-day' => 'color: {{VALUE}};',
				],
				'condition' => [
					'bh_this_day' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'bh_time_color',
			[
				'label' => esc_html__('Time Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.ube-business-hours-hight-ligh span.ube-business-time' => 'color: {{VALUE}};',
				],
				'condition' => [
					'bh_this_day' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(Group_Control_Background::get_type(),
			[
				'name' => 'bh_background_color',
				'label' => esc_html__('Background', 'ube'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.ube-business-hours-hight-ligh',
				'condition' => [
					'bh_this_day' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'bh_list',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'bh_day' => esc_html__('Saturday', 'ube'),
						'bh_time' => esc_html__('9:00 AM to 6:00 PM', 'ube'),
					],

					[
						'bh_day' => esc_html__('Sunday', 'ube'),
						'bh_time' => esc_html__('Close', 'ube'),
						'bh_this_day' => esc_html__('yes', 'ube'),
					],

					[
						'bh_day' => esc_html__('Monday', 'ube'),
						'bh_time' => esc_html__('9:00 AM to 6:00 PM', 'ube'),
					],

					[
						'bh_day' => esc_html__('Tues Day', 'ube'),
						'bh_time' => esc_html__('9:00 AM to 6:00 PM', 'ube'),
					],

					[
						'bh_day' => esc_html__('Wednesday', 'ube'),
						'bh_time' => esc_html__('9:00 AM to 6:00 PM', 'ube'),
					],

					[
						'bh_day' => esc_html__('Thursday', 'ube'),
						'bh_time' => esc_html__('9:00 AM to 6:00 PM', 'ube'),
					],

					[
						'bh_day' => esc_html__('Friday', 'ube'),
						'bh_time' => esc_html__('9:00 AM to 6:30 PM', 'ube'),
					]
				],
				'title_field' => '{{{ bh_day }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('bh_wrapper_section_style', [
			'label' => esc_html__('Wrapper', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'bh_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control('bh_align', [
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
			'condition' => [
				'bh_width[size]!' => '',
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		]);

		$this->add_control(
			'bh_divider_heading_tab_style',
			[
				'label' => esc_html__('Divider', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'bh_layout' => '04',
				],
			]
		);

		$this->add_responsive_control(
			'bh_divider_margin_left',
			[
				'label' => esc_html__('Margin Left', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-business-divider' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'bh_layout' => '04',
				],
			]
		);
		$this->add_responsive_control(
			'bh_divider_margin_right',
			[
				'label' => esc_html__('Margin Right', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-business-divider' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'bh_layout' => '04',
				],
			]
		);

		$this->add_control(
			'bh_divider_position',
			[
				'label' => esc_html__('Position', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center' => esc_html__('Center', 'ube'),
					'top' => esc_html__('Top', 'ube'),
					'bottom' => esc_html__('Bottom', 'ube'),
				],
				'condition' => [
					'bh_layout' => '04',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('bh_item_section_style', [
			'label' => esc_html__('Item', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'bh_item_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bh_item_typography',
				'selector' => '{{WRAPPER}} .ube-business-hours-item',
			]
		);

		$this->add_responsive_control(
			'bh_item_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bh_item_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bh_border_style_color',
			[
				'label' => esc_html__('Border Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'bh_layout!' => '01',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours' => '--ube-bh-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bh_item_border',
				'selector' => '{{WRAPPER}} .ube-business-hours-item',
				'separator' => 'before',
				'condition' => [
					'bh_layout' => '01',
				],
			]
		);

		$this->add_control(
			'bh_item_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('bh_day_section_style', [
			'label' => esc_html__('Day', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'bh_day_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item span.ube-business-day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bh_day_typography',
				'selector' => '{{WRAPPER}} .ube-business-hours-item span.ube-business-day',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('bh_time_section_style', [
			'label' => esc_html__('Time', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'bh_time_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-business-hours-item span.ube-business-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bh_time_typography',
				'selector' => '{{WRAPPER}} .ube-business-hours-item span.ube-business-time',
			]
		);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/business-hours.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{
		ube_get_template('elements-view/business-hours.php');
	}
}
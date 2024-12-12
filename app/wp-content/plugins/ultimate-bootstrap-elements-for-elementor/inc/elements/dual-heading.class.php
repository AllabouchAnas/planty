<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Core\Schemes;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Dual_Heading extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'dual-heading';
	}

	public function get_title()
	{
		return esc_html__('Dual Heading', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-t-letter';
	}

	public function get_ube_keywords()
	{
		return array('heading', 'dual' , 'dual heading', 'ube' , 'ube dual heading');
	}

	protected function register_controls()
	{

		$options_tag_html = array(
			'h1' => esc_html__('H1', 'ube'),
			'h2' => esc_html__('H2', 'ube'),
			'h3' => esc_html__('H3', 'ube'),
			'h4' => esc_html__('H4', 'ube'),
			'h5' => esc_html__('H5', 'ube'),
			'h6' => esc_html__('H6', 'ube'),
			'div' => esc_html__('div', 'ube'),
			'span' => esc_html__('span', 'ube'),
			'p' => esc_html__('p', 'ube'),
		);

		$this->start_controls_section('dual_heading_hd_content_section', [
			'label' => esc_html__('Heading', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'dual_heading_title_first',
			[
				'label' => esc_html__('First Part', 'ube'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Dual Heading', 'ube'),
			]
		);

		$this->add_control(
			'dual_heading_title_last',
			[
				'label' => esc_html__('Last Part', 'ube'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Example', 'ube'),
			]
		);

		$this->add_control('dual_heading_title_size', [
			'label' => esc_html__('Size', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => array(
				'' => esc_html__('Default', 'ube'),
				'sm' => esc_html__('Small', 'ube'),
				'md' => esc_html__('Medium', 'ube'),
				'lg' => esc_html__('Large', 'ube'),
				'xl' => esc_html__('Extra Large', 'ube'),
				'xxl' => esc_html__('Extra Extra Large', 'ube'),
			),
			'default' => '',
		]);

		$this->add_control(
			'dual_heading_title_tag',
			[
				'label' => esc_html__('Title Tag', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => $options_tag_html,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_desc_content_section', [
			'label' => esc_html__('Description', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'dual_heading_desc_heading',
			[
				'label' => esc_html__('text', 'ube'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_sub_title_content_section', [
			'label' => esc_html__('Sub Heading', 'ube'),
		]);

		$this->add_control('dual_heading_sub_title_text', [
			'label' => esc_html__('Text', 'ube'),
			'type' => Controls_Manager::TEXTAREA,
			'dynamic' => [
				'active' => true,
			],
		]);

		$this->add_control('dual_heading_sub_title_tag', [
			'label' => esc_html__('HTML Tag', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => $options_tag_html,
			'default' => 'h6',
		]);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_divider_content_section', [
			'label' => esc_html__('Divider', 'ube'),
		]);

		$this->add_control('dual_heading_divider_enable', [
			'label' => esc_html__('Divider', 'ube'),
			'type' => Controls_Manager::SWITCHER,
		]);

		$this->add_control('dual_heading_divider_position', [
			'label' => esc_html__('Position', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'before' => esc_html__('Before Heading', 'ube'),
				'after' => esc_html__('After Heading', 'ube'),
			],
			'default' => 'after',
			'condition' => [
				'dual_heading_divider_enable' => 'yes',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_wrapper_style_section', [
			'label' => esc_html__('Wrapper', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'dual_heading_text_align',
			[
				'label' => esc_html__('Text Align', 'ube'),
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
			]
		);

		$this->add_responsive_control('dual_heading_max_width', [
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
				'{{WRAPPER}} .ube-dual-heading' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('dual_heading_alignment', [
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
				'dual_heading_max_width[size]!' => '',
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_first_style_section', [
			'label' => esc_html__('Heading ( First Part )', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'dual_heading_title_first!' => '',
			],
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'dual_heading_first_text_color',
			'selector' => '{{WRAPPER}} .ube-dual-heading-title-first',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name' => 'dual_heading_first_typography',
			'selector' => '{{WRAPPER}} .ube-dual-heading-title-first',
		]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dual_heading_first_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-dual-heading-title-first',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dual_heading_first_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-dual-heading-title-first' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'dual_heading_first_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-dual-heading-title-first' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_last_style_section', [
			'label' => esc_html__('Heading ( Last Part )', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'dual_heading_title_last!' => '',
			],
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'dual_heading_last_text_color',
			'selector' => '{{WRAPPER}} .ube-dual-heading-title-last',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name' => 'dual_heading_last_typography',
			'selector' => '{{WRAPPER}} .ube-dual-heading-title-last',
		]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dual_heading_last_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-dual-heading-title-last',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dual_heading_last_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-dual-heading-title-last' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'dual_heading_last_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-dual-heading-title-last' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_desc_heading_style_section', [
			'label' => esc_html__('Description', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'dual_heading_desc_heading!' => '',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name' => 'dual_heading_desc_heading_typography',
			'selector' => '{{WRAPPER}} .ube-dual-heading-desc-heading',
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'dual_heading_desc_heading_text_color',
			'selector' => '{{WRAPPER}} .ube-dual-heading-desc-heading',
		]);

		$this->add_responsive_control( 'dual_heading_desc_heading_spacing', [
			'label'      => esc_html__( 'Spacing', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', 'em' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .ube-dual-heading-desc-heading' => 'margin-top : {{SIZE}}{{UNIT}}',
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_sub_title_style_section', [
			'label' => esc_html__('Sub Heading', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'dual_heading_sub_title_text!' => '',
			],
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'dual_heading_sub_title_typography',
				'selector' => '{{WRAPPER}} .ube-dual-heading-sub-title',
			]
		);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'dual_heading_sub_title_text_color',
			'selector' => '{{WRAPPER}} .ube-dual-heading-sub-title',
		]);

		$this->add_responsive_control('dual_heading_sub_title_spacing', [
			'label' => esc_html__('Spacing', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-dual-heading-sub-title' => 'margin-bottom : {{SIZE}}{{UNIT}} !important',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('dual_heading_divider_style_section', [
			'label' => esc_html__('Divider', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'dual_heading_divider_enable' => 'yes',
			],
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'dual_heading_divider_border',
			'selector' => '{{WRAPPER}} .ube-heading-divider',
			'fields_options' => [
				'background' => [
					'default' => 'classic',
				],
				'color' => [
					'default' => '#000',
				],
			],
		]);

		$this->add_responsive_control('heading_divicer_spacing', [
			'label' => esc_html__('Spacing', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-dual-heading-divider-after .ube-heading-divider' => 'margin-top : {{SIZE}}{{UNIT}} !important',
				'{{WRAPPER}} .ube-dual-heading-divider-before .ube-heading-divider' => 'margin-bottom : {{SIZE}}{{UNIT}} !important',
			],
		]);

		$this->add_responsive_control('dual_heading_divicer_width', [
			'label' => esc_html__('Width', 'ube'),
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
			'size_units' => ['px', '%', 'em'],
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
				'{{WRAPPER}} .ube-heading-divider' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('dual_heading_divicer_height', [
			'label' => esc_html__('Height', 'ube'),
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
			'size_units' => ['px', '%', 'em'],
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
				'{{WRAPPER}} .ube-heading-divider' => 'height: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();

	}

	public function render()
	{
		ube_get_template('elements/dual-heading.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{
		ube_get_template('elements-view/dual-heading.php');
	}
}
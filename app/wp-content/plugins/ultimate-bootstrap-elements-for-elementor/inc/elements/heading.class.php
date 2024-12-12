<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Heading extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-heading';
	}

	public function get_title()
	{
		return esc_html__('Heading', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-heading';
	}

	public function get_ube_keywords()
	{
		return array('heading', 'ube', 'ube heading');
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

		$this->start_controls_section('heading_content_section', [
			'label' => esc_html__('Heading', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control('heading_title', [
			'label' => esc_html__('Text', 'ube'),
			'type' => Controls_Manager::TEXTAREA,
			'placeholder' => esc_html__('Enter your title', 'ube'),
			'default' => esc_html__('Add Your Heading Text Here', 'ube'),
			'description' => esc_html__('Wrap any words with &lt;mark&gt;&lt;/mark&gt; tag to make them highlight.', 'ube'),
		]);

		$this->add_control('heading_title_link', [
			'label' => esc_html__('Link', 'ube'),
			'type' => Controls_Manager::URL,
			'separator' => 'before',
			'dynamic' => [
				'active' => true,
			],
		]);

		$this->add_control('heading_title_size', [
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

		$this->add_control('heading_title_tag', [
			'label' => esc_html__('HTML Tag', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => $options_tag_html,
			'default' => 'h2',
		]);



		$this->end_controls_section();

		$this->start_controls_section('heading_description_content_section', [
			'label' => esc_html__('Description', 'ube'),
		]);

		$this->add_control('heading_description', [
			'label' => esc_html__('Text', 'ube'),
			'type' => Controls_Manager::WYSIWYG,
		]);



		$this->end_controls_section();

		$this->start_controls_section('heading_sub_title_content_section', [
			'label' => esc_html__('Sub Heading', 'ube'),
		]);

		$this->add_control('heading_sub_title_text', [
			'label' => esc_html__('Text', 'ube'),
			'type' => Controls_Manager::TEXTAREA,
			'dynamic' => [
				'active' => true,
			],
		]);

		$this->add_control('heading_sub_title_tag', [
			'label' => esc_html__('HTML Tag', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => $options_tag_html,
			'default' => 'h6',
		]);





		$this->end_controls_section();

		$this->start_controls_section('heading_divider_content_section', [
			'label' => esc_html__('Divider', 'ube'),
		]);

		$this->add_control('heading_divider_enable', [
			'label' => esc_html__('Divider', 'ube'),
			'type' => Controls_Manager::SWITCHER,
		]);

		$this->add_control('heading_divider_position', [
			'label' => esc_html__('Position', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'before' => esc_html__('Before Heading', 'ube'),
				'after' => esc_html__('After Heading', 'ube'),
			],
			'default' => 'after',
			'condition' => [
				'heading_divider_enable' => 'yes',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('heading_wrapper_style_section', [
			'tab' => Controls_Manager::TAB_STYLE,
			'label' => esc_html__('Wrapper', 'ube'),
		]);

		$this->add_responsive_control(
			'heading_align',
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
				'default' => '',
			]
		);

		$this->add_responsive_control('heading_max_width', [
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
				'{{WRAPPER}} .ube-heading' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('heading_alignment', [
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
				'heading_max_width[size]!' => '',
			],

			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('heading_title_style_section', [
			'label' => esc_html__('Heading', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'heading_title!' => '',
			],
		]);

		$this->add_responsive_control('heading_title_margin', [
			'label' => esc_html__('Margin', 'ube'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', 'em'],
			'selectors' => [
				'{{WRAPPER}} .ube-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_title_typography',
				'selector' => '{{WRAPPER}} .ube-heading-title',
			]
		);

		$this->add_group_control(Group_Control_Text_Shadow::get_type(), [
			'name' => 'heading_text_shadow',
			'selector' => '{{WRAPPER}} .ube-heading-title',
		]);

		$this->start_controls_tabs('heading_title_style_tabs');

		$this->start_controls_tab('heading_title_style_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'heading_title_text_color',
			'selector' => '{{WRAPPER}} .ube-heading-title',
		]);

		$this->add_control('heading_title_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_tab();





		$this->start_controls_tab('heading_title_style_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'heading_title_text_color_hover',
			'selector' => '{{WRAPPER}} .ube-heading-title:hover, {{WRAPPER}} .ube-heading-title a:hover',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section('heading_mark_style_section', [
			'label' => esc_html__('Highlight Words', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'heading_title!' => '',
			],
		]);

		$this->start_controls_tabs('heading_mark_style_tabs');

		$this->start_controls_tab('heading_mark_style_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_mark_typography',
				'selector' => '{{WRAPPER}} .ube-heading-title mark',
			]
		);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'heading_mark_text_color',
			'selector' => '{{WRAPPER}} .ube-heading-title mark',
		]);

		$this->add_control('heading_border_enable', [
			'label' => esc_html__('Border', 'ube'),
			'type' => Controls_Manager::SWITCHER,
			'selectors' => [
				'{{WRAPPER}} .ube-heading-title mark:before' => 'content: "";',
			],
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'heading_mark_border',
			'selector' => '{{WRAPPER}} .ube-heading-title mark:before',
			'condition' => [
				'heading_border_enable' => 'yes',
			],
		]);

		$this->add_responsive_control('heading_mark_border_spacing', [
			'label' => esc_html__('Border Spacing', 'ube'),
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
				'{{WRAPPER}} .ube-heading-title mark:before' => 'top: calc(100% + {{SIZE}}{{UNIT}});',
			],
			'condition' => [
				'heading_border_enable' => 'yes',
			],
		]);

		$this->add_responsive_control('heading_border_width', [
			'label' => esc_html__('Border Width', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 50,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-heading-title mark:before' => 'height: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'heading_border_enable' => 'yes',
			],
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('heading_mark_style_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_mark_typography_hover',
				'selector' => '{{WRAPPER}} .ube-heading-title mark:hover',
			]
		);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'heading_mark_text_color_hover',
			'selector' => '{{WRAPPER}} .ube-heading-title mark:hover',
		]);

		$this->add_control('heading_border_enable_hover', [
			'label' => esc_html__('Border', 'ube'),
			'type' => Controls_Manager::SWITCHER,
			'selectors' => [
				'{{WRAPPER}} .ube-heading-title mark:hover:before' => 'content: "";',
			],
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'heading_mark_background_hover',
			'selector' => '{{WRAPPER}} .ube-heading-title mark:hover:before',
			'condition' => [
				'heading_border_enable_hover' => 'yes',
			],
		]);

		$this->add_responsive_control('heading_mark_border_spacing_hover', [
			'label' => esc_html__('Border Spacing', 'ube'),
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
				'{{WRAPPER}} .ube-heading-title mark:hover:before' => 'top: calc(100% + {{SIZE}}{{UNIT}});',
			],
			'condition' => [
				'heading_border_enable_hover' => 'yes',
			],
		]);

		$this->add_responsive_control('heading_mark_border_width_hover', [
			'label' => esc_html__('Border Width', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 50,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-heading-title mark:hover:before' => 'height: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'heading_border_enable_hover' => 'yes',
			],
		]);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section('heading_description_style_section', [
			'label' => esc_html__('Description', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'heading_description!' => '',
			],
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_description_typography',
				'selector' => '{{WRAPPER}} .ube-heading-description',
			]
		);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'heading_description_text_color',
			'selector' => '{{WRAPPER}} .ube-heading-description',
		]);

		$this->add_responsive_control('heading_description_spacing_hover', [
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
				'{{WRAPPER}} .ube-heading-description' => 'margin-top : {{SIZE}}{{UNIT}}',
			],
		]);

		$this->add_control('heading_description_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_section();

		$this->start_controls_section('heading_sub_title_style_section', [
			'label' => esc_html__('Sub Heading', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'heading_sub_title_text!' => '',
			],
		]);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_sub_title_typography',
				'selector' => '{{WRAPPER}} .ube-heading-sub-title',
			]
		);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'heading_sub_title_text_color',
			'selector' => '{{WRAPPER}} .ube-heading-sub-title',
		]);

		$this->add_responsive_control('heading_sub-title_spacing_hover', [
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
				'{{WRAPPER}} .ube-heading-sub-title' => 'margin-bottom : {{SIZE}}{{UNIT}} !important',
			],
		]);

		$this->add_control('heading_sub_title_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_section();
		$this->start_controls_section('heading_divider_style_section', [
			'label' => esc_html__('Divider', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'heading_divider_enable' => 'yes',
			],
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'heading_divider_border',
			'selector' => '{{WRAPPER}} .ube-heading-divider',
			'condition' => [
				'heading_divider_enable' => 'yes',
			],
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
				'{{WRAPPER}} .ube-heading-divider-after .ube-heading-divider' => 'margin-top : {{SIZE}}{{UNIT}} !important',
				'{{WRAPPER}} .ube-heading-divider-before .ube-heading-divider' => 'margin-bottom : {{SIZE}}{{UNIT}} !important',
			],
		]);

		$this->add_responsive_control('heading_divicer_width', [
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
			'condition' => [
				'heading_divider_enable' => 'yes',
			],
		]);

		$this->add_responsive_control('heading_divicer_height', [
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
			'condition' => [
				'heading_divider_enable' => 'yes',
			],
		]);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/heading.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{
		ube_get_template('elements-view/heading.php');
	}
}
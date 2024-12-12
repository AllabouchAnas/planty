<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Banner extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-banner';
	}

	public function get_title()
	{
		return esc_html__('Banner', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-image';
	}

	public function get_ube_keywords()
	{
		return array('banner' , 'ube' , 'ube banner');
	}

	protected function register_controls()
	{
		$this->start_controls_section('banner_layout_content_section', [
			'label' => esc_html__('Layout Options', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'banner_layout',
			[
				'label' => esc_html__('Layout', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout-01',
				'label_block' => false,
				'options' => [
					'layout-01' => esc_html__('Layout 01', 'ube'),
					'layout-02' => esc_html__('Layout 02', 'ube'),
					'layout-03' => esc_html__('Layout 03', 'ube'),
					'layout-04' => esc_html__('Layout 04', 'ube'),
					'layout-05' => esc_html__('Layout 05', 'ube'),
					'layout-06' => esc_html__('Layout 06', 'ube'),
					'layout-07' => esc_html__('Layout 07', 'ube'),
				],
			]
		);

		$this->add_control(
			'banner_layout_hover_effect',
			[
				'label' => esc_html__('Hover Effect', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'label_block' => false,
				'options' => [
					'' => esc_html__('None', 'ube'),
					'symmetry' => esc_html__('Symmetry', 'ube'),
					'suprema' => esc_html__('Suprema', 'ube'),
					'layla' => esc_html__('Layla', 'ube'),
					'bubba' => esc_html__('Bubba', 'ube'),
					'jazz' => esc_html__('Jazz', 'ube'),
					'flash' => esc_html__('Flash', 'ube'),
					'ming' => esc_html__('Ming', 'ube'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('banner_image_content_section', [
			'label' => esc_html__('Image', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'banner_image',
			[
				'label' => esc_html__('Choose Image', 'ube'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control('banner_size_mode', [
			'label' => esc_html__('Size Mode', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'original' => esc_html__('Original', 'ube'),
				'100' => '1:1',
				'133.333333333' => '4:3',
				'75' => '3:4',
				'177.777777778' => '16:9',
				'56.25' => '9:16',
				'custom' => esc_html__('Custom', 'ube'),
				'custom-height' => esc_html__('Custom Height', 'ube'),
			],
			'default' => 'original',
		]);

		$this->add_responsive_control(
			'banner_size_width',
			[
				'label' => esc_html__('Custom Width', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'banner_size_mode' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-bg ' => '--ube-banner-custom-width: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'banner_size_height',
			[
				'label' => esc_html__('Custom Height', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'banner_size_mode' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-bg ' => 'padding-bottom:calc(({{VALUE}}/var(--ube-banner-custom-width))*100%)',
				],
			]
		);

		$this->add_responsive_control(
			'banner_size_custom_height',
			[
				'label' => esc_html__('Custom Height', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'default' => 400,
				'min' => 1,
				'condition' => [
					'banner_size_mode' => 'custom-height',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-bg ' => 'height: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'banner_layout_hover_img',
			[
				'label' => esc_html__('Hover Image Effect', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'label_block' => false,
				'options' => [
					'' => esc_html__('None', 'ube'),
					'zoom-in' => esc_html__('Zoom In', 'ube'),
					'zoom-out' => esc_html__('Zoom Out', 'ube'),
					'slide-left' => esc_html__('Slide Left', 'ube'),
					'slide-right' => esc_html__('Slide Right', 'ube'),
					'slide-top' => esc_html__('Slide Top', 'ube'),
					'slide-bottom' => esc_html__('Slide Bottom', 'ube'),
					'rotate' => esc_html__('Rotate', 'ube'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('banner_content_content_section', [
			'label' => esc_html__('Content', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control('banner_title', [
			'label' => esc_html__('Title', 'ube'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('Title on the Banner', 'ube'),
		]);

		$this->add_control(
			'banner_title_tag',
			[
				'label' => esc_html__('Title Tag', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1' => esc_html__('H1', 'ube'),
					'h2' => esc_html__('H2', 'ube'),
					'h3' => esc_html__('H3', 'ube'),
					'h4' => esc_html__('H4', 'ube'),
					'h5' => esc_html__('H5', 'ube'),
					'h6' => esc_html__('H6', 'ube'),
					'span' => esc_html__('Span', 'ube'),
					'p' => esc_html__('P', 'ube'),
					'div' => esc_html__('Div', 'ube'),
				],
			]
		);

		$this->add_control('banner_description', [
			'label' => esc_html__('Description', 'ube'),
			'default' => esc_html__('Description on the Banner', 'ube'),
			'type' => Controls_Manager::WYSIWYG,
		]);

		$this->add_control('banner_link', [
			'label' => esc_html__('Link', 'ube'),
			'type' => Controls_Manager::URL,
		]);

		$this->add_control(
			'banner_always_show',
			[
				'label' => esc_html__('Always show', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html__('Show', 'ube'),
				'label_off' => esc_html__('Hide', 'ube'),
				'return_value' => 'yes',
				'separator' => 'before',
				'description' => esc_html__('Always display full information', 'ube'),
				'conditions' => [
					'terms' => [
						[
							'name' => 'banner_layout',
							'operator' => 'in',
							'value' => [
								'layout-04',
								'layout-05',
								'layout-06',
								'layout-07',
							],
						],
					]
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('banner_btn_content_section', [
			'label' => esc_html__('Button', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'banner_enable_button',
			[
				'label' => esc_html__('Show Button', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html__('Show', 'ube'),
				'label_off' => esc_html__('Hide', 'ube'),
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'banner_button_fixed',
			[
				'label' => esc_html__('Button Fixed Below', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html__('On', 'ube'),
				'label_off' => esc_html__('Off', 'ube'),
				'return_value' => 'yes',

				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'banner_layout',
							'operator' => '==',
							'value' => 'layout-02'
						],
						[
							'name' => 'banner_enable_button',
							'operator' => '==',
							'value' => 'yes'
						]
					]
				]

			]
		);

		$this->add_control('banner_text_button', [
			'label' => esc_html__('Text Button', 'ube'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('Read Mode', 'ube'),
			'condition' => [
				'banner_enable_button' => 'yes',
			],
		]);

		$this->add_control(
			'banner_button_icon',
			[
				'label' => esc_html__('Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'banner_enable_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'banner_button_icon_align',
			[
				'label' => esc_html__('Icon Position', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => esc_html__('Before', 'ube'),
					'after' => esc_html__('After', 'ube'),
				],
				'condition' => [
					'banner_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'banner_button_type',
			[
				'label' => esc_html__('Type', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => ube_get_button_styles(),
				'condition' => [
					'banner_enable_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'banner_button_scheme',
			[
				'label' => esc_html__('Scheme', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(false),
				'default' => 'primary',
				'condition' => [
					'banner_enable_button' => 'yes',
					'banner_button_type[value]!' => 'link',
				],
			]
		);

		$this->add_control(
			'banner_button_shape',
			[
				'label' => esc_html__('Shape', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => ube_get_button_shape(),
				'condition' => [
					'banner_enable_button' => 'yes',
					'banner_button_type[value]!' => 'link',
				],
			]
		);


		$this->add_control(
			'banner_button_size',
			[
				'label' => esc_html__('Size', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => ube_get_button_sizes(),
				'style_transfer' => true,
				'condition' => [
					'banner_enable_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('banner_wrapper_style_section', [
			'label' => esc_html__('Wrapper', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'banner_text_align',
			[
				'label' => esc_html__('Content Align', 'ube'),
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
				'separator' => 'after',
				'conditions' => [
					'terms' => [
						[
							'name' => 'banner_layout',
							'operator' => '!in',
							'value' => [
								'layout-07',
								'layout-05',
							],
						],
					]
				]
			]
		);


		$this->add_control(
			'banner_heading_bg_overlay',
			[
				'label' => esc_html__('Background overlay', 'ube'),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->start_controls_tabs('banner_overlay_tabs');

		$this->start_controls_tab('banner_overlay_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'banner_bg_overlay',
			'selector' => '{{WRAPPER}} .ube-banner:after',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('banner_overlay_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'banner_hover_bg_overlay',
			'selector' => '{{WRAPPER}} .ube-banner:hover:after',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_responsive_control(
			'banner_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'banner_layout!' => 'layout-04',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control('banner_content_show', [
			'label' => esc_html__('Top Show', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 500,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-banner-content' => 'top: calc(100% - {{SIZE}}{{UNIT}})',
			],
			'condition' => [
				'banner_layout' => 'layout-04',
			],
		]);

		$this->end_controls_section();

		$this->start_controls_section('banner_title_style_section', [
			'label' => esc_html__('Title', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'banner_title!' => '',
			],
		]);

		$this->add_control(
			'banner_title_text_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-banner-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'banner_title_typography',
				'selector' => '{{WRAPPER}} .ube-banner-title',
			]
		);

		$this->add_responsive_control(
			'banner_title_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control('banner_title_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_section();

		$this->start_controls_section('banner_desc_style_section', [
			'label' => esc_html__('Description', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'banner_description!' => '',
			],
		]);

		$this->add_control(
			'banner_desc_text_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-banner-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'banner_desc_typography',
				'selector' => '{{WRAPPER}} .ube-banner-description',
			]
		);

		$this->add_responsive_control(
			'banner_desc_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control('banner_desc_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_section();

		$this->start_controls_section('banner_button_style_section', [
			'label' => esc_html__('Button', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'banner_enable_button' => 'yes',
			],
		]);

		$this->add_responsive_control(
			'banner_button_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-banner-btn' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'banner_button_typography',
				'selector' => '{{WRAPPER}} .ube-banner-btn',
			]
		);

		$this->start_controls_tabs('banner_button_tabs');

		$this->start_controls_tab('banner_button_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_control(
			'banner_button_text_color',
			[
				'label' => esc_html__('Button Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-banner-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'banner_button_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-banner-btn',
			]
		);


		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'banner_button_background',
			'selector' => '{{WRAPPER}} .ube-banner-btn',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('banner_button_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_control(
			'banner_button_text_color_hover',
			[
				'label' => esc_html__('Button Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-banner-btn:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'banner_button_border_hover',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-banner-btn:hover',
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'banner_button_background_hover',
			'selector' => '{{WRAPPER}} .ube-banner-btn:hover',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'banner_button_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'banner_button_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-banner-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control('banner_button_icon_spacing', [
			'label' => esc_html__('Spacing Icon', 'ube'),
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
				'{{WRAPPER}} .ube-banner-btn.icon-before > i,{{WRAPPER}} .ube-banner-btn.icon-before > svg' => 'margin-right : {{SIZE}}{{UNIT}}',
				'{{WRAPPER}} .ube-banner-btn.icon-after > i , {{WRAPPER}} .ube-banner-btn.icon-after > svg' => 'margin-left : {{SIZE}}{{UNIT}}'
			],
			'condition' => [
				'banner_button_icon[value]!' => '',
			],
		]);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/banner.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{

	}
}